<?php
class CreateGaji extends Conn {
  public function InsertGaji() {
    $gajis = isset($_POST['gajis']) ? $_POST['gajis'] : json_decode(file_get_contents('php://input'))->gajis;

    $query = "";

    foreach ($gajis as $gaji) {
      $query = $query."('$gaji->gol/$gaji->tingkat', $gaji->masaKerja, $gaji->gaji),";
    }

    $query = substr($query, 0, strlen($query)-1);

    $dbh = $this->connect();

    $sth = $dbh->prepare("INSERT INTO gaji_pokok (gaji_pokok.golongan, gaji_pokok.masa_kerja, gaji_pokok.gaji) VALUES $query;");
    
		$sth->execute([]);

		return json_encode([
      "callback" => $sth->rowCount() > 0 ? true : false
    ]);
  }
}