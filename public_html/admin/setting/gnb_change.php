<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<?
$sql = "SELECT * FROM GNB";
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
				<p class="mab_10">메인메뉴와 서브메뉴 개수를 설정합니다.</p>
				<table summary="">
					<caption></caption>
					<tbody>
						<tr>
							<th scope="row"><label for="gnb_main_cnt">메인</label></th>
							<th scope="row"><label for="gnb_suba_cnt">서브1</label></th>
							<th scope="row"><label for="gnb_subb_cnt">서브2</label></th>
							<th scope="row"><label for="gnb_subc_cnt">서브3</label></th>
							<th scope="row"><label for="gnb_subd_cnt">서브4</label></th>
							<th scope="row"><label for="gnb_sube_cnt">서브5</label></th>
							<th scope="row"><label for="gnb_subf_cnt">서브6</label></th>
							<th scope="row"><label for="gnb_subg_cnt">서브7</label></th>
							<th scope="row"><label for="gnb_subh_cnt">서브8</label></th>
							<th scope="row"><label for="gnb_subi_cnt">서브9</label></th>
							<th scope="row"><label for="gnb_subj_cnt">서브10</label></th>
						</tr>
						<tr>
							<td><input type="text" name="gnb_main_cnt" id="gnb_main_cnt" class="input_type01 w_40" value="<?=$row['gnb_main_cnt']?>"></td>
							<td><input type="text" name="gnb_suba_cnt" id="gnb_suba_cnt" class="input_type01 w_40" value="<?=$row['gnb_suba_cnt']?>"></td>
							<td><input type="text" name="gnb_subb_cnt" id="gnb_subb_cnt" class="input_type01 w_40" value="<?=$row['gnb_subb_cnt']?>"></td>
							<td><input type="text" name="gnb_subc_cnt" id="gnb_subc_cnt" class="input_type01 w_40" value="<?=$row['gnb_subc_cnt']?>"></td>
							<td><input type="text" name="gnb_subd_cnt" id="gnb_subd_cnt" class="input_type01 w_40" value="<?=$row['gnb_subd_cnt']?>"></td>
							<td><input type="text" name="gnb_sube_cnt" id="gnb_sube_cnt" class="input_type01 w_40" value="<?=$row['gnb_sube_cnt']?>"></td>
							<td><input type="text" name="gnb_subf_cnt" id="gnb_subf_cnt" class="input_type01 w_40" value="<?=$row['gnb_subf_cnt']?>"></td>
							<td><input type="text" name="gnb_subg_cnt" id="gnb_subg_cnt" class="input_type01 w_40" value="<?=$row['gnb_subg_cnt']?>"></td>
							<td><input type="text" name="gnb_subh_cnt" id="gnb_subh_cnt" class="input_type01 w_40" value="<?=$row['gnb_subh_cnt']?>"></td>
							<td><input type="text" name="gnb_subi_cnt" id="gnb_subi_cnt" class="input_type01 w_40" value="<?=$row['gnb_subi_cnt']?>"></td>
							<td><input type="text" name="gnb_subj_cnt" id="gnb_subj_cnt" class="input_type01 w_40" value="<?=$row['gnb_subj_cnt']?>"></td>
						</tr>

					</tbody>
				</table>
			</div>

			<div class="board_A0_W mat_30">
				<p class="mab_10">메인메뉴와 서브메뉴 이름을 설정합니다</p>
				<table summary="">
					<caption></caption>
					<tbody>
						<tr>
						    <th scope="row"><label for="gnb_main">메인메뉴a</label></th>
						    <th scope="row"><label for="gnb_suba0">서브a1</label></th>
						    <th scope="row"><label for="gnb_suba1">서브a2</label></th>
						    <th scope="row"><label for="gnb_suba2">서브a3</label></th>
						    <th scope="row"><label for="gnb_suba3">서브a4</label></th>
						    <th scope="row"><label for="gnb_suba4">서브a5</label></th>
						    <th scope="row"><label for="gnb_suba5">서브a6</label></th>
						    <th scope="row"><label for="gnb_suba6">서브a7</label></th>
						    <th scope="row"><label for="gnb_suba7">서브a8</label></th>
						    <th scope="row"><label for="gnb_suba8">서브a9</label></th>
						    <th scope="row"><label for="gnb_suba9">서브a10</label></th>
						</tr>
						<tr>
						    <td><input type="text" name="gnb_main" id="gnb_main" class="input_type01 w_40" value="<?=$row['gnb_main']?>"></td>
						    <td><input type="text" name="gnb_suba0" id="gnb_suba0" class="input_type01 w_40" value="<?=$row['gnb_suba0']?>"></td>
						    <td><input type="text" name="gnb_suba1" id="gnb_suba1" class="input_type01 w_40" value="<?=$row['gnb_suba1']?>"></td>
						    <td><input type="text" name="gnb_suba2" id="gnb_suba2" class="input_type01 w_40" value="<?=$row['gnb_suba2']?>"></td>
						    <td><input type="text" name="gnb_suba3" id="gnb_suba3" class="input_type01 w_40" value="<?=$row['gnb_suba3']?>"></td>
						    <td><input type="text" name="gnb_suba4" id="gnb_suba4" class="input_type01 w_40" value="<?=$row['gnb_suba4']?>"></td>
						    <td><input type="text" name="gnb_suba5" id="gnb_suba5" class="input_type01 w_40" value="<?=$row['gnb_suba5']?>"></td>
						    <td><input type="text" name="gnb_suba6" id="gnb_suba6" class="input_type01 w_40" value="<?=$row['gnb_suba6']?>"></td>
						    <td><input type="text" name="gnb_suba7" id="gnb_suba7" class="input_type01 w_40" value="<?=$row['gnb_suba7']?>"></td>
						    <td><input type="text" name="gnb_suba8" id="gnb_suba8" class="input_type01 w_40" value="<?=$row['gnb_suba8']?>"></td>
						    <td><input type="text" name="gnb_suba9" id="gnb_suba9" class="input_type01 w_40" value="<?=$row['gnb_suba9']?>"></td>
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
					document.frm.action="gnb_change_post.php";
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
