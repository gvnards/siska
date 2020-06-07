<?php
class UpdateGaji extends Conn {
  public function EditGaji() {
    $gajis = isset($_POST['gajis']) ? $_POST['gajis'] : json_decode(file_get_contents('php://input'))->gajis;

    $dbh = $this->connect();

    $sth = $dbh->prepare("UPDATE gaji_pokok SET gaji_pokok.golongan=?, gaji_pokok.masa_kerja=".intval($gajis[0]->masaKerja).", gaji_pokok.gaji=".intval($gajis[0]->gaji)." WHERE id=".intval($gajis[0]->id).";");
    
		$sth->execute([$gajis[0]->gol."/".$gajis[0]->tingkat]);

		return json_encode([
      "callback" => $sth->rowCount() > 0 ? true : false
    ]);
  }
}