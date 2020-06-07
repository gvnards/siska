<?php
class Conn {
  private $host;
  private $username;
  private $password;
  private $dbName;
  private $charset;

  protected function connect () {
    $this->host = "localhost";
    $this->username = "root";
    $this->password = "";
    $this->dbName = "siska";
    $this->charset = "utf8mb4";

    try {
      $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName.";charset=".$this->charset;
      $pdo = new PDO($dsn, $this->username, $this->password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e) {
      return $e;
    }
  }
}