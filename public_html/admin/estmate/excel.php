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
$EXCEL_STR .= "<table>";
$EXCEL_STR .= "<tr>";
$EXCEL_STR .= "<td>번호</td>";
$EXCEL_STR .= "<td>종류</td>";
$EXCEL_STR .= "<td>신청자명</td>";
$EXCEL_STR .= "<td>성별</td>";
$EXCEL_STR .= "<td>연락처</td>";
$EXCEL_STR .= "<td>이메일</td>";
$EXCEL_STR .= "<td>주소</td>";
$EXCEL_STR .= "<td>지역</td>";
$EXCEL_STR .= "<td>방문일</td>";
$EXCEL_STR .= "<td>등록일</td>";
$EXCEL_STR .= "</tr>";
if(($totals) > 0){
    $sql = "SELECT * FROM estmate $sub_SQL ORDER BY est_uid DESC";
    //SELECT * FROM 테이블이름 WHERE 조건 ORDER BY 컬럼이름 LIMIT 갯수
    $result = mysqli_query($conn, $sql);
    $cnt = $page+1; //게시글 번호
    while($row = mysqli_fetch_array($result)){
        $row['est_regdate'] = mb_substr($row['est_regdate'], 0, 10);
$EXCEL_STR .= "<tr>";
$EXCEL_STR .= "<td>".$cnt++."</td>";
$EXCEL_STR .= "<td>".$row['est_type']."</td>";
$EXCEL_STR .= "<td>".$row['est_name']."</td>";
$EXCEL_STR .= "<td>".$row['est_gender']."</td>";
$EXCEL_STR .= "<td>".$row['est_phone']."</td>";
$EXCEL_STR .= "<td>".$row['est_email']."</td>";
$EXCEL_STR .= "<td>".$row['est_address']."</td>";
$EXCEL_STR .= "<td>".$row['est_location']."</td>";
$EXCEL_STR .= "<td>".$row['est_visit']."</td>";
$EXCEL_STR .= "<td>".$row['est_regdate']."</td>";
$EXCEL_STR .= "</tr>";
    }
}
$EXCEL_STR .= "</table>";

echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";
echo $EXCEL_STR;
?>
