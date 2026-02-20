<?php


class UserRepository
{
  private $conn;

  private $table;

  public function __construct($conn, $table)
  {
    $this->conn = $conn;
    $this->table = $table;
  }

  public function insert($data)
  {
    $sql = "INSERT INTO users (name, email, password) VALUES(:name, :email, :password)";
    $stmt = $this->conn->prepare($sql);
    $result = $stmt->execute([
      ':name' => $data['name'],
      ':email' => $data['email'],
      ':password' => password_hash($data['password'], PASSWORD_DEFAULT)
    ]);

    return $result;
  }

  public function getAll()
  {
    $sql = "SELECT * FROM users";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
  }

  public function attemptLogin() {}
}

$userrepo = new UserRepository($conn, 'users');
