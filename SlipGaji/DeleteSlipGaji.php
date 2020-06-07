<?php
class DeleteSlipGaji extends Conn {
  public function DelSlipGaji () {
    $nip = isset($_POST['nip']) ? $_POST['nip'] : json_decode(file_get_contents('php://input'))->nip;
    $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : json_decode(file_get_contents('php://input'))->tanggal;
    $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : json_decode(file_get_contents('php://input'))->jenis;

    $dbh = $this->connect();

		$sth = $dbh->prepare("DELETE FROM slip_gaji WHERE nip=? AND tanggal_slip=? AND jenis=?");
    $sth->execute([$nip, $tanggal, $jenis]);
    
    return json_encode([
      "callback" => $sth->rowCount() > 0 ? true : false
    ]);
  }
}