<?php
class ReadLogin extends Conn {
  public function Login () {
    $loginAs = $_GET['loginAs'];
    $username = $_GET['username'];
    $password = $_GET['password'];

    if ($loginAs === 'admin') {
      $dbh = $this->connect();

      $sth = $dbh->prepare("SELECT * FROM admin WHERE username=?;");
      $sth->execute([$username]);

      $isAny = false;
      while ($row = $sth->fetchObject()) {
        if (password_verify($password, $row->password)) {
          $isAny = [
            "nama" => $row->nama,
            "nama_opd" => $row->nama_opd,
            "opd_id" => $row->opd_id,
            "nama_jabatan" => $row->nama_jabatan
          ];
        }
      }
    }

    return json_encode([
      "callback" => !$isAny ? $isAny : true,
      "data" => $isAny
    ]);
  }

  public function GetDataAccount () {
    $loginAs = $_GET['loginAs'];
    $username = $_GET['username'];

    if ($loginAs === 'admin') {
      $dbh = $this->connect();

      $sth = $dbh->prepare("SELECT * FROM admin WHERE username=?;");
      $sth->execute([$username]);

      $allData = [];
      while ($row = $sth->fetchObject()) {
        array_push($allData, [
          "nama" => $row->nama,
          "nama_opd" => $row->nama_opd,
          "opd_id" => $row->opd_id,
          "nama_jabatan" => $row->nama_jabatan
        ]);
      }
    }

    return json_encode([
      "data" => $allData
    ]);
  }
}