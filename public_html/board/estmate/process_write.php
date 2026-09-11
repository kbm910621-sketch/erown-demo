<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$est_company  = isset($_POST['in_company']) ? chkXSS(trim($_POST['in_company'])) : '';
$est_name     = isset($_POST['in_name']) ? chkXSS(trim($_POST['in_name'])) : '';
$est_phone    = isset($_POST['in_tel']) ? chkXSS(trim($_POST['in_tel'])) : '';
$est_email    = isset($_POST['in_email']) ? chkXSS(trim($_POST['in_email'])) : '';
$est_position = isset($_POST['in_position']) && trim($_POST['in_position']) !== '' ? chkXSS(trim($_POST['in_position'])) : '-';
$est_memo     = isset($_POST['in_memo']) ? chkXSS(trim($_POST['in_memo'])) : '';

$in_ad_type_arr = isset($_POST['in_ad_type']) ? (array)$_POST['in_ad_type'] : array();
$est_ad_type    = !empty($in_ad_type_arr) ? chkXSS(implode(', ', $in_ad_type_arr)) : '일반 문의';

$agree = isset($_POST['agree']) || isset($_POST['in_agree']) || isset($_POST['agree_privacy']);
if (!$agree) {
    echo "<script type='text/javascript'>alert('개인정보 수집 및 이용에 동의해 주세요.'); history.back();</script>";
    exit;
}

if (!$est_company || !$est_name || !$est_phone || !$est_email || !$est_ad_type) {
    echo "<script type='text/javascript'>alert('필수 항목을 모두 입력해주세요.'); history.back();</script>";
    exit;
}

$regEmail = '/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/';
if (!preg_match($regEmail, $est_email)) {
    echo "<script type='text/javascript'>alert('이메일 주소가 유효하지 않습니다.'); history.back();</script>";
    exit;
}

$sql = "
INSERT INTO estmate
(est_company, est_name, est_position, est_ad_type, est_phone, est_email, est_memo, est_regdate)
VALUES (
    '$est_company',
    '$est_name',
    '$est_position',
    '$est_ad_type',
    '$est_phone',
    '$est_email',
    '$est_memo',
    NOW()
)
";

$result = mysqli_query($conn, $sql);
if ($result === false) {
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($conn));
} else {
    echo "<script type='text/javascript'>alert('문의가 정상적으로 접수되었습니다. 확인 후 담당자가 신속히 연락드리겠습니다.'); location.href='write.php';</script>";
}
?>