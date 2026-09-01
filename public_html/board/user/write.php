<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";?>
<script src="/smarteditor/js/service/HuskyEZCreator.js"></script>

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

                <form name="frm" action="frm" method="post">
                <input type="hidden" name="id" value="<?=$row['user_uid']?>">
    			<!--board_A0_write-->
    			<div class="board_A0_W">
    			<table summary="사용자 게시판">
    				<caption>사용자 게시판</caption>
    				<colgroup>
    					<col width="200px" />
    					<col width="*" />
    				</colgroup>
    				<tbody>
    					<tr>
    						<th scope="row">제목</th>
    						<td><input type="text" name="user_title" id="user_title" class="input_type01 w_100p"></td>
    					</tr>
    					<tr>
    						<th scope="row">작성자</th>
    						<td><input type="text" name="user_name" id="user_name" class="input_type01 w_100" maxlength="4"></td>
    					</tr>
                        <!-- <tr>
                            <th scope="row">공개여부</th>
                            <td>
                                <ul class="rc_box">
                                    <li>
                                        <input type="checkbox" class="radio_type01" name="user_lock" id="user_lock" value="1"/>
                                        <label class="pointer" for="user_lock">비밀글</label>
                                    </li>
                                </ul>
                            </td>
                        </tr> -->
    					<tr>
    						<th scope="row">비밀번호</th>
    						<td><input type="password" name="user_pwd" id="user_pwd" class="input_type01 w_100"></td>
    					</tr>
    					<tr>
    						<th scope="row">비밀번호 확인</th>
    						<td><input type="password" name="user_pwd_chk" id="user_pwd_chk" class="input_type01 w_100"></td>
    					</tr>
    					<tr>
    						<th scope="row">내용</th>
    						<td><textarea name="user_description" id="user_description" class="textarea_type01 w_100p" style="display:none;"></textarea></td>
    					</tr>
    				</tbody>
    			</table>
    			</div>
    			</form>
    			<script type="text/javascript">
    			var oEditors = [];

    			nhn.husky.EZCreator.createInIFrame({
    				oAppRef: oEditors,
    				elPlaceHolder: "user_description", //textarea ID
    				sSkinURI: "/smarteditor/SmartEditor2Skin.html", //skin경로
    				fCreator: "createSEditor2"
    			});

    			function submitContents(elClickedObj) {
    				oEditors.getById["user_description"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
    				// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
    				chk_edit = document.getElementById("user_description").value;
    				//alert(chk_edit);
    				try {
    					elClickedObj.form.submit();
    				} catch(e) {}
    			}

    			//form 체크
    			$(function () {
    				$('input').attr('title', '내용을 입력하세요'); //입력가이드

    				var RegexName = /^[가-힣]{2,4}$/; //이름 유효성 검사 2~4자 사이

    				$('#btn_submit').click(function(){
    					if(!chkForm('user_title', '제목을', 'input', '2')) return;
    					if(!chkForm('user_name', '작성자를', 'input', '2')) return;
    					// 이름 검사
    					if ( !RegexName.test($.trim($("#user_name").val())) )
    					{
    						alert("잘못된 이름입니다.");
    						$("#user_name").focus();
    						return false;
    					}
    					if(!chkForm('user_pwd', '비밀번호를', 'input', '4')) return;
    					if(!chkForm('user_pwd_chk', '비밀번호 확인을', 'input', '4')) return;
    					if($('#user_pwd').val() != $('#user_pwd_chk').val()){
    						alert('비밀번호가 일치하지 않습니다.');
    						return;
    					}
    					//스마트에디터 값 체크
    					if(chk_edit=='' || chk_edit==' ' || chk_edit==null || chk_edit=='<p>&nbsp;</p>' || chk_edit=='<p><br></p>'){
    						alert('내용을 입력해주세요')
    						oEditors.getById["user_description"].exec("FOCUS");
    						return;
    					}
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
