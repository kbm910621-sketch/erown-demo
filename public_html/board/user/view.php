<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";?>


<body>

<?php
$bno = $_GET['id']; /*bno함수에 id값을 받아와 넣음*/
$sql = "SELECT * FROM user WHERE user_uid='".$bno."'";
$result = mysqli_query($conn, $sql);
$view_chk = mysqli_fetch_array($result);
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
            <input type="button" class="btn_2 size_s password_close" value="취소" onClick="location.href='list.php'">

        </div>
        <!--//button-->
	</div>
</div>
</form>
<!--//password-->
<div id="blank_layer" style="display:block; background:#404040; opacity:1;"></div>

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
$user_pwd = $view_chk['user_pwd'];

if(isset($_POST['user_pwd'])) { //만약 pw_chk POST값이 있다면
	$user_pwd_chk = $_POST['user_pwd']; // $pwk변수에 POST값으로 받은 pw_chk를 넣습니다.
	if($user_pwd_chk == $user_pwd) { //다시 if문으로 DB의 pw와 입력하여 받아온 bpw와 값이 같은지 비교를 하고
		$user_view_chk = 1;
		echo "
		 <script>
			$('#blank_layer').css('display','none');
			$('.password_layer').css('display','none');
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

<?php
if($user_view_chk === 1){
	$filtered_id = mysqli_real_escape_string($conn, $_GET['id']); //필터 보안
	$sql ="SELECT * FROM user WHERE user_uid={$filtered_id}";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);

	$update_link ='<a href="update.php?id='.$_GET['id'].'" class="btn_1 size_n">수정</a>';
	$delete_link ='
		<input type="hidden" name="user_uid" value="'.$_GET['id'].'" />
		<input type="submit" value="삭제" class="btn_3 size_n" />
	';

	//조회수 증가
	$no = $_GET['id'];
	if($no != $_COOKIE['hit_notice'.$no]){
		$sql = "UPDATE user SET user_hit=user_hit+1 WHERE user_uid='$no'"; //쿼리전송
		$result = mysqli_query($conn, $sql);
		setcookie('hit_notice'.$no,$no,time()+60*60*24,'/');
	}
	$row['user_regdate'] = mb_substr($row['user_regdate'], 0, 10); //제목 글자수 css 사용해도 됨
}


?>

<!-- <script>history.replaceState({}, null, location.pathname);</script> //뒤에주소 삭제 -->
<!--blank_layer-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/blank.php";?>
<!--//blank_layer-->
<!--skip-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/skip.php";?>
<!--//skip-->

<!--wrap-->
<div id="wrap">

	<!--header-->
    <?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php";?>
    <!--//header-->
	<!--visual-->
    <?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/visual.php";?>
    <!--//visual-->
	<!--lnb-->
    <?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/lnb.php";?>
    <!--//lnb-->

	<!--container-->
	<div id="container">
		<!--inner-->
		<div class="inner">

			<!--title-->
            <?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/title.php";?>
    		<!--//title-->
			<!--content-->
			<section class="content">
				<!--board_A0_view-->
				<div class="board_A0_V">
					<table summary="공지사항 상세보기로  제목, 작성일, 작성자, 첨부파일, 내용을 제공합니다.">
						<caption>공지사항 상세보기</caption>
						<colgroup>
							<col width="10%" />
							<col width="90%" />
						</colgroup>
						<tbody>
							<tr>
								<th colspan="2" scope="col" class="subject">
									<strong><?=$row['user_title']?></strong>
									<div class="sub_info">
										<span><?=$row['user_regdate']?></span>
										<span>조회 : <?=$row['user_hit']?></span>
									</div>
								</th>
							</tr>
							<tr>
								<th scope="row">작성자</th>
								<td><?=$row['user_name']?></td>
							</tr>
							<tr>
								<td colspan="2" class="body_matter">
									<?if($row['user_file0']){?>
									<img src="uploads/<?=$row['user_file0']?>">
									<?}?>
									<?=$row['user_description']?>
								</td>
							</tr>
							<tr class="reply">
								<th scope="row">답변</th>
								<td><?=$row['user_reply']?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!--//board_A0_view-->
				<!--button-->
				<div class="button a_r mat_30">
				<form action="process_delete.php" method="post" onsubmit="if(!confirm('글을 삭제할까요?')){return false;}">
					<?=$delete_link?>
					<input type="button" class="btn_2 size_n" value="목록" onClick="location.href='list.php'">
				</form>
				</div>
				<!--//button-->
			</section>
			<!--//content-->

		</div>
	    <!--//inner-->
	</div>
	<!--//container-->

	<!--footer-->
    <?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php";?>
    <!--//footer-->

</div>
<!--//wrap-->

</body>
</html>
