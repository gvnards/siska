<?php
class UpdateProfil extends Conn {
  public function EditProfil () {
    $id = isset($_POST['id']) ? $_POST['id'] : json_decode(file_get_contents('php://input'))->id;
    $status_perkawinan = isset($_POST['status_perkawinan']) ? $_POST['status_perkawinan'] : json_decode(file_get_contents('php://input'))->status_perkawinan;
    $is_pasangan_pns = isset($_POST['is_pasangan_pns']) ? $_POST['is_pasangan_pns'] : json_decode(file_get_contents('php://input'))->is_pasangan_pns;
    $is_greater_than = isset($_POST['is_greater_than']) ? $_POST['is_greater_than'] : json_decode(file_get_contents('php://input'))->is_greater_than;
    $jumlah_anak = isset($_POST['jumlah_anak']) ? $_POST['jumlah_anak'] : json_decode(file_get_contents('php://input'))->jumlah_anak;

    $dbh = $this->connect();

    $sth = $dbh->prepare("UPDATE profil_pegawai SET status_perkawinan=?, is_pasangan_pns=?, is_greater_than=?, jumlah_anak=? WHERE id=?");
    $sth->execute([intval($status_perkawinan), intval($is_pasangan_pns), intval($is_greater_than), intval($jumlah_anak), intval($id)]);

    return json_encode([
      "callback" => $sth->rowCount()
    ]);
  }
}