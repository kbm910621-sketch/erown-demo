<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";

// Stats
$today = date('Y-m-d');

// 1. Estimates
$sql_est_total = "SELECT COUNT(*) FROM estmate";
$res_est_total = mysqli_query($conn, $sql_est_total);
$tot_est = $res_est_total ? (int)mysqli_fetch_array($res_est_total)[0] : 0;

$sql_est_today = "SELECT COUNT(*) FROM estmate WHERE DATE(est_regdate) = '$today'";
$res_est_today = mysqli_query($conn, $sql_est_today);
$today_est = $res_est_today ? (int)mysqli_fetch_array($res_est_today)[0] : 0;

// 2. Portfolio
$sql_port_total = "SELECT COUNT(*) FROM portfolio";
$res_port_total = mysqli_query($conn, $sql_port_total);
$tot_port = $res_port_total ? (int)mysqli_fetch_array($res_port_total)[0] : 0;

// 3. Popups
$sql_pop_total = "SELECT COUNT(*) FROM popup";
$res_pop_total = mysqli_query($conn, $sql_pop_total);
$tot_pop = $res_pop_total ? (int)mysqli_fetch_array($res_pop_total)[0] : 0;

$cat_map = array(
    'bus'     => '시내버스 광고',
    'shelter' => '버스 승강장·쉘터',
    'did'     => 'DID·터미널 광고',
    'taxi'    => '택시·택배·특화매체',
    'online'  => '온라인 마케팅',
    'video'   => '영상제작',
    'mart'    => '대형마트 카트',
    'print'   => '인쇄물·현수막',
    'web'     => '홈페이지제작'
);
?>

<body class="bg_body">

<!--header-->
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php"; ?>
<!--//header-->

<style>
/* Modern Dashboard Styles */
.dash-container { padding: 0 0 50px 0; }
.dash-welcome {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-radius: 12px;
    padding: 26px 30px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.08);
}
.dash-welcome h2 { font-size: 22px; font-weight: 700; margin: 0 0 6px 0; letter-spacing: -0.5px; color: #fff; }
.dash-welcome p { font-size: 14px; color: #94a3b8; margin: 0; }
.dash-welcome .welcome-actions { display: flex; gap: 10px; }
.btn-site-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 18px;
    background: #2563eb;
    color: #ffffff !important;
    font-size: 13.5px;
    font-weight: 600;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-site-link:hover { background: #1d4ed8; transform: translateY(-1px); }

/* KPI Grid */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}
.kpi-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 22px 24px;
    position: relative;
    overflow: hidden;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    text-decoration: none;
    display: block;
}
.kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    border-color: #cbd5e1;
}
.kpi-label { font-size: 13.5px; font-weight: 600; color: #64748b; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; }
.kpi-num { font-size: 30px; font-weight: 800; color: #0f172a; line-height: 1.1; letter-spacing: -1px; }
.kpi-sub { font-size: 12.5px; color: #94a3b8; margin-top: 6px; font-weight: 500; }
.kpi-sub strong { color: #2563eb; font-weight: 700; }
.kpi-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 20px;
    background: #eff6ff;
    color: #2563eb;
}

/* Sections Layout */
.dash-section-wrap {
    display: flex;
    flex-direction: column;
    gap: 30px;
}
.dash-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px 28px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
}
.dash-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}
.dash-card-title {
    font-size: 17px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
}
.dash-card-title::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 16px;
    background: #2563eb;
    border-radius: 2px;
}
.btn-more-link {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-decoration: none;
    transition: color 0.15s;
}
.btn-more-link:hover { color: #2563eb; }

/* Inquiries Table */
.dash-table {
    width: 100%;
    border-collapse: collapse;
}
.dash-table th {
    background: #f8fafc;
    color: #475569;
    font-size: 13px;
    font-weight: 700;
    padding: 12px 14px;
    border-bottom: 2px solid #e2e8f0;
    text-align: center;
}
.dash-table td {
    padding: 14px 14px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13.5px;
    color: #334155;
    vertical-align: middle;
    text-align: center;
}
.dash-table tbody tr.table-row-hover {
    cursor: pointer;
    transition: background-color 0.15s;
}
.dash-table tbody tr.table-row-hover:hover {
    background-color: #f8fafc;
}
.dash-badge {
    display: inline-block;
    padding: 4px 10px;
    background: #eff6ff;
    color: #1e40af;
    border: 1px solid #bfdbfe;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}
.dash-company { font-weight: 700; color: #0f172a; text-align: left !important; }
.dash-content-snippet { text-align: left !important; color: #64748b; max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* Portfolio Grid */
.port-preview-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}
.port-item-card {
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    text-decoration: none;
    display: block;
    background: #ffffff;
    transition: all 0.2s;
}
.port-item-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
    border-color: #2563eb;
}
.port-item-thumb {
    width: 100%;
    height: 140px;
    background-size: cover;
    background-position: center;
    background-color: #f1f5f9;
    position: relative;
}
.port-cat-tag {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(15, 23, 42, 0.85);
    color: #ffffff;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 4px;
    backdrop-filter: blur(4px);
}
.port-item-info {
    padding: 12px 14px;
}
.port-item-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.port-item-client {
    font-size: 12px;
    color: #64748b;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

@media (max-width: 1200px) {
    .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    .port-preview-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<!--wrap-->
<div id="wrap">
	<!--container-->
	<div id="container">
		<!--title-->
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/title.php"; ?>
		<!--//title-->

		<!--content-->
		<section class="content dash-container">

			<!-- Welcome Banner -->
			<div class="dash-welcome">
				<div>
					<h2>가온엔 관리자 센터</h2>
					<p>안녕하세요, <strong><?=$_SESSION['MID']?></strong>님. 홈페이지의 실시간 상담 접수 및 콘텐츠를 효율적으로 관리하세요.</p>
				</div>
				<div class="welcome-actions">
					<a href="/" target="_blank" class="btn-site-link">
						<span>🌐 홈페이지 바로가기</span>
					</a>
				</div>
			</div>

			<!-- KPI Cards -->
			<div class="kpi-grid">
				<a href="/admin/estmate/list.php" class="kpi-card">
					<div class="kpi-label">
						<span>상담 / 견적 문의</span>
						<span class="kpi-badge">신청 관리</span>
					</div>
					<div class="kpi-num"><?=$tot_est?><span style="font-size:16px; font-weight:500; color:#64748b; margin-left:4px;">건</span></div>
					<div class="kpi-sub">오늘 신규 접수: <strong><?=$today_est?></strong>건</div>
				</a>

				<a href="/admin/bbs/portfolio/admin_portfolio.php" class="kpi-card">
					<div class="kpi-label">
						<span>등록 포트폴리오</span>
						<span class="kpi-badge">사례 관리</span>
					</div>
					<div class="kpi-num"><?=$tot_port?><span style="font-size:16px; font-weight:500; color:#64748b; margin-left:4px;">개</span></div>
					<div class="kpi-sub">총 9개 카테고리 운영 중</div>
				</a>

				<a href="/admin/popup/list.php" class="kpi-card">
					<div class="kpi-label">
						<span>팝업 관리</span>
						<span class="kpi-badge">알림창</span>
					</div>
					<div class="kpi-num"><?=$tot_pop?><span style="font-size:16px; font-weight:500; color:#64748b; margin-left:4px;">건</span></div>
					<div class="kpi-sub">메인 및 페이지 안내 팝업</div>
				</a>

				<a href="/admin/setting/pw_change.php" class="kpi-card">
					<div class="kpi-label">
						<span>기본 환경 설정</span>
						<span class="kpi-badge">계정 보안</span>
					</div>
					<div class="kpi-num" style="font-size:20px; font-weight:700; color:#2563eb; line-height:1.5;">설정 바로가기</div>
					<div class="kpi-sub">비밀번호 변경 및 메타 관리</div>
				</a>
			</div>

			<!-- Sections Wrap -->
			<div class="dash-section-wrap">

				<!-- Recent Inquiries Section -->
				<div class="dash-card">
					<div class="dash-card-header">
						<div class="dash-card-title">최근 견적 및 상담 문의</div>
						<a href="/admin/estmate/list.php" class="btn-more-link">더보기 &rsaquo;</a>
					</div>
					<table class="dash-table">
						<thead>
							<tr>
								<th style="width: 70px;">번호</th>
								<th style="width: 180px; text-align: left; padding-left: 16px;">회사/상호명</th>
								<th style="width: 100px;">담당자</th>
								<th style="width: 130px;">연락처</th>
								<th style="width: 140px;">문의 매체</th>
								<th style="text-align: left; padding-left: 16px;">문의 내용</th>
								<th style="width: 120px;">접수일시</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql_est_list = "SELECT * FROM estmate ORDER BY est_uid DESC LIMIT 5";
							$res_est_list = mysqli_query($conn, $sql_est_list);
							$has_est = false;

							if ($res_est_list && mysqli_num_rows($res_est_list) > 0) {
								$has_est = true;
								while ($row = mysqli_fetch_array($res_est_list)) {
									$co = !empty($row['est_company']) ? htmlspecialchars($row['est_company']) : '-';
									$name = !empty($row['est_name']) ? htmlspecialchars($row['est_name']) : '-';
									$phone = !empty($row['est_phone']) ? htmlspecialchars($row['est_phone']) : '-';
									$type = !empty($row['est_ad_type']) ? htmlspecialchars($row['est_ad_type']) : '-';
									$content = !empty($row['est_content']) ? htmlspecialchars($row['est_content']) : '-';
									$date = substr($row['est_regdate'], 0, 10);
							?>
							<tr class="table-row-hover" onclick="location.href='/admin/estmate/view.php?id=<?=$row['est_uid']?>';">
								<td><?=$row['est_uid']?></td>
								<td class="dash-company"><?=$co?></td>
								<td><strong><?=$name?></strong></td>
								<td><?=$phone?></td>
								<td><span class="dash-badge"><?=$type?></span></td>
								<td class="dash-content-snippet"><?=$content?></td>
								<td style="color:#64748b; font-size:12.5px;"><?=$date?></td>
							</tr>
							<?php
								}
							}
							if (!$has_est) {
							?>
							<tr>
								<td colspan="7" style="padding: 40px; color:#94a3b8;">접수된 상담/견적 문의가 없습니다.</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

				<!-- Recent Portfolio Section -->
				<div class="dash-card">
					<div class="dash-card-header">
						<div class="dash-card-title">최근 등록 포트폴리오</div>
						<a href="/admin/bbs/portfolio/admin_portfolio.php" class="btn-more-link">포트폴리오 관리 &rsaquo;</a>
					</div>
					<div class="port-preview-grid">
						<?php
						$sql_port_list = "SELECT * FROM portfolio ORDER BY id DESC LIMIT 4";
						$res_port_list = mysqli_query($conn, $sql_port_list);
						$has_port = false;

						if ($res_port_list && mysqli_num_rows($res_port_list) > 0) {
							$has_port = true;
							while ($prow = mysqli_fetch_array($res_port_list)) {
								$cat_name = isset($cat_map[$prow['category']]) ? $cat_map[$prow['category']] : $prow['category'];
								$p_thumb = !empty($prow['thumb']) ? $prow['thumb'] : '/images/bs_ad/baro.jpg';
								$p_thumb = str_replace('/admin/bbs/portfolio/uploads/bus/', '/images/port/', $p_thumb);
						?>
						<a href="/admin/bbs/portfolio/admin_portfolio.php" class="port-item-card">
							<div class="port-item-thumb" style="background-image: url('<?=$p_thumb?>');">
								<span class="port-cat-tag"><?=$cat_name?></span>
							</div>
							<div class="port-item-info">
								<h4 class="port-item-title"><?=htmlspecialchars($prow['title'])?></h4>
								<p class="port-item-client"><?=!empty($prow['client']) ? htmlspecialchars($prow['client']) : '가온엔 광고 집행'?></p>
							</div>
						</a>
						<?php
							}
						}
						if (!$has_port) {
						?>
						<div style="grid-column: span 4; text-align:center; padding: 40px; color:#94a3b8;">등록된 포트폴리오가 없습니다.</div>
						<?php } ?>
					</div>
				</div>

			</div>
			<!--// Sections Wrap -->

		</section>
		<!--//content-->
	</div>
	<!--//container-->
</div>
<!--//wrap-->

</body>
</html>