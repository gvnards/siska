<?php
class ReadSlipGaji extends Conn {
  public function GetJenisSlip () {
    $dbh = $this->connect();

		$sth = $dbh->prepare("SELECT * FROM jenis_slip");
    $sth->execute([]);

    $allJenisSlip = [];
		while ($row = $sth->fetchObject()) {
			array_push($allJenisSlip, $row);
		}

		return json_encode($allJenisSlip);
  }

  public function GetSlipGaji () {
    $nips = isset($_GET['nips']) ? $_GET['nips'] : 0;
    $nip = isset($_GET['nip']) ? $_GET['nip'] : 0;
    $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : 0;
    $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : 0;

    $dbh = $this->connect();

    if ($nips !== 0) {
      if (!is_array($nips)) {
        $nips = explode(",", $nips);
      }
      $queryNips = "(";
      foreach ($nips as $key => $value) {
        $queryNips .= "slip.nip=$value OR ";
      }
      $queryNips = substr($queryNips, 0, strlen($queryNips)-4).")";

      if ($tahun !== 0 && $bulan !== 0) {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE $queryNips AND slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id AND slip.tanggal_slip LIKE ?
        ORDER BY slip.id;");
        $sth->execute([$tahun.'-'.$bulan.'-%']);
      } else if ($tahun !== 0 && $bulan === 0) {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE $queryNips AND slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id AND slip.tanggal_slip LIKE ?
        ORDER BY slip.id;");
        $sth->execute([$tahun.'-%']);
      } else if ($tahun === 0 && $bulan !== 0) {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE $queryNips AND slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id AND slip.tanggal_slip LIKE ?
        ORDER BY slip.id;");
        $sth->execute(['%-'.$bulan.'-%']);
      } else {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE $queryNips AND slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id
        ORDER BY slip.id;");
        $sth->execute([]);
      }

      $allSlipGajiData = [];
      while ($row = $sth->fetchObject()) {
        array_push($allSlipGajiData, $row);
      }
  
      return json_encode($allSlipGajiData);
    }

    if ($nip !== 0) {
      if ($tahun !== 0 && $bulan !== 0) {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE slip.nip=? AND slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id AND slip.tanggal_slip LIKE ?
        ORDER BY slip.id;");
        $sth->execute([$nip, $tahun.'-'.$bulan.'-%']);
      } else if ($tahun !== 0 && $bulan === 0) {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE slip.nip=? AND slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id AND slip.tanggal_slip LIKE ?
        ORDER BY slip.id;");
        $sth->execute([$nip, $tahun.'-%']);
      } else if ($tahun === 0 && $bulan !== 0) {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE slip.nip=? AND slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id AND slip.tanggal_slip LIKE ?
        ORDER BY slip.id;");
        $sth->execute([$nip, '%-'.$bulan.'-%']);
      } else {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE slip.nip=? AND slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id
        ORDER BY slip.id;");
        $sth->execute([$nip]);
      }
    } else if ($nip === 0) {
      if ($tahun !== 0 && $bulan !== 0) {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id AND slip.tanggal_slip LIKE ?
        ORDER BY slip.id;");
        $sth->execute([$tahun.'-'.$bulan.'-%']);
      } else if ($tahun !== 0 && $bulan === 0) {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id AND slip.tanggal_slip LIKE ?
        ORDER BY slip.id;");
        $sth->execute([$tahun.'-%']);
      } else if ($tahun === 0 && $bulan !== 0) {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id AND slip.tanggal_slip LIKE ?
        ORDER BY slip.id;");
        $sth->execute(['%-'.$bulan.'-%']);
      } else {
        $sth = $dbh->prepare("SELECT slip.id AS id, slip.nip AS nip, slip.nama AS nama, jenis.jenis AS jenis_slip, slip.isGolonganAuto AS isGolonganAuto, slip.jenis AS id_jenis_slip, slip.tunjangan_jabatan AS tunjangan_jabatan, slip.tunjangan_suami_istri AS tunjangan_suami_istri, slip.tunjangan_anak AS tunjangan_anak, slip.tunjangan_beras AS tunjangan_beras, slip.jkk AS jkk, slip.jkm AS jkm, slip.bpjs AS bpjs, slip.iwp_1_persen AS iwp_1_persen, slip.iwp_8_persen AS iwp_8_persen, gapok.golongan AS golongan, gapok.masa_kerja AS masa_kerja, gapok.id AS id_gaji_pokok, gapok.gaji AS gaji_pokok, pot.id AS id_potongan, pot.nama AS nama_potongan, pot.jenis AS jenis_potongan, pot.potongan AS potongan, tun.id AS id_tunjangan, tun.nama AS nama_tunjangan, tun.jenis AS jenis_tunjangan, tun.tunjangan AS tunjangan, potl.jenis AS nama_potongan_lainlain, potl.potongan AS potongan_lainlain, slip.tanggal_slip AS tanggal_slip, slip.total_gaji AS penerimaan, slip.total_tunjangan AS total_tunjangan, slip.total_potongan AS total_potongan, slip.catatan AS catatan
        FROM slip_gaji AS slip, potongan AS pot, potongan_lainlain AS potl, tunjangan AS tun, gaji_pokok AS gapok, jenis_slip AS jenis, slip_gaji_potongan, slip_gaji_tunjangan
        WHERE slip.jenis=jenis.id AND slip.golongan=gapok.id AND slip_gaji_potongan.id_slip=slip.id AND slip_gaji_potongan.id_potongan=pot.id AND slip_gaji_tunjangan.id_slip=slip.id AND slip_gaji_tunjangan.id_tunjangan=tun.id AND slip.id_potongan_lainlain=potl.id
        ORDER BY slip.id;");
        $sth->execute([]);
      }
    }
    
    $allSlipGajiData = [];
		while ($row = $sth->fetchObject()) {
			array_push($allSlipGajiData, $row);
    }

		return json_encode($allSlipGajiData);
  }
}