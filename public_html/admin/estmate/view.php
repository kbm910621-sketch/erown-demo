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
		<input type="hidden" name="est_uid[]" value="'.$_GET['id'].'" />
		<input type="submit" value="삭제" class="btn_3 size_n" />
	';
}
$row['est_regdate'] = mb_substr($row['est_regdate'], 0, 16);
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
				<table summary="신청정보 상세보기로 회사명, 담당자명, 연락처, 이메일, 희망 광고유형, 문의내용을 제공합니다.">
					<caption>신청정보 상세보기</caption>
					<colgroup>
						<col width="15%" />
						<col width="35%" />
						<col width="15%" />
						<col width="35%" />
					</colgroup>
					<tbody>
						<tr>
							<th colspan="4" scope="col" class="subject">
								<strong><?=htmlspecialchars($row['est_company'])?> - 온라인 상담/견적 신청</strong>
								<div class="sub_info"><span><?=$row['est_regdate']?></span></div>
							</th>
						</tr>
						<tr>
							<th scope="row">담당자명</th>
							<td><?=htmlspecialchars($row['est_name'])?></td>
							<th scope="row">직급</th>
							<td><?=htmlspecialchars($row['est_position'] ? $row['est_position'] : '-')?></td>
						</tr>
						<tr>
							<th scope="row">연락처</th>
							<td><a href="tel:<?=htmlspecialchars($row['est_phone'])?>" style="font-weight:bold;"><?=htmlspecialchars($row['est_phone'])?></a></td>
							<th scope="row">이메일</th>
							<td><?=htmlspecialchars($row['est_email'] ? $row['est_email'] : '-')?></td>
						</tr>
						<tr>
							<th scope="row">희망 광고유형</th>
							<td colspan="3"><b style="color:#111;"><?=htmlspecialchars($row['est_ad_type'])?></b></td>
						</tr>
						<tr>
							<td colspan="4" class="body_matter" style="min-height:160px; line-height:1.8; padding:30px 20px; font-size:14px;">
								<?=nl2br(htmlspecialchars($row['est_content']))?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!--//board_A0_view-->

			<!--button-->
			<div class="button a_r mat_30">
			<form action="process_delete.php" method="post" onsubmit="if(!confirm('신청내역을 삭제할까요?')){return false;}">
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