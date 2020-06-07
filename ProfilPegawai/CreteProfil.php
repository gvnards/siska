<?php
class CreateProfil extends Conn {
  public function InsertProfil () {
    $nips = isset($_POST['nips']) ? $_POST['nips'] : json_decode(file_get_contents('php://input'))->nips;
    $kawins = isset($_POST['kawins']) ? $_POST['kawins'] : json_decode(file_get_contents('php://input'))->kawins;
    $nips = explode(",", $nips);
    $kawins = explode(",", $kawins);

    $count = 0;

    foreach ($nips as $key => $nip) {
      $dbh = $this->connect();

      $sth = $dbh->prepare("INSERT INTO profil_pegawai (nip, status_perkawinan) SELECT * FROM (SELECT ?, ?) AS temp WHERE NOT EXISTS (SELECT nip FROM profil_pegawai WHERE nip=?) LIMIT 1;");

      $sth->execute([$nip, $kawins[$key], $nip]);
      $count += $sth->rowCount();
    }
    return json_encode([
      "callback" => $count
    ]);
  }
}