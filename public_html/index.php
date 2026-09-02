<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";
?>

<body class="is-main">
<?php
$sql = "SELECT COUNT(*) FROM popup";
$result = mysqli_query($conn, $sql);
$temp = mysqli_fetch_array($result);
$totals = $temp[0];

$categories = array(
  'bus'    => '시내버스 광고',
  'taxi'   => '택시·택배 광고',
  'did'    => 'DID 전광판',
  'print'  => '인쇄·대형현수막',
  'online' => '온라인 마케팅',
  'web'    => '홈페이지 제작',
  'video'  => '영상제작',
  'mart'   => '대형마트 리테일',
);

$result = mysqli_query($conn, "SELECT * FROM portfolio WHERE status='active' ORDER BY sort_order ASC, id DESC");
$list   = array();
while ($row = mysqli_fetch_assoc($result)) {
  $list[] = $row;
}
$total = count($list);

$portBus = array();
$portOnline = array();
$portVideo = array();
$portOther = array();

foreach ($list as $item) {
  if ($item['category'] == 'bus') $portBus[] = $item;
  if ($item['category'] == 'online' || $item['category'] == 'web') $portOnline[] = $item;
  if ($item['category'] == 'video') $portVideo[] = $item;
  if (in_array($item['category'], array('taxi','mart','did','print'))) $portOther[] = $item;
}

if($totals>0){
	$sql = "SELECT * FROM popup WHERE pop_status='1' ORDER BY pop_order ASC";
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_array($result)){
		if($_COOKIE["todayCookie_".$row['pop_uid']] != "done"){
?>
<div class="popup_layer" id="popup_<?php echo $row['pop_uid']; ?>" style="top:<?php echo $row['pop_top']; ?>px;left:<?php echo $row['pop_left']; ?>px">
    <div class="pop_top"></div>
    <div class="pop_mid"><img src="/admin/popup/uploads/<?php echo $row['pop_file0']; ?>" style="width:<?php echo $row['pop_width']; ?>px" alt="" /></div>
    <div class="pop_botm">
		<input type="checkbox" class="btn_day_close" val="<?php echo $row['pop_uid']; ?>">
		<label for="popcheck" class="btn_day_close" val="<?php echo $row['pop_uid']; ?>">오늘 하루 동안 열지 않기</label>
		<span class="pop_close" popnum="<?php echo $row['pop_uid']; ?>">닫기</span>
    </div>
</div>
<?php } } } ?>

<script type="text/javascript">
$(function () {
	$(document).on('click','.pop_close', function(){ $('#popup_'+$(this).attr('popnum')).hide(); });
	$(document).on('click','.btn_day_close', function(){ setCookie("todayCookie_"+$(this).attr('val'), "done", 1); $('#popup_'+$(this).attr('val')).hide(); });
});
function setCookie(name, value, expiredays){ var d = new Date(); d.setDate(d.getDate() + expiredays); document.cookie = name + "=" + escape(value) + "; path=/; expires=" + d.toGMTString() + ";"; }
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/blank.php";?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/skip.php";?>

<div id="wrap" class="agency-master-system">

	<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php";?>
  
  <!-- ============================================
       01 HERO STAGE : GSAP 1.2S SYMMETRIC SILKY SCROLL HERO
  ============================================ -->
  <section class="main_hero" id="hero">
    <div class="main_hero_text_wrap">
      <h1 class="main_hero_text">
        보여주는 광고보다<br>
        이해되는 광고를 만듭니다.
      </h1>
      <div class="main_hero_keywords">
        <a href="#bus" class="mhk-pill">버스 광고</a>
        <a href="#other" class="mhk-pill">택시 광고</a>
        <a href="#online" class="mhk-pill">온라인·SNS</a>
        <a href="#video" class="mhk-pill">영상제작</a>
        <a href="#online" class="mhk-pill">병원 마케팅</a>
      </div>
    </div>

    <div class="main_hero_panel_wrap">
      <div class="main_hero_panel">
        <div class="main_hero_panel_video_wrap">
          <video autoplay muted loop playsinline class="main_hero_panel_video">
            <source src="/images/movie.mp4" type="video/mp4">
          </video>
          <div class="main_hero_panel_dim"></div>
          <div class="main_hero_panel_overlay_text">
            <div class="mho-text-box">
              <h2 class="mho-title">
                보여주는 광고보다<br>
                이해되는 광고를 만듭니다.
              </h2>
              <p class="mho-sub">
                광주 시내버스 104개 노선 단독 직영 · 네이버 1위 마케팅 · 4K 시네마틱 프로덕션
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================
       01-B ABOUT STATS SECTION (CLEAN LIGHT BACKGROUND)
  ============================================ -->
  <section class="am-about-stats-sec">
    <div class="aas-silk-canvas">
      <svg class="aas-silk-svg" viewBox="0 0 1600 600" fill="none" preserveAspectRatio="none">
        <path class="silk-line line-1" d="M-100,220 C350,60 700,380 1150,140 C1400,-20 1550,220 1750,160" stroke="#e8edf4" stroke-width="1.1" stroke-linecap="round" />
        <path class="silk-line line-2" d="M-80,360 C320,180 780,460 1180,240 C1420,80 1560,340 1780,260" stroke="#edf2f7" stroke-width="0.9" stroke-linecap="round" />
      </svg>
    </div>

    <div class="am-container" style="position:relative; z-index:2;">
      <div class="aas-top-row wow fadeInUp" data-wow-duration="0.8s">
        <div class="aas-headline-col">
          <div class="aas-kicker-line">
            <span class="akl-dash"></span>
            <span class="akl-text">ABOUT GAON-N</span>
          </div>
          <h2 class="aas-main-title">
            우리는 광고의<br>
            <span class="aas-blue-highlight">오프라인과 온라인을 잇는</span><br>
            통합 마케팅 파트너입니다.
          </h2>
        </div>

        <div class="aas-watermark-col">
          <div class="awc-huge-text">BUS</div>
          <div class="awc-huge-text">TAXI</div>
          <div class="awc-huge-text bold">ONLINE</div>
        </div>
      </div>

      <div class="aas-cards-grid wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.15s">
        <div class="aas-stat-card">
          <span class="asc-label">누적 광고 집행</span>
          <div class="asc-value-row">
            <strong class="asc-num counter" data-target="500">500</strong><span class="asc-plus">+</span>
          </div>
          <span class="asc-unit">건</span>
        </div>
        <div class="aas-stat-card">
          <span class="asc-label">운행 광고 차량</span>
          <div class="asc-value-row">
            <strong class="asc-num counter" data-target="200">200</strong><span class="asc-plus">+</span>
          </div>
          <span class="asc-unit">대</span>
        </div>
        <div class="aas-stat-card">
          <span class="asc-label">광주 지역 서비스</span>
          <div class="asc-value-row">
            <strong class="asc-num counter" data-target="10">10</strong>
          </div>
          <span class="asc-unit">년</span>
        </div>
        <div class="aas-stat-card">
          <span class="asc-label">고객 재계약률</span>
          <div class="asc-value-row">
            <strong class="asc-num counter" data-target="98">98</strong>
          </div>
          <span class="asc-unit">%</span>
        </div>
        <div class="aas-stat-card">
          <span class="asc-label">협력 매체사</span>
          <div class="asc-value-row">
            <strong class="asc-num counter" data-target="50">50</strong><span class="asc-plus">+</span>
          </div>
          <span class="asc-unit">곳</span>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================
       02 SECTION 01 : 시내버스 광고 (BIG FULL-IMAGE VISUAL CARDS)
  ============================================ -->
  <section class="am-section am-bg-slate" id="bus">
    <div class="am-container">
      
      <div class="am-sec-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker">01 / BUS ADVERTISING</span>
            <h2 class="ash-title">시내버스 광고</h2>
            <p class="ash-desc">광주 시내버스 104개 전 노선 단독 배차. 일일 150만 시민의 눈높이에서 18시간 동안 반복 각인되는 움직이는 랜드마크입니다.</p>
          </div>
          <div class="ash-actions">
            <button type="button" class="ash-guide-btn blue" id="btnOpenRouteSearchModal">
              <span>광주 104개 노선 실시간 검색기 ↗</span>
            </button>
            <button type="button" class="ash-guide-btn bus-guide-open" data-guide="guideBus">
              <span>시내버스 규격 가이드 ↗</span>
            </button>
          </div>
        </div>
      </div>

      <!-- BUS BLUEPRINT STUDIO CONSOLE -->
      <div class="am-bus-console wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="abc-chip-bar">
          <button type="button" class="abc-chip bus-spot-btn on"
                  data-name="차도면 대형 래핑"
                  data-size="3,700 × 1,000 mm"
                  data-target="왕복 6~8차선 반대편 차량 운전자 &amp; 보행자 시야 정면 100% 노출"
                  data-material="LG 하우시스 최고급 내후성 정품 솔벤 시트 (1년 이상 변색 방지)"
                  data-benefit="도심 간선도로 주행 중 가장 거대한 면적으로 브랜드 인지도를 각인시킵니다. 상무지구, 광천터미널 등 핵심 도로에서 3초 안에 시선을 장악합니다.">
            차도면 (3,700×1,000)
          </button>
          <button type="button" class="abc-chip bus-spot-btn"
                  data-name="인도면 표준 래핑"
                  data-size="3,000 × 500 mm"
                  data-target="버스 정류장 대기 승객 &amp; 인도 보행자 눈높이 1:1 밀착"
                  data-material="LG 하우시스 최고급 내후성 정품 솔벤 시트"
                  data-benefit="승객 탑승 시 눈높이 정면에 위치하여 전화번호, 진료과목, 핵심 진료 안내 등 상세 정보 전달에 가장 효과적인 밀착형 규격입니다.">
            인도면 (3,000×500)
          </button>
          <button type="button" class="abc-chip bus-spot-btn"
                  data-name="후면 번호판 상단 래핑"
                  data-size="2,400 × 300 mm"
                  data-target="신호 대기 및 도로 정체 시 후방 차량 운전자 3분 이상 강제 주시"
                  data-material="LG 하우시스 정품 솔벤 반사 시트 지원"
                  data-benefit="출퇴근 시간 및 교차로 신호 대기 중 뒤따르는 차량 운전자와 동승자 시선 정면에 장시간 강제 노출되는 가온엔 필수 패키지 면입니다.">
            후면 (2,400×300)
          </button>
          <button type="button" class="abc-chip bus-spot-btn"
                  data-name="사랑면 (승하차문 측면)"
                  data-size="1,000 × 500 mm"
                  data-target="승객 승하차 시 즉각적인 시선 유도"
                  data-material="고접착 실사 솔벤 시트"
                  data-benefit="하차문 바로 옆에 위치하여 탑승객이 내릴 때 100% 마주치게 되며, 보행자가 버스에 접근할 때 즉각적인 주목도를 형성합니다.">
            사랑면 (1,000×500)
          </button>
          <button type="button" class="abc-chip bus-spot-btn"
                  data-name="내부 중앙창문 포스터"
                  data-size="1,100 × 500 mm"
                  data-target="좌석 및 통로 탑승객 15~30분간 시선 독점"
                  data-material="실내 고선명 페트(PET) 출력"
                  data-benefit="목적지까지 이동하는 15~30분 동안 승객 시선 정면에 머물며 병원/학원의 세부 강점과 브랜드 스토리를 정독시키는 고밀도 매체입니다.">
            내부 창문 (1,100×500)
          </button>
          <button type="button" class="abc-chip bus-spot-btn"
                  data-name="정류소 음성 안내 방송"
                  data-size="1회 7초 성우 음성"
                  data-target="해당 정류소 도착 전 탑승 승객 전원 청각 100% 각인"
                  data-material="전문 성우 육성 녹음 + 공식 오디오 마스터링"
                  data-benefit="'이번 정류소는 ○○병원 앞입니다.' 정류소당 단 1개 광고주만 독점 송출되어 시각적 한계를 넘어 청각으로 확실하게 기억시킵니다.">
            음성 안내 방송 (7초)
          </button>
        </div>

        <div class="abc-stage-row">
          <div class="abc-visual-viewport">
            <div class="avv-frame">
              <img src="/images/sample_bus.jpg" id="dynBusImg" alt="시내버스 광고 실사">
              <div class="avv-marker" id="dvsMarker" style="top:35%; left:25%;"></div>
            </div>
          </div>

          <div class="abc-brief-panel">
            <div class="abp-badge" id="dynBusBadge">차도면 대형 래핑</div>
            <h3 class="abp-title" id="dynBusSize">3,700 × 1,000 mm</h3>
            
            <div class="abp-field">
              <span class="abp-lbl">노출 타깃</span>
              <strong class="abp-val" id="dynBusTarget">왕복 6~8차선 반대편 차량 운전자 &amp; 보행자 시야 정면 100% 노출</strong>
            </div>

            <div class="abp-field">
              <span class="abp-lbl">소재 및 재질</span>
              <strong class="abp-val" id="dynBusMaterial">LG 하우시스 최고급 내후성 정품 솔벤 시트 (1년 이상 변색 방지)</strong>
            </div>
            
            <div class="abp-field">
              <span class="abp-lbl">상권 공략 전략</span>
              <p class="abp-desc" id="dynBusBenefit">도심 간선도로 주행 중 가장 거대한 면적으로 브랜드 인지도를 각인시킵니다. 상무지구, 광천터미널 등 핵심 도로에서 3초 안에 시선을 장악합니다.</p>
            </div>

            <div class="abp-action">
              <a href="#consultation" class="abp-btn">이 규격으로 맞춤 견적 신청 →</a>
            </div>
          </div>
        </div>

      </div>

      <!-- 3 BIG FULL-IMAGE PANORAMIC CARDS -->
      <div class="am-full-visual-grid-3 wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="afv-card">
          <img src="/images/sample_bus.jpg" alt="104개 노선 단독 직영">
          <div class="afv-scrim"></div>
          <div class="afv-overlay-content">
            <div class="afv-badge-row">
              <span class="afv-pill blue">01 / FLEET DIRECT</span>
              <div class="afv-icon-badge"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="14" x="3" y="3" rx="2"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/><path d="M3 10h18"/><path d="M7 3v7"/><path d="M17 3v7"/></svg></div>
            </div>
            <h3 class="afv-title">광주 104개 전 노선 단독 직영 배차</h3>
            <p class="afv-desc">상무·수완·봉선·첨단 등 핵심 거점을 관통하는 맞춤형 최적 노선 단독 설계</p>
            <div class="afv-footer-stat">광주 5개 구 1,000대 시내버스 독점 운영</div>
          </div>
        </div>

        <div class="afv-card">
          <img src="/images/sub_bg_b.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="1일 18시간 노출">
          <div class="afv-scrim"></div>
          <div class="afv-overlay-content">
            <div class="afv-badge-row">
              <span class="afv-pill blue">02 / 18H EXPOSURE</span>
              <div class="afv-icon-badge"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/><path d="M22 12A10 10 0 0 0 12 2"/></svg></div>
            </div>
            <h3 class="afv-title">1일 18시간 · 일 150만 시민 눈높이 노출</h3>
            <p class="afv-desc">도심 주요 간선도로와 교차로를 쉼 없이 순환하며 운전자와 보행자 시선 정면 강제 노출</p>
            <div class="afv-footer-stat">차도면 3.7m + 인도면 3.0m + 후면 2.4m 3면 패키지</div>
          </div>
        </div>

        <div class="afv-card">
          <img src="/images/sub_bg_c.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="LG 정품 솔벤 시공">
          <div class="afv-scrim"></div>
          <div class="afv-overlay-content">
            <div class="afv-badge-row">
              <span class="afv-pill blue">03 / PREMIUM PRINT</span>
              <div class="afv-icon-badge"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg></div>
            </div>
            <h3 class="afv-title">LG 하우시스 정품 솔벤 &amp; 100% 직영 시공</h3>
            <p class="afv-desc">외주 없는 본사 10년 경력팀 직접 시공 및 시공 직후 번호판 4면 실사 즉시 보고</p>
            <div class="afv-footer-stat">시공 직후 차량 4면 번호판 실사 즉시 전송</div>
          </div>
        </div>

      </div>

      <!-- SECTION 01 : RECENT BUS PORTFOLIO SHOWCASE STRIP -->
      <div class="am-sub-port-strip wow fadeInUp" data-wow-duration="0.8s">
        <div class="asps-head">
          <div class="asps-title-wrap">
            <span class="asps-kicker">BUS PORTFOLIO</span>
            <h4 class="asps-title">최근 시내버스 광고 집행 실사 포트폴리오</h4>
          </div>
          <a href="/portfolio.php" class="asps-more-link">버스 광고 실사 전체보기 ↗</a>
        </div>
        <div class="asps-grid">
          <?php 
          $busItems = !empty($portBus) ? array_slice($portBus, 0, 4) : array_slice($list, 0, 4);
          foreach ($busItems as $bItem): 
          ?>
          <div class="asps-card main-port-card" data-cat="<?php echo htmlspecialchars($bItem['category']); ?>" data-id="<?php echo (int)$bItem['id']; ?>" data-name="<?php echo htmlspecialchars($bItem['title']); ?>">
            <div class="asps-thumb">
              <img src="<?php echo !empty($bItem['thumb']) ? htmlspecialchars($bItem['thumb']) : '/images/sample_bus.jpg'; ?>" alt="<?php echo htmlspecialchars($bItem['title']); ?>">
              <span class="asps-badge">시내버스</span>
              <div class="asps-hover-overlay">상세보기 ↗</div>
            </div>
            <div class="asps-info">
              <strong class="asps-item-title"><?php echo htmlspecialchars($bItem['title']); ?></strong>
              <span class="asps-item-loc">광주 104개 노선 단독 직영 시공</span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       03 SECTION 02 : 온라인 마케팅 (BIG FULL-IMAGE SCREEN CAPTURE SHOWCASE)
  ============================================ -->
  <section class="am-section" id="online">
    <div class="am-container">

      <div class="am-sec-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker">02 / DIGITAL MARKETING</span>
            <h2 class="ash-title">온라인 마케팅 솔루션</h2>
            <p class="ash-desc">시내버스 옥외광고로 형성된 브랜드 인지도를 실제 검색과 네이버 예약, 매장 방문 매출로 즉각 전환시키는 통합 디지털 솔루션입니다.</p>
          </div>
          <button type="button" class="ash-guide-btn bus-guide-open" data-guide="guideOnline">
            <span>온라인 채널 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- 4 BIG FULL-IMAGE CAPTURE VISUAL CARDS -->
      <div class="am-online-visual-grid-4 wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- CARD 01 : SMART PLACE & BLOG -->
        <div class="aov-card wide">
          <img src="/images/sub_bg_a.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="네이버 스마트플레이스 1위">
          <div class="aov-scrim"></div>
          <div class="aov-overlay">
            <span class="aov-pill blue">01 / NAVER SEARCH &amp; PLACE</span>
            <h3 class="aov-title">네이버 스마트플레이스 1위 세팅 &amp; C-Rank 브랜드 블로그</h3>
            <p class="aov-desc">광주 로컬 키워드 1페이지 지도 최상단 노출 + 24시간 네이버 예약 연동 + 의료법 준수 전문 칼럼 정기 발행</p>
            <div class="aov-metrics-row">
              <div class="amr-tag">상권 키워드 지도 상위 노출</div>
              <div class="amr-tag">월 8~12편 전문 칼럼</div>
              <div class="amr-tag">네이버 예약 연동</div>
            </div>
          </div>
        </div>

        <!-- CARD 02 : MOM CAFE -->
        <div class="aov-card">
          <img src="/images/sub_bg_b.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="맘카페 바이럴">
          <div class="aov-scrim"></div>
          <div class="aov-overlay">
            <span class="aov-pill green">02 / LOCAL COMMUNITY</span>
            <h3 class="aov-title">광주 대표 맘카페 &amp; 당근마켓 바이럴</h3>
            <p class="aov-desc">광주맘스홀릭 및 당근 동네생활 실사용자 기반 자연스러운 방문 후기 여론 형성</p>
            <div class="aov-metrics-row">
              <div class="amr-tag">3050 주부 신뢰 확보</div>
            </div>
          </div>
        </div>

        <!-- CARD 03 : INSTAGRAM REELS -->
        <div class="aov-card">
          <img src="/images/sub_bg_e.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="인스타그램 릴스">
          <div class="aov-scrim"></div>
          <div class="aov-overlay">
            <span class="aov-pill cyan">03 / SNS PERFORMANCE</span>
            <h3 class="aov-title">인스타그램 릴스 &amp; 반경 타깃 광고</h3>
            <p class="aov-desc">사업장 반경 1~3km 내 거주 고객 집중 타깃팅 + 9:16 모바일 숏폼 영상 제작</p>
            <div class="aov-metrics-row">
              <div class="amr-tag">반경 1~3km 정밀 노출</div>
            </div>
          </div>
        </div>

        <!-- CARD 04 : GOOGLE GDN -->
        <div class="aov-card wide">
          <img src="/images/sub_bg_c.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="구글 검색 & GDN">
          <div class="aov-scrim"></div>
          <div class="aov-overlay">
            <span class="aov-pill purple">04 / GOOGLE RETARGETING</span>
            <h3 class="aov-title">구글 검색광고 &amp; 유튜브 GDN 리타깃팅</h3>
            <p class="aov-desc">키워드 검색 고객과 제휴 언론사 배너 네트워크를 결합하여 이탈 고객을 24시간 재유입</p>
            <div class="aov-metrics-row">
              <div class="amr-tag">구글 검색 키워드</div>
              <div class="amr-tag">유튜브 배너 네트워크</div>
            </div>
          </div>
        </div>

      </div>

      <!-- 3-PILLAR TRUST STRIP -->
      <div class="am-online-guarantee-deck wow fadeInUp" data-wow-duration="0.8s">
        <div class="aog-card">
          <div class="aog-icon-box"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg></div>
          <div class="aog-body">
            <strong>의료법 및 광고 심의 준수</strong>
            <span>과장 광고 및 불법 표현을 원천 차단하여 보건소 행정처분 및 제재 리스크 0%</span>
          </div>
        </div>

        <div class="aog-card">
          <div class="aog-icon-box"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
          <div class="aog-body">
            <strong>주간 노출 순위 투명 보고</strong>
            <span>플레이스 노출 순위, 유입 키워드, 광고 클릭 현황을 매주 데이터 기반으로 보고</span>
          </div>
        </div>

        <div class="aog-card">
          <div class="aog-icon-box"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg></div>
          <div class="aog-body">
            <strong>인하우스 1:1 전담 디렉터 배정</strong>
            <span>외주 하청 없는 가온엔 본사 전문 디렉터가 광고 집행 전 과정을 전담 관리</span>
          </div>
        </div>
      </div>

      <!-- SECTION 02 : RECENT ONLINE MARKETING PORTFOLIO SHOWCASE STRIP -->
      <div class="am-sub-port-strip wow fadeInUp" data-wow-duration="0.8s">
        <div class="asps-head">
          <div class="asps-title-wrap">
            <span class="asps-kicker green">DIGITAL MARKETING PORTFOLIO</span>
            <h4 class="asps-title">온라인 마케팅 &amp; 스마트플레이스 1위 집행 실적</h4>
          </div>
          <a href="/portfolio.php" class="asps-more-link">온라인 사례 전체보기 ↗</a>
        </div>
        <div class="asps-grid">
          <?php 
          $onlineItems = !empty($portOnline) ? array_slice($portOnline, 0, 4) : array_slice($list, 0, 4);
          foreach ($onlineItems as $oItem): 
          ?>
          <div class="asps-card main-port-card" data-cat="<?php echo htmlspecialchars($oItem['category']); ?>" data-id="<?php echo (int)$oItem['id']; ?>" data-name="<?php echo htmlspecialchars($oItem['title']); ?>">
            <div class="asps-thumb">
              <img src="<?php echo !empty($oItem['thumb']) ? htmlspecialchars($oItem['thumb']) : '/images/sub_bg_a.jpg'; ?>" alt="<?php echo htmlspecialchars($oItem['title']); ?>">
              <span class="asps-badge green">온라인마케팅</span>
              <div class="asps-hover-overlay">상세보기 ↗</div>
            </div>
            <div class="asps-info">
              <strong class="asps-item-title"><?php echo htmlspecialchars($oItem['title']); ?></strong>
              <span class="asps-item-loc">플레이스 1위 &amp; 블로그 상위 노출</span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       04 SECTION 03 : 영상제작 (KEPT IN DARK NAVY THEME)
  ============================================ -->
  <section class="am-section am-bg-dark am-video-ambient-sec" id="video">
    <div class="avs-ambient-bg">
      <div class="avs-glow glow-left"></div>
      <div class="avs-glow glow-right"></div>
      <svg class="avs-watermark-svg" viewBox="0 0 1400 800" fill="none">
        <circle cx="200" cy="300" r="280" stroke="rgba(56,189,248,0.06)" stroke-width="1.5" />
        <circle cx="200" cy="300" r="180" stroke="rgba(56,189,248,0.04)" stroke-width="1" stroke-dasharray="6 6" />
        <circle cx="1200" cy="500" r="320" stroke="rgba(24,85,183,0.08)" stroke-width="1.5" />
        <path d="M-100,500 C400,200 900,700 1500,300" stroke="rgba(255,255,255,0.04)" stroke-width="1.5" />
      </svg>
    </div>

    <div class="am-container" style="position:relative; z-index:2;">

      <div class="am-sec-head dark-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker gold">03 / 4K CINEMATIC PRODUCTION</span>
            <h2 class="ash-title white">영상제작</h2>
            <p class="ash-desc light">기업·상급병원 브랜드 필름부터 TV CF, 9:16 모바일 숏폼, 옥외 DID 모션까지 인하우스 프로덕션이 14일 Fast-Track으로 제작합니다.</p>
          </div>
          <button type="button" class="ash-guide-btn dark bus-guide-open" data-guide="guideVideo">
            <span>영상제작 공정 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- DARK VIDEO CONSOLE -->
      <div class="am-video-console wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="avc-mode-bar">
          <button type="button" class="avc-btn on" data-video-mode="wide">16:9 와이드 시네마 모드</button>
          <button type="button" class="avc-btn" data-video-mode="shorts">9:16 SNS 릴스/숏폼 모드</button>
        </div>

        <div class="avc-grid">
          
          <div class="avc-player-frame" id="dynVideoFrame">
            <video autoplay muted loop playsinline class="avc-video" id="dynMainVideo">
              <source src="/images/movie.mp4" type="video/mp4">
            </video>
            <div class="avc-scrim"></div>
            
            <div class="avc-caption">
              <span class="avc-badge gold" id="dynVideoTag">16:9 4K BRAND FILM</span>
              <h3 id="dynVideoTitle">기업 · 상급병원 4K 시네마틱 브랜드 필름</h3>
              <p id="dynVideoSub">Sony FX Cinema 풀프레임 + 4K 드론 항공촬영 + 전문 성우 더빙</p>
            </div>
          </div>

          <!-- 4 DELIVERABLES -->
          <div class="avc-products-col">
            <div class="avp-card on" data-target-mode="wide"
                 data-vtitle="기업 · 상급병원 4K 시네마틱 브랜드 필름"
                 data-vsub="Sony FX Cinema 풀프레임 + 4K 드론 항공촬영 + 전문 성우 더빙">
              <span class="avp-watermark-num">01</span>
              <div class="avp-text-box">
                <strong class="avp-big-title">기업 · 상급병원 브랜드 필름 (3~5분)</strong>
                <p>Sony FX Cinema 풀프레임 카메라와 국토부 승인 4K 항공 드론으로 완성하는 최고급 영화급 홍보영상</p>
              </div>
            </div>

            <div class="avp-card" data-target-mode="wide"
                 data-vtitle="TV CF & 극장 스크린 광고 (15초 / 30초)"
                 data-vsub="15초/30초 고임팩트 스토리텔링 + 2D/3D 모션그래픽">
              <span class="avp-watermark-num">02</span>
              <div class="avp-text-box">
                <strong class="avp-big-title">TV CF · 극장 광고 (15초 / 30초)</strong>
                <p>지상파/케이블 TV 및 CGV/메가박스 스크린에 송출되는 15초/30초 초압축 임팩트 스토리텔링</p>
              </div>
            </div>

            <div class="avp-card" data-target-mode="shorts"
                 data-vtitle="SNS 모바일 숏폼 바이럴 (9:16 세로형)"
                 data-vsub="인스타그램 릴스 + 유튜브 쇼츠 + 틱톡 최적화 바이럴">
              <span class="avp-watermark-num">03</span>
              <div class="avp-text-box">
                <strong class="avp-big-title">SNS 릴스 · 틱톡 숏폼 (9:16 세로형)</strong>
                <p>첫 3초 만에 시선을 사로잡는 빠른 컷 전환과 자막 모션그래픽으로 수만~수십만 뷰의 유기적 알고리즘 도달</p>
              </div>
            </div>

            <div class="avp-card" data-target-mode="wide"
                 data-vtitle="DID 디지털 전광판 모션그래픽 (15초 풀HD)"
                 data-vsub="옥외 고휘도 스크린 전용 15초 풀HD 고시인성 모션">
              <span class="avp-watermark-num">04</span>
              <div class="avp-text-box">
                <strong class="avp-big-title">DID 전광판 모션그래픽 (15초 풀HD)</strong>
                <p>유스퀘어 터미널, 지하철역, 관공서 로비 등의 고휘도 LED 전광판 환경에서 1초 만에 읽히는 고시인성 모션</p>
              </div>
            </div>
          </div>

        </div>

        <!-- 14-DAY WORKFLOW -->
        <div class="am-video-big-workflow">
          <div class="avbw-card">
            <div class="avbw-top">
              <div class="avbw-picto-box"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg></div>
              <span class="avbw-day">D+3</span>
            </div>
            <span class="avbw-step">STEP 01</span>
            <strong>콘티 기획</strong>
            <p>1:1 맞춤형 스토리보드 및 연출 콘티 확정</p>
          </div>

          <div class="avbw-card">
            <div class="avbw-top">
              <div class="avbw-picto-box"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/><circle cx="8.5" cy="12" r="2.5"/></svg></div>
              <span class="avbw-day">D+7</span>
            </div>
            <span class="avbw-step">STEP 02</span>
            <strong>4K 본촬영</strong>
            <p>Sony FX 풀프레임 시네마 + 4K 드론 항공촬영</p>
          </div>

          <div class="avbw-card">
            <div class="avbw-top">
              <div class="avbw-picto-box"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/><line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="13" x2="9" y2="15"/><line x1="15" y1="12" x2="15" y2="16"/></svg></div>
              <span class="avbw-day">D+10</span>
            </div>
            <span class="avbw-step">STEP 03</span>
            <strong>편집 &amp; 더빙</strong>
            <p>전문 성우 내레이션 녹음, BGM 믹싱, 색보정</p>
          </div>

          <div class="avbw-card highlight">
            <div class="avbw-top">
              <div class="avbw-picto-box gold"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg></div>
              <span class="avbw-day gold">D+14</span>
            </div>
            <span class="avbw-step">STEP 04</span>
            <strong>최종 납품</strong>
            <p>14일 내 멀티 포맷(16:9 / 9:16) 완성본 납품</p>
          </div>
        </div>

      </div>

      <!-- SECTION 03 : RECENT 4K VIDEO PORTFOLIO SHOWCASE STRIP -->
      <div class="am-sub-port-strip dark wow fadeInUp" data-wow-duration="0.8s">
        <div class="asps-head">
          <div class="asps-title-wrap">
            <span class="asps-kicker gold">CINEMA REEL PORTFOLIO</span>
            <h4 class="asps-title white">최근 4K 브랜드 필름 &amp; 숏폼 영상 제작 실적</h4>
          </div>
          <a href="/portfolio.php" class="asps-more-link gold">영상 포트폴리오 전체보기 ↗</a>
        </div>
        <div class="asps-grid">
          <?php 
          $videoItems = !empty($portVideo) ? array_slice($portVideo, 0, 4) : array_slice($list, 0, 4);
          foreach ($videoItems as $vItem): 
          ?>
          <div class="asps-card dark main-port-card" data-cat="<?php echo htmlspecialchars($vItem['category']); ?>" data-id="<?php echo (int)$vItem['id']; ?>" data-name="<?php echo htmlspecialchars($vItem['title']); ?>">
            <div class="asps-thumb">
              <img src="<?php echo !empty($vItem['thumb']) ? htmlspecialchars($vItem['thumb']) : '/images/sub_bg_d.jpg'; ?>" alt="<?php echo htmlspecialchars($vItem['title']); ?>">
              <span class="asps-badge gold">영상제작</span>
              <div class="asps-hover-overlay dark">영상 재생 &amp; 상세보기 ↗</div>
            </div>
            <div class="asps-info">
              <strong class="asps-item-title white"><?php echo htmlspecialchars($vItem['title']); ?></strong>
              <span class="asps-item-loc light">4K UHD 시네마틱 &amp; 숏폼 제작</span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       05 SECTION 04 : 특화 옥외매체 (BIG FULL-IMAGE ACCORDION)
  ============================================ -->
  <section class="am-section" id="other">
    <div class="am-container">

      <div class="am-sec-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker">04 / SPECIALIZED OOH MEDIA</span>
            <h2 class="ash-title">특화 옥외매체</h2>
            <p class="ash-desc">각 매체 카드를 클릭하시면 상세한 실측 규격, 운영 시간, 최적의 타깃 분석을 확인하실 수 있습니다.</p>
          </div>
          <button type="button" class="ash-guide-btn bus-guide-open" data-guide="guideTaxiDelivery">
            <span>특화 매체 실측표 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- DYNAMIC ACCORDION WITH CLEAN ELLIPSIS -->
      <div class="am-ooh-accordion wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="aoa-card on">
          <img src="/images/sub_bg_b.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="택시 래핑 광고">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">01 / URBAN MOBILITY</span>
            <h3 class="aoa-title-ellipsis">법인 · 개인택시 양측면 래핑</h3>
            <p class="aoa-desc-ellipsis">광주 전역 200여 대 차량이 주요 번화가와 골목길을 24시간 365일 상시 운행하며, 보행자 눈높이에서 밀착 노출되어 높은 주목도를 발휘합니다.</p>
            <div class="doa-spec">실측 규격: 2,100 × 320 mm | 24시간 365일 연속 운행</div>
          </div>
        </div>

        <div class="aoa-card">
          <img src="/images/sub_bg_c.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="택배차량 래핑 광고">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">02 / LOGISTICS BILLBOARD</span>
            <h3 class="aoa-title-ellipsis">택배 탑차 3면 와이드 래핑</h3>
            <p class="aoa-desc-ellipsis">광주 5개 구 대규모 아파트 단지와 주택가 골목길에 매일 10시간 이상 머무는 움직이는 초대형 랜드마크 빌보드로 주민 일상에 자연스럽게 각인됩니다.</p>
            <div class="doa-spec">실측 규격: 양면 3,000×1,500 + 후면 | 1일 10시간 체류</div>
          </div>
        </div>

        <div class="aoa-card">
          <img src="/images/sub_bg_d.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="대형마트 쇼핑카트">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">03 / RETAIL PURCHASE POINT</span>
            <h3 class="aoa-title-ellipsis">대형마트 쇼핑카트 &amp; 무빙워크</h3>
            <p class="aoa-desc-ellipsis">이마트, 롯데마트 1,000여 대 카트 손잡이 정면에 위치하여 실질적 구매권을 가진 3050 주부 및 가족 고객과 60분간 1:1로 동행합니다.</p>
            <div class="doa-spec">실측 규격: 280 × 160 mm | 쇼핑 1회당 60분 연속 주시</div>
          </div>
        </div>

        <div class="aoa-card">
          <img src="/images/sub_bg_e.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="DID 디지털 전광판">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">04 / DIGITAL SMART SIGNAGE</span>
            <h3 class="aoa-title-ellipsis">DID 디지털 전광판 &amp; 전자현수막</h3>
            <p class="aoa-desc-ellipsis">유스퀘어 터미널, 지하철 환승역, 관공서 로비에 고휘도 55~85" UHD 스크린으로 15초 영상을 하루 100회 이상 연속 송출합니다.</p>
            <div class="doa-spec">실측 규격: 55~85" UHD 패널 | 일 100회 이상 송출</div>
          </div>
        </div>

      </div>

      <!-- SECTION 04 : RECENT SPECIALIZED OOH PORTFOLIO SHOWCASE STRIP -->
      <div class="am-sub-port-strip wow fadeInUp" data-wow-duration="0.8s">
        <div class="asps-head">
          <div class="asps-title-wrap">
            <span class="asps-kicker purple">SPECIALIZED OOH PORTFOLIO</span>
            <h4 class="asps-title">택시 · 택배 · 마트 · DID 특화 매체 집행 실적</h4>
          </div>
          <a href="/portfolio.php" class="asps-more-link purple">특화 매체 사례 전체보기 ↗</a>
        </div>
        <div class="asps-grid">
          <?php 
          $otherItems = !empty($portOther) ? array_slice($portOther, 0, 4) : array_slice($list, 0, 4);
          foreach ($otherItems as $otItem): 
          ?>
          <div class="asps-card main-port-card" data-cat="<?php echo htmlspecialchars($otItem['category']); ?>" data-id="<?php echo (int)$otItem['id']; ?>" data-name="<?php echo htmlspecialchars($otItem['title']); ?>">
            <div class="asps-thumb">
              <img src="<?php echo !empty($otItem['thumb']) ? htmlspecialchars($otItem['thumb']) : '/images/sub_bg_b.jpg'; ?>" alt="<?php echo htmlspecialchars($otItem['title']); ?>">
              <span class="asps-badge purple"><?php echo isset($categories[$otItem['category']]) ? $categories[$otItem['category']] : '특화매체'; ?></span>
              <div class="asps-hover-overlay">상세보기 ↗</div>
            </div>
            <div class="asps-info">
              <strong class="asps-item-title"><?php echo htmlspecialchars($otItem['title']); ?></strong>
              <span class="asps-item-loc">도심 밀착 타깃 옥외매체 시공</span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       06 SECTION 05 : 성공 사례
  ============================================ -->
  <section class="am-section am-bg-slate" id="archive">
    <div class="am-container">

      <div class="am-sec-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker">PORTFOLIO ARCHIVE</span>
            <h2 class="ash-title">전체 성공 사례 아카이브</h2>
            <p class="ash-desc">카테고리 탭을 클릭하여 고화질 실사 사례를 확인하고, 즉시 1:1 맞춤 견적을 문의하세요.</p>
          </div>
          <div class="am-filter-chips">
            <button type="button" class="afc-btn on" data-filter="all">전체보기</button>
            <button type="button" class="afc-btn" data-filter="bus">시내버스</button>
            <button type="button" class="afc-btn" data-filter="online">온라인 마케팅</button>
            <button type="button" class="afc-btn" data-filter="video">영상제작</button>
            <button type="button" class="afc-btn" data-filter="taxi">택시·택배</button>
            <button type="button" class="afc-btn" data-filter="mart">마트·DID</button>
          </div>
        </div>
      </div>

      <!-- MASTER GRID -->
      <div class="am-port-grid wow fadeInUp" data-wow-duration="0.8s" id="masterPortGrid">
        <?php foreach (array_slice($list, 0, 8) as $item): ?>
        <div class="apg-card main-port-card" data-cat="<?php echo htmlspecialchars($item['category']); ?>" data-id="<?php echo (int)$item['id']; ?>" data-name="<?php echo htmlspecialchars($item['title']); ?>">
          <div class="apg-thumb">
            <?php if (!empty($item['thumb'])): ?>
            <img src="<?php echo htmlspecialchars($item['thumb']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
            <?php else: ?>
            <div class="apg-empty">이미지 준비 중</div>
            <?php endif; ?>
            <div class="apg-scrim"></div>
            <span class="apg-tag"><?php echo isset($categories[$item['category']]) ? $categories[$item['category']] : '광고사례'; ?></span>
            <div class="apg-hover-btn">상세보기 &amp; 견적조회 ↗</div>
          </div>
          <div class="apg-info">
            <span class="apg-cat"><?php echo isset($categories[$item['category']]) ? $categories[$item['category']] : '광고집행'; ?></span>
            <strong class="apg-title"><?php echo htmlspecialchars($item['title']); ?></strong>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="am-more-box">
        <a href="/portfolio.php" class="am-more-btn">
          <span>포트폴리오 전체 100+ 사례 더보기</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>

    </div>
  </section>


  <!-- ============================================
       07 SECTION 06 : 마스터플랜
  ============================================ -->
  <section class="am-section" id="process">
    <div class="am-container">
      <div class="am-sec-head text-center wow fadeInUp" data-wow-duration="0.7s">
        <span class="ash-kicker">WORKFLOW PIPELINE</span>
        <h2 class="ash-title">마스터플랜</h2>
        <p class="ash-desc" style="margin:0 auto;">외주 없는 100% 본사 인하우스 전문팀이 기획부터 시공, 보고까지 완벽히 책임지는 4단계 마스터플랜입니다.</p>
      </div>

      <div class="am-pipeline-grid wow fadeInUp" data-wow-duration="0.8s">
        <div class="apg-step-card">
          <div class="apg-step-header">
            <span class="apg-huge-gothic-num">01</span>
            <span class="apg-day-pill">D+1 DAY</span>
          </div>
          <div class="apg-icon-circle"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg></div>
          <h3 class="apg-step-title">상권 분석 &amp; 노선 믹스</h3>
          <p class="apg-step-sub">타깃 상권 빅데이터 분석 및 온·오프라인 최적 미디어 믹스 설계</p>
          <div class="apg-deliverable-box">
            <span>핵심 산출물:</span>
            <strong>상권 분석 보고서 &amp; 최적 노선 믹스</strong>
          </div>
        </div>

        <div class="apg-step-card">
          <div class="apg-step-header">
            <span class="apg-huge-gothic-num">02</span>
            <span class="apg-day-pill">D+3 DAY</span>
          </div>
          <div class="apg-icon-circle"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.92 0 1.67-.75 1.67-1.67 0-.42-.17-.83-.42-1.17-.25-.33-.42-.75-.42-1.16 0-.92.75-1.67 1.67-1.67h1.92c3.08 0 5.58-2.5 5.58-5.58 0-4.83-4.42-8.75-9.42-8.75z"/><circle cx="7.5" cy="11.5" r="1.5"/><circle cx="12" cy="7.5" r="1.5"/><circle cx="16.5" cy="11.5" r="1.5"/></svg></div>
          <h3 class="apg-step-title">1:1 디자인 시안 기획</h3>
          <p class="apg-step-sub">도심 속에서 3초 안에 읽히는 실사 래핑 및 영상 스토리보드 제작</p>
          <div class="apg-deliverable-box">
            <span>핵심 산출물:</span>
            <strong>3면 실측 1:1 맞춤 디자인 시안 3종</strong>
          </div>
        </div>

        <div class="apg-step-card">
          <div class="apg-step-header">
            <span class="apg-huge-gothic-num">03</span>
            <span class="apg-day-pill">D+7 DAY</span>
          </div>
          <div class="apg-icon-circle"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg></div>
          <h3 class="apg-step-title">직영 출력 &amp; 책임 시공</h3>
          <p class="apg-step-sub">LG 하우시스 정품 솔벤 시트 자체 출력과 본사 10년 경력팀 직접 시공</p>
          <div class="apg-deliverable-box">
            <span>핵심 산출물:</span>
            <strong>LG 하우시스 최고급 내후성 시공</strong>
          </div>
        </div>

        <div class="apg-step-card highlight">
          <div class="apg-step-header">
            <span class="apg-huge-gothic-num blue">04</span>
            <span class="apg-day-pill gold">D+14 DAY</span>
          </div>
          <div class="apg-icon-circle blue"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0f3f8c" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="m9 15 2 2 4-4"/></svg></div>
          <h3 class="apg-step-title">실시간 증빙 &amp; 리포트</h3>
          <p class="apg-step-sub">시공 직후 차량 4면 번호판 실사 촬영본 전송 및 주간 순위 투명 보고</p>
          <div class="apg-deliverable-box blue">
            <span>핵심 산출물:</span>
            <strong>차량 4면 실사 증빙철 &amp; 주간 리포트</strong>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================
       08 PARTNERS MARQUEE
  ============================================ -->
  <section class="am-partners-sec">
    <div class="am-container">
      <div class="apt-title">TRUSTED BY INDUSTRY LEADERS</div>
    </div>
    <div class="apt-marquee-box">
      <div class="apt-track track-left">
        <span class="apt-chip">전남대학교병원</span><span class="apt-chip">조선대학교병원</span><span class="apt-chip">광주안과</span><span class="apt-chip">센트럴치과병원</span><span class="apt-chip">이루다어학원</span><span class="apt-chip">중흥건설</span><span class="apt-chip">광주도시공사</span><span class="apt-chip">그린모빌리티</span>
        <span class="apt-chip">전남대학교병원</span><span class="apt-chip">조선대학교병원</span><span class="apt-chip">광주안과</span><span class="apt-chip">센트럴치과병원</span><span class="apt-chip">이루다어학원</span><span class="apt-chip">중흥건설</span><span class="apt-chip">광주도시공사</span><span class="apt-chip">그린모빌리티</span>
      </div>
      <div class="apt-track track-right">
        <span class="apt-chip">원광대한방병원</span><span class="apt-chip">바른정형외과</span><span class="apt-chip">법무법인 광산</span><span class="apt-chip">드림공인중개사</span><span class="apt-chip">홀리데이호텔</span><span class="apt-chip">라붐웨딩홀</span><span class="apt-chip">베비에르</span><span class="apt-chip">봉선어학센터</span>
        <span class="apt-chip">원광대한방병원</span><span class="apt-chip">바른정형외과</span><span class="apt-chip">법무법인 광산</span><span class="apt-chip">드림공인중개사</span><span class="apt-chip">홀리데이호텔</span><span class="apt-chip">라붐웨딩홀</span><span class="apt-chip">베비에르</span><span class="apt-chip">봉선어학센터</span>
      </div>
    </div>
  </section>


  <!-- ============================================
       09 AUTHENTIC AGENCY 1:1 CONSULTATION & QUOTE FORM
  ============================================ -->
  <section class="am-consultation-studio-sec" id="consultation">
    <div class="am-container">
      <div class="acs-card-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- LEFT: REAL AGENCY CONTACT & COMPANY INFO -->
        <div class="acs-info-col">
          <span class="acs-kicker">CONTACT &amp; ESTIMATE</span>
          <h2 class="acs-title">
            광고 집행 문의 &amp;<br>
            <span class="acs-highlight">1:1 맞춤 견적 상담</span>
          </h2>
          <p class="acs-desc">
            업종과 상권에 최적화된 시내버스 노선 매칭부터 온라인 검색 마케팅, 영상제작까지 가온엔 전문 디렉터가 신속하고 정확하게 안내해 드립니다.
          </p>

          <div class="acs-direct-box">
            <div class="adb-row">
              <span class="adb-label">대표 전화</span>
              <strong class="adb-val">062-375-1215</strong>
            </div>
            <div class="adb-row">
              <span class="adb-label">팩스 번호</span>
              <span class="adb-text">062-375-1216</span>
            </div>
            <div class="adb-row">
              <span class="adb-label">공식 이메일</span>
              <span class="adb-text">gaon_ad@naver.com</span>
            </div>
            <div class="adb-row">
              <span class="adb-label">본사 주소</span>
              <span class="adb-text">광주광역시 서구 상무중앙로 78, 5층 (치평동)</span>
            </div>
            <div class="adb-row">
              <span class="adb-label">상담 시간</span>
              <span class="adb-text">평일 09:00 ~ 18:00 (온라인 문의 상시 접수)</span>
            </div>
          </div>
        </div>

        <!-- RIGHT: PRACTICAL CORPORATE ESTIMATE FORM -->
        <div class="acs-form-col">
          <form name="frm" method="post" action="/board/estmate/write_ok.php" class="acs-form-box">
            <h3 class="afb-title">광고 문의 및 견적 요청서</h3>
            
            <div class="afb-fields-grid">
              <div class="afb-field">
                <label for="in_company" class="afb-lbl">회사명 / 상호 <span class="req">*</span></label>
                <input type="text" id="in_company" name="in_company" placeholder="예: (주)가온메디컬" class="afb-input">
              </div>

              <div class="afb-field">
                <label for="in_name" class="afb-lbl">담당자 성함 <span class="req">*</span></label>
                <input type="text" id="in_name" name="in_name" placeholder="예: 홍길동 팀장" class="afb-input">
              </div>

              <div class="afb-field">
                <label for="in_tel" class="afb-lbl">연락처 <span class="req">*</span></label>
                <input type="text" id="in_tel" name="in_tel" placeholder="예: 010-1234-5678" class="afb-input">
              </div>

              <div class="afb-field">
                <label for="in_email" class="afb-lbl">이메일 주소 <span class="req">*</span></label>
                <input type="email" id="in_email" name="in_email" placeholder="예: contact@domain.com" class="afb-input">
              </div>
            </div>

            <!-- AD TYPES CHECKBOXES -->
            <div class="afb-checks-group">
              <label class="afb-lbl">관심 광고 매체 (중복 선택 가능) <span class="req">*</span></label>
              <div class="afb-checks-row">
                <label class="afb-check-item">
                  <input type="checkbox" name="in_ad_type[]" value="시내버스 광고" checked>
                  <span class="aci-btn">시내버스 광고</span>
                </label>
                <label class="afb-check-item">
                  <input type="checkbox" name="in_ad_type[]" value="온라인 마케팅">
                  <span class="aci-btn">온라인 마케팅</span>
                </label>
                <label class="afb-check-item">
                  <input type="checkbox" name="in_ad_type[]" value="4K 영상제작">
                  <span class="aci-btn">4K 영상제작</span>
                </label>
                <label class="afb-check-item">
                  <input type="checkbox" name="in_ad_type[]" value="택시·택배">
                  <span class="aci-btn">택시·택배</span>
                </label>
                <label class="afb-check-item">
                  <input type="checkbox" name="in_ad_type[]" value="마트·DID">
                  <span class="aci-btn">마트·DID</span>
                </label>
              </div>
            </div>

            <!-- INQUIRY CONTENT TEXTAREA -->
            <div class="afb-textarea-group">
              <label for="in_content" class="afb-lbl">문의 내용 / 희망 지역 / 예산 (선택)</label>
              <textarea id="in_content" name="in_content" rows="3" placeholder="희망하시는 집행 시기, 주요 타깃 지역(예: 상무지구, 수완지구 등), 예산 또는 문의사항을 남겨주시면 더욱 정확한 제안서를 준비해 드립니다." class="afb-textarea"></textarea>
            </div>

            <!-- PRIVACY AGREEMENT & SUBMIT BUTTON -->
            <div class="afb-bottom-row">
              <label class="afb-agree-item">
                <input type="checkbox" id="agree" name="agree" checked>
                <span>개인정보 수집 및 이용에 동의합니다.</span>
              </label>

              <button type="button" id="btn_submit" class="afb-submit-btn">
                <span>견적 및 상담 신청하기</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </section>


  <!-- ============================================
       10 LUXURY DIRECTORY: 104 BUS ROUTES SEARCH MODAL
  ============================================ -->
  <div class="route-search-modal-overlay" id="routeSearchModal">
    <div class="rsm-panel">
      <div class="rsm-head">
        <div>
          <span class="rsm-kicker">GAON-N BUS ROUTE DIRECTORY 2026</span>
          <h3 class="rsm-title">광주 시내버스 104개 전 노선 실시간 검색 디렉토리</h3>
          <p class="rsm-desc">광주광역시 104개 전체 노선(급행/간선/지선)의 주요 경유 상권, 운행 대수, 배차 간격 및 타깃을 실시간으로 확인하세요.</p>
        </div>
        <button type="button" class="rsm-close" id="btnCloseRouteSearch">✕</button>
      </div>

      <div class="rsm-body">
        <div class="rsm-search-bar">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <input type="text" id="modalBusRouteSearchInput" placeholder="노선 번호 또는 경유 상권 검색 (예: 순환01, 상무지구, 봉선동, 첨단, 수완, 전남대)">
        </div>

        <div class="rsm-tabs-row">
          <button type="button" class="rsm-tab on" data-filter-cat="all">전체 104개 노선</button>
          <button type="button" class="rsm-tab" data-filter-cat="express">급행 노선 (6)</button>
          <button type="button" class="rsm-tab" data-filter-cat="main">간선 노선 (24)</button>
          <button type="button" class="rsm-tab" data-filter-cat="feeder">지선 노선 (74)</button>
          <button type="button" class="rsm-tab" data-filter-cat="seo">서구 (상무·광천)</button>
          <button type="button" class="rsm-tab" data-filter-cat="nam">남구 (봉선·풍암)</button>
          <button type="button" class="rsm-tab" data-filter-cat="buk">북구 (용봉·일곡)</button>
          <button type="button" class="rsm-tab" data-filter-cat="gwangsan">광산구 (수완·첨단)</button>
        </div>

        <div class="rsm-directory-list" id="modalBusRouteFullGrid">
          <!-- Injected dynamically with rich directory styling -->
        </div>
      </div>

      <div class="rsm-foot">
        <div class="rf-notice">
          <strong>※ 병원 / 학원 / 매장 앞 통과 노선 무료 매칭 서비스</strong>
          <span>광고주님의 사업장 위치를 알려주시면 가장 노출 빈도가 높은 골든 노선 조합을 1:1 무료 컨설팅해 드립니다.</span>
        </div>
        <a href="#consultation" class="rsm-foot-btn" onclick="closeRouteModal();">1:1 노선 무료 분석 신청 →</a>
      </div>
    </div>
  </div>


  <!-- ============================================
       11 HIGH-END 3-COLUMN MASTER SPECIFICATION MODAL
  ============================================ -->
  <div class="bus-guide-overlay" id="busGuideOverlay">
    <div class="lux-modal-panel">
      
      <div class="lux-modal-head">
        <div>
          <span class="lmh-label">GAON-N OFFICIAL SPECIFICATION MASTER DECK</span>
          <h3 class="lmh-title">가온엔 통합 미디어 공식 규격 &amp; 마케팅 가이드</h3>
          <p class="lmh-desc">광주 104개 시내버스 7대 규격부터 온라인 6대 채널, 4K 영상 프로덕션, 특화 옥외매체 공식 실측표입니다.</p>
        </div>
        <button type="button" class="lux-modal-close" id="btnCloseBusGuide">✕</button>
      </div>

      <div class="lux-modal-tabs">
        <button type="button" class="lmt-tab on" data-target="guideBus">🚌 시내버스 광고</button>
        <button type="button" class="lmt-tab" data-target="guideOnline">📱 온라인 통합 마케팅</button>
        <button type="button" class="lmt-tab" data-target="guideVideo">🎬 4K 영상제작</button>
        <button type="button" class="lmt-tab" data-target="guideTaxiDelivery">🚕 택시 · 택배차량</button>
        <button type="button" class="lmt-tab" data-target="guideMartDid">🏢 대형마트 · DID</button>
      </div>

      <div class="lux-modal-body">
        
        <!-- 01 BUS GUIDE -->
        <div class="bus-guide-page on" id="guideBus">
          <div class="lmg-page-header">
            <h4 class="lmg-sec-title">시내버스 외부 광고 4대 부착면 및 내부 매체 공식 실측 규격</h4>
            <span class="lmg-sec-sub">LG 하우시스 정품 솔벤 시트 100% 본사 직영 시공 (차량 번호판 포함 4면 실사 즉시 보고)</span>
          </div>

          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">차도면 대형</span>
                <strong class="lhc-size">3,700 × 1,000 mm</strong>
                <span class="lhc-aspect">DRIVER SIDE WIDE</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">차도면 대형 래핑 광고</h5>
                <p class="lhc-desc">왕복 6~8차선 반대편 차량 운전자와 인도 보행자의 시야 정면에 노출되는 가장 거대한 랜드마크 규격입니다.</p>
                <div class="lhc-spec-list">
                  <div class="lsl-item"><span class="lsl-k">핵심 타깃</span><strong class="lsl-v">도심 간선도로 운전자 &amp; 반대편 보행자</strong></div>
                  <div class="lsl-item"><span class="lsl-k">원단 소재</span><strong class="lsl-v">LG 하우시스 최고급 내후성 정품 솔벤 시트</strong></div>
                </div>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">인도면 표준</span>
                <strong class="lhc-size">3,000 × 500 mm</strong>
                <span class="lhc-aspect">CURB SIDE STANDARD</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">인도면 표준 래핑 광고</h5>
                <p class="lhc-desc">버스 정류장 대기 승객 및 인도 보행자의 눈높이와 1:1로 밀착되어 상세 진료 과목과 전화번호 전달에 최적입니다.</p>
                <div class="lhc-spec-list">
                  <div class="lsl-item"><span class="lsl-k">핵심 타깃</span><strong class="lsl-v">정류소 탑승 대기 승객 &amp; 인도 보행자</strong></div>
                  <div class="lsl-item"><span class="lsl-k">원단 소재</span><strong class="lsl-v">LG 하우시스 최고급 내후성 정품 솔벤 시트</strong></div>
                </div>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">후면 보조</span>
                <strong class="lhc-size">2,400 × 300 mm</strong>
                <span class="lhc-aspect">REAR LICENSE TOP</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">후면 번호판 상단 래핑 광고</h5>
                <p class="lhc-desc">교차로 신호 대기 및 출퇴근 도로 정체 시 후방 차량 운전자에게 3분 이상 강제 주시되는 필수 패키지 면입니다.</p>
                <div class="lhc-spec-list">
                  <div class="lsl-item"><span class="lsl-k">핵심 타깃</span><strong class="lsl-v">신호 대기 후방 정체 차량 운전자 전원</strong></div>
                  <div class="lsl-item"><span class="lsl-k">원단 소재</span><strong class="lsl-v">LG 하우시스 정품 솔벤 반사 시트 지원</strong></div>
                </div>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">사랑면</span>
                <strong class="lhc-size">1,000 × 500 mm</strong>
                <span class="lhc-aspect">DOOR SIDE IMPACT</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">사랑면 승하차문 보조 광고</h5>
                <p class="lhc-desc">승객이 승하차할 때 100% 마주치는 하차문 측면에 위치하여 접근하는 보행자에게 즉각적인 시선을 유도합니다.</p>
                <div class="lhc-spec-list">
                  <div class="lsl-item"><span class="lsl-k">핵심 타깃</span><strong class="lsl-v">승하차 승객 및 버스 접근 보행자</strong></div>
                  <div class="lsl-item"><span class="lsl-k">원단 소재</span><strong class="lsl-v">고접착 실사 솔벤 시트 (방수/내후성)</strong></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 02 ONLINE GUIDE -->
        <div class="bus-guide-page" id="guideOnline">
          <div class="lmg-page-header">
            <h4 class="lmg-sec-title">가온엔 통합 온라인 마케팅 6대 채널 세부 실행 가이드</h4>
            <span class="lmg-sec-sub">의료법 100% 사전 법무 검수 통과 + 주간 순위 리포트 투명 제공</span>
          </div>

          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">01 플레이스</span>
                <strong class="lhc-size">지도 1위 세팅</strong>
                <span class="lhc-aspect">LOCAL SEARCH SEO</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">네이버 스마트플레이스 1위 세팅 &amp; SEO</h5>
                <p class="lhc-desc">로컬 1위 SEO 알고리즘 8대 평가 요소 세팅, 영수증 리뷰 빌드업, 24시간 네이버 예약/톡톡 연동으로 유입 콜 수를 극대화합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">02 C-Rank 블로그</span>
                <strong class="lhc-size">월 8~12편 칼럼</strong>
                <span class="lhc-aspect">MEDICAL LAW PASS</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">C-Rank 브랜드 블로그 파워콘텐츠</h5>
                <p class="lhc-desc">의료법 제56조 100% 사전 법무 검수로 행정처분 위험 0%. 원장님 진료 철학 기반 월 8~12편 전문 칼럼으로 스마트블록과 뷰탭을 점유합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge green">03 맘카페 바이럴</span>
                <strong class="lhc-size">광주 맘스홀릭</strong>
                <span class="lhc-aspect">COMMUNITY BUZZ</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">광주 대표 맘카페 &amp; 동네생활 바이럴</h5>
                <p class="lhc-desc">광주맘스홀릭, 맘수다방 및 당근마켓 동네생활 실유저 침투로 자연스러운 내방 후기와 3050 주부 신뢰 여론을 100% 형성합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">04 SNS 릴스</span>
                <strong class="lhc-size">반경 1~3km</strong>
                <span class="lhc-aspect">GEO-TARGET SPONSORED</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">인스타그램 릴스 &amp; 초정밀 반경 스폰서드</h5>
                <p class="lhc-desc">병원/매장 반경 1~3km 내 실제 거주 세대원만을 정밀 타깃팅하여 9:16 세로형 숏폼 영상 광고로 문의 전화를 즉각 폭발시킵니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge purple">05 구글 GDN</span>
                <strong class="lhc-size">검색 &amp; 배너</strong>
                <span class="lhc-aspect">GOOGLE RETARGETING</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">구글 검색광고 &amp; 유튜브 GDN 리타깃팅</h5>
                <p class="lhc-desc">구글 검색 키워드 타깃팅과 유튜브/언론사 제휴 배너 네트워크(GDN)를 통해 관심 고객에게 지속적인 리타깃팅을 집행합니다.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 03 VIDEO GUIDE -->
        <div class="bus-guide-page" id="guideVideo">
          <div class="lmg-page-header">
            <h4 class="lmg-sec-title">4K 시네마틱 영상제작 &amp; SNS 숏폼 14일 Fast-Track 공정 가이드</h4>
            <span class="lmg-sec-sub">Sony FX Cinema 풀프레임 + 4K 드론 항공촬영 + 전문 성우 녹음</span>
          </div>

          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">브랜드 필름</span>
                <strong class="lhc-size">4K UHD 풀프레임</strong>
                <span class="lhc-aspect">CINEMA PRODUCTION</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">기업 · 상급병원 4K 시네마틱 브랜드 필름</h5>
                <p class="lhc-desc">Sony FX 풀프레임 카메라와 국토부 승인 4K 항공 드론으로 완성하는 최고급 영화급 홍보영상으로 홈페이지 메인 및 TV CF에 최적화됩니다.</p>
              </div>
            </div>
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">모바일 숏폼</span>
                <strong class="lhc-size">9:16 FHD 세로형</strong>
                <span class="lhc-aspect">VIRAL SHORTS</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">SNS 릴스 · 유튜브 쇼츠 · 틱톡 숏폼</h5>
                <p class="lhc-desc">첫 3초 만에 시선을 사로잡는 빠른 컷 전환과 자막 모션그래픽으로 수만~수십만 뷰의 유기적 알고리즘 도달을 달성합니다.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 04 TAXI & DELIVERY GUIDE -->
        <div class="bus-guide-page" id="guideTaxiDelivery">
          <div class="lmg-page-header">
            <h4 class="lmg-sec-title">택시 &amp; 택배차량 래핑 공식 실측 가이드</h4>
            <span class="lmg-sec-sub">광주 전역 200대 택시 24시간 운행 &amp; 택배 탑차 3면 와이드 빌보드</span>
          </div>

          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">택시 래핑</span>
                <strong class="lhc-size">2,100 × 320 mm</strong>
                <span class="lhc-aspect">24H URBAN RUN</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">법인 · 개인택시 양측면 래핑 광고</h5>
                <p class="lhc-desc">광주 전역 200여 대 차량이 주요 번화가와 골목길까지 24시간 365일 연속 운행하며 보행자 눈높이에서 밀착 노출됩니다.</p>
              </div>
            </div>
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">택배 탑차</span>
                <strong class="lhc-size">3,000 × 1,500 mm</strong>
                <span class="lhc-aspect">3-SIDE BILLBOARD</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">택배 탑차 3면 와이드 래핑 광고</h5>
                <p class="lhc-desc">광주 5개 구 아파트 단지와 주택가 골목길에 매일 10시간 이상 머무는 움직이는 초대형 랜드마크 빌보드입니다.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 05 MART & DID GUIDE -->
        <div class="bus-guide-page" id="guideMartDid">
          <div class="lmg-page-header">
            <h4 class="lmg-sec-title">대형마트 쇼핑카트 &amp; DID 디지털 전광판 규격</h4>
            <span class="lmg-sec-sub">이마트/롯데마트 1,000대 카트 &amp; 유스퀘어 터미널 고휘도 LED</span>
          </div>

          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">쇼핑카트</span>
                <strong class="lhc-size">280 × 160 mm</strong>
                <span class="lhc-aspect">60 MIN ACCOMPANY</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">대형마트 쇼핑카트 양면 플레이트 광고</h5>
                <p class="lhc-desc">이마트, 롯데마트 1,000여 대 카트 손잡이 정면에 장착되어 60분 쇼핑 내내 3050 주부 및 가족 고객과 1:1로 동행합니다.</p>
              </div>
            </div>
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">DID 전광판</span>
                <strong class="lhc-size">55 ~ 85" UHD</strong>
                <span class="lhc-aspect">100+ DAILY PLAYS</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">DID 전자현수막 &amp; 도심 전광판</h5>
                <p class="lhc-desc">유스퀘어 터미널, 지하철 환승역, 관공서 로비에 고휘도 LED로 15~20초 영상이 일 100회 이상 연속 송출됩니다.</p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="lux-modal-foot">
        <a href="#consultation" class="lmf-btn" onclick="closeGuideModal();">원하는 매체 &amp; 마케팅 맞춤 견적 문의하기 →</a>
      </div>

    </div>
  </div>


  <!-- ============================================
       12 PORTFOLIO CINEMATIC LIGHTBOX MODAL
  ============================================ -->
  <div class="portfolio-modal-backdrop" id="modalBackdrop">
    <div class="portfolio-modal-box">
      <button type="button" class="portfolio-modal-close" id="modalClose">✕</button>
      <div class="pmb-media">
        <img src="" id="modalImg" alt="포트폴리오 상세 이미지">
      </div>
      <div class="pmb-info">
        <div class="pmb-tags">
          <span class="pmb-cat" id="modalCat">광고 집행 사례</span>
          <span class="pmb-id" id="modalId">#01</span>
        </div>
        <h3 class="pmb-title" id="modalTitle">광고 프로젝트명</h3>
        <p class="pmb-desc" id="modalDesc">가온엔이 기획·시공한 대표 광고 집행 사례입니다. 업종별 최적화된 노선과 미디어 믹스로 최고의 브랜드 노출 및 매출 전환 성과를 달성했습니다.</p>
        <div class="pmb-action">
          <a href="#consultation" class="pmb-cta-btn" onclick="$('#modalClose').click();">이와 같은 광고 견적 문의하기 →</a>
        </div>
      </div>
    </div>
  </div>

	<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php";?>

</div>

</body>
</html>
