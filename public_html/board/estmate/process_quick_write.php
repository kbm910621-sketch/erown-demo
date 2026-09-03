<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

header('Content-Type: application/json; charset=utf-8');

$est_company  = isset($_POST['in_company']) ? chkXSS($_POST['in_company']) : '';
$est_name     = isset($_POST['in_name']) ? chkXSS($_POST['in_name']) : '';
$est_phone    = isset($_POST['in_tel']) ? chkXSS($_POST['in_tel']) : '';
$est_email    = isset($_POST['in_email']) ? chkXSS($_POST['in_email']) : '';
$est_position = '담당자';
$est_memo     = isset($_POST['in_memo']) ? chkXSS($_POST['in_memo']) : '';
$est_ad_type  = '메인 하단 1:1 빠른 견적 문의';

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
    echo json_encode(array('status' => 'success', 'message' => '견적 문의가 정상 접수되었습니다! 전문 매니저가 신속히 연락드리겠습니다.'));
}
?>