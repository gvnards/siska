<?php
class ReadProfil extends Conn {
  public function GetProfil () {
    $nip = $_GET['nip'];

    $dbh = $this->connect();
    $sth = $dbh->prepare("SELECT * FROM profil_pegawai WHERE nip=?");
    $sth->execute([$nip]);

    $data = [];
    while ($row = $sth->fetchObject()) {
      $data = $row;
    }
    return json_encode($data);
  }
}