<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<body class="bg_body">

<!--header-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php";?>
<!--//header-->

<?php
$today = date('Y-m-d');

// 1. Estimates
$tot_est = 0;
$sql_est_total = "SELECT COUNT(*) FROM estmate";
$res_est_total = mysqli_query($conn, $sql_est_total);
if ($res_est_total) {
    $row_est_total = mysqli_fetch_array($res_est_total);
    if ($row_est_total) $tot_est = (int)$row_est_total[0];
}

$today_est = 0;
$sql_est_today = "SELECT COUNT(*) FROM estmate WHERE DATE(est_regdate) = '$today'";
$res_est_today = mysqli_query($conn, $sql_est_today);
if ($res_est_today) {
    $row_est_today = mysqli_fetch_array($res_est_today);
    if ($row_est_today) $today_est = (int)$row_est_today[0];
}

// 2. Portfolio
$tot_port = 0;
$sql_port_total = "SELECT COUNT(*) FROM portfolio";
$res_port_total = mysqli_query($conn, $sql_port_total);
if ($res_port_total) {
    $row_port_total = mysqli_fetch_array($res_port_total);
    if ($row_port_total) $tot_port = (int)$row_port_total[0];
}

// 3. Popups
$tot_pop = 0;
$sql_pop_total = "SELECT COUNT(*) FROM popup";
$res_pop_total = mysqli_query($conn, $sql_pop_total);
if ($res_pop_total) {
    $row_pop_total = mysqli_fetch_array($res_pop_total);
    if ($row_pop_total) $tot_pop = (int)$row_pop_total[0];
}

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

function normalize_port_img($url) {
    if (empty($url)) return '/images/bs_ad/baro.jpg';
    return str_replace('/admin/bbs/portfolio/uploads/bus/', '/images/port/', $url);
}
?>

<style>
.main_stat_wrap { display: flex; gap: 15px; margin-bottom: 35px; flex-wrap: wrap; }
.main_stat_box { flex: 1; min-width: 200px; background: #fff; border: 1px solid #dcdcdc; border-radius: 6px; padding: 20px; box-sizing: border-box; text-decoration: none !important; transition: all 0.2s; }
.main_stat_box:hover { border-color: #111; box-shadow: 0 4px 12px rgba(0,0,0,0.06); transform: translateY(-2px); }
.main_stat_tit { font-size: 13px; font-weight: 600; color: #666; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; }
.main_stat_num { font-size: 26px; font-weight: 700; color: #111; line-height: 1.2; }
.main_stat_sub { font-size: 12px; color: #888; margin-top: 6px; }
.main_stat_sub b { color: #2563eb; }
.main_sec_header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 10px; }
.main_sec_header h2 { margin: 0; }
.main_more_btn { font-size: 13px; color: #666; text-decoration: none; }
.main_more_btn:hover { color: #111; text-decoration: underline; }
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

			<!-- Stat Box Grid -->
			<div class="main_stat_wrap">
				<a href="/admin/estmate/list.php" class="main_stat_box">
					<div class="main_stat_tit">
						<span>상담 / 견적 신청</span>
						<span style="color:#2563eb; font-weight:bold;">신청관리</span>
					</div>
					<div class="main_stat_num"><?=$tot_est?><span style="font-size:15px; font-weight:normal; color:#666; margin-left:3px;">건</span></div>
					<div class="main_stat_sub">오늘 신규 접수: <b><?=$today_est?></b>건</div>
				</a>

				<a href="/admin/bbs/portfolio/admin_portfolio.php" class="main_stat_box">
					<div class="main_stat_tit">
						<span>등록 포트폴리오</span>
						<span style="color:#2563eb; font-weight:bold;">사례관리</span>
					</div>
					<div class="main_stat_num"><?=$tot_port?><span style="font-size:15px; font-weight:normal; color:#666; margin-left:3px;">개</span></div>
					<div class="main_stat_sub">총 9개 광고유형 운영</div>
				</a>

				<a href="/admin/popup/list.php" class="main_stat_box">
					<div class="main_stat_tit">
						<span>팝업 관리</span>
						<span style="color:#666; font-weight:bold;">알림창</span>
					</div>
					<div class="main_stat_num"><?=$tot_pop?><span style="font-size:15px; font-weight:normal; color:#666; margin-left:3px;">건</span></div>
					<div class="main_stat_sub">메인 및 서브 안내 팝업</div>
				</a>

				<a href="/" target="_blank" class="main_stat_box">
					<div class="main_stat_tit">
						<span>가온엔 홈페이지</span>
						<span style="color:#111; font-weight:bold;">새창열기 ↗</span>
					</div>
					<div class="main_stat_num" style="font-size:18px; color:#2563eb; line-height:1.7;">바로가기</div>
					<div class="main_stat_sub">사용자 화면 확인</div>
				</a>
			</div>

			<!--board_A0_list : Recent Inquiries -->
	  		<div class="board_A0_L">
				<div class="main_sec_header">
					<h2 class="bbs_rctit" style="margin-bottom:0;">신청정보 최근글</h2>
					<a href="/admin/estmate/list.php" class="main_more_btn">더보기 +</a>
				</div>
				<table summary="신청정보 최근글 목록이며 번호, 회사/상호명, 담당자명, 직급, 희망 광고유형, 연락처, 작성일을 제공합니다.">
					<caption>신청정보 최근글 목록</caption>
					<colgroup>
						<col width="80" />
						<col width="*" />
						<col width="120" />
						<col width="100" />
						<col width="160" />
						<col width="150" />
						<col width="120" />
					</colgroup>
					<thead>
						<tr>
							<th scope="col" class="resp">번호</th>
							<th scope="col">회사/상호명</th>
							<th scope="col">담당자명</th>
							<th scope="col">직급</th>
							<th scope="col">희망 광고유형</th>
							<th scope="col">연락처</th>
							<th scope="col">작성일</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$view_limit = 5;
						$sql = "SELECT * FROM estmate ORDER BY est_uid DESC LIMIT $view_limit";
						$result = mysqli_query($conn, $sql);
						$has_est = false;

						if ($result && mysqli_num_rows($result) > 0) {
							$has_est = true;
							$cnt = 1;
							while ($row = mysqli_fetch_array($result)) {
								$date = substr($row['est_regdate'], 0, 10);
								$pos = ($row['est_position'] && $row['est_position'] !== '-') ? htmlspecialchars($row['est_position']) : '-';
						?>
						<tr>
							<td class="resp"><?=$cnt?></td>
							<td class="subject">
								<a href="/admin/estmate/view.php?id=<?=$row['est_uid']?>"><b><?=htmlspecialchars($row['est_company'])?></b></a>
							</td>
							<td><?=htmlspecialchars($row['est_name'])?></td>
							<td><?=$pos?></td>
							<td><?=htmlspecialchars($row['est_ad_type'])?></td>
							<td><?=htmlspecialchars($row['est_phone'])?></td>
							<td><?=$date?></td>
						</tr>
						<?php $cnt++; }} ?>
						<?php if (!$has_est) { ?>
						<tr>
							<td colspan="7" class="no_text">등록된 신청 정보가 없습니다.</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<!--//board_A0_list-->

			<!--board_A0_list : Recent Portfolio -->
	  		<div class="board_A0_L mat_50">
				<div class="main_sec_header">
					<h2 class="bbs_rctit" style="margin-bottom:0;">포트폴리오 최근글</h2>
					<a href="/admin/bbs/portfolio/admin_portfolio.php" class="main_more_btn">더보기 +</a>
				</div>
				<table summary="포트폴리오 최근글 목록이며 번호, 썸네일, 광고유형, 광고명, 광고주, 지역, 등록일을 제공합니다.">
					<caption>포트폴리오 최근글 목록</caption>
					<colgroup>
						<col width="70" />
						<col width="100" />
						<col width="140" />
						<col width="*" />
						<col width="140" />
						<col width="120" />
						<col width="100" />
					</colgroup>
					<thead>
						<tr>
							<th scope="col" class="resp">번호</th>
							<th scope="col">썸네일</th>
							<th scope="col">광고유형</th>
							<th scope="col">광고명</th>
							<th scope="col">광고주</th>
							<th scope="col">지역</th>
							<th scope="col">노출여부</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql_port = "SELECT * FROM portfolio ORDER BY id DESC LIMIT 5";
						$res_port = mysqli_query($conn, $sql_port);
						$has_port = false;

						if ($res_port && mysqli_num_rows($res_port) > 0) {
							$has_port = true;
							$cnt = 1;
							while ($prow = mysqli_fetch_array($res_port)) {
								$cat_name = isset($cat_map[$prow['category']]) ? $cat_map[$prow['category']] : $prow['category'];
								$thumb_src = !empty($prow['thumb']) ? normalize_port_img($prow['thumb']) : '/images/bs_ad/baro.jpg';
								$status_txt = ($prow['status'] === 'active') ? '<span style="color:#16a34a; font-weight:bold;">공개</span>' : '<span style="color:#999;">비공개</span>';
						?>
						<tr>
							<td class="resp"><?=$cnt?></td>
							<td>
								<a href="/admin/bbs/portfolio/admin_portfolio.php?mode=modify&id=<?=$prow['id']?>">
									<img src="<?=$thumb_src?>" alt="" style="width:70px; height:46px; object-fit:cover; border:1px solid #ddd; border-radius:3px; vertical-align:middle;">
								</a>
							</td>
							<td><?=$cat_name?></td>
							<td class="subject">
								<a href="/admin/bbs/portfolio/admin_portfolio.php?mode=modify&id=<?=$prow['id']?>"><b><?=htmlspecialchars($prow['title'])?></b></a>
							</td>
							<td><?=htmlspecialchars($prow['client'] ? $prow['client'] : '-')?></td>
							<td><?=htmlspecialchars($prow['location'] ? $prow['location'] : '-')?></td>
							<td><?=$status_txt?></td>
						</tr>
						<?php $cnt++; }} ?>
						<?php if (!$has_port) { ?>
						<tr>
							<td colspan="7" class="no_text">등록된 포트폴리오가 없습니다.</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<!--//board_A0_list-->

		</section>
		<!--//content-->
	</div>
	<!--//container-->
</div>
<!--//wrap-->

</body>
</html>
