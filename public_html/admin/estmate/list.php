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
$frFIELD = isset($_GET['frFIELD']) ? $_GET['frFIELD'] : '';
$frSearch = isset($_GET['frSearch']) ? $_GET['frSearch'] : '';
$sub_SQL = "";
if($frFIELD && $frSearch){
    $escSearch = mysqli_real_escape_string($conn, $frSearch);
    if($frFIELD=="est_all"){
        $sub_SQL = "WHERE est_company LIKE '%$escSearch%' OR est_name LIKE '%$escSearch%' OR est_ad_type LIKE '%$escSearch%'";
    }else if($frFIELD=="est_company" || $frFIELD=="est_name" || $frFIELD=="est_ad_type"){
        $sub_SQL = "WHERE $frFIELD LIKE '%$escSearch%'";
    }
}

$_page = isset($_GET['_page']) ? (int)$_GET['_page'] : 1;
$view_limit = 10; //게시글 노출 수
if(!$_page) $_page = 1;
$page = ($_page-1)*$view_limit;

$sql = "SELECT COUNT(*) FROM estmate $sub_SQL";
$result = mysqli_query($conn, $sql);
$totals = 0;
if ($result) {
    $temp = mysqli_fetch_array($result);
    if ($temp) {
        $totals = (int)$temp[0];
    }
}
?>

<style>
.est-table-wrap table { table-layout: fixed !important; width: 100% !important; border-top: 1px solid #111; }
.est-table-wrap th { text-align: center; border-bottom: 1px solid #d5d5d5; padding: 14px 6px; font-weight: 500; background: #fafafa; font-size: 13.5px; }
.est-table-wrap td { text-align: center; border-bottom: 1px solid #e5e5e5; padding: 12px 6px; font-size: 13px; vertical-align: middle; }
.est-table-wrap td.subject { text-align: left; }
.est-ellipsis { display: block; width: 100%; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important; word-break: break-all; }
.est-table-wrap td.subject a { display: block; width: 100%; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important; color: #111; font-weight: bold; }
.est-table-wrap td.subject a:hover { color: #ffba00; text-decoration: underline; }
</style>

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
        if (!confirm(checked + '건의 신청정보를 삭제할까요?')) return;
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
                        <select name="frFIELD" id="frFIELD" class="select_type01" title="검색조건 선택">
                            <option value='est_all' <?if($frFIELD=='est_all'){?>selected<?}?>>전체</option>
                            <option value='est_company' <?if($frFIELD=='est_company'){?>selected<?}?>>회사명</option>
                            <option value='est_name' <?if($frFIELD=='est_name'){?>selected<?}?>>담당자명</option>
                            <option value='est_ad_type' <?if($frFIELD=='est_ad_type'){?>selected<?}?>>희망광고유형</option>
                        </select>
                        <input type="text" class="input_type01 w_400" name="frSearch" id="frSearch" value="<?=$frSearch?>" placeholder="검색어를 입력하세요" onkeypress="EnterKey();">
                        <span class="search_btn" id="btnSearch">검색</span>
                    </div>
                </fieldset>
            </div>
            <!--//search-->

            <!--board_A0_list-->
            <form id="deleteForm" action="process_delete.php" method="post">
            <div class="board_A0_L est-table-wrap">
                <p class="count">총 <b><?=$totals?></b>건의 내용이 있습니다</p>
                <table summary="신청정보 관리 목록이며 선택, 번호, 회사/상호명, 담당자명, 직급, 희망 광고유형, 연락처, 이메일, 작성일을 제공합니다.">
                    <caption>신청정보 관리 목록</caption>
                    <colgroup>
                        <col width="45" />
                        <col width="60" />
                        <col width="*" />
                        <col width="110" />
                        <col width="90" />
                        <col width="150" />
                        <col width="130" />
                        <col width="170" />
                        <col width="105" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" id="chkAll"></th>
                            <th scope="col" class="resp">번호</th>
                            <th scope="col">회사/상호명</th>
                            <th scope="col">담당자명</th>
                            <th scope="col">직급</th>
                            <th scope="col">희망 광고유형</th>
                            <th scope="col">연락처</th>
                            <th scope="col">이메일</th>
                            <th scope="col">작성일</th>
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
                                $company_txt = htmlspecialchars($row['est_company']);
                                $name_txt = htmlspecialchars($row['est_name']);
                                $pos = ($row['est_position'] && $row['est_position'] !== '-') ? htmlspecialchars($row['est_position']) : '-';
                                $ad_type = htmlspecialchars($row['est_ad_type']);
                                $phone_txt = htmlspecialchars($row['est_phone']);
                                $email = ($row['est_email'] && $row['est_email'] !== '-') ? htmlspecialchars($row['est_email']) : '-';
                        ?>
                        <tr>
                            <td><input type="checkbox" name="est_uid[]" value="<?=$row['est_uid']?>"></td>
                            <td class="resp"><?=$cnt?></td>
                            <td class="subject">
                                <a href="view.php?id=<?=$row['est_uid']?>" title="<?=$company_txt?>"><b><?=$company_txt?></b></a>
                            </td>
                            <td><span class="est-ellipsis" title="<?=$name_txt?>"><?=$name_txt?></span></td>
                            <td><span class="est-ellipsis" title="<?=$pos?>"><?=$pos?></span></td>
                            <td><span class="est-ellipsis" title="<?=$ad_type?>"><?=$ad_type?></span></td>
                            <td><span class="est-ellipsis" title="<?=$phone_txt?>"><?=$phone_txt?></span></td>
                            <td><span class="est-ellipsis" title="<?=$email?>"><?=$email?></span></td>
                            <td><?=$row['est_regdate']?></td>
                        </tr>
                        <?$cnt++;}}?>
                        <?if(($totals) <= 0){?>
                        <tr>
                            <td colspan="9" class="no_text">등록된 글이 없습니다.</td>
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
