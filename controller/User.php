<?php

class User
{
  public $conn;
  public $userRepository;

  public function __construct($conn, UserRepository $userRepository)
  {
    $this->conn = $conn;
    $this->userRepository = $userRepository;
  }

  public function register($request)
  {
    $name = trim($request['name']);
    $email = trim(($request['email']));
    $password = trim(($request['password']));
    $passwordConfirmaiton = trim(($request['password_confirmation']));

    $validated = $this->validateRegisterRequest($name, $email, $password, $passwordConfirmaiton);

    $users = $this->userRepository->getAll();
    foreach ($users as $user) {
      if ($email == $user['email']) {
        $_SESSION['errors']['email'] = "The Email Has Already been taken";
        $emailAlreadyExists = true;
      }
    }
    if (!$validated || $emailAlreadyExists) {
      $_SESSION['old'] = $request;
      header('Location: /register');
      exit();
    }
    $data = [];
    $data = [
      'name' => $name,
      'email' => $email,
      'password' => $password
    ];

    $result = $this->userRepository->insert($data);

    if ($result) {
      $_SESSION['success'] = "registration successfull";
      header('Location: /login');
    }
  }

  public function validateRegisterRequest(
    string $name,
    string $email,
    string $password,
    string $passwordConfirmation
  ) {
    $_SESSION['errors'] = [];
    if (empty($name)) {
      $_SESSION['errors']['name'] = "The name field is required";
    } else if (strlen($name) < 3) {
      $_SESSION['errors']['name'] = "The name field must be atleast 3 characters long";
    }

    if (empty($email)) {
      $_SESSION['errors']['email'] = "The email field is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['errors']['email'] = "The email format is invalid";
    }

    if (empty($password)) {
      $_SESSION['errors']['password'] = "The email field is required";
    } else if (strlen($password < 8)) {
      $_SESSION['errors']['password'] = "Pssword Must be eight characters long";
    }

    if ($password !== $passwordConfirmation) {
      $_SESSION['errors']['password'] = "Password does not match";
    }

    if (empty($_SESSION['errors'])) {
      return true;
    }

    return false;
  }

  public function login($request)
  {
    $email = $request['email'];
    $password = $request['password'];
    $validated = $this->validateLoginRequest($email, $password);
    if (!$validated) {
      header('Location: /login');
      exit();
    }
    $users = $this->userRepository->getAll();
    foreach ($users as $user) {
      if ($email == $user['email'] && password_verify($password, $user['password'])) {
        session('success', "Logged in successfully");
        $_SESSION['user'] = $user;
        header('Location: /');
        exit();
      }
    }
    $_SESSION['errors']['email'] = "The credentials does not match our records";
    header('Location: /login');
    exit();
  }

  public function validateLoginRequest(string $email, string $password): bool
  {
    $_SESSION['errors'] = [];
    if (empty($email)) {
      $_SESSION['errors']['email'] = "the email fields id required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['errors']['email'] = "the email is invalid";
    }

    if (empty($password)) {
      $_SESSION['errors']['password'] = "the password field  is required";
    }

    if (empty($_SESSION['errors'])) {
      return true;
    }

    return false;
  }

  public function logout()
  {
    if (isset($_SESSION['user'])) {
      session_unset();
      session_destroy();
      header('Location: /login');
    }
  }

  public static function check(): bool
  {
    if (isset($_SESSION['user'])) {
      return true;
    } else {
      return false;
    }
  }
}

$user = new User($conn,  $userrepo);
