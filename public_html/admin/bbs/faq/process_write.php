<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$qn_title = chkXSS($_POST['qn_title']);
$qn_description = chkXSS($_POST['qn_description']);
$qn_author = $_SESSION['MName'];


//쿼리전송
$sql = "
INSERT INTO qna
(qn_title, qn_description, qn_author, qn_regdate)
VALUES (
    '$qn_title',
    '$qn_description',
    '$qn_author',
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
