<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$tit_uid = $_POST['tit_uid'];
$tit_ch1 = chkXSS($_POST['tit_ch1']);
$tit_ch2 = chkXSS($_POST['tit_ch2']);
$tit_ch3 = chkXSS($_POST['tit_ch3']);
$tit_ch4 = chkXSS($_POST['tit_ch4']);
$tit_ch5 = chkXSS($_POST['tit_ch5']);
$tit_ch6 = chkXSS($_POST['tit_ch6']);
$tit_ch7 = chkXSS($_POST['tit_ch7']);
$tit_ch8 = chkXSS($_POST['tit_ch8']);
$tit_ch9 = chkXSS($_POST['tit_ch9']);
$tit_ch10 = chkXSS($_POST['tit_ch10']);
$tit_ch11 = chkXSS($_POST['tit_ch11']);
$tit_ch12 = chkXSS($_POST['tit_ch12']);
$tit_ch13 = chkXSS($_POST['tit_ch13']);

//쿼리전송
$sql = "
UPDATE title
    SET
        tit_ch1 = '$tit_ch1',
        tit_ch2 = '$tit_ch2',
        tit_ch3 = '$tit_ch3',
        tit_ch4 = '$tit_ch4',
        tit_ch5 = '$tit_ch5',
        tit_ch6 = '$tit_ch6',
        tit_ch7 = '$tit_ch7',
        tit_ch8 = '$tit_ch8',
        tit_ch9 = '$tit_ch9',
        tit_ch10 = '$tit_ch10',
        tit_ch11 = '$tit_ch11',
        tit_ch12 = '$tit_ch12',
        tit_ch13 = '$tit_ch13'
";

$result = mysqli_query($conn, $sql);

if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($conn));
} else {
    echo "<script type='text/javascript'>alert('타이틀을 변경했습니다');";
    echo "location.href='title_change.php';";
    echo "</script>";
}
?>
