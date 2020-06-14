<?php
include_once 'excel_reader.php';

class ImportExcel extends Conn {
  public function GajiPokok () {
    // upload file xls
    $target = $_SERVER['DOCUMENT_ROOT']."\/siska_server\/temp\/".basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $target);
    // beri permisi agar file xls dapat di baca
    chmod($target, 0777);
    // ambil data dari file xls
    $data = new Spreadsheet_Excel_Reader($target, false);
    // hitung jumlah baris dari data
    $jml_baris = $data->rowcount($sheet_index=0);

    $counting = 0;

    $dbh = $this->connect();
    for ($i=2; $i<=$jml_baris; $i++) {
      if ($data->val($i, 1) !== "" && $data->val($i, 2) !== "" && $data->val($i, 3) !== "") {
        $sth = $dbh->prepare("INSERT INTO gaji_pokok (golongan, masa_kerja, gaji) VALUES (?, ?, ?);");
        $sth->execute([
          $data->val($i, 1),
          $data->val($i, 2),
          $data->val($i, 3)
        ]);
        $counting++;
      }
    }
    return json_encode([
      "callback" => $counting > 0 ? true : false
    ]);
  }
}