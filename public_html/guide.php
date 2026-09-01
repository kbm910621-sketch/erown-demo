<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";?>

<body style="background:#fff;">

<!--password-->
<div class="password_layer">
	<div class="password_box">
		<div class="pass_tit">비밀번호 입력</div>
		<dl>
			<dt><label for="">비밀번호</label></dt>
			<dd><input type="password" class="input_type01 w_200" placeholder="비밀번호를 입력하세요"></dd>
		</dl>
        <!--button-->
        <div class="button mat_20">
            <input type="button" class="btn_1 size_s" value="확인" onClick="location.href='index.php'">
            <input type="button" class="btn_2 size_s password_close" value="취소">
        </div>
        <!--//button-->
	</div>
</div>
<span class="btn_1 size_t mat_50 mal_10 mab_50" id="callpw">비밀번호 레이어 호출</span>
<!--//password-->

<script type="text/javascript">
// 게시판 비밀번호
$('#callpw').click(function(){
	$('.password_layer').addClass('on');
	$('body').addClass('no_scroll');
	$('#blank_layer').show();
});
$('.password_close').click(function(){
	$('.password_layer').removeClass('on');
	$('body').removeClass('no_scroll');
	$('#blank_layer').hide();
});
</script>


<!--blank_layer-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/blank.php";?>
<!--//blank_layer-->

<!--wrap-->
<div id="wrap" style="padding:0 10px;">

	<!--tab-->
	<style>
		.cont_box { border:1px solid #111; border-top:none; text-align:center; padding:50px;  }
	</style>
    <div class="tab_A0" id="tab_toggle">
        <div class="tab_mobile"><b>tab_1</b><span class="stic_1"></span><span class="stic_2"></span></div>
        <ul>
            <li id="tab1" class="on" onClick="cnt_tab('1'); return false;"><span>tab_1</span></li>
            <li id="tab2" onClick="cnt_tab('2'); return false;"><span>tab_2</span></li>
            <li id="tab3" onClick="cnt_tab('3'); return false;"><span>tab_3</span></li>
            <li id="tab4" onClick="cnt_tab('4'); return false;"><span>폰트 테스트</span></li>
            <li id="tab5" onClick="cnt_tab('5'); return false;"><span>다른 스타일의 탭</span></li>
        </ul>
    </div>
	<div class="cont_box" id="view_1" style="display:;">id="view_1"</div>
	<div class="cont_box" id="view_2" style="display:none;">id="view_2"</div>
	<div class="cont_box" id="view_3" style="display:none;">id="view_3"</div>
	<div class="cont_box" id="view_4" style="display:none;">
		id="view_4"
		<!--test-->
	    <div class="test_a">
			<div class="test_b">
				<span>new</span>
			</div>
		</div>
	    <div class="font_test">
	        <p>COPYRIGHTⓒgeboard. ALL RIGHTS RESERVED font-weight:000; font-family:"Noto Sans KR";</p>
	        <p class="fo1">COPYRIGHTⓒgeboard. ALL RIGHTS RESERVED font-weight:100; font-family:"Noto Sans KR";</p>
	        <p class="fo2">COPYRIGHTⓒgeboard. ALL RIGHTS RESERVED font-weight:300; font-family:"Noto Sans KR";</p>
	        <p class="fo3">COPYRIGHTⓒgeboard. ALL RIGHTS RESERVED font-weight:400; font-family:"Noto Sans KR";</p>
	        <p class="fo4">COPYRIGHTⓒgeboard. ALL RIGHTS RESERVED font-weight:500; font-family:"Noto Sans KR";</p>
	        <p class="fo5">COPYRIGHTⓒgeboard. ALL RIGHTS RESERVED font-weight:600; font-family:"Noto Sans KR";</p>
	        <p class="fo6">COPYRIGHTⓒgeboard. ALL RIGHTS RESERVED font-weight:900; font-family:"Noto Sans KR";</p>
	    </div>
		<style>
			.font_test { padding:50px;  }
			.font_test p { margin:20px 0; font-size:1rem; font-weight:normal; background:#FFFF99; line-height:normal; overflow: hidden;}
			.font_test p.fo1 { font-weight:100; margin-top:50px; }
			.font_test p.fo2 { font-weight:300; }
			.font_test p.fo3 { font-weight:400; }
			.font_test p.fo4 { font-weight:500; }
			.font_test p.fo5 { font-weight:700; margin-top:50px;  }
			.font_test p.fo6 { font-weight:900;}
			.test_a { display:inline-block; position:relative; }
			.test_a .test_b { width:51px; height:51px; background:#000; border-radius:50%; display:table; text-align:center; }
			.test_a .test_b span { color:#fff; display:table-cell; vertical-align:middle; }
		</style>
		<!--test-->
	</div>
	<div class="cont_box" id="view_5" style="display:none;">
		id="view_5"
		<div class="tab_A0 flex_grow a_l mat_50">
	        <div class="tab_mobile"><b>tab1</b><span class="stic_1"></span><span class="stic_2"></span></div>
			<ul>
				<li class="on"><a href="#;">tab1</a></li>
				<li><a href="#;">tab2</a></li>
				<li><a href="#;">tab3</a></li>
			</ul>
		</div>

		<div class="tab_A1 mat_50">
	        <div class="tab_mobile"><b>tab_1</b><span class="stic_1"></span><span class="stic_2"></span></div>
			<ul>
				<li class="on"><a href="#;">tab1</a></li>
				<li><a href="#;">tab2</a></li>
				<li><a href="#;">tab3</a></li>
				<li><a href="#;">tab4</a></li>
				<li><a href="#;">tab5</a></li>
			</ul>
		</div>
	</div>

	<script type="text/javascript">
	//tab click - mobile
	function toggle_close(){
		$("#tab_toggle").removeClass('active');
		$(".tab_A0 ul").stop().slideUp(250);
		$(".tab_A1 ul").stop().slideUp(250); // a1 예제
		$(".tab_mobile span").removeClass("open");
	};
	function toggle_open(){
		$("#tab_toggle").addClass('active');
		$(".tab_A0 ul").stop().slideDown(250);
		$(".tab_A1 ul").stop().slideDown(250); // a1 예제
		$(".tab_mobile span").addClass("open")
	};

	$("#tab_toggle").click(function(){
		if($windowWid < 600){
			if($(this).hasClass('active')) {
				toggle_close();
			} else {
				toggle_open();
			}
		}
	});

	//tab view
	function cnt_tab(val) {
		if (val == '1') {
			$("#view_1").show();
			$(".cont_box").not("#view_1").hide();
			$("#tab1").addClass("on");
			$(".tab_A0 li").not("#tab1").removeClass("on");
			$('.tab_mobile b').text('tab_1');
		}
		if (val == '2') {
			$("#view_2").show();
			$(".cont_box").not("#view_2").hide();
			$("#tab2").addClass("on");
			$(".tab_A0 li").not("#tab2").removeClass("on");
			$('.tab_mobile b').text('tab_2');
		}
		if (val == '3') {
			$("#view_3").show();
			$(".cont_box").not("#view_3").hide();
			$("#tab3").addClass("on");
			$(".tab_A0 li").not("#tab3").removeClass("on");
			$('.tab_mobile b').text('tab_3');
		}
		if (val == '4') {
			$("#view_4").show();
			$(".cont_box").not("#view_4").hide();
			$("#tab4").addClass("on");
			$(".tab_A0 li").not("#tab4").removeClass("on");
			$('.tab_mobile b').text('폰트 테스트');
		}
		if (val == '5') {
			$("#view_5").show();
			$(".cont_box").not("#view_5").hide();
			$("#tab5").addClass("on");
			$(".tab_A0 li").not("#tab5").removeClass("on");
			$('.tab_mobile b').text('다른 스타일의 탭');
		}
	}

	//reset
	function reset_pc(){
		$(".tab_A0 ul").css("display","flex");
		$("#tab_toggle").removeClass('active');
		$(".tab_mobile span").removeClass("open");
	};
	function reset_mobile(){
		$(".tab_A0 ul").css("display","none");
	};

	$(window).resize(function(){
		$windowWid = window.innerWidth;
		if($windowWid > 600 && !navigator.userAgent.match(/iPhone/i) && !navigator.userAgent.match(/iPad/i)){
			reset_pc();
		} else if($windowWid < 600 && !navigator.userAgent.match(/iPhone/i) && !navigator.userAgent.match(/iPad/i)) {
			reset_mobile();
		}
	});

	//아이폰계열
	$( window ).on( 'orientationchange', function(){
		$windowWid = window.innerWidth;
		if($windowWid > 600 && !navigator.userAgent.match(/Android/i)){
			reset_pc();
		} else if($windowWid < 600 && !navigator.userAgent.match(/Android/i)) {
			reset_mobile();
		}
	});
	</script>
	<!--//tab-->


	<!--search-->
	<div class="search_box mat_50">
		<fieldset>
			<legend>게시물검색</legend>
			<select name="frFIELD" id="frFIELD" class="select_type01" title="검색조건 선택">
				<option value='news_all' <?if($frFIELD=='news_all'){?>selected<?}?>>전체</option>
				<option value='news_author' <?if($frFIELD=='news_author'){?>selected<?}?>>이름</option>
				<option value='news_title' <?if($frFIELD=='news_title'){?>selected<?}?>>제목</option>
				<option value='news_description' <?if($frFIELD=='news_description'){?>selected<?}?>>내용</option>
			</select>
			<input type="text" class="input_type01" name="frSearch" id="frSearch" value="<?=$frSearch?>" placeholder="검색어를 입력하세요" onkeypress="EnterKey();">
			<span class="search_btn" id="btnSearch">검색</span>
		</fieldset>
	</div>
	<!--//search-->

	<!--button-->
	<div class="button mat_50">
		<span class="btn_1 size_t">수정</span>
		<span class="btn_1 size_s">취소</span>
		<span class="btn_2 size_s">확인</span>
		<span class="btn_1 size_n">확인</span>
		<span class="btn_1 size_l rad_10">확인</span>
		<span class="btn_2 size_l rad_10">확인</span>
		<span class="btn_3 size_l rad_10">확인</span>
		<span class="btn_4 size_l rad_10">확인</span>
	</div>
	<!--//button-->


	<!--board_A0_write-->
	<div class="board_A0_W mat_50">
		<table summary="summary">
			<caption>caption</caption>
			<colgroup>
				<col width="200px" />
				<col width="*" />
			</colgroup>
			<tbody>
				<tr>
					<th scope="row" class="essential">구분</th>
					<td>
						<ul class="rc_box">
							<li>
								<input type="radio" class="radio_type01" name="" id="" value="남성"/>
								<label for="">남성</label>
							</li>
							<li>
								<input type="radio" class="radio_type02" name="" id="" value="여성"/>
								<label for="">여성</label>
							</li>
							<li>
								<input type="radio" class="radio_type03" name="" id="" value="없음"/>
								<label for="">없음</label>
							</li>
							<li>
								<input type="checkbox" class="chk_type01" name="" id="" value="0" tabindex="비밀" />
								<label for="">비밀</label>
							</li>
							<li>
								<input type="checkbox" class="chk_type02" name="" id="" value="0" tabindex="비밀" />
								<label for="">비밀</label>
							</li>
							<li>
								<input type="checkbox" class="chk_type03" name="" id="" value="0" tabindex="비밀" />
								<label for="">비밀</label>
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row" class="essential">선택</th>
					<td>
						<div class="select_box">
							<select class="select_type01" name="select01" id="select01" title="검색조건 선택">
								<option>제목</option>
								<option>내용</option>
								<option>작성자</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row">연락처</th>
					<td>
						<select class="select_type01">
							<option>010</option>
							<option>011</option>
						</select>
						<span class="hyphen">-</span>
						<input type="text" class="input_type01 w_small" name="" id="" value="" title="" maxlength="4" />
						<span class="hyphen">-</span>
						<input type="text" class="input_type01 w_small" name="" id="" value="" title="" maxlength="4" />
					</td>
				</tr>
				<tr>
					<th scope="row" class="essential">제목</th>
					<td>
						<input type="text" class="input_type01 w_90p" name="input" id="input" value="" title="" />
					</td>
				</tr>
				<tr>
					<th scope="row" class="essential">내용</th>
					<td>
						<textarea name="textarea" id="textarea" class="textarea_type01 w_90p" rows="10" placeholder="2,000 Bytes 이내로 작성하세요."></textarea>
						<p class="exp mat_5">개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.</p>
					</td>
				</tr>
				<tr>
					<th scope="row" class="essential">이메일</th>
					<td>
						<p class="exp mab_5">개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.</p>
						<input type="text" class="input_type01 w_large" name="input" id="input" value="" title="" placeholder="입력예시 : asdf1234@naver.com" />
					</td>
				</tr>
				<tr>
					<th scope="row" class="essential">이메일</th>
					<td>
						<p class="exp mab_5">개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.</p>
						<input type="text" class="input_type01 w_normal" name="" id="" value="" title="" />
						<span class="at">@</span>
						<input type="text" class="input_type01 w_normal" name="" id="" value="" title="메일 선택" />
						<select class="select_type01">
							<option>직접입력</option>
							<option>naver.com</option>
						</select>
						<p class="exp mat_5">개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.</p>
						<p class="exp mat_5">설명부분입니다.</p>
					</td>
				</tr>
				<tr>
					<th scope="row">첨부파일</th>
					<td>
						<p class="exp mab_5">총 20MBytes 이하</p>
						<ul class="file_Box">
							<li><input type="file" class="file_type01" name="userfile[]" id="ga_file" title="첨부파일 선택" /></li>
							<li><input type="file" class="file_type01" name="userfile[]" title="첨부파일 선택" /></li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row" class="essential">예정일</td>
					<td>
						<div class="date_pick">
							<input type="text" class="date_cell input_type01 w_200" name="in_visit" id="in_visit" placeholder="예정일을 선택해주세요.">
							<label class="icon_date" for="in_visit">예정일</label>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<script type="text/javascript">
	$("#in_visit").datepicker({
		dateFormat:"yy-mm-dd",
		dayNamesMin:["일", "월", "화", "수", "목", "금", "토"],
		monthNames:["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
		showMonthAfterYear:true,
		yearSuffix: "년",
		minDate: '0'
	});
	</script>
	<!--//board_A0_write-->

	<!--board_A0_form-->
	<div class="board_A0_I mat_50">
		<p class="info_txt"><b>*</b> 필수입력</p>
		<ul>
			<li>
				<div class="I_tr">
					<div class="I_th essential"><label for="input" title="">선택</label></div>
					<div class="I_td">
						<div class="rc_box">
							<span>
								<input type="radio" class="radio_type01" name="" id="" value="0" tabindex="일반" checked="checked" />
								<label for="">일반</label>
							</span>
							<span>
								<input type="radio" class="radio_type01" name="" id="" value="0" tabindex="일반" checked="checked" />
								<label for="">일반</label>
							</span>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="I_tr">
					<div class="I_th essential"><label for="input" title="">선택</label></div>
					<div class="I_td">
						<div class="select_box">
							<span>
								<label for="select01">검색옵션1</label>
								<select class="select_type01" name="select01" id="select01" title="검색조건 선택">
									<option>제목</option>
									<option>내용</option>
									<option>작성자</option>
								</select>
								<input type="text" class="input_type01 w_100" name="" id="" value="" title="" />
							</span>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="I_tr">
					<div class="I_th essential"><label for="input" title="">선택</label></div>
					<div class="I_td">
						<p class="exp mab_5">총 20MBytes 이하</p>
						<p class="exp mab_5">개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.</p>
						<ul class="file_Box">
							<li><input type="file" class="file_type01" name="userfile[]" id="ga_file" title="첨부파일 선택" /></li>
						</ul>
						<p class="exp mat_5">총 20MBytes 이하</p>
						<p class="exp mat_5">개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.</p>
					</div>
				</div>
			</li>
			<li>
				<div class="I_tr">
					<div class="I_th essential"><label for="input" title="">선택</label></div>
					<div class="I_td">
						<p class="exp mab_5">개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.</p>
						<input type="text" class="input_type01 w_normal" name="" id="" value="" title="" />
						<span class="at">@</span>
						<input type="text" class="input_type01 w_normal" name="" id="" value="" title="메일 선택" />
						<select class="select_type01">
							<option>직접입력</option>
							<option>naver.com</option>
						</select>
						<p class="exp mat_5">개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.</p>
						<p class="exp mat_5">설명부분입니다.</p>
					</div>
				</div>
			</li>
			<li>
				<div class="I_tr">
					<div class="I_th essential"><label for="input" title="">선택</label></div>
					<div class="I_td">
						<textarea name="textarea" id="textarea" class="textarea_type01 w_large" rows="10" placeholder="2,000 Bytes 이내로 작성하세요."></textarea>
						<p class="exp mat_5">개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.</p>
					</div>
				</div>
			</li>
			<li>
				<div class="I_tr">
					<div class="I_th essential"><label for="input" title="">선택</label></div>
					<div class="I_td">
						<select class="select_type01">
							<option>010</option>
							<option>011</option>
						</select>
						<span class="hyphen">-</span>
						<input type="text" class="input_type01 w_small" name="" id="" value="" title="" maxlength="4" />
						<span class="hyphen">-</span>
						<input type="text" class="input_type01 w_small" name="" id="" value="" title="" maxlength="4" />
					</div>
				</div>
			</li>
		</ul>
	</div>
	<!--//board_A0_form-->

	<!--board_A0_list-->
	<div class="board_A0_L mat_50">
		<p class="count">총 <b>234</b>건의 내용이 있습니다</p>
		<table summary="공지사항 목록이며 번호, 제목, 첨부파일, 작성자, 작성일을 제공하고 제목 링크를 통해 상세페이지로 이동합니다.">
			<caption>공지사항 목록</caption>
			<colgroup>
				<col width="200px" />
				<col width="*">
				<col width="200px" />
				<col width="200px" />
				<col width="200px" />
			</colgroup>
			<thead>
				<tr>
					<th scope="col" class="resp">번호</th>
					<th scope="col">제목</th>
					<th scope="col">첨부파일</th>
					<th scope="col" class="resp">작성자</th>
					<th scope="col">작성일</th>
				</tr>
			</thead>
			<tbody>
				<tr class="notice">
					<td class="resp"><span>notice</span></td>
					<td class="subject"><a href="#">board_A0_list 제목입니다.</a></td>
					<td class="add"><a href="#"><span>첨부파일이 있습니다.</span></a></td>
					<td class="resp">관리자</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<td class="resp">999</td>
					<td class="subject"><a href="#">board_A0_list 제목입니다.</a><i class="icon_new"></i></td>
					<td class="add"><a href="#"><span>첨부파일이 있습니다.</span></a></td>
					<td class="resp">관리자</td>
					<td>2017-12-26</td>
				</tr>
				<tr class="secret">
					<td class="resp">secret</td>
					<td class="subject"><a href="#">board_A0_list 제목입니다.</a></td>
					<td class="add"></td>
					<td class="resp">관리자</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<td colspan="5" class="no_text">등록된 글이 없습니다.</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!--//board_A0_list-->

	<br>

	<!--board_A0_view-->
	<div class="board_A0_V">
		<table summary="공지사항 상세보기로  제목, 작성일, 작성자, 첨부파일, 내용을 제공합니다.">
			<caption>공지사항 상세보기</caption>
			<colgroup>
				<col width="100px" />
				<col width="*" />
			</colgroup>
			<tbody>
				<tr>
					<th colspan="2" scope="col" class="subject">
						<strong>news_title</strong>
						<div class="sub_info">
							<span>2019-08-23</span>
							<span>조회 : 111</span>
						</div>
					</th>
				</tr>
				<tr>
					<td colspan="2" class="body_matter">contents</td>
				</tr>
				<tr>
					<th scope="row" class="next"><span>다음글</span></th>
					<td class="ellips"><a href="#;">공지사항 상세보기로  제목, 작성일, 작성자, 첨부파일, 내용을 제공합니다.</a></td>
				</tr>
				<tr>
					<th scope="row" class="prev"><span>이전글</span></th>
					<td class="ellips"><a href="#;">이전글</a></td>
				</tr>
			</tbody>
		</table>
	</div>
	<!--//board_A0_view-->

	<br>


	<!--board_A0_faq-->
	<div class="board_A0_F">
		<p class="count">총 <b>258</b>건</p>
		<div class="accordion">
			<dl>
				<dt><span class="num">1</span>개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.<i class="on"></i></dt>
				<dd>신용평가는 매년 3월 1일부터 고객별 연1회 실시합니다.
	유효기간은 신용평가등급 확정일로부터 1년을 원칙으로 합니다.
	단, 차기결산일로부터 5월(개인기업은 소득세 과세표준 확정신고 기한으로부터 1월)을 초과할 수 없습니다. <br>[예시] 12월말 결산법인의 경우 등급확정일이 '15.4.1일이면 유효기간은 '16.3.31일 이고, 등급확정일이 '15.8.5일이면 유효기간은 '16.5.31일입니다.</dd>
			</dl>
			<dl>
				<dt><span class="num">2</span>개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.<i></i></dt>
				<dd>신용평가는 매년 3월 1일부터 고객별 연1회 실시합니다.
	유효기간은 신용평가등급 확정일로부터 1년을 원칙으로 합니다.
	단, 차기결산일로부터 5월(개인기업은 소득세 과세표준 확정신고 기한으로부터 1월)을 초과할 수 없습니다.[예시] 12월말 결산법인의 경우 등급확정일이 '15.4.1일이면 유효기간은 '16.3.31일 이고, 등급확정일이 '15.8.5일이면 유효기간은 '16.5.31일입니다.</dd>
			</dl>
		</div>
	</div>
	<!--//board_A0_faq-->

	<br>

	<!--board_A0_gallery-->
	<div class="board_A0_G">
		<p class="count">총 <b>258</b>건</p>
		<ul>
			<li>
				<a href="#;">
					<div style=""><span class="icon_plus"></span></div>
					<strong>board_A0_G</strong>
				</a>
			</li>
			<li>
				<a href="#;">
					<div style=""><span class="icon_plus"></span></div>
					<strong>board_A0_G</strong>
				</a>
			</li>
			<li>
				<a href="#;">
					<div style=""><span class="icon_plus"></span></div>
					<strong>board_A0_G</strong>
				</a>
			</li>
			<li>
				<a href="#;">
					<div style=""><span class="icon_plus"></span></div>
					<strong>board_A0_G</strong>
				</a>
			</li>
		</ul>
		<ul>
			<li class="colum_2">
				<a href="#">
					<div style=""><span class="icon_plus"></span></div>
					<strong>board_A0_G</strong>
					<span class="sub_txt">2019-08-27</span>
				</a>
			</li>
			<li class="colum_2">
				<a href="#">
					<div style=""><span class="icon_plus"></span></div>
					<strong>board_A0_G</strong>
					<span class="sub_txt">2019-08-27</span>
				</a>
			</li>
		</ul>
	</div>
	<!--//board_A0_gallery-->

	<br>

	<!--board_A0_blog-->
	<div class="board_A0_B">
		<p class="count">총 <b>258</b>건</p>
		<ul>
			<li>
				<div class="B_img"><img src="a.jpg" alt="" /></div>
				<div class="B_txt">
					<strong><a href="#" title="">개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.</a></strong>
					<p class="info">
						<span>2017-11-29</span>
						<span>조회수 20</span>
					</p>
					<p class="summary">
						개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.
					</p>
				</div>
			</li>
			<li>
				<div class="B_img"><img src="a.jpg" alt="" /></div>
				<div class="B_txt">
					<strong>board_A0_B</strong>
					<p class="info">
						<span>2017-11-29</span>
						<span>조회수 20</span>
					</p>
					<p class="summary">
						개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.
					</p>
				</div>
			</li>
			<li>
				<div class="B_txt">
					<strong>board_A0_B</strong>
					<p class="info">
						<span>2017-11-29</span>
						<span><b>조회수</b>20</span>
					</p>
					<p class="summary">
						개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.개선의견에 대한 회신이 필요한 경우, 이메일 정보를 입력해주시기 바랍니다.
					</p>
				</div>
			</li>
		</ul>
	</div>
	<!--//board_A0_blog-->

	<br>

	<!--table_A0-->
	<div class="table_A0 a_left">
		<table summary="summary">
			<caption>caption</caption>
			<colgroup>
				<col width=" " />
				<col width=" " />
				<col width=" " />
				<col width=" " />
				<col width=" " />
				<col width=" " />
			</colgroup>
			<thead>
				<tr>
					<th scope="col">항목1</th>
					<th scope="col">항목2</th>
					<th scope="col">항목3</th>
					<th scope="col">항목4</th>
					<th scope="col">항목5</th>
					<th scope="col">항목6</th>
				</tr>
			</thead>
			<tbody>
				<tr class="tr_right">
					<td>table_A0</td>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<td>table_A0</td>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<td>table_A0</td>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<td>table_A0</td>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<td>table_A0</td>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!--//table_A0-->

	<br>

	<!--table_A0-->
	<div class="table_A0">
		<table summary="summary">
			<caption>caption</caption>
			<colgroup>
				<col width=" " />
				<col width=" " />
				<col width=" " />
				<col width=" " />
				<col width=" " />
				<col width=" " />
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">항목1</th>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<th rowspan="2" scope="row">항목1</th>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<th scope="row">항목1</th>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<th scope="row">항목1</th>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!--//table_A0-->

	<br>

	<!--table_A0-->
	<div class="table_A0">
		<table summary="summary">
			<caption>caption</caption>
			<colgroup>
				<col width=" " />
				<col width=" " />
				<col width=" " />
				<col width=" " />
				<col width=" " />
				<col width=" " />
			</colgroup>
			<thead>
				<tr>
					<th scope="col">항목1</th>
					<th scope="col">항목2</th>
					<th scope="col">항목3</th>
					<th scope="col">항목4</th>
					<th scope="col">항목5</th>
					<th scope="col">항목6</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th scope="row">항목1</th>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<th rowspan="2" scope="row">항목1</th>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<th scope="row">항목1</th>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
				<tr>
					<th scope="row">항목1</th>
					<td>table_A0</td>
					<td>첨부파일이 있습니다</td>
					<td>관리자</td>
					<td>2017-12-26</td>
					<td>2017-12-26</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!--//table_A0-->


	<br>


	<!--paging-->
	<div class="paging">
		<a href='#' class="boxFirst" title="처음 페이지 이동">처음 페이지 이동<span></span></a><a href='#' class="boxPrev" title="이전 페이지 이동">이전 페이지 이동</a><a href='#' class="boxnow">1</a><a href='#'>2</a><a href='#'>3</a><a href='#'>4</a><a href='#'>5</a><a href='#'>6</a><a href='#'>7</a><a href='#'>8</a><a href='#'>9</a><a href='#'>99999999999999</a><a href='#' class="boxNext" title="다음 페이지 이동">다음 페이지 이동</a><a href='#' class="boxLast" title="마지막 페이지 이동">마지막 페이지 이동<span></span></a>
	</div>
	<!--paging-->

	<br>
	<br>
	<br>
	<br>
	<br>
	<br>




</div>
<!--//wrap-->

</body>
</html>
