<?
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

header( "Content-type: application/vnd.ms-excel" );
header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = visit_list.xls" );
header( "Content-Description: PHP4 Generated Data" );

$_page=$_GET['_page'];

$sql = "SELECT COUNT(*) FROM estmate";
$result = mysqli_query($conn, $sql);
$temp = mysqli_fetch_array($result);
$totals = $temp[0];
?>
<?
$EXCEL_STR = "";
$EXCEL_STR .= "<div>총 <b>".$totals."</b>건의 내용이 있습니다.</div>";
$EXCEL_STR .= "<table border='1'>";
$EXCEL_STR .= "<tr>";
$EXCEL_STR .= "<th>번호</th>";
$EXCEL_STR .= "<th>회사명</th>";
$EXCEL_STR .= "<th>담당자명</th>";
$EXCEL_STR .= "<th>직급</th>";
$EXCEL_STR .= "<th>광고 유형</th>";
$EXCEL_STR .= "<th>연락처</th>";
$EXCEL_STR .= "<th>이메일</th>";
$EXCEL_STR .= "<th>문의 내용</th>";
$EXCEL_STR .= "<th>등록일</th>";
$EXCEL_STR .= "</tr>";
if(($totals) > 0){
    $sql = "SELECT * FROM estmate ORDER BY est_uid DESC";
    $result = mysqli_query($conn, $sql);
    $cnt = 1;
    while($row = mysqli_fetch_array($result)){
        $row['est_regdate'] = mb_substr($row['est_regdate'], 0, 10);
        $pos = $row['est_position'] ? $row['est_position'] : '-';
        $EXCEL_STR .= "<tr>";
        $EXCEL_STR .= "<td>".$cnt++."</td>";
        $EXCEL_STR .= "<td>".$row['est_company']."</td>";
        $EXCEL_STR .= "<td>".$row['est_name']."</td>";
        $EXCEL_STR .= "<td>".$pos."</td>";
        $EXCEL_STR .= "<td>".$row['est_ad_type']."</td>";
        $EXCEL_STR .= "<td>".$row['est_phone']."</td>";
        $EXCEL_STR .= "<td>".$row['est_email']."</td>";
        $EXCEL_STR .= "<td>".nl2br(htmlspecialchars($row['est_memo']))."</td>";
        $EXCEL_STR .= "<td>".$row['est_regdate']."</td>";
        $EXCEL_STR .= "</tr>";
    }
}
$EXCEL_STR .= "</table>";

echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";
echo $EXCEL_STR;
?>
