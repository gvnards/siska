<?php
class ReadGaji extends Conn {
  public function GetGaji() {
    $id_gaji = isset($_GET["id_gaji"]) ? $_GET["id_gaji"] : -1;
    $golongan = isset($_GET["golongan"]) ? $_GET["golongan"] : -1;
    $masaKerja = isset($_GET["masaKerja"]) ? $_GET["masaKerja"] : -1;

    $dbh = $this->connect();

    if ($id_gaji != -1) {
      $sth = $dbh->prepare("SELECT * FROM gaji_pokok WHERE id=?");
      $sth->execute([$id_gaji]);
    } else {
      if ($golongan == -1 && $masaKerja == -1) {
        $sth = $dbh->prepare("SELECT * FROM gaji_pokok");
        $sth->execute([]);
      } else if ($golongan != -1 && $masaKerja == -1) {
        $sth = $dbh->prepare("SELECT * FROM gaji_pokok WHERE golongan=?");
        $sth->execute([$golongan]);
      } else if ($golongan == -1 && $masaKerja != -1) {
        $sth = $dbh->prepare("SELECT * FROM gaji_pokok WHERE masa_kerja=".intval($masaKerja));
        $sth->execute([]);
      } else if ($golongan != -1 && $masaKerja != -1) {
        $sth = $dbh->prepare("SELECT * FROM gaji_pokok WHERE golongan=? AND masa_kerja=".intval($masaKerja));
        $sth->execute([$golongan]);
      }
    }

    $allGaji = [];
		while ($row = $sth->fetchObject()) {
			array_push($allGaji, $row);
		}

		return json_encode($allGaji);
  }
}