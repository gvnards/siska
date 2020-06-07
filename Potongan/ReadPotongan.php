<?php
class ReadPotongan extends Conn {
  public function GetPotongan() {
    $dbh = $this->connect();

    if (!isset($_GET['idSlip'])) {
      $sth = $dbh->prepare("SELECT * FROM potongan WHERE id<>0");
      $sth->execute([]);
    } else {
      $sth = $dbh->prepare("SELECT potongan.id AS id, potongan.nama AS nama, potongan.jenis AS jenis, potongan.potongan AS potongan FROM potongan, slip_gaji_potongan WHERE potongan.id=slip_gaji_potongan.id_potongan AND slip_gaji_potongan.id_slip=?");
      $sth->execute([$_GET['idSlip']]);
    }
    
    $allPotongan = [];
		while ($row = $sth->fetchObject()) {
			array_push($allPotongan, $row);
		}

		return json_encode($allPotongan);
  }
}