<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?php


if($_POST['adm_id'] != NULL){
  $sql = "SELECT COUNT(*) FROM member WHERE adm_id='{$_POST['adm_id']}'";
  $result = mysqli_query($conn, $sql);
  $member = mysqli_fetch_array($result);
  $id_check = $member[0];

  if($id_check >= 1){
  	echo "<p style='color:#F00;'>존재하는 아이디입니다.</p>";
  } else {
  	echo "<p>사용 가능한 아이디입니다.</p>";
  }
}


?>
