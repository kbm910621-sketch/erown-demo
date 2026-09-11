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
		<input type="submit" value="신청내역 삭제" class="btn_3 size_n" style="background:#dc2626; border-color:#dc2626;" />
	';
}
?>

<style>
.est-view-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden; margin-top: 10px; }
.est-view-head { background: #f8fafc; padding: 20px 28px; border-bottom: 1.5px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; }
.est-view-company { font-size: 20px; font-weight: 800; color: #0f172a; margin: 0; }
.est-view-date { font-size: 13.5px; font-weight: 600; color: #64748b; }
.est-grid-table { width: 100%; border-collapse: collapse; }
.est-grid-table th { background: #f8fafc; color: #334155; font-size: 14px; font-weight: 700; padding: 16px 20px; border: 1px solid #e2e8f0; width: 15%; text-align: left; }
.est-grid-table td { color: #0f172a; font-size: 14.5px; font-weight: 500; padding: 16px 20px; border: 1px solid #e2e8f0; width: 35%; vertical-align: middle; }
.est-memo-sec { padding: 28px; border-top: 2px solid #e2e8f0; background: #ffffff; }
.est-memo-title { font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 14px; display: flex; align-items: center; gap: 8px; }
.est-memo-box { background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 24px; font-size: 15.5px; line-height: 1.85; color: #0f172a; white-space: pre-wrap; word-break: break-all; min-height: 140px; font-family: "Pretendard", "Apple SD Gothic Neo", sans-serif; font-weight: 500; }
.est-badge-pill { display: inline-block; padding: 5px 12px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; border-radius: 6px; font-size: 13px; font-weight: 700; }
.est-link-call { color: #1855b7 !important; font-weight: 700 !important; text-decoration: underline !important; font-size: 15px !important; }
</style>

<!--wrap-->
<div id="wrap">
	<!--container-->
	<div id="container">
		<!--title-->
		<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/title.php";?>
		<!--//title-->

		<!--content-->
		<section class="content">

			<div class="est-view-card">
				<!-- TOP HEADER -->
				<div class="est-view-head">
					<h3 class="est-view-company"><?=htmlspecialchars($row['est_company'])?> <span style="font-size:15px; font-weight:600; color:#475569; margin-left:8px;">신청 정보 상세</span></h3>
					<span class="est-view-date">접수일시 : <?=$row['est_regdate']?></span>
				</div>

				<!-- INFO GRID -->
				<table class="est-grid-table">
					<tbody>
						<tr>
							<th scope="row">회사 / 브랜드명</th>
							<td style="font-size:16px; font-weight:700; color:#0f172a;"><?=htmlspecialchars($row['est_company'])?></td>
							<th scope="row">담당자명 / 직급</th>
							<td><b><?=htmlspecialchars($row['est_name'])?></b> <span style="color:#64748b; margin-left:6px;"><?=($row['est_position'] && $row['est_position'] !== '-' ? '('.htmlspecialchars($row['est_position']).')' : '')?></span></td>
						</tr>
						<tr>
							<th scope="row">희망 광고유형</th>
							<td><span class="est-badge-pill"><?=htmlspecialchars($row['est_ad_type'])?></span></td>
							<th scope="row">접수일시</th>
							<td><?=$row['est_regdate']?></td>
						</tr>
						<tr>
							<th scope="row">연락처 (전화번호)</th>
							<td><a href="tel:<?=htmlspecialchars($row['est_phone'])?>" class="est-link-call">📞 <?=htmlspecialchars($row['est_phone'])?></a></td>
							<th scope="row">이메일 주소</th>
							<td><a href="mailto:<?=htmlspecialchars($row['est_email'])?>" style="color:#0f172a; font-weight:600; text-decoration:underline;">✉ <?=htmlspecialchars($row['est_email'])?></a></td>
						</tr>
					</tbody>
				</table>

				<!-- CONSULTATION MEMO / MESSAGE -->
				<div class="est-memo-sec">
					<h4 class="est-memo-title">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
						문의 및 상담 내용 (고객 작성)
					</h4>
					<div class="est-memo-box">
						<?php 
						$memo_text = isset($row['est_memo']) ? trim($row['est_memo']) : '';
						if ($memo_text !== '') {
							echo nl2br(htmlspecialchars($memo_text));
						} else {
							echo '<span style="color:#94a3b8; font-style:italic;">(별도의 작성된 상담 상세 내용이 없습니다.)</span>';
						}
						?>
					</div>
				</div>
			</div>

			<!-- ACTION BUTTONS -->
			<div class="button a_r mat_30" style="display:flex; justify-content:space-between; align-items:center;">
				<input type="button" class="btn_2 size_n" value="← 목록으로 돌아가기" onClick="location.href='list.php'" style="padding:10px 24px; font-size:14px; font-weight:700;">
				<form action="process_delete.php" method="post" onsubmit="if(!confirm('이 신청 내역을 영구히 삭제할까요?')){return false;}">
					<?=$delete_link?>
				</form>
			</div>

		</section>
		<!--//content-->
	</div>
	<!--//container-->
</div>
<!--//wrap-->

</body>
</html>
