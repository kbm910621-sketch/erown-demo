<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>
<script src="/smarteditor/js/service/HuskyEZCreator.js"></script>
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

			<form name="frm" action="frm" method="post" enctype="multipart/form-data">
			<!--board_A0_write-->
			<div class="board_A0_W">
				<table summary="갤러리입니다">
					<caption>갤러리</caption>
					<colgroup>
						<col width="100px" />
						<col width="*" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">제목</th>
							<td><input type="text" name="ph_title" id="ph_title" class="input_type01 w_100p"></td>
						</tr>
						<tr>
							<th scope="row">작성자</th>
							<td><input type="text" name="ph_author" id="ph_author" class="input_type01 w_100" value="<?=$_SESSION['MName']?>" readonly></td>
						</tr>
						<tr>
							<th scope="row">내용</th>
							<td><textarea name="ph_description" id="ph_description" class="textarea_type01 w_100p" style="display:none;"></textarea></td>
						</tr>
						<tr>
							<th scope="row">첨부파일</th>
							<td>
								<p class="exp mab_5">총 20MBytes 이하</p>
								<ul class="file_Box">
									<li><input type="file" class="file_type01" name="userfile[]" id="ga_file" title="첨부파일 선택" /></li>
									<li><input type="file" class="file_type01" name="userfile[]" title="첨부파일 선택" /></li>
									<li><input type="file" class="file_type01" name="userfile[]" title="첨부파일 선택" /></li>
									<li><input type="file" class="file_type01" name="userfile[]" title="첨부파일 선택" /></li>
									<li><input type="file" class="file_type01" name="userfile[]" title="첨부파일 선택" /></li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			</form>
			<script type="text/javascript">
			var oEditors = [];

			nhn.husky.EZCreator.createInIFrame({
				oAppRef: oEditors,
				elPlaceHolder: "ph_description", //textarea ID
				sSkinURI: "/smarteditor/SmartEditor2Skin.html", //skin경로
				fCreator: "createSEditor2"
			});

			function submitContents(elClickedObj) {
				oEditors.getById["ph_description"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
				// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
				chk_edit = document.getElementById("ph_description").value;
				//alert(chk_edit);
				try {
					elClickedObj.form.submit();
				} catch(e) {}
			}

			//form 체크
			$(function () {
				$('input').attr('title', '내용을 입력하세요'); //입력가이드
				$('#btn_submit').click(function(){
					if(!chkForm('ph_title', '제목을', 'input', '2')) return;
					// if(!chkForm('nt_author', '작성자를', 'input', '2')) return;
					//스마트에디터 값 체크
					if(chk_edit=='' || chk_edit==' ' || chk_edit==null || chk_edit=='<p>&nbsp;</p>' || chk_edit=='<p><br></p>'){
						alert('내용을 입력해주세요')
						oEditors.getById["ph_description"].exec("FOCUS");
						return;
					}
					if(!chkForm('ga_file', '이미지를', 'input', '2')) return;
					document.frm.action="process_write.php";
					document.frm.submit();
				});
			});
			</script>
			<!--//board_A0_write-->
			<!--button-->
			<div class="button a_r mat_30">
				<input type="button" class="btn_1 size_n" value="확인" id="btn_submit" onclick="submitContents();">
				<input type="button" class="btn_2 size_n" value="취소" onclick="history.back(-1);">
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
