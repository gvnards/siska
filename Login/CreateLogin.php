<?php
class CreateLogin extends Conn {
  public function InsertAccount () {
    $loginAs = isset($_POST['loginAs']) ? $_POST['loginAs'] : json_decode(file_get_contents('php://input'))->loginAs;
    $namaOPD = isset($_POST['namaOPD']) ? $_POST['namaOPD'] : json_decode(file_get_contents('php://input'))->namaOPD;
    $idOPD = isset($_POST['idOPD']) ? $_POST['idOPD'] : json_decode(file_get_contents('php://input'))->idOPD;
    $username = isset($_POST['username']) ? $_POST['username'] : json_decode(file_get_contents('php://input'))->username;
    $password = isset($_POST['password']) ? $_POST['password'] : json_decode(file_get_contents('php://input'))->password;

    if ($loginAs === 'admin') {
      $password = password_hash($password, PASSWORD_DEFAULT);

      $dbh = $this->connect();

      $sth = $dbh->prepare("INSERT INTO admin (nama_opd, opd_id, username, password) VALUES (?, ?, ?, ?);");
      $sth->execute([$namaOPD, $idOPD, $username, $password]);
    }

    return json_encode([
      "callback" => $sth->rowCount() > 0 ? true : false
    ]);
  }
}