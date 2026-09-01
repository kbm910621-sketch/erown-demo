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
    if($frFIELD=="user_all"){
        $sub_SQL = "WHERE user_name LIKE '%$frSearch%' or user_title LIKE '%$frSearch%' or user_description LIKE '%$frSearch%' or user_stat LIKE '%$frSearch%'";
    }else{
        $sub_SQL = "WHERE $frFIELD LIKE '%$frSearch%' ";
    }
}

$_page=$_GET['_page'];
$view_limit = 10; //게시글 노출 수
if(!$_page)($_page=1);
$page = ($_page-1)*$view_limit;

$sql = "SELECT COUNT(*) FROM user $sub_SQL";
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
                            <option value='user_all' <?if($frFIELD=='user_all'){?>selected<?}?>>전체</option>
                            <option value='user_name' <?if($frFIELD=='user_name'){?>selected<?}?>>이름</option>
                            <option value='user_title' <?if($frFIELD=='user_title'){?>selected<?}?>>제목</option>
                            <option value='user_description' <?if($frFIELD=='user_description'){?>selected<?}?>>내용</option>
                        </select>
                        <input type="text" class="input_type01 w_400" name="frSearch" id="frSearch" value="<?=$frSearch?>" placeholder="검색어를 입력하세요" onkeypress="EnterKey();">
                        <span class="search_btn" id="btnSearch">검색</span>
                    </div>
                </fieldset>
            </div>
            <!--//search-->
            <input type="hidden" name="news_uid" value="<?=$_GET['id']?>">
            <!--board_A0_list-->
            <div class="board_A0_L">
                <p class="count">총 <b><?=$totals?></b>건의 내용이 있습니다</p>
                <table summary="공지사항 목록이며 번호, 제목, 첨부파일, 작성자, 작성일을 제공하고 제목 링크를 통해 상세페이지로 이동합니다.">
                    <caption>공지사항 목록</caption>
                    <colgroup>
                        <col width="80" />
                        <col width="*" />
                        <col width="80" />
                        <col width="150" />
                        <!-- <col width="80" /> -->
                        <col width="80" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col" class="resp">번호</th>
                            <th scope="col">제목</th>
                            <th scope="col" class="resp">작성자</th>
                            <th scope="col">작성일</th>
                            <!-- <th scope="col">상태</th> -->
                            <th scope="col" class="resp">조회수</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(($totals) > 0){
                            $sql = "SELECT * FROM user $sub_SQL ORDER BY user_uid DESC LIMIT $page, $view_limit";
                            //SELECT * FROM 테이블이름 WHERE 조건 ORDER BY 컬럼이름 LIMIT 갯수
                            $result = mysqli_query($conn, $sql);
                            $cnt = $page+1; //게시글 번호
                            while($row = mysqli_fetch_array($result)){
                                $title = $row['user_title'];
                                if(mb_strlen($title)>30){
                                    $title=str_replace($row['user_title'],mb_substr($row['user_title'],0,30,'utf-8')."...",$row['user_title']); //title이 30을 넘어서면 ...표시
                                }
                                // $row['user_title'] = mb_substr($row['user_title'], 0, 26); //제목 글자수 css 사용해도 됨
                                $row['user_regdate'] = mb_substr($row['user_regdate'], 0, 10);

                                //새글 표시
                                $new_date = $row['user_regdate'];
                                $now_date = date('Y-m-d', time());

                                //상태 표시
                                $view_stat = '';
                                if(!empty($row['user_reply'])) {
                                	$view_stat = '<span class="fc_0">답변완료</span>';
                                }else{
                                    $view_stat = '<span class="fc_1">대기중</span>';
                                }
                        ?>
                        <tr>
                            <td class="resp"><?=$cnt?></td>
                            <td class="subject">
                                <?if ($new_date == $now_date){?>
                                <i class="icon_new"></i>
                                <?}?>
                                <a href="view.php?id=<?=$row['user_uid']?>" id="callpw"><?=$title?></a>
                            </td>
                            <td class="resp"><?=$row['user_name']?></td>
                            <td><?=$row['user_regdate']?></td>
                            <!-- <td><?=$view_stat?></td> -->
                            <td><?=$row['user_hit']?></td>
                        </tr>
                        <?$cnt++;}}?>
                        <?if(($totals) <= 0){?>
                        <tr>
                            <td colspan="6" class="no_text">등록된 글이 없습니다.</td>
                        </tr>
                        <?}?>
                    </tbody>
                </table>
            </div>
            <!--//board_A0_list-->

            <!--button-->
            <!-- <div class="button a_r mat_30">
                <a href="write.php" class="btn_1 size_n">등록</a>
            </div> -->
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
