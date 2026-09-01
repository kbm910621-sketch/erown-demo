<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$key_uid = $_POST['key_uid'];
$key_ch1 = chkXSS($_POST['key_ch1']);
$key_ch2 = chkXSS($_POST['key_ch2']);
$key_ch3 = chkXSS($_POST['key_ch3']);
$key_ch4 = chkXSS($_POST['key_ch4']);
$key_ch5 = chkXSS($_POST['key_ch5']);

//쿼리전송
$sql = "
UPDATE keyword
    SET
        key_ch1 = '$key_ch1',
        key_ch2 = '$key_ch2',
        key_ch3 = '$key_ch3',
        key_ch4 = '$key_ch4',
        key_ch5 = '$key_ch5'
";

$result = mysqli_query($conn, $sql);

if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($conn));
} else {
    echo "<script type='text/javascript'>alert('키워드를 변경했습니다');";
    echo "location.href='keyword_change.php';";
    echo "</script>";
}
?>
