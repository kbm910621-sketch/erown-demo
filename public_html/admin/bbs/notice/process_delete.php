<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$notice_uid = $_POST['notice_uid'];

//파일삭제 추가
$sql = "SELECT * FROM notice WHERE notice_uid = $notice_uid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
if($row['notice_file0']){
    $del_file= 'uploads/'.$row['notice_file0'];
    if($row['notice_file0'] && is_file($del_file)) unlink($del_file);
}


//쿼리전송
$sql = "
DELETE
    FROM notice
    WHERE notice_uid = '$notice_uid'
";

$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($conn));
} else {
    echo "<script type='text/javascript'>alert('글을 삭제했습니다');";
    echo "location.href='list.php';";
    echo "</script>";
    //header('location: author.php'); //redirect
}
?>
