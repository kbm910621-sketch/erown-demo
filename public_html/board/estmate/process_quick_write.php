<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

header('Content-Type: application/json; charset=utf-8');

$est_company  = isset($_POST['in_company']) ? chkXSS(trim($_POST['in_company'])) : '';
$est_name     = isset($_POST['in_name']) ? chkXSS(trim($_POST['in_name'])) : '';
$est_phone    = isset($_POST['in_tel']) ? chkXSS(trim($_POST['in_tel'])) : '';
$est_email    = isset($_POST['in_email']) ? chkXSS(trim($_POST['in_email'])) : '';
$est_position = isset($_POST['in_position']) && trim($_POST['in_position']) !== '' ? chkXSS(trim($_POST['in_position'])) : '-';
$est_ad_type  = isset($_POST['in_ad_type']) && trim($_POST['in_ad_type']) !== '' ? chkXSS(trim($_POST['in_ad_type'])) : '일반 문의';
$est_memo     = isset($_POST['in_memo']) ? chkXSS(trim($_POST['in_memo'])) : '';

$agree = isset($_POST['agree_privacy']) || isset($_POST['in_agree']) || isset($_POST['agree']);
if (!$agree) {
    echo json_encode(array('status' => 'error', 'message' => '개인정보 수집 및 이용에 동의해 주세요.'));
    exit;
}

if (!$est_company || !$est_name || !$est_phone || !$est_email || !$est_memo) {
    echo json_encode(array('status' => 'error', 'message' => '모든 항목을 입력해주세요.'));
    exit;
}

$regEmail = '/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/';
if (!preg_match($regEmail, $est_email)) {
    echo json_encode(array('status' => 'error', 'message' => '유효한 이메일 주소를 입력해주세요.'));
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
    echo json_encode(array('status' => 'error', 'message' => '접수 처리 중 데이터베이스 오류가 발생했습니다.'));
} else {
    echo json_encode(array('status' => 'success', 'message' => '문의가 정상적으로 접수되었습니다. 확인 후 담당자가 신속히 연락드리겠습니다.'));
}
?>