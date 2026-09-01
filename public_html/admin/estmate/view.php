<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<body class="bg_body">

<!--header-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php";?>
<!--//header-->

<?php
if(isset($_GET['id'])){
	$filtered_id = mysqli_real_escape_string($conn, $_GET['id']); //필터 보안
	$sql ="SELECT * FROM estmate WHERE est_uid={$filtered_id}";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	$delete_link ='
		<input type="hidden" name="est_uid" value="'.$_GET['id'].'" />
		<input type="submit" value="삭제" class="btn_3 size_n" />
	';
}

$row['est_regdate'] = mb_substr($row['est_regdate'], 0, 10); //제목 글자수 css 사용해도 됨
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

			<!--board_A0_view-->
			<div class="board_A0_V">
				<table summary="신청정보 관리 상세보기입니다">
					<caption>신청정보 관리 상세보기</caption>
					<colgroup>
						<col width="10%" />
						<col width="40%" />
						<col width="10%" />
						<col width="40%" />
					</colgroup>
                    <tbody>
                        <tr>
                            <th scope="row">회사명</th>
                            <td><?=$row['est_company']?></td>
                            <th scope="row">담당자명</th>
                            <td><?=$row['est_name']?></td>
                        </tr>
                        <tr>
                            <th scope="row">직급</th>
                            <td><?=$row['est_position']?></td>
                            <th scope="row">광고 유형</th>
                            <td><?=$row['est_ad_type']?></td>
                        </tr>
                        <tr>
                            <th scope="row">연락처</th>
                            <td><?=$row['est_phone']?></td>
                            <th scope="row">이메일</th>
                            <td><?=$row['est_email']?></td>
                        </tr>
                        <tr>
                            <th scope="row">등록일</th>
                            <td><?=$row['est_regdate']?></td>
                            <th scope="row"></th>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="body_matter">
                                <?=$row['est_memo']?>
                            </td>
                        </tr>
                    </tbody>
				</table>
			</div>
			<!--//board_A0_view-->
			<!--button-->
			<div class="button a_r mat_30">
			<form action="process_delete.php" method="post" onsubmit="if(!confirm('글을 삭제할까요?')){return false;}">
				<?=$delete_link?>
				<input type="button" class="btn_2 size_n" value="목록" onClick="location.href='list.php'">
				</form>
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
