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
if($frFIELD=="est_all"){
    $sub_SQL = "WHERE est_company LIKE '%$frSearch%' OR est_name LIKE '%$frSearch%' OR est_ad_type LIKE '%$frSearch%'";
}

$_page=$_GET['_page'];
$view_limit = 10; //게시글 노출 수
if(!$_page)($_page=1);
$page = ($_page-1)*$view_limit;

$sql = "SELECT COUNT(*) FROM estmate $sub_SQL";
$result = mysqli_query($conn, $sql);
$temp = mysqli_fetch_array($result);
$totals = $temp[0];
?>

<script type="text/javascript">
$(function(){
    // 글검색
    $('#btnSearch').click(function(){
        searchList();
    });

    // 전체 선택
    $('#chkAll').on('change', function() {
        $('input[name="est_uid[]"]').prop('checked', $(this).is(':checked'));
    });

    // 선택 삭제
    $('#btnDeleteAll').on('click', function() {
        var checked = $('input[name="est_uid[]"]:checked').length;
        if (!checked) { alert('삭제할 항목을 선택해주세요.'); return; }
        if (!confirm(checked + '개를 삭제할까요?')) return;
        $('#deleteForm').submit();
    });
});

var searchList = function(){
    var frSearch = $('#frSearch').val();
    location.href="list.php?frFIELD="+$('#frFIELD option:selected').val()+"&frSearch="+encodeURI(frSearch);
}

var EnterKey = function(){
    if(event.keyCode == 13){ searchList(); }
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
                        <select name="frFIELD" id="frFIELD" class="select_type01">
                            <option value='est_all'>전체</option>
                            <option value='est_company'>회사명</option>
                            <option value='est_name'>담당자명</option>
                            <option value='est_ad_type'>광고유형</option>
                        </select>
                        <input type="text" class="input_type01 w_400" name="frSearch" id="frSearch" value="<?=$frSearch?>" placeholder="검색어를 입력하세요" onkeypress="EnterKey();">
                        <span class="search_btn" id="btnSearch">검색</span>
                    </div>
                </fieldset>
            </div>
            <!--//search-->
            <form id="deleteForm" action="process_delete.php" method="post">
            <div class="board_A0_L">
                <p class="count">총 <b><?=$totals?></b>건의 내용이 있습니다</p>
                <table summary="진료상담 목록입니다">
                    <caption>진료상담</caption>
                        <colgroup>
                            <col width="60" />
                            <col width="" />
                            <col width="" />
                            <col width="80" />
                            <col width="" />
                            <col width="130" />
                            <col width="180" />
                            <col width="120" />
                        </colgroup>
                    <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" id="chkAll"></th>

                            <th scope="col" class="resp">번호</th>
                            <th scope="col">회사명</th>
                            <th scope="col">담당자명</th>
                            <th scope="col">직급</th>
                            <th scope="col">광고 유형</th>
                            <th scope="col">연락처</th>
                            <th scope="col">이메일</th>
                            <th scope="col">등록일</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        if(($totals) > 0){
                            $sql = "SELECT * FROM estmate $sub_SQL ORDER BY est_uid DESC LIMIT $page, $view_limit";
                            $result = mysqli_query($conn, $sql);
                            $cnt = $page+1;
                            while($row = mysqli_fetch_array($result)){
                                $row['est_regdate'] = mb_substr($row['est_regdate'], 0, 10);
                        ?>
                        <tr>
                            <td><input type="checkbox" name="est_uid[]" value="<?=$row['est_uid']?>"></td>
                            <td class="resp"><?=$cnt?></td>
                            <td><a href="view.php?id=<?=$row['est_uid']?>"><?=$row['est_company']?></a></td>
                            <td><?=$row['est_name']?></td>
                            <td><?=$row['est_position']?></td>
                            <td><?=$row['est_ad_type']?></td>
                            <td><?=$row['est_phone']?></td>
                            <td><?=$row['est_email']?></td>
                            <td><?=$row['est_regdate']?></td>
                        </tr>
                        <?$cnt++;}}?>
                        <?if(($totals) <= 0){?>
                        <tr>
                            <td colspan="8" class="no_text">등록된 글이 없습니다.</td>
                        </tr>
                        <?}?>
                    </tbody>
                </table>
            </div>
            </form>
            <!--//board_A0_list-->
            <!--button-->
            <div class="button a_r mat_30">
                <a href="excel.php" target="_blank" class="btn_1 size_n">엑셀다운로드</a>
                <button type="button" class="btn_3 size_n" id="btnDeleteAll">선택 삭제</button>
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
