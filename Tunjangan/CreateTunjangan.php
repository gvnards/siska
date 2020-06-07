<?php
class CreateTunjangan extends Conn {
  public function InsertTunjangan() {
    $tunjangans = isset($_POST['tunjangans']) ? $_POST['tunjangans'] : json_decode(file_get_contents('php://input'))->tunjangans;

    $query = "";

    foreach ($tunjangans as $tunjangan) {
      $query = $query."('$tunjangan->nama', '$tunjangan->jenis', $tunjangan->tunjangan),";
    }

    $query = substr($query, 0, strlen($query)-1);

    $dbh = $this->connect();

    $sth = $dbh->prepare("INSERT INTO tunjangan (tunjangan.nama, tunjangan.jenis, tunjangan.tunjangan) VALUES $query;");

		$sth->execute([]);

		return json_encode([
      "callback" => $sth->rowCount() > 0 ? true : false
    ]);
  }
}