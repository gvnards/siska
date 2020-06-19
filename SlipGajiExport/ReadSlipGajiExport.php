<?php
class ReadSlipGajiExport extends Conn {
  public function GetSlipGajiExport () {
    $id_slip = $_GET['idSlip'];
    $dbh = $this->connect();

    $sth = $dbh->prepare("SELECT slip_gaji.nip, slip_gaji.nama, slip_gaji.tunjangan_jabatan, slip_gaji.tunjangan_suami_istri, slip_gaji.tunjangan_anak, slip_gaji.tunjangan_beras, slip_gaji.jkk, slip_gaji.jkm, slip_gaji.bpjs, slip_gaji.iwp_1_persen, slip_gaji.iwp_8_persen, slip_gaji.tanggal_slip, slip_gaji.total_gaji, slip_gaji.total_tunjangan, slip_gaji.total_potongan, slip_gaji.catatan AS catatan, potongan_lainlain.jenis AS nama_potongan_lainlain, potongan_lainlain.potongan AS potongan_lainlain, gaji_pokok.gaji AS gaji_pokok
    FROM slip_gaji, potongan_lainlain, gaji_pokok
    WHERE slip_gaji.id_potongan_lainlain=potongan_lainlain.id AND slip_gaji.golongan=gaji_pokok.id AND slip_gaji.id=?");
    $sth->execute([$id_slip]);
    $slip = $sth->fetchObject();

    $sth = $dbh->prepare("SELECT tunjangan.nama, tunjangan.jenis, tunjangan.tunjangan
    FROM tunjangan, slip_gaji_tunjangan
    WHERE slip_gaji_tunjangan.id_tunjangan=tunjangan.id AND slip_gaji_tunjangan.id_slip=?");
    $sth->execute([$id_slip]);
    $tunjangan = [];
    while ($row = $sth->fetchObject()) {
      array_push($tunjangan, $row);
    }

    $sth = $dbh->prepare("SELECT potongan.nama, potongan.jenis, potongan.potongan
    FROM potongan, slip_gaji_potongan
    WHERE slip_gaji_potongan.id_potongan=potongan.id AND slip_gaji_potongan.id_slip=?");
    $sth->execute([$id_slip]);
    $potongan = [];
    while ($row = $sth->fetchObject()) {
      array_push($potongan, $row);
    }

    return json_encode([
      "slip" => $slip,
      "tunjangan" => $tunjangan,
      "potongan" => $potongan
    ]);
  }
}