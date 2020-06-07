<?php
class UpdatePotongan extends Conn {
  public function EditPotongan() {
    $potongans = isset($_POST['potongans']) ? $_POST['potongans'] : json_decode(file_get_contents('php://input'))->potongans;

    $dbh = $this->connect();

    $sth = $dbh->prepare("UPDATE potongan SET potongan.nama=?, potongan.jenis=?,potongan.potongan=".floatval($potongans[0]->potongan)." WHERE id=".intval($potongans[0]->id).";");
    
		$sth->execute([$potongans[0]->nama, $potongans[0]->jenis]);

		return json_encode([
      "callback" => $sth->rowCount() > 0 ? true : false
    ]);
  }
}