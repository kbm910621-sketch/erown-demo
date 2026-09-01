<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$user_uid = $_POST['user_uid'];
$user_title = chkXSS($_POST['user_title']);
$user_description = chkXSS($_POST['user_description']);

//쿼리전송
$sql = "
UPDATE user
SET
    user_title = '$user_title',
    user_description = '$user_description'
WHERE
    user_uid = '$user_uid'
";

$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($conn));
} else {
    echo "<script type='text/javascript'>alert('글을 수정했습니다');";
    echo "location.href='list.php';";
    echo "</script>";
    //header('location: author.php'); //redirect
}
?>
