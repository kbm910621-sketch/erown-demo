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
    $sql ="SELECT * FROM notice WHERE notice_uid={$filtered_id}";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
}
?>
<script type="text/javascript">
function godel(del_num = 0) {
    var f = document.file_del;
    f.del_num.value = del_num;
    f.action = "file_delete.php?id=<?=$row['notice_uid']?>"
    f.method = "post"
    f.submit();
}
</script>

<form name="file_del">
    <input type="hidden" name="del_num"/>
</form>
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
            <input type="hidden" name="notice_uid" value="<?=$_GET['id']?>">
            <!--board_A0_write-->
            <div class="board_A0_W">
                <table summary="공지사항 목록이며 번호, 제목, 첨부파일, 작성자, 작성일을 제공하고 제목 링크를 통해 상세페이지로 이동합니다.">
                    <caption>공지사항 목록</caption>
                    <colgroup>
                        <col width="100px" />
                        <col width="*" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="row">제목</th>
                            <td><input type="text" name="notice_title" id="notice_title" class="input_type01 w_100p" value="<?=$row['notice_title']?>"></td>
                        </tr>
                        <tr>
                            <th scope="row">작성자</th>
                            <td><?=$row['notice_author']?></td>
                        </tr>
                        <tr>
                            <th scope="row">내용</th>
                            <td><textarea name="notice_description" id="notice_description" class="textarea_type01 w_100p" style="display:none;"><?=$row['notice_description']?></textarea></td>
                        </tr>
                        <tr>
                            <th scope="row">첨부파일</th>
                            <td>
                                <!-- <p class="exp mab_5">총 20MBytes 이하</p> -->
                                <ul class="file_Box">
                                    <?if($row['notice_file0']){?>
                                    <li>파일: <?=$row['notice_file0']?> <a href="javascript:godel(0);" class="btn_2 size_s">파일삭제</a></li>
                                    <?}?>
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
                elPlaceHolder: "notice_description", //textarea ID
                sSkinURI: "/smarteditor/SmartEditor2Skin.html", //skin경로
                fCreator: "createSEditor2"
            });

            function submitContents(elClickedObj) {
                oEditors.getById["notice_description"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
                // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
                chk_edit = document.getElementById("notice_description").value;
                //alert(chk_edit);
                try {
                    elClickedObj.form.submit();
                } catch(e) {}
            }

            //form 체크
            $(function () {
                $('input').attr('title', '내용을 입력하세요'); //입력가이드
                $('#btn_submit').click(function(){
                    if(!chkForm('notice_title', '제목을', 'input', '2')) return;
                    //스마트에디터 값 체크
                    if(chk_edit=='' || chk_edit==' ' || chk_edit==null || chk_edit=='<p>&nbsp;</p>' || chk_edit=='<p><br></p>'){
                        alert('내용을 입력해주세요')
                        oEditors.getById["notice_description"].exec("FOCUS");
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
