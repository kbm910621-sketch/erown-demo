<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<body>

<!--login-->
<div class="admin_login">
    <h1>
        <strong>GE BOARD</strong>
        <span>관리자</span>
    </h1>
    <form name="frm" action="frm" method="post">
    <fieldset>
        <legend>관리자 로그인</legend>
        <p class="info_txt">관리자 아이디와 비밀번호를 입력해주세요</p>
        <dl class="login_field">
            <dt><label for="adm_id">아이디</label></dt>
            <dd><input type="text" name="adm_id" id="adm_id" class="alt" placeholder="아이디를 입력하세요"></dd>
        </dl>
        <dl class="login_field alt">
            <dt><label for="adm_pw">비밀번호</label></dt>
            <dd><input type="password" name="adm_pw" id="adm_pw" class="alt" placeholder="비밀번호를 입력하세요"></dd>
        </dl>
        <input type="button" class="login_btn" value="로그인" id="btn_submit">
    </fieldset>
    </form>
</div>
<script type="text/javascript">
//form 체크
$(function logIn() {
	$('input').attr('title', '내용을 입력하세요'); //입력가이드
	$('#btn_submit').click(function(){
		if(!chkForm('adm_id', '아이디를', 'input', '2')) return;
		if(!chkForm('adm_pw', '비밀번호를', 'input', '4')) return;
		document.frm.action="login_post.php";
		document.frm.submit();
	});
});
</script>
<!--//login-->

</body>
</html>
