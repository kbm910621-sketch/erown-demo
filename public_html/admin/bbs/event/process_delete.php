<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$ev_uid = $_POST['ev_uid'];


 //파일삭제 추가
 $sql = "SELECT * FROM evnet WHERE ev_uid = $ev_uid";
 $result = mysqli_query($conn, $sql);
 $row = mysqli_fetch_array($result);

 $total = 5;
 for($i=0; $i<$total; $i++) {
    $del_file= 'uploads/'.$row['ev_file'.$i];
    if($row['ev_file'.$i] && is_file($del_file)) unlink($del_file);
 }

//쿼리전송
$sql = "
DELETE
    FROM event
    WHERE ev_uid = '$ev_uid'
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
