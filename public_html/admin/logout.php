<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

if($_SESSION['MID']!=''){
	session_unset();
	echo "
	<script>
	window.alert('로그아웃 되었습니다.');
	location.href='/admin/login.php'
	</script>
	";
}
?>
