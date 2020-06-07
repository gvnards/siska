<?php
class CreatePotongan extends Conn {
  public function InsertPotongan() {
    $potongans = isset($_POST['potongans']) ? $_POST['potongans'] : json_decode(file_get_contents('php://input'))->potongans;

    $query = "";

    foreach ($potongans as $potongan) {
      $query = $query."('$potongan->nama', '$potongan->jenis', $potongan->potongan),";
    }

    $query = substr($query, 0, strlen($query)-1);

    $dbh = $this->connect();

    $sth = $dbh->prepare("INSERT INTO potongan (potongan.nama, potongan.jenis, potongan.potongan) VALUES $query;");
    
		$sth->execute([]);

		return json_encode([
      "callback" => $sth->rowCount() > 0 ? true : false
    ]);
  }
}