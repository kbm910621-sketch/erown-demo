<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";

$id = $_GET['id'];
//파일삭제 추가
$sql = "SELECT * FROM notice WHERE notice_uid = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if($row['notice_file0']){
    $sql = "
    UPDATE notice
    SET
        notice_file0 = ''
    WHERE
        notice_uid = '$id'
    ";

    $del_file= 'uploads/'.$row['notice_file0'];
    if($row['notice_file0'] && is_file($del_file)) unlink($del_file);
}


$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($conn));
} else {
    echo "<script type='text/javascript'>alert('파일이 삭제 되었습니다.');";
    echo "location.href='update.php?id=$id';";
    echo "</script>";
}
?>
