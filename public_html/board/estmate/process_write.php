<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$est_company  = chkXSS($_POST['in_company']);
$est_name     = chkXSS($_POST['in_name']);
$est_phone    = chkXSS($_POST['in_tel']);
$est_email    = chkXSS($_POST['in_email']);
$est_position = chkXSS($_POST['in_position']);
$est_memo     = chkXSS($_POST['in_memo']);

$in_ad_type_arr = isset($_POST['in_ad_type']) ? $_POST['in_ad_type'] : array();
$est_ad_type    = implode(', ', $in_ad_type_arr);

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
    echo "<script type='text/javascript'>alert('상담 신청이 완료되었습니다.'); location.href='write.php';</script>";
}
?>