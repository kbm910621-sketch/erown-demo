<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<body class="bg_body">

<!--header-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php";?>
<!--//header-->

<?php
//검색
$frFIELD = $_GET['frFIELD'];
$frSearch = $_GET['frSearch'];
$sub_SQL="";
if($frFIELD && $frSearch){
    if($frFIELD=="qn_all"){
        $sub_SQL = "WHERE qn_author LIKE '%$frSearch%' or qn_title LIKE '%$frSearch%' or qn_description LIKE '%$frSearch%'";
    }else{
        $sub_SQL = "WHERE $frFIELD LIKE '%$frSearch%' ";
    }
}

$_page=$_GET['_page'];
$view_limit = 10; //게시글 노출 수
if(!$_page)($_page=1);
$page = ($_page-1)*$view_limit;

$sql = "SELECT COUNT(*) FROM qna $sub_SQL";
$result = mysqli_query($conn, $sql);
$temp = mysqli_fetch_array($result);
$totals = $temp[0];
?>

<script type="text/javascript">
//글검색
$(function(){
    $('#btnSearch').click(function(){
        searchList();
    });
});

var searchList = function(){
    //if(!chkForm('frSearch', '검색어를', 'input', '1')) return;
    var frSearch = $('#frSearch').val();
    location.href="list.php?frFIELD="+$('#frFIELD option:selected').val()+"&frSearch="+encodeURI(frSearch);
}

var EnterKey = function(){
    if(event.keyCode == 13){
        searchList();
    }
}
</script>

<!--wrap-->
<div id="wrap">
	<!--container-->
	<div id="container">
		<!--title-->
		<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/title.php";?>
		<!--//title-->

        <!--content-->
        <section class="content">

            <!--search-->
            <div class="search_box">
            <fieldset>
                <legend>게시물검색</legend>
                <div class="single">
                    <select name="frFIELD" id="frFIELD" class="select_type01" title="검색조건 선택">
                        <option value='qn_all' <?if($frFIELD=='qn_all'){?>selected<?}?>>전체</option>
                        <option value='qn_author' <?if($frFIELD=='qn_author'){?>selected<?}?>>이름</option>
                        <option value='qn_title' <?if($frFIELD=='qn_title'){?>selected<?}?>>제목</option>
                        <option value='qn_description' <?if($frFIELD=='qn_description'){?>selected<?}?>>내용</option>
                    </select>
                    <input type="text" class="input_type01 w_400" name="frSearch" id="frSearch" value="<?=$frSearch?>" placeholder="검색어를 입력하세요" onkeypress="EnterKey();">
                    <span class="search_btn" id="btnSearch">검색</span>
                </div>
            </fieldset>
            </div>
            <!--//search-->
            <!--board_A0_list-->
            <div class="board_A0_L">
                <p class="count">총 <b><?=$totals?></b>건의 내용이 있습니다</p>
                <table summary="자주묻는 질문 목록입니다">
                    <caption>자주묻는 질문 목록</caption>
                    <colgroup>
                        <col width="100" />
                        <col width="*" />
                        <col width="150" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col" class="resp">번호</th>
                            <th scope="col">질문</th>
                            <th scope="col">작성일</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(($totals) > 0){
                            $sql = "SELECT * FROM qna $sub_SQL ORDER BY qn_uid DESC LIMIT $page, $view_limit";
                            //SELECT * FROM 테이블이름 WHERE 조건 ORDER BY 컬럼이름 LIMIT 갯수
                            $result = mysqli_query($conn, $sql);
                            $cnt = $page+1; //게시글 번호
                            while($row = mysqli_fetch_array($result)){
                                // $row['qn_title'] = mb_substr($row['qn_title'], 0, 50); //제목 글자수 css 사용해도 됨
                                $row['qn_regdate'] = mb_substr($row['qn_regdate'], 0, 10);
                        ?>
                        <tr>
                            <td class="resp"><?=$cnt?></td>
                            <td class="subject"><a href="view.php?id=<?=$row['qn_uid']?>"><?=$row['qn_title']?></a></td>
                            <td><?=$row['qn_regdate']?></td>
                        </tr>
                        <?$cnt++;}}?>
                        <?if(($totals) <= 0){?>
                        <tr>
                            <td colspan="3" class="no_text">등록된 글이 없습니다.</td>
                        </tr>
                        <?}?>
                    </tbody>
                </table>
            </div>
            <!--//board_A0_list-->
            <!--button-->
            <div class="button a_r mat_30">
                <a href="write.php" class="btn_1 size_n">등록</a>
            </div>
            <!--//button-->
            <?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/paging.php";?>

        </section>
        <!--//content-->
    </div>
    <!--//container-->
</div>
<!--//wrap-->

</body>
</html>
