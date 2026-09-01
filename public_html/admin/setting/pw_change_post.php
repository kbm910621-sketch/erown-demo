<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$adm_pw_old_be = $_POST['adm_pw_old'];
$adm_pw_new_be = $_POST['adm_pw_new'];

$adm_pw_old = md5($adm_pw_old_be); //비밀번호 암호화
$adm_pw_new = md5($adm_pw_new_be); //비밀번호 암호화

if($_SESSION['MPW']!=$adm_pw_old){
    alert("기존 비밀번호가 같지 않습니다.");
}

//쿼리전송
$sql = "
UPDATE member
    SET
        adm_pw = '$adm_pw_new',
        adm_pwdchange = now()
    WHERE
        adm_id='".$_SESSION['MID']."'
";

$result = mysqli_query($conn, $sql);

if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($conn));
} else {
    echo "<script type='text/javascript'>alert('비밀번호 변경 완료');";
    echo "location.href='/admin/main.php';";
    echo "</script>";
}
?>
