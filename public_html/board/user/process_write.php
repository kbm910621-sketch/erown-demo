<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$user_title = chkXSS($_POST['user_title']);
$user_name = chkXSS($_POST['user_name']);
$user_description = chkXSS($_POST['user_description']);
$user_lock = $_POST['user_lock'];

$user_pwd = $_POST['user_pwd'];
// $user_pwd = md5($user_pws); //비밀번호 암호화


//쿼리전송
$sql = "
INSERT INTO user
(user_title, user_name, user_pwd, user_description, user_regdate )
VALUES (
    '$user_title',
    '$user_name',
    '$user_pwd',
    '$user_description',
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
}
?>
