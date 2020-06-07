<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-type: application/json; charset=utf-8;");
header("Access-Control-Allow-Headers: content-type");

if (!isset($_GET['onGet']) && !isset(json_decode(file_get_contents('php://input'))->onPost) && !isset($_POST['onPost'])) return;
include_once 'Conn/Conn.php';
foreach (glob('Gaji/*.php') as $filename) {
  include_once $filename;
}
foreach (glob('Potongan/*.php') as $filename) {
  include_once $filename;
}
foreach (glob('SlipGaji/*.php') as $filename) {
  include_once $filename;
}
foreach (glob('Login/*.php') as $filename) {
  include_once $filename;
}
foreach (glob('ProfilPegawai/*.php') as $filename) {
  include_once $filename;
}
foreach (glob('Tunjangan/*.php') as $filename) {
  include_once $filename;
}
foreach (glob('SlipGajiExport/*.php') as $filename) {
  include_once $filename;
}

if (isset($_GET['onGet'])) {
  $action = $_GET['onGet'];
  switch ($action) {
    case "GetSlipGajiExport":
      echo (new ReadSlipGajiExport)->GetSlipGajiExport();
      break;
    case "GetGaji":
      echo (new ReadGaji)->GetGaji();
      break;
    case "GetPotongan":
      echo (new ReadPotongan)->GetPotongan();
      break;
    case "GetJenisSlip":
      echo (new ReadSlipGaji)->GetJenisSlip();
      break;
    case "GetSlipGaji":
      echo (new ReadSlipGaji)->GetSlipGaji();
      break;
    case "Login":
      echo (new ReadLogin)->Login();
      break;
    case "GetDataAccount":
      echo (new ReadLogin)->GetDataAccount();
      break;
    case "GetProfil":
      echo (new ReadProfil)->GetProfil();
      break;
    case "GetTunjangan":
      echo (new ReadTunjangan)->GetTunjangan();
      break;
  }
} else if (isset(json_decode(file_get_contents('php://input'))->onPost) || isset($_POST['onPost'])) {
  $action = isset($_POST['onPost']) ? $_POST['onPost'] : json_decode(file_get_contents('php://input'))->onPost;
  switch ($action) {
    case "InsertGaji":
      echo (new CreateGaji)->InsertGaji();
      break;
    case "DelGaji":
      echo (new DeleteGaji)->DelGaji();
      break;
    case "InsertPotongan":
      echo (new CreatePotongan)->InsertPotongan();
      break;
    case "DelPotongan":
      echo (new DeletePotongan)->DelPotongan();
      break;
    case "EditGaji":
      echo (new UpdateGaji)->EditGaji();
      break;
    case "EditPotongan":
      echo (new UpdatePotongan)->EditPotongan();
      break;
    case "InsertSlipGaji":
      echo (new CreateSlipGaji)->InsertSlipGaji();
      break;
    case "EditSlipGaji":
      echo (new UpdateSlipGaji)->EditSlipGaji();
      break;
    case "DelSlipGaji":
      echo (new DeleteSlipGaji)->DelSlipGaji();
      break;
    case "InsertAccount":
      echo (new CreateLogin)->InsertAccount();
      break;
    case "InsertProfil":
      echo (new CreateProfil)->InsertProfil();
      break;
    case "EditProfil":
      echo (new UpdateProfil)->EditProfil();
      break;
    case "InsertTunjangan":
      echo (new CreateTunjangan)->InsertTunjangan();
      break;
    case "DelTunjangan":
      echo (new DeleteTunjangan)->DelTunjangan();
      break;
    case "EditTunjangan":
      echo (new UpdateTunjangan)->EditTunjangan();
      break;
  }
}