<?
$sql = "SELECT * FROM title";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$page_title = $row['tit_ch1'];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />
<meta name="format-detection" content="telephone=no" /><!-- 전화번호 자동링크 없애기 -->
<meta name="keywords" content=""><!-- 키워드 제공 -->
<meta name="description" content=""><!-- 요약정보 -->
<meta name="robots" content="all"><!-- 검색로봇 -->
<link type="text/css" rel="stylesheet" href="/admin/css/import.css">
<link type="text/css" rel="stylesheet" href="/admin/css/jquery-ui.css">
<script src="/admin/js/jquery-1.12.4.js"></script>
<script src="/admin/js/jquery-ui.js"></script>
<script src="/admin/js/checkform.js"></script>
<script src="/admin/js/img_size.js"></script>
<link rel="shortcut icon" href="/images/ge.ico" type="image/x-icon">
<title><?=$page_title?></title>
</head>
