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

<style>
.board_A0_L table { width: 100%; border-collapse: collapse; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
.board_A0_L table thead th { background: #f8fafc; color: #1e293b; font-size: 13.5px; font-weight: 700; padding: 14px 10px; border-bottom: 2px solid #e2e8f0; text-align: center; }
.board_A0_L table tbody tr.est-row { cursor: pointer; transition: all 0.15s ease; border-bottom: 1px solid #edf2f7; }
.board_A0_L table tbody tr.est-row:hover { background-color: #f1f5f9 !important; }
.board_A0_L table tbody tr.est-row:hover td { background-color: #f1f5f9 !important; }
.board_A0_L table tbody tr.est-row td { color: #334155; font-size: 14px; font-weight: 500; padding: 14px 10px; vertical-align: middle; text-align: center; }
.est-col-company { color: #0f172a !important; font-weight: 700 !important; font-size: 14.5px !important; text-align: left !important; padding-left: 16px !important; }
.est-col-name { color: #1e293b !important; font-weight: 600 !important; }
.est-col-phone { color: #0f172a !important; font-weight: 600 !important; letter-spacing: 0.2px; }
.est-badge { display: inline-block; padding: 4px 10px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; border-radius: 6px; font-size: 12.5px; font-weight: 600; }
.est-date { color: #64748b; font-size: 13px; font-weight: 500; }
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
        if (!confirm(checked + '개를 삭제할까요?')) return;
        $('#deleteForm').submit();
    });

    // 테이블 행(TR) 전체 클릭 시 상세 페이지로 이동 (체크박스 셀 제외)
    $(document).on('click', '.board_A0_L table tbody tr.est-row td', function(e) {
        if ($(this).hasClass('chk-cell') || $(e.target).is('input[type="checkbox"]')) {
            return;
        }
        var href = $(this).closest('tr').data('href');
        if (href) {
            location.href = href;
        }
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
                <p class="count">총 <b><?=$totals?></b>건의 신청 내역이 있습니다 (행을 클릭하면 상세 내용을 확인하실 수 있습니다)</p>
                <table summary="신청정보 목록">
                    <caption>신청정보 목록</caption>
                        <colgroup>
                            <col width="50" />
                            <col width="60" />
                            <col width="18%" />
                            <col width="11%" />
                            <col width="9%" />
                            <col width="16%" />
                            <col width="15%" />
                            <col width="18%" />
                            <col width="11%" />
                        </colgroup>
                    <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" id="chkAll"></th>
                            <th scope="col" class="resp">번호</th>
                            <th scope="col" style="text-align:left; padding-left:16px;">회사/브랜드명</th>
                            <th scope="col">담당자명</th>
                            <th scope="col">직급</th>
                            <th scope="col">희망 광고유형</th>
                            <th scope="col">연락처</th>
                            <th scope="col">이메일</th>
                            <th scope="col">등록일시</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        if(($totals) > 0){
                            $sql = "SELECT * FROM estmate $sub_SQL ORDER BY est_uid DESC LIMIT $page, $view_limit";
                            $result = mysqli_query($conn, $sql);
                            $cnt = $page+1;
                            while($row = mysqli_fetch_array($result)){
                                $row['est_regdate'] = mb_substr($row['est_regdate'], 0, 16);
                        ?>
                        <tr class="est-row" data-href="view.php?id=<?=$row['est_uid']?>">
                            <td class="chk-cell"><input type="checkbox" name="est_uid[]" value="<?=$row['est_uid']?>"></td>
                            <td class="resp"><?=$cnt?></td>
                            <td class="est-col-company"><?=$row['est_company']?></td>
                            <td class="est-col-name"><?=$row['est_name']?></td>
                            <td><?=($row['est_position'] && $row['est_position'] !== '-' ? htmlspecialchars($row['est_position']) : '-')?></td>
                            <td><span class="est-badge"><?=htmlspecialchars($row['est_ad_type'])?></span></td>
                            <td class="est-col-phone"><?=htmlspecialchars($row['est_phone'])?></td>
                            <td><?=htmlspecialchars($row['est_email'])?></td>
                            <td><span class="est-date"><?=$row['est_regdate']?></span></td>
                        </tr>
                        <?$cnt++;}}?>
                        <?if(($totals) <= 0){?>
                        <tr>
                            <td colspan="9" class="no_text" style="padding: 40px 0; color: #94a3b8; font-size: 15px;">등록된 신청 정보가 없습니다.</td>
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
