<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$adm_uid = $_POST['adm_uid'];
$adm_id = $_POST['adm_id'];
$adm_name = $_POST['adm_name'];
$adm_pws = $_POST['adm_pw'];
$adm_regdate = $_POST['adm_regdate'];

$adm_pw = md5($adm_pws); //비밀번호 암호화

// if(substr($adm_id,"12"))alert("회원아이디는 12자 까지만 허용됩니다.");
// if(preg_match("/[^a-z 0-9]/",$adm_id ))alert("아이디는 영문소문자와 숫자만 가능합니다.");
// if(!preg_match('/^[a-z\d][\w\d_\.-]+@[a-z\d][\w\d-]+[\.][a-z\.]{2,8}$/',$email)){
// alert("이메일주소가 잘못되었습니다.");
// }

$sql2 = "SELECT COUNT(*) FROM member WHERE adm_id='$adm_id'";
$result2 = mysqli_query($conn, $sql2);
$member2 = mysqli_fetch_array($result2);
$id_check = $member2[0];

echo $id_check;

if($id_check >= 1){
  alert("아이디가 중복됩니다.");
}

// 쿼리전송
$sql = "
  INSERT INTO member
  (adm_uid, adm_id, adm_name, adm_pw, adm_regdate)
  VALUES (
    '$adm_uid',
    '$adm_id',
    '$adm_name',
    '$adm_pw',
    NOW()
  )
";

$result = mysqli_query($conn, $sql);
if($result === false){
  echo '저장하는 과정에서 문제가 생겼습니다.';
  error_log(mysqli_error($conn));
} else {
  echo "<script type='text/javascript'>alert('관리자 등록 완료');";
  echo "location.href='/index.php';";
  echo "</script>";
}
?>
