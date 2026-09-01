<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<body class="bg_body">

<!--header-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php";?>
<!--//header-->

<!--wrap-->
<div id="wrap">
	<!--container-->
	<div id="container">
		<!--title-->
		<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/title.php";?>
		<!--//title-->

		<!--content-->
		<section class="content">

			<!--board_A0_write-->
			<form name="frm" action="frm" method="post">
			<div class="board_A0_W">
				<table summary="관리자 비밀번호를 변경합니다">
					<caption>관리자 비밀번호 변경</caption>
					<colgroup>
						<col width="150px" />
						<col width="*" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row"><label for="adm_pw_old">기존 비밀번호</label></th>
							<td><input type="password" name="adm_pw_old" id="adm_pw_old" class="input_type01 w_400" placeholder="기존 비밀번호를 입력해주세요"></td>
						</tr>
						<tr>
							<th scope="row"><label for="adm_pw_new">신규 비밀번호</label></th>
							<td><input type="password" name="adm_pw_new" id="adm_pw_new" class="input_type01 w_400" placeholder="신규 비밀번호를 입력해주세요"></td>
						</tr>
						<tr>
							<th scope="row"><label for="adm_pw_new_chk">비밀번호 확인</label></th>
							<td><input type="password" name="adm_pw_new_chk" id="adm_pw_new_chk" class="input_type01 w_400" placeholder="비밀번호를 다시 한번 입력해주세요"></td>
						</tr>
					</tbody>
				</table>
			</div>
			</form>
			<!--//board_A0_write-->
			<script type="text/javascript">
			//form 체크
			$(function () {
				$('input').attr('title', '내용을 입력하세요'); //입력가이드
				$('#btn_submit').click(function(){
					if(!chkForm('adm_pw_old', '기존비밀번호를', 'input', '4')) return;
					if(!chkForm('adm_pw_new', '신규비밀번호를', 'input', '4')) return;
					if(!chkForm('adm_pw_new_chk', '비밀번호 확인을', 'input', '4')) return;
					if($('#adm_pw_new').val() != $('#adm_pw_new_chk').val()){
						alert('비밀번호가 일치하지 않습니다.');
						return;
					}
					document.frm.action="pw_change_post.php";
					document.frm.submit();
				});
			});
			</script>
			<!--button-->
			<div class="button a_r mat_30">
				<input type="button" class="btn_1 size_n" value="확인" id="btn_submit">
				<input type="button" class="btn_2 size_n" value="취소" onclick="window.location.reload();">
			</div>
			<!--//button-->

		</section>
		<!--//content-->
	</div>
	<!--//container-->
</div>
<!--//wrap-->

</body>
</html>
