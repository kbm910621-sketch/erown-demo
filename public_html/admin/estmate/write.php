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

			<div class="user_agree" style="border:1px solid #111; padding:20px;">
				<strong>행사 안내를 위한 개인정보 수집 &middot; 이용 동의</strong>
				[개인정보보호법] 제 15조 법규에 의거하여 롯데하이마트 주식회사는 고객님의 개인정보 수집 및 이용에 대해 개인정보 수집 및 이용 동의서를 받고 있습니다.<br>
				개인정보 제공자가 동의한 내용 외의 다른 목적으로 활용하지 않으며, 제공된 개인정보의 이용을 거부하고자 할 때에는 개인정보 관리책임자를 통해 열람,<br>
				정정 혹은 삭제를 요구할 수 있습니다.
			</div>
			<p class="check mab_50"><input id="agree" type="checkbox"><label for="agree" style="cursor:pointer;">개인정보 취급방침에 동의합니다.</label></p>
			<!--board_A0_write-->
			<form name="frm" action="frm" method="post">
			<div class="board_A0_W">
				<table summary="신청에 관련된 입력 서식 제공">
					<caption>신청</caption>
					<colgroup>
						<col width="200px" />
						<col width="*" />
					</colgroup>
					<tbody>
						<tr>
							<th scope="row" class="essential"><label for="in_type">종류</label></th>
							<td>
								<div class="select_box">
									<select class="select_type01" name="in_type" id="in_type" title="검색조건 선택">
										<option value="">선택</option>
										<option value="인간">인간</option>
										<option value="동물">동물</option>
										<option value="외계인">외계인</option>
										<option value="어류">어류</option>
										<option value="종류를 모르겠다">종류를 모르겠다</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<th scope="row" class="essential"><label for="in_name">이름</label></th>
							<td><input type="text" name="in_name" id="in_name" class="input_type01 w_normal"></td>
						</tr>
						<tr>
							<th scope="row" class="essential">성별</th>
							<td>
								<ul class="rc_box">
									<li>
										<input type="radio" class="radio_type01" name="in_gender" id="in_gender1" value="남성"/>
										<label for="in_gender1">남성</label>
									</li>
									<li class="mal_10 mar_10">
										<input type="radio" class="radio_type01" name="in_gender" id="in_gender2" value="여성"/>
										<label for="in_gender2">여성</label>
									</li>
									<li>
										<input type="radio" class="radio_type01" name="in_gender" id="in_gender3" value="없음"/>
										<label for="in_gender3">없음</label>
									</li>
								</ul>
							</td>
						</tr>
						<tr>
							<th scope="row" class="essential">연락처</th>
							<td>
								<select class="select_type01" id="in_tel1" name="in_tel1">
									<option value="">선택</option>
									<option value="010">010</option>
									<option value="011">011</option>
									<option value="016">016</option>
									<option value="017">017</option>
									<option value="018">018</option>
									<option value="019">019</option>
									<option value="061">061</option>
									<option value="062">062</option>
								</select>
								<span class="hyphen">-</span>
								<input type="text" class="input_type01 w_small" name="in_tel2" id="in_tel2" maxlength="4" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"/>
								<span class="hyphen">-</span>
								<input type="text" class="input_type01 w_small" name="in_tel3" id="in_tel3" maxlength="4" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"/>
							</td>
						</tr>
						<tr>
							<th scope="row" class="essential"><label for="in_email">이메일</label></th>
							<td><input type="text" class="input_type01 w_large" name="in_email" id="in_email" placeholder="입력예시 : asdf1234@naver.com"/></td>
						</tr>
						<tr>
							<th scope="row" class="essential"><label for="in_location">지역</label></th>
							<td>
								<select class="select_type01" id="in_location" name="in_location">
									<option value="">선택</option>
									<option value="1구역">1구역</option>
									<option value="2구역">2구역</option>
									<option value="51구역">51구역</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row" class="essential">예정일</td>
							<td>
								<div class="date_pick">
									<input type="text" class="date_cell input_type01 w_200" name="in_visit" id="in_visit" value="<?=$row['est_visit']?>" title="" />
									<label class="icon_date" for="in_visit">예정일</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			</form>
			<script type="text/javascript">
			$("#in_visit").datepicker({
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
					if(!$('#agree').is(":checked")){
						alert('개인정보 취급방침에 동의해주세요.');
						$('#agree').focus();
						return;
					}
					if(!chkForm('in_type', '종류를', 'input')) return;
					if(!chkForm('in_name', '이름을', 'input', '2')) return;
					if(!$('#in_gender1').is(":checked") && !$('#in_gender2').is(":checked") && !$('#in_gender3').is(":checked")){
						alert('성별을 선택하세요');
						return;
					}
					if($('#in_tel1 option:selected').val() == ""){
						alert('연락처를 입력해주세요.');
						$('#in_tel1').focus();
						return;
					}
					if(!chkForm('in_tel2', '연락처를', 'input', '2')) return;
					if(!chkForm('in_tel3', '연락처를', 'input', '4')) return;
					// 이메일 유효성 검사
					var u_email = $('#in_email');
					var regEmail = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
					if( !u_email.val() ){
						alert('이메일주소를 입력 해 주세요');
						u_email.focus();
						return false;
					} else {
						if(!regEmail.test(u_email.val())) {
							alert('이메일 주소가 유효하지 않습니다');
							u_email.focus();
							return false;
						}
					}
					if($('#in_location option:selected').val() == ""){
						alert('지역을 선택해주세요.');
						$('#in_location').focus();
						return;
					}
					if(!chkForm('in_visit', '예약일을', 'input', '10')) return;
					document.frm.action="process_write.php";
					document.frm.submit();
				});
			});
			</script>
			<!--//board_A0_write-->
			<!--button-->
			<div class="button a_r mat_30">
				<input type="button" class="btn_1 size_n" value="확인" id="btn_submit">
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
