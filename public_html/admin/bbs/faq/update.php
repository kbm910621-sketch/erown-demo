<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>
<script src="/smarteditor/js/service/HuskyEZCreator.js"></script>
<body class="bg_body">

<!--header-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php";?>
<!--//header-->

<?php
if(isset($_GET['id'])){
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']); //필터 보안
    $sql ="SELECT * FROM qna WHERE qn_uid={$filtered_id}";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
}
?>

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
            <input type="hidden" name="qn_uid" value="<?=$_GET['id']?>">
            <!--board_A0_write-->
            <div class="board_A0_W">
                <table summary="자주묻는 질문입니다">
					<caption>자주묻는 질문</caption>
                    <colgroup>
                        <col width="100px" />
                        <col width="*" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="row"><label for="qn_title" title="">제목</label></th>
                            <td><input type="text" name="qn_title" id="qn_title" class="input_type01 w_100p" value="<?=$row['qn_title']?>"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="qn_description" title="">내용</label></th>
                            <td><textarea name="qn_description" id="qn_description" class="textarea_type01 w_100p" style="display:none;"><?=$row['qn_description']?></textarea></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </form>
            <script type="text/javascript">
            var oEditors = [];

            nhn.husky.EZCreator.createInIFrame({
                oAppRef: oEditors,
                elPlaceHolder: "qn_description", //textarea ID
                sSkinURI: "/smarteditor/SmartEditor2Skin.html", //skin경로
                fCreator: "createSEditor2"
            });

            function submitContents(elClickedObj) {
                oEditors.getById["qn_description"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
                // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
                chk_edit = document.getElementById("qn_description").value;
                //alert(chk_edit);
                try {
                    elClickedObj.form.submit();
                } catch(e) {}
            }

            //form 체크
            $(function () {
                $('input').attr('title', '내용을 입력하세요'); //입력가이드
                $('#btn_submit').click(function(){
                    if(!chkForm('qn_title', '제목을', 'input', '2')) return;
                    //스마트에디터 값 체크
                    if(chk_edit=='' || chk_edit==' ' || chk_edit==null || chk_edit=='<p>&nbsp;</p>' || chk_edit=='<p><br></p>'){
                        alert('내용을 입력해주세요')
                        oEditors.getById["qn_description"].exec("FOCUS");
                        return;
                    }
                    document.frm.action="process_update.php";
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
