<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";?>



<body>

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
                <div class="user_agree" style="border:1px solid #111; padding:20px;">
    				<strong>이용약관</strong>
    			</div>
    			<p class="check mab_50"><input id="agree" type="checkbox"><label for="agree" style="cursor:pointer;">개인정보 취급방침에 동의합니다.</label></p>
    			<!--board_A0_write-->
    			<form name="frm" action="frm" method="post">
    			<div class="board_A0_W">
    				<table summary="관리자 생성">
    					<caption>관리자 생성</caption>
    					<colgroup>
    						<col width="200px" />
    						<col width="*" />
    					</colgroup>
    					<tbody>
    						<tr>
    							<th scope="row" class="essential">아이디</th>
    							<td style="position:relative">
									<input type="text" name="adm_id" id="adm_id" class="input_type01 w_large check">
                                    <div class="mat_10" style="position:absolute; top:22px; left:380px"></div>
									<p class="exp mat_5">6자~10자 영문 대소문자, 숫자</p>
    							</td>
    						</tr>
                            <tr>
                                <th scope="row" class="essential">이름</th>
  								<td><input type="text" name="adm_name" id="adm_name" class="input_type01 w_normal"></td>
    						</tr>
    						<tr>
                                <th scope="row" class="essential">비밀번호</th>
  								<td>
  									<input type="password" name="adm_pw" id="adm_pw" class="input_type01 w_large">
  									<p class="exp mat_5">비밀번호는 <b class="fc_1">9~12자의 영문 대문자, 소문자, 숫자, 특수문자를 혼합</b>해서 사용하실수 있습니다.</p>
  									<p class="exp mat_5">해당 특수문자는 사용하실 수 없습니다.(&nbsp;&nbsp;<b class="fc_1">&lt; ,&nbsp; &gt; ,&nbsp; / ,&nbsp; \\ ,&nbsp; &amp; ,&nbsp; | ,&nbsp;  ^ ,&nbsp; % ,&nbsp; + ,&nbsp; .</b>&nbsp;&nbsp;)</p>
  									<p class="exp mat_5">비밀번호 변경 시 우측 <b class="fc_1">보안등급을 참고</b>하셔서 안전한 비밀번호로 변경하시기 바랍니다.</p>
  								</td>
    						</tr>
                            <tr>
  								<th scope="row" class="essential">비밀번호 확인</th>
  								<td><input type="password"  name="adm_pw_chk" id="adm_pw_chk" class="input_type01 w_large"></td>
  							</tr>
    					</tbody>
    				</table>
    			</div>
    			</form>
				<script type="text/javascript">
				//아이디 중복 체크 실시간
				$(".check").on("keyup", function(){ //check라는 클래스에 입력을 감지
					var self = $(this);
					var adm_id;
					if(self.attr("id") === "adm_id"){
						adm_id = self.val();
					}

					$.post( //post방식으로 id_check.php에 입력한 userid값을 넘깁니다
						"idcheck.php",
						{ adm_id : adm_id },
						function(data){
							if(data){ //만약 data값이 전송되면
								self.parent().find("div").html(data); //div태그를 찾아 html방식으로 data를 뿌려줍니다.
								// self.parent().find("div").css("color", "#F00"); //div 태그를 찾아 css효과로 빨간색을 설정합니다
							}
						}
					);
				});

				//form 체크
				$(function () {
					$('input').attr('title', '내용을 입력하세요'); //입력가이드

					var RegexName = /^[가-힣]{2,4}$/; //이름 유효성 검사 2~4자 사이
					var RegexId = /^[a-z0-9_-]{2,12}$/; //아이디 유효성 검사 316자 사이

					$('#btn_submit').click(function(){
                        if(!$('#agree').is(":checked")){
    						alert('개인정보 취급방침에 동의해주세요.');
    						$('#agree').focus();
    						return;
    					}
						if(!chkForm('adm_id', '아이디를', 'input', '2')) return;
						// 아이디 검사
						if ( !RegexId.test($.trim($("#adm_id").val())) )
						{
							alert("아이디는 2~12자 사이의 영문소문자와 숫자만 가능합니다");
							$("#adm_id").focus();
							return false;
						}
						if(!chkForm('adm_name', '이름을', 'input', '2')) return;
						// 이름 검사
						if ( !RegexName.test($.trim($("#adm_name").val())) )
						{
							alert("잘못된 이름입니다.");
							$("#adm_name").focus();
							return false;
						}

						if(!chkForm('adm_pw', '비밀번호를', 'input', '4')) return;
						if(!chkForm('adm_pw_chk', '비밀번호 확인을', 'input', '4')) return;

						if($('#adm_pw').val() != $('#adm_pw_chk').val()){
							alert('비밀번호가 일치하지 않습니다.');
							return;
						}

						document.frm.action="process_join.php";
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
