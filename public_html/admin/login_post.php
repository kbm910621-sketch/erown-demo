<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";


// 세션변수 create
function setsSession($name,$value){
	$$name = $_SESSION["$name"] = $value;
}

$adm_id = $_POST['adm_id'];
$adm_pws = $_POST['adm_pw'];
$adm_pw = md5($adm_pws); //비밀번호 암호화


//쿼리전송
$sql = "SELECT * FROM member WHERE adm_id='$adm_id'";
$result = mysqli_query($conn, $sql);
$member = mysqli_fetch_array($result);

if(!$member['adm_id']){
	alert("존재하지 않는 아이디입니다.");
}

if($member['adm_pw']!=$adm_pw){
	alert("비밀번호가 같지 않습니다.");
}

setsSession('MID',$adm_id);
setsSession('MName',$member['adm_name']);
setsSession('MPW',$adm_pw);

echo "
 <script>
 window.alert('로그인 되었습니다.');
 location.href='/admin/main.php'
 </script>
 ";
?>
