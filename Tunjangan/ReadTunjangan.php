<?php
class ReadTunjangan extends Conn {
  public function GetTunjangan() {
    $dbh = $this->connect();

    if (!isset($_GET['idSlip'])) {
      $sth = $dbh->prepare("SELECT * FROM tunjangan WHERE id<>0");
      $sth->execute([]);
    } else {
      $sth = $dbh->prepare("SELECT tunjangan.id AS id, tunjangan.nama AS nama, tunjangan.jenis AS jenis, tunjangan.tunjangan AS tunjangan FROM tunjangan, slip_gaji_tunjangan WHERE tunjangan.id=slip_gaji_tunjangan.id_tunjangan AND slip_gaji_tunjangan.id_slip=?");
      $sth->execute([$_GET['idSlip']]);
    }

    $allTunjangan = [];
		while ($row = $sth->fetchObject()) {
			array_push($allTunjangan, $row);
		}

		return json_encode($allTunjangan);
  }
}