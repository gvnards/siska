<?php
class DeleteGaji extends Conn {
  public function DelGaji() {
    $id = isset($_POST['id']) ? $_POST['id'] : json_decode(file_get_contents('php://input'))->id;
    
    $dbh = $this->connect();

    $sth = $dbh->prepare("DELETE FROM gaji_pokok WHERE id = ?");

    $sth->execute([$id]);

    return json_encode([
      "callback" => $sth->rowCount() > 0 ? true : false
    ]);
  }
}