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

			<form name="frm" action="frm" method="post" enctype="multipart/form-data">
			<!--board_A0_write-->
			<div class="board_A0_W">
				<table summary="팝업 제목, 노출 기간, 노출 여부, 팝업 위치, 팝업 크기, 팝업 내용을 등록합니다">
					<caption>팝업 관리</caption>
					<colgroup>
						<col width="150px" />
						<col width="*" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">팝업제목</th>
							<td><input type="text" name="pop_title" id="pop_title" class="input_type01 w_100p"></td>
						</tr>
						<tr>
							<th scope="row">노출 기간</th>
							<td>
								<div class="date_pick">
									<input type="text" class="date_cell input_type01 w_100" name="pop_start" id="pop_start" value="<?=$row['pop_start']?>" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="10" />
									<label class="icon_date" for="pop_start">시작일</label>
								</div>
								<span class="date_space">~</span>
								<div class="date_pick">
									<input type="text" class="date_cell input_type01 w_100" name="pop_end" id="pop_end" value="<?=$row['pop_end']?>" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="10" />
									<label class="icon_date" for="pop_end">종료일</label>
								</div>
							</td>
						</tr>
						<tr>
							<th scope="row">노출여부</th>
							<td>
								<ul class="rc_box">
									<li>
										<input type="radio" class="chk_type01" name="pop_view" id="" value="Y" <?if($row['pop_view']=="Y"||$row['pop_view']==""){?>checked<?}?> />
										<label for="">노출</label>
									</li>
									<li>
										<input type="radio" class="chk_type01" name="pop_view" id="" value="N" <?if($row['pop_view']=="N"){?>checked<?}?> />
										<label for="">미노출</label>
									</li>
								</ul>
							</td>
						</tr>
						<tr>
							<th scope="row">팝업 위치</th>
							<td>
								상단 <input type="text" class="input_type01 w_100" name="pop_top" id="pop_top" value="0" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"/> PX
								<span class="space"></span>
								좌측 <input type="text" class="input_type01 w_100" name="pop_left" id="pop_left" value="0" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"/> PX
							</td>
						</tr>
						<tr>
							<th scope="row">팝업 크기</th>
							<td>가로 <input type="text" class="input_type01 w_100" name="pop_width" id="pop_width" value="200" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"/> PX</td>
						</tr>
						<tr>
							<th scope="row">팝업 내용</th>
							<td>
								<!-- <p class="exp mab_5">총 20MBytes 이하</p> -->
								<ul class="file_Box">
									<li><input type="file" class="file_type01" id="pop_file" name="userfile[]" title="첨부파일 선택" /></li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			</form>
			<script type="text/javascript">
			$("#pop_start").datepicker({
				dateFormat:"yy-mm-dd",
				dayNamesMin:["일", "월", "화", "수", "목", "금", "토"],
				monthNames:["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
				showMonthAfterYear:true,
				yearSuffix: "년",
				minDate: '0'
			});
			$("#pop_end").datepicker({
				dateFormat:"yy-mm-dd",
				dayNamesMin:["일", "월", "화", "수", "목", "금", "토"],
				monthNames:["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
				showMonthAfterYear:true,
				yearSuffix: "년",
				minDate: '0'
			});
			//form 체크
			$(function () {
				$('input').attr('title', '내용을 입력하세요'); //입력가이드
				$('#btn_submit').click(function(){
					if(!chkForm('pop_title', '제목을', 'input', '2')) return;
					if(!chkForm('pop_start', '시작일을', 'input', '10')) return;
					if(!chkForm('pop_end', '종료일을', 'input', '10')) return;
					if($('#pop_start').val() > $('#pop_end').val()){
						alert('종료일이 시작일 이전 입니다.');
						return;
					}
					if(!chkForm('pop_file', '팝업내용을', 'input', '2')) return;
					document.frm.action="process_write.php";
					document.frm.submit();
				});
			});
			</script>
			<!--//board_A0_write-->
			<!--button-->
			<div class="button a_r mat_30">
				<input type="button" class="btn_1 size_n" value="확인" id="btn_submit">
				<input type="button" class="btn_2 size_n" value="취소" onclick="location.href='list.php'">
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
