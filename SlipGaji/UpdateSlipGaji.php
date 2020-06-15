<?php
class UpdateSlipGaji extends Conn {
  public function EditSlipGaji () {
    $id = isset($_POST['id']) ? $_POST['id'] : json_decode(file_get_contents('php://input'))->id;
    $nip = isset($_POST['nip']) ? $_POST['nip'] : json_decode(file_get_contents('php://input'))->nip;
    $nama = isset($_POST['nama']) ? $_POST['nama'] : json_decode(file_get_contents('php://input'))->nama;
    $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : json_decode(file_get_contents('php://input'))->jenis;
    $golongan = isset($_POST['golongan']) ? $_POST['golongan'] : json_decode(file_get_contents('php://input'))->golongan;
    $tunjangan_jabatan = isset($_POST['tunjanganJabatan']) ? $_POST['tunjanganJabatan'] : json_decode(file_get_contents('php://input'))->tunjanganJabatan;
    $tunjangan_suami_istri = isset($_POST['tunjanganSuamiIstri']) ? $_POST['tunjanganSuamiIstri'] : json_decode(file_get_contents('php://input'))->tunjanganSuamiIstri;
    $tunjangan_anak = isset($_POST['tunjanganAnak']) ? $_POST['tunjanganAnak'] : json_decode(file_get_contents('php://input'))->tunjanganAnak;
    $tunjangan_beras = isset($_POST['tunjanganBeras']) ? $_POST['tunjanganBeras'] : json_decode(file_get_contents('php://input'))->tunjanganBeras;
    $id_potongan = isset($_POST['idPotongan']) ? $_POST['idPotongan'] : json_decode(file_get_contents('php://input'))->idPotongan;
    $id_potongan_lainlain = isset($_POST['idPotonganLainLain']) ? $_POST['idPotonganLainLain'] : json_decode(file_get_contents('php://input'))->idPotonganLainLain;
    $id_tunjangan = isset($_POST['idTunjangan']) ? $_POST['idTunjangan'] : json_decode(file_get_contents('php://input'))->idTunjangan;
    $tanggal_slip = isset($_POST['tanggalSlip']) ? $_POST['tanggalSlip'] : json_decode(file_get_contents('php://input'))->tanggalSlip;
    $total_gaji = isset($_POST['totalGaji']) ? $_POST['totalGaji'] : json_decode(file_get_contents('php://input'))->totalGaji;
    $total_tunjangan = isset($_POST['totalTunjangan']) ? $_POST['totalTunjangan'] : json_decode(file_get_contents('php://input'))->totalTunjangan;
    $total_potongan = isset($_POST['totalPotongan']) ? $_POST['totalPotongan'] : json_decode(file_get_contents('php://input'))->totalPotongan;

    $dbh = $this->connect();

    // insert POTONGAN LAIN LAIN (if any)
    if ($id_potongan_lainlain !== 0) {
      $sth = $dbh->prepare("INSERT INTO potongan_lainlain (potongan) VALUES(?);");
      $sth->execute([$id_potongan_lainlain]);
      $id_potongan_lainlain = $dbh->lastInsertId();
    }

    // update SLIP GAJI
    $sth = $dbh->prepare("UPDATE slip_gaji SET nip=?, nama=?, jenis=?, golongan=?, tunjangan_jabatan=?, tunjangan_suami_istri=?, tunjangan_anak=?, tunjangan_beras=?, id_potongan_lainlain=?, tanggal_slip=?, total_gaji=?, total_tunjangan=?, total_potongan=? WHERE id=?");
    $sth->execute([$nip, $nama, $jenis, $golongan, $tunjangan_jabatan, $tunjangan_suami_istri, $tunjangan_anak, $tunjangan_beras, $id_potongan_lainlain, $tanggal_slip, $total_gaji, $total_tunjangan, $total_potongan, $id]);

    // delete POTONGAN
    $sth = $dbh->prepare("DELETE FROM slip_gaji_potongan WHERE id_slip=?;");
    $sth->execute([$id]);

    // insert POTONGAN
    foreach ($id_potongan as $key => $value) {
      $sth = $dbh->prepare("INSERT INTO slip_gaji_potongan(id_potongan, id_slip) VALUES(?, ?)");
      $sth->execute([$value, $id]);
    }

    // delete TUNJANGAN
    $sth = $dbh->prepare("DELETE FROM slip_gaji_tunjangan WHERE id_slip=?;");
    $sth->execute([$id]);

    // insert TUNJANGAN
    foreach ($id_tunjangan as $key => $value) {
      $sth = $dbh->prepare("INSERT INTO slip_gaji_tunjangan(id_tunjangan, id_slip) VALUES(?, ?)");
      $sth->execute([$value, $id]);
    }

    return json_encode([
      "callback" => $sth->rowCount() > 0 ? true : false
    ]);
  }
}