<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";

$id = $_GET['id'];
$del_num = $_POST['del_num'];

//파일삭제 추가
$sql = "SELECT * FROM event WHERE ev_uid = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);


$file_db = 'ev_file'.$del_num;

if($row[$file_db]){
    $sql = "
    UPDATE event SET
        $file_db = ''
    WHERE
        ev_uid = '$id'
    ";

    $del_file= 'uploads/'.$row['ev_file'.$del_num];
    if($row['ev_file'.$del_num] && is_file($del_file)) unlink($del_file);
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
