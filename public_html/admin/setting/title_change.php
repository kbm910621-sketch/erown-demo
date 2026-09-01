<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<?
$sql = "SELECT * FROM title";
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
				<table summary="사이트 타이틀을 변경합니다">
					<caption>사이트 타이틀을 변경</caption>
					<colgroup>
						<col width="250px" />
						<col width="*" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row"><label for="tit_ch1">메인 타이틀</label></th>
							<td><input type="text" name="tit_ch1" id="tit_ch1" class="input_type01 w_100p" placeholder="메인 타이틀을 입력해주세요" value="<?=$row['tit_ch1']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch2">서브 타이틀 A</label></th>
							<td><input type="text" name="tit_ch2" id="tit_ch2" class="input_type01 w_100p" placeholder="서브 타이틀 A를 입력해주세요" value="<?=$row['tit_ch2']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch3">서브 타이틀 B</label></th>
							<td><input type="text" name="tit_ch3" id="tit_ch3" class="input_type01 w_100p" placeholder="서브 타이틀 B를 입력해주세요" value="<?=$row['tit_ch3']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch4">서브 타이틀 C</label></th>
							<td><input type="text" name="tit_ch4" id="tit_ch4" class="input_type01 w_100p" placeholder="서브 타이틀 C를 입력해주세요" value="<?=$row['tit_ch4']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch5">서브 타이틀 D</label></th>
							<td><input type="text" name="tit_ch5" id="tit_ch5" class="input_type01 w_100p" placeholder="서브 타이틀 D를 입력해주세요" value="<?=$row['tit_ch5']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch6">서브 타이틀 E</label></th>
							<td><input type="text" name="tit_ch6" id="tit_ch6" class="input_type01 w_100p" placeholder="서브 타이틀 E를 입력해주세요" value="<?=$row['tit_ch6']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch7">서브 타이틀 F</label></th>
							<td><input type="text" name="tit_ch7" id="tit_ch7" class="input_type01 w_100p" placeholder="서브 타이틀 F를 입력해주세요" value="<?=$row['tit_ch7']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch8">서브 타이틀 G</label></th>
							<td><input type="text" name="tit_ch8" id="tit_ch8" class="input_type01 w_100p" placeholder="서브 타이틀 G를 입력해주세요" value="<?=$row['tit_ch8']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch9">서브 타이틀 H</label></th>
							<td><input type="text" name="tit_ch9" id="tit_ch9" class="input_type01 w_100p" placeholder="서브 타이틀 H를 입력해주세요" value="<?=$row['tit_ch9']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch10">서브 타이틀 I</label></th>
							<td><input type="text" name="tit_ch10" id="tit_ch10" class="input_type01 w_100p" placeholder="서브 타이틀 I를 입력해주세요" value="<?=$row['tit_ch10']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch11">서브 타이틀 J</label></th>
							<td><input type="text" name="tit_ch11" id="tit_ch11" class="input_type01 w_100p" placeholder="서브 타이틀 J를 입력해주세요" value="<?=$row['tit_ch11']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch12">서브 타이틀 K</label></th>
							<td><input type="text" name="tit_ch12" id="tit_ch12" class="input_type01 w_100p" placeholder="서브 타이틀 K를 입력해주세요" value="<?=$row['tit_ch12']?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="tit_ch13">커뮤니티 타이틀(게시판)</label></th>
							<td><input type="text" name="tit_ch13" id="tit_ch13" class="input_type01 w_100p" placeholder="서브 타이틀 L를 입력해주세요" value="<?=$row['tit_ch13']?>"></td>
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
					if(!chkForm('tit_ch1', '메인 타이틀을', 'input', '4')) return;
					if(!chkForm('tit_ch2', '서브 타이틀 A를', 'input', '4')) return;
					if(!chkForm('tit_ch3', '서브 타이틀 B를', 'input', '4')) return;
					if(!chkForm('tit_ch4', '서브 타이틀 C를', 'input', '4')) return;
					if(!chkForm('tit_ch5', '서브 타이틀 D를', 'input', '4')) return;
					if(!chkForm('tit_ch6', '서브 타이틀 E를', 'input', '4')) return;
					if(!chkForm('tit_ch7', '서브 타이틀 F를', 'input', '4')) return;
					if(!chkForm('tit_ch8', '서브 타이틀 G를', 'input', '4')) return;
					if(!chkForm('tit_ch9', '서브 타이틀 H를', 'input', '4')) return;
					if(!chkForm('tit_ch10', '서브 타이틀 I를', 'input', '4')) return;
					if(!chkForm('tit_ch11', '서브 타이틀 J를', 'input', '4')) return;
					if(!chkForm('tit_ch12', '서브 타이틀 K를', 'input', '4')) return;
					if(!chkForm('tit_ch13', '서브 타이틀 L를', 'input', '4')) return;
					document.frm.action="title_change_post.php";
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
