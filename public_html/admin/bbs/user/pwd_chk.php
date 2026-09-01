<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<body>

<?php
$bno = $_GET['id']; /*bno함수에 id값을 받아와 넣음*/
$sql = "SELECT * FROM user WHERE user_uid='".$bno."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
?>

<!--password-->
<form name="frm" action="" method="post">
<div class="password_layer" style="display:block;">
	<div class="password_box">
		<div class="pass_tit">비밀번호 입력</div>
		<dl>
			<dt><label for="">비밀번호</label></dt>
			<dd><input type="password" name="user_pwd" id="user_pwd" class="input_type01 w_200" placeholder="비밀번호를 입력하세요"></dd>
		</dl>
        <!--button-->
        <div class="button mat_20">
            <input type="button" class="btn_1 size_s" value="확인" id="btn_submit">
            <input type="button" class="btn_2 size_s password_close" value="취소" onclick="history.back(-1);">

        </div>
        <!--//button-->
	</div>
</div>
</form>
<!--//password-->
<div id="blank_layer" style="display:block;"></div>

<script type="text/javascript">
//form 체크
$(function () {
	$('#btn_submit').click(function(){
		if(!chkForm('user_pwd', '비밀번호를', 'input', '4')) return;
		document.frm.submit();
	});
});
</script>

<?php
$user_pwd = $row['user_pwd'];

if(isset($_POST['user_pwd'])) { //만약 pw_chk POST값이 있다면
	$user_pwd_chk = $_POST['user_pwd']; // $pwk변수에 POST값으로 받은 pw_chk를 넣습니다.
	if($user_pwd_chk == $user_pwd) { //다시 if문으로 DB의 pw와 입력하여 받아온 bpw와 값이 같은지 비교를 하고
		echo "
		 <script>
		 location.href='view.php?id=$bno'
		 </script>
		 ";
	 }else{
		 echo "
		  <script>
		  window.alert('비밀번호가 다릅니다.');
		  location.href='list.php'
		  </script>
		  ";
	 }
}
?>


</body>
</html>
