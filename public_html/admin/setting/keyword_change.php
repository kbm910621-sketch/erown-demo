<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<?
$sql = "SELECT * FROM keyword";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
?>
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
				<p class="mab_10">검색엔진에 노출되는 키워드(meta tag)를 관리합니다.</p>
				<table summary="관리자 비밀번호를 변경합니다">
					<caption>관리자 비밀번호 변경</caption>
					<colgroup>
						<col width="250px" />
						<col width="*" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row"><label for="key_ch1">사이트 제목</label></th>
							<td><input type="text" name="key_ch1" id="key_ch1" class="input_type01 w_100p" placeholder="사이트 제목을 입력해주세요" value="<?=$row['key_ch1']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="key_ch2">사이트 주소(url)</label></th>
							<td><input type="text" name="key_ch2" id="key_ch2" class="input_type01 w_100p" placeholder="사이트 주소를(http://url.com) 입력해주세요" value="<?=$row['key_ch2']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="key_ch3">사이트 대표 이미지(url)</label></th>
							<td><input type="text" name="key_ch3" id="key_ch3" class="input_type01 w_100p" placeholder="이미지 주소를(http://url.com) 입력해주세요" value="<?=$row['key_ch3']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="key_ch4">keywords</label></th>
							<td><input type="text" name="key_ch4" id="key_ch4" class="input_type01 w_100p" placeholder="키워드를 입력해주세요" value="<?=$row['key_ch4']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="key_ch5">description</label></th>
							<td><input type="text" name="key_ch5" id="key_ch5" class="input_type01 w_100p" placeholder="요약정보를 입력해주세요" value="<?=$row['key_ch5']?>"></td>
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
					if(!chkForm('key_ch1', '사이트 제목을', 'input', '4')) return;
					if(!chkForm('key_ch2', '사이트 주소를', 'input', '4')) return;
					if(!chkForm('key_ch3', '이미지 주소를', 'input', '4')) return;
					if(!chkForm('key_ch4', '키워드를', 'input', '4')) return;
					if(!chkForm('key_ch5', '요약정보를', 'input', '4')) return;
					document.frm.action="keyword_change_post.php";
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
