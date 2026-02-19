<?php

class User
{
  public $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function register($request)
  {
    $name = trim($request['name']);
    $email = trim(($request['email']));
    $password = trim(($request['password']));
    $passwordConfirmaiton = trim(($request['password_confirmation']));

    $validated = $this->validateRegisterRequest($name, $email, $password, $passwordConfirmaiton);
    if (!$validated) {
      $_SESSION['old'] = $request;
      header('Location: /register');
      exit();
    }

    $sql = "INSERT INTO users (name, email, password) VALUES(:name, :email, :password)";
    $stmt = $this->conn->prepare($sql);
    $res = $stmt->execute([
      ':name' => $name,
      ':email' => $email,
      ':password' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    if ($res) {
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
    $name = $request['name'];
    $password = $request['password'];
    $validated = $this->validateLoginRequest($name, $password);
  }

  public function validateLoginRequest(string $name, string $password)
  {
    $sql = "SELECT * FROM users";
    $stmt = $this->conn->prepare($sql);
  }
}

$auth = new User($conn);
