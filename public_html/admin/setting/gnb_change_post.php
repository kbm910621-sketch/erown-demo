<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$gnb_uid = $_POST['gnb_uid'];
$gnb_main_cnt = chkXSS($_POST['gnb_main_cnt']);
$gnb_suba_cnt = chkXSS($_POST['gnb_suba_cnt']);
$gnb_subb_cnt = chkXSS($_POST['gnb_subb_cnt']);
$gnb_subc_cnt = chkXSS($_POST['gnb_subc_cnt']);
$gnb_subd_cnt = chkXSS($_POST['gnb_subd_cnt']);
$gnb_sube_cnt = chkXSS($_POST['gnb_sube_cnt']);
$gnb_subf_cnt = chkXSS($_POST['gnb_subf_cnt']);
$gnb_subg_cnt = chkXSS($_POST['gnb_subg_cnt']);
$gnb_subh_cnt = chkXSS($_POST['gnb_subh_cnt']);
$gnb_subi_cnt = chkXSS($_POST['gnb_subi_cnt']);
$gnb_subj_cnt = chkXSS($_POST['gnb_subj_cnt']);
$gnb_main = chkXSS($_POST['gnb_main']);
$gnb_suba0 = chkXSS($_POST['gnb_suba0']);
$gnb_suba1 = chkXSS($_POST['gnb_suba1']);
$gnb_suba2 = chkXSS($_POST['gnb_suba2']);
$gnb_suba3 = chkXSS($_POST['gnb_suba3']);
$gnb_suba4 = chkXSS($_POST['gnb_suba4']);
$gnb_suba5 = chkXSS($_POST['gnb_suba5']);
$gnb_suba6 = chkXSS($_POST['gnb_suba6']);
$gnb_suba7 = chkXSS($_POST['gnb_suba7']);
$gnb_suba8 = chkXSS($_POST['gnb_suba8']);
$gnb_suba9 = chkXSS($_POST['gnb_suba9']);

//쿼리전송
$sql = "
UPDATE GNB
    SET
        gnb_main_cnt = '$gnb_main_cnt',
        gnb_suba_cnt = '$gnb_suba_cnt',
        gnb_subb_cnt = '$gnb_subb_cnt',
        gnb_subc_cnt = '$gnb_subc_cnt',
        gnb_subd_cnt = '$gnb_subd_cnt',
        gnb_sube_cnt = '$gnb_sube_cnt',
        gnb_subf_cnt = '$gnb_subf_cnt',
        gnb_subg_cnt = '$gnb_subg_cnt',
        gnb_subh_cnt = '$gnb_subh_cnt',
        gnb_subi_cnt = '$gnb_subi_cnt',
        gnb_subj_cnt = '$gnb_subj_cnt',
        gnb_main = '$gnb_main',
        gnb_suba0 = '$gnb_suba0',
        gnb_suba1 = '$gnb_suba1',
        gnb_suba2 = '$gnb_suba2',
        gnb_suba3 = '$gnb_suba3',
        gnb_suba4 = '$gnb_suba4',
        gnb_suba5 = '$gnb_suba5',
        gnb_suba6 = '$gnb_suba6',
        gnb_suba7 = '$gnb_suba7',
        gnb_suba8 = '$gnb_suba8',
        gnb_suba9 = '$gnb_suba9'
";

$result = mysqli_query($conn, $sql);

if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($conn));
} else {
    echo "<script type='text/javascript'>alert('메뉴를 변경했습니다');";
    echo "location.href='gnb_change.php';";
    echo "</script>";
}
?>
