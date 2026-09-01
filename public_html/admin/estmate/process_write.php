<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";

$est_type = $_POST['in_type'];
$est_name = chkXSS($_POST['in_name']);
$est_gender = $_POST['in_gender'];
$in_tel1 = $_POST['in_tel1'];
$in_tel2 = $_POST['in_tel2'];
$in_tel3 = $_POST['in_tel3'];
$est_phone = $in_tel1."-".$in_tel2."-".$in_tel3;
$est_email = $_POST['in_email'];
$est_location = $_POST['in_location'];
$est_visit = $_POST['in_visit'];
// $u_name = chkXSS($_POST['u_name']);


//쿼리전송
$sql = "
INSERT INTO estmate
(est_type, est_name, est_gender, est_phone, est_email, est_location, est_visit, est_regdate)
VALUES (
    '$est_type',
    '$est_name',
    '$est_gender',
    '$est_phone',
    '$est_email',
    '$est_location',
    '$est_visit',
    NOW()
)
";



$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($conn));
} else {
    echo "<script type='text/javascript'>alert('글을 작성했습니다');";
    echo "location.href='list.php';";
    echo "</script>";
    //header('location: author.php'); //redirect
}
?>
