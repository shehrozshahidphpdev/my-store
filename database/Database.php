<?php


class Database
{
  public $db_host;
  private $db_username;
  private $db_password;
  public $db_name;


  public function __construct(string $db_host, string $db_username, string $db_password, string $db_name)
  {
    $this->db_host = $db_host;
    $this->db_username = $db_username;
    $this->db_password = $db_password;
    $this->db_name = $db_name;
  }

  public function getConnection()
  {
    try {
      $conn = new PDO("mysql:host=$this->db_host;dbname=$this->db_name", $this->db_username, $this->db_password);
      $conn->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
    } catch (\Exception $e) {
      die("Conneciton Failed: " . $e->getMessage());
    }

    return $conn;
  }
}

$conn = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
