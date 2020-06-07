<?php
class UpdateTunjangan extends Conn {
  public function EditTunjangan() {
    $tunjangans = isset($_POST['tunjangans']) ? $_POST['tunjangans'] : json_decode(file_get_contents('php://input'))->tunjangans;

    $dbh = $this->connect();

    $sth = $dbh->prepare("UPDATE tunjangan SET tunjangan.nama=?, tunjangan.jenis=?,tunjangan.tunjangan=".floatval($tunjangans[0]->tunjangan)." WHERE id=".intval($tunjangans[0]->id).";");

		$sth->execute([$tunjangans[0]->nama, $tunjangans[0]->jenis]);

		return json_encode([
      "callback" => $sth->rowCount() > 0 ? true : false
    ]);
  }
}