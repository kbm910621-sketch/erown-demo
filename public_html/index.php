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
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $list[] = $row;
  }
}

// 100% REAL AUTHENTIC HIGH-RES IMAGES SOURCED DIRECTLY FROM BS-AD.CO.KR (1.5MB+ ULTRA HIGH-RES)
if (empty($list)) {
  $list = array(
    // 01 BUS ADVERTISING (REAL BUS WRAPPINGS)
    array('id'=>1, 'category'=>'bus', 'title'=>'광주 시내버스 차도면 대형 래핑 광고 집행 실사', 'thumb'=>'/images/bs_ad/baro.jpg'),
    array('id'=>2, 'category'=>'bus', 'title'=>'광주 주요 간선도로 시내버스 인도면 표준 래핑', 'thumb'=>'/images/bs_ad/baro_3.jpg'),
    array('id'=>3, 'category'=>'bus', 'title'=>'교차로 신호 대기 차량 타깃 시내버스 후면 래핑', 'thumb'=>'/images/bs_ad/baro_9.jpg'),
    array('id'=>4, 'category'=>'bus', 'title'=>'광주 104개 노선 시내버스 내부 중앙창문 포스터', 'thumb'=>'/images/bs_ad/port_in03.jpg'),
    array('id'=>5, 'category'=>'bus', 'title'=>'광주 전남 대표 브랜드 시내버스 3면 풀패키지 래핑', 'thumb'=>'/images/bs_ad/baro_10.jpg'),
    array('id'=>6, 'category'=>'bus', 'title'=>'상무·수완·첨단 주요 상권 관통 시내버스 외부 래핑', 'thumb'=>'/images/bs_ad/baro_11.jpg'),
    array('id'=>7, 'category'=>'bus', 'title'=>'도심 주요 간선 축 시내버스 차도면 3.7m 와이드 래핑', 'thumb'=>'/images/bs_ad/baro_12.jpg'),
    array('id'=>8, 'category'=>'bus', 'title'=>'광주 시내버스 내부 하차문 사랑면 포스터 광고', 'thumb'=>'/images/bs_ad/port_in05.jpg'),

    // 02 ONLINE MARKETING (SEARCH & PLACE & SOCIAL)
    array('id'=>9, 'category'=>'online', 'title'=>'봉선동 입시학원 네이버 스마트플레이스 1위 세팅 & 관리', 'thumb'=>'/images/bs_ad/baro_13.jpg'),
    array('id'=>10, 'category'=>'online', 'title'=>'상무지구 피부과 C-Rank 브랜드 블로그 전문 칼럼 마케팅', 'thumb'=>'/images/bs_ad/baro_14.jpg'),
    array('id'=>11, 'category'=>'online', 'title'=>'수완지구 외식 브랜드 광주 맘카페 & SNS 릴스 바이럴', 'thumb'=>'/images/bs_ad/baro_15.jpg'),
    array('id'=>12, 'category'=>'online', 'title'=>'광주 로컬 핫플레이스 인스타그램 반경 1~3km 타깃 광고', 'thumb'=>'/images/bs_ad/baro_16.jpg'),

    // 03 VIDEO PRODUCTION (4K CINEMATIC & SHORTS)
    array('id'=>13, 'category'=>'video', 'title'=>'광주 대표 종합병원 4K UHD 시네마틱 브랜드 필름', 'thumb'=>'/images/bs_ad/visual01.jpg'),
    array('id'=>14, 'category'=>'video', 'title'=>'기업 TV CF & 극장 스크린 30초 풀프레임 광고 영상', 'thumb'=>'/images/bs_ad/visual02.jpg'),
    array('id'=>15, 'category'=>'video', 'title'=>'SNS 릴스 · 유튜브 숏폼 9:16 모바일 바이럴 영상', 'thumb'=>'/images/bs_ad/visual03.jpg'),
    array('id'=>16, 'category'=>'video', 'title'=>'유스퀘어 터미널 DID 디지털 전광판 15초 모션그래픽', 'thumb'=>'/images/bs_ad/did_01.jpg'),

    // 04 SPECIALIZED OOH MEDIA (TAXI, DELIVERY, MART, DID)
    array('id'=>17, 'category'=>'taxi', 'title'=>'광주 전역 법인·개인택시 200대 양측면 래핑 광고', 'thumb'=>'/images/bs_ad/baro_17.jpg'),
    array('id'=>18, 'category'=>'taxi', 'title'=>'광주 5개 구 아파트 단지 택배 탑차 3면 와이드 래핑', 'thumb'=>'/images/bs_ad/baro_18.jpg'),
    array('id'=>19, 'category'=>'mart', 'title'=>'이마트 · 롯데마트 1,000대 쇼핑카트 양면 플레이트 광고', 'thumb'=>'/images/bs_ad/port_in09.jpg'),
    array('id'=>20, 'category'=>'did', 'title'=>'광천터미널 & 지하철 환승역 고휘도 DID 전자현수막', 'thumb'=>'/images/bs_ad/did_02.jpg')
  );
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

// Ensure each section category has authentic real images
if (count($portBus) < 4) {
  $portBus = array(
    array('id'=>1, 'category'=>'bus', 'title'=>'광주 시내버스 차도면 대형 래핑 광고 집행 실사', 'thumb'=>'/images/bs_ad/baro.jpg'),
    array('id'=>2, 'category'=>'bus', 'title'=>'광주 주요 간선도로 시내버스 인도면 표준 래핑', 'thumb'=>'/images/bs_ad/baro_3.jpg'),
    array('id'=>3, 'category'=>'bus', 'title'=>'교차로 신호 대기 차량 타깃 시내버스 후면 래핑', 'thumb'=>'/images/bs_ad/baro_9.jpg'),
    array('id'=>4, 'category'=>'bus', 'title'=>'광주 104개 노선 시내버스 내부 중앙창문 포스터', 'thumb'=>'/images/bs_ad/port_in03.jpg')
  );
}
if (count($portOnline) < 4) {
  $portOnline = array(
    array('id'=>9, 'category'=>'online', 'title'=>'봉선동 입시학원 네이버 스마트플레이스 1위 세팅 & 관리', 'thumb'=>'/images/bs_ad/baro_13.jpg'),
    array('id'=>10, 'category'=>'online', 'title'=>'상무지구 피부과 C-Rank 브랜드 블로그 전문 칼럼 마케팅', 'thumb'=>'/images/bs_ad/baro_14.jpg'),
    array('id'=>11, 'category'=>'online', 'title'=>'수완지구 외식 브랜드 광주 맘카페 & SNS 릴스 바이럴', 'thumb'=>'/images/bs_ad/baro_15.jpg'),
    array('id'=>12, 'category'=>'online', 'title'=>'광주 로컬 핫플레이스 인스타그램 반경 1~3km 타깃 광고', 'thumb'=>'/images/bs_ad/baro_16.jpg')
  );
}
if (count($portVideo) < 4) {
  $portVideo = array(
    array('id'=>13, 'category'=>'video', 'title'=>'광주 대표 종합병원 4K UHD 시네마틱 브랜드 필름', 'thumb'=>'/images/bs_ad/visual01.jpg'),
    array('id'=>14, 'category'=>'video', 'title'=>'기업 TV CF & 극장 스크린 30초 풀프레임 광고 영상', 'thumb'=>'/images/bs_ad/visual02.jpg'),
    array('id'=>15, 'category'=>'video', 'title'=>'SNS 릴스 · 유튜브 숏폼 9:16 모바일 바이럴 영상', 'thumb'=>'/images/bs_ad/visual03.jpg'),
    array('id'=>16, 'category'=>'video', 'title'=>'유스퀘어 터미널 DID 디지털 전광판 15초 모션그래픽', 'thumb'=>'/images/bs_ad/did_01.jpg')
  );
}
if (count($portOther) < 4) {
  $portOther = array(
    array('id'=>17, 'category'=>'taxi', 'title'=>'광주 전역 법인·개인택시 200대 양측면 래핑 광고', 'thumb'=>'/images/bs_ad/baro_17.jpg'),
    array('id'=>18, 'category'=>'taxi', 'title'=>'광주 5개 구 아파트 단지 택배 탑차 3면 와이드 래핑', 'thumb'=>'/images/bs_ad/baro_18.jpg'),
    array('id'=>19, 'category'=>'mart', 'title'=>'이마트 · 롯데마트 1,000대 쇼핑카트 양면 플레이트 광고', 'thumb'=>'/images/bs_ad/port_in09.jpg'),
    array('id'=>20, 'category'=>'did', 'title'=>'광천터미널 & 지하철 환승역 고휘도 DID 전자현수막', 'thumb'=>'/images/bs_ad/did_02.jpg')
  );
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
                광주 시내버스 104개 전 노선 맞춤 배차 · 네이버 1위 마케팅 · 4K 시네마틱 프로덕션
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
       02 SECTION 01 : 시내버스 광고 (HUMAN CRAFTED CLEAN STAGE)
  ============================================ -->
  <section class="am-section am-bg-slate" id="bus">
    <div class="am-container">
      
      <div class="am-sec-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker">BUS ADVERTISING</span>
            <h2 class="ash-title">시내버스 광고</h2>
            <p class="ash-desc">광주 104개 전 노선 맞춤 배차. 1일 18시간 동안 반복 각인되는 움직이는 랜드마크 빌보드입니다.</p>
          </div>
          <div class="ash-actions">
            <button type="button" class="ash-guide-btn blue" id="btnOpenRouteSearchModal">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <span>104개 노선 실시간 검색기</span>
            </button>
            <button type="button" class="ash-guide-btn bus-guide-open" data-guide="guideBusOut">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
              <span>규격 가이드 &amp; 제안서(PDF) ↗</span>
            </button>
          </div>
        </div>
      </div>

      <!-- 1. NATURAL AGENCY SHOWCASE STAGE -->
      <div class="am-bus-human-showcase wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- SPEC SELECTION TABS -->
        <div class="abh-tabs-row">
          <button type="button" class="abh-tab-btn on"
                  data-name="차도면 대형 래핑"
                  data-size="3,700 × 1,000 mm"
                  data-img="/images/bs_ad/baro.jpg"
                  data-title="왕복 8차선 운전자의 시선을 사로잡는 차도면 대형 래핑"
                  data-desc="상무대로, 죽봉대로, 무진대로 등 광주 도심 주요 간선도로를 주행하며 반대편 차량 운전자와 보행자에게 1일 18시간 동안 가장 압도적인 스케일로 브랜드를 각인시킵니다."
                  data-target="차량 운전자 및 보행자 정면 시야"
                  data-material="LG 하우시스 최고급 내후성 정품 솔벤 시트">
            <span>차도면 (3,700×1,000)</span>
          </button>
          <button type="button" class="abh-tab-btn"
                  data-name="인도면 표준 래핑"
                  data-size="3,000 × 500 mm"
                  data-img="/images/bs_ad/baro_3.jpg"
                  data-title="정류장 탑승객 눈높이에 밀착되는 인도면 표준 래핑"
                  data-desc="승객 탑승 시 눈높이 정면에 위치하여 전화번호, 진료과목, 핵심 진료 안내 등 상세 정보를 정확하게 전달하는 보행자 맞춤형 규격입니다."
                  data-target="정류장 대기 승객 및 인도 보행자"
                  data-material="LG 하우시스 최고급 내후성 정품 솔벤 시트">
            <span>인도면 (3,000×500)</span>
          </button>
          <button type="button" class="abh-tab-btn"
                  data-name="후면 번호판 상단 래핑"
                  data-size="2,400 × 300 mm"
                  data-img="/images/bs_ad/baro_9.jpg"
                  data-title="신호 대기 차량 운전자를 3분 이상 사로잡는 후면 래핑"
                  data-desc="출퇴근 시간 및 도심 교차로 신호 대기 중 뒤따르는 차량 운전자와 동승자의 시선 정면에 장시간 강제 노출되는 가온엔 필수 패키지 면입니다."
                  data-target="신호 대기 후방 차량 운전자 전원"
                  data-material="LG 하우시스 정품 솔벤 반사 시트 지원">
            <span>후면 (2,400×300)</span>
          </button>
          <button type="button" class="abh-tab-btn"
                  data-name="내부 중앙창문 &amp; 음성안내"
                  data-size="1,100 × 500 mm / 음성 7초"
                  data-img="/images/bs_ad/port_in03.jpg"
                  data-title="이동 30분 동안 승객의 시각과 청각을 동시 독점"
                  data-desc="탑승 승객이 목적지까지 이동하는 동안 시선 정면에 머무르며, 정류소 도착 전 전문 성우 음성 방송으로 확실하게 브랜드를 기억시킵니다."
                  data-target="버스 탑승 승객 전원 (일 150만 명)"
                  data-material="실내 고선명 PET 출력 + 성우 음성 더빙">
            <span>내부 창문 &amp; 음성방송</span>
          </button>
        </div>

        <!-- STAGE CONTENT GRID -->
        <div class="abh-stage-body">
          
          <!-- LEFT: LARGE HIGH-RES PHOTO -->
          <div class="abh-photo-box">
            <img src="/images/bs_ad/baro.jpg" id="dynBusPhoto" alt="시내버스 광고 집행 실사">
            <div class="abh-photo-tag" id="dynBusPhotoTag">차도면 대형 래핑 (3,700 × 1,000 mm)</div>
          </div>

          <!-- RIGHT: NATURAL HUMAN AGENCY BRIEF -->
          <div class="abh-text-box">
            <span class="abh-sub-badge" id="dynBusSubBadge">광주 시내버스 외부 광고</span>
            <h3 class="abh-title" id="dynBusTitle">왕복 8차선 운전자의 시선을 사로잡는 차도면 대형 래핑</h3>
            <p class="abh-desc" id="dynBusDesc">상무대로, 죽봉대로, 무진대로 등 광주 도심 주요 간선도로를 주행하며 반대편 차량 운전자와 보행자에게 1일 18시간 동안 가장 압도적인 스케일로 브랜드를 각인시킵니다.</p>

            <div class="abh-points-list">
              <div class="apl-item">
                <span class="apl-dot"></span>
                <span class="apl-label">실측 규격 :</span>
                <strong class="apl-val" id="dynBusSize">3,700 × 1,000 mm</strong>
              </div>
              <div class="apl-item">
                <span class="apl-dot"></span>
                <span class="apl-label">주요 타깃 :</span>
                <strong class="apl-val" id="dynBusTarget">차량 운전자 및 보행자 정면 시야</strong>
              </div>
              <div class="apl-item">
                <span class="apl-dot"></span>
                <span class="apl-label">원단 소재 :</span>
                <strong class="apl-val" id="dynBusMaterial">LG 하우시스 최고급 내후성 정품 솔벤 시트</strong>
              </div>
            </div>

            <div class="abh-cta-box">
              <a href="/board/estmate/write.php" class="abh-cta-btn">
                <span>이 규격으로 시내버스 견적 문의하기</span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </a>
            </div>
          </div>

        </div>

      </div>

      <!-- 2. RECENT BUS PORTFOLIO SHOWCASE STRIP -->
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
              <img src="<?php echo !empty($bItem['thumb']) ? htmlspecialchars($bItem['thumb']) : '/images/sub_bg_a.jpg'; ?>" alt="<?php echo htmlspecialchars($bItem['title']); ?>">
              <span class="asps-badge">시내버스</span>
              <div class="asps-hover-overlay">상세보기 ↗</div>
            </div>
            <div class="asps-info">
              <strong class="asps-item-title"><?php echo htmlspecialchars($bItem['title']); ?></strong>
              <span class="asps-item-loc">광주 104개 노선 맞춤 직영 시공</span>
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
            <span class="ash-kicker">DIGITAL MARKETING</span>
            <h2 class="ash-title">온라인 마케팅</h2>
            <p class="ash-desc">네이버 스마트플레이스 1위 세팅부터 C-Rank 브랜드 블로그, 맘카페 바이럴까지 통합 운영합니다.</p>
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
          <img src="/images/sub_bg_f.jpg" alt="네이버 스마트플레이스 1위">
          <div class="aov-scrim"></div>
          <div class="aov-overlay">
            <span class="aov-pill blue">01 / NAVER SEARCH &amp; PLACE</span>
            <h3 class="aov-title">네이버 스마트플레이스 1위 세팅 &amp; C-Rank 브랜드 블로그</h3>
            <p class="aov-desc">광주 로컬 키워드 1페이지 지도 최상단 노출 + 24시간 네이버 예약 연동 + 고품격 브랜드 칼럼 정기 발행</p>
            <div class="aov-metrics-row">
              <div class="amr-tag">상권 키워드 지도 상위 노출</div>
              <div class="amr-tag">월 8~12편 전문 칼럼</div>
              <div class="amr-tag">네이버 예약 연동</div>
            </div>
          </div>
        </div>

        <!-- CARD 02 : MOM CAFE -->
        <div class="aov-card">
          <img src="/images/sub_bg_g.jpg" alt="맘카페 바이럴">
          <div class="aov-scrim"></div>
          <div class="aov-overlay">
            <span class="aov-pill green">02. 맘카페 &amp; 동네생활</span>
            <h3 class="aov-title">광주 대표 맘카페 &amp; 당근마켓 바이럴</h3>
            <p class="aov-desc">광주맘스홀릭 및 당근 동네생활 실사용자 기반 자연스러운 방문 후기 여론 형성</p>
            <div class="aov-metrics-row">
              <div class="amr-tag">3050 주부 신뢰 확보</div>
            </div>
          </div>
        </div>

        <!-- CARD 03 : INSTAGRAM REELS -->
        <div class="aov-card">
          <img src="/images/sub_bg_e.jpg" alt="인스타그램 릴스">
          <div class="aov-scrim"></div>
          <div class="aov-overlay">
            <span class="aov-pill blue">03. 인스타그램 릴스 타깃</span>
            <h3 class="aov-title">인스타그램 릴스 &amp; 반경 타깃 광고</h3>
            <p class="aov-desc">사업장 반경 1~3km 내 거주 고객 집중 타깃팅 + 9:16 모바일 숏폼 영상 제작</p>
            <div class="aov-metrics-row">
              <div class="amr-tag">반경 1~3km 정밀 노출</div>
            </div>
          </div>
        </div>

        <!-- CARD 04 : GOOGLE GDN -->
        <div class="aov-card wide">
          <img src="/images/sub_bg_h.jpg" alt="구글 검색 & GDN">
          <div class="aov-scrim"></div>
          <div class="aov-overlay">
            <span class="aov-pill purple">04. 구글 &amp; 유튜브 리타깃팅</span>
            <h3 class="aov-title">구글 검색광고 &amp; 유튜브 GDN 리타깃팅</h3>
            <p class="aov-desc">키워드 검색 고객과 제휴 언론사 배너 네트워크를 결합하여 이탈 고객을 24시간 재유입</p>
            <div class="aov-metrics-row">
              <div class="amr-tag">구글 검색 키워드</div>
              <div class="amr-tag">유튜브 배너 네트워크</div>
            </div>
          </div>
        </div>

      </div>

      <!-- ============================================
           HOSPITAL MEDICAL BRAND BLOG & COLUMN STUDIO (DYNAMIC REAL EXPERIENCE)
      ============================================ -->
      <div class="am-hospital-blog-sim-stage wow fadeInUp" data-wow-duration="0.8s">
        <div class="ahbs-layout">
          
          <!-- LEFT: MEDICAL SUBJECT SWITCHER & AUDIENCE -->
          <div class="ahbs-controller">
            <div class="ahbs-head">
              <span class="ahbs-kicker">HOSPITAL BRAND BLOG STUDIO</span>
              <h3 class="ahbs-title">병원·의원 전문 브랜드 블로그 칼럼 라이브 뷰</h3>
              <p class="ahbs-desc">단순 홍보글이 아닌 원장님의 진료 철학과 전문 지식을 진정성 있게 담아 환자의 내방 결정을 이끌어내는 고품격 브랜드 블로그 실전 칼럼입니다.</p>
            </div>

            <div class="ahbs-subject-tabs">
              <button type="button" class="asb-tab on" data-dept="skin">
                <div class="asb-icon-badge">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div class="asb-text">
                  <strong>피부과 · 리프팅</strong>
                  <span>울쎄라 vs 써마지 1:1 비교 분석 칼럼</span>
                </div>
              </button>

              <button type="button" class="asb-tab" data-dept="dental">
                <div class="asb-icon-badge">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="asb-text">
                  <strong>치과 · 임플란트</strong>
                  <span>뼈이식 임플란트 실패 없는 3가지 수술 기준</span>
                </div>
              </button>

              <button type="button" class="asb-tab" data-dept="ortho">
                <div class="asb-icon-badge">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24M14.83 9.17l4.24-4.24M14.83 14.83l4.24 4.24M9.17 14.83l-4.24 4.24"/></svg>
                </div>
                <div class="asb-text">
                  <strong>정형외과 · 통증</strong>
                  <span>허리 디스크 비수술 도수·주사 치료 호전 원리</span>
                </div>
              </button>

              <button type="button" class="asb-tab" data-dept="korean">
                <div class="asb-icon-badge">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22v-7M9 9l3-7 3 7M9 9h6M4 22h16"/></svg>
                </div>
                <div class="asb-text">
                  <strong>한방병원 · 교통사고</strong>
                  <span>교통사고 후유증 3일 골든타임 입원 치료 가이드</span>
                </div>
              </button>
            </div>

            <div class="ahbs-audit-note">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              <span>가온엔은 인위적인 어뷰징 없이 신뢰도 높은 정통 브랜드 콘텐츠만을 기획·발행합니다.</span>
            </div>
          </div>

          <!-- RIGHT: NAVER SMART EDITOR ONE MEDICAL BLOG VIEW -->
          <div class="ahbs-blog-mockup-wrap">
            <div class="ahbs-blog-mockup">
              
              <!-- BLOG TOP BRAND HEADER -->
              <div class="abm-header">
                <div class="abh-brand-info">
                  <span class="abh-blog-name" id="simBlogBrand">가온메디컬 공식 의학 매거진</span>
                  <span class="abh-blog-stats">이웃 4,820명 · 일 방문 2,500+</span>
                </div>
                <span class="abh-follow-btn">+ 이웃추가</span>
              </div>

              <!-- BLOG POSTING CONTAINER -->
              <div class="abm-post-body" id="simBlogPostContainer">
                
                <div class="apb-category-row">
                  <span class="apb-cat" id="simPostCat">피부과 원장 칼럼</span>
                  <span class="apb-date">오늘 작성 · 5분 읽기</span>
                </div>

                <h4 class="apb-title" id="simPostTitle">울쎄라 vs 써마지 차이점, 원장님이 직접 명확하게 비교해 드립니다</h4>

                <div class="apb-author-profile">
                  <div class="aap-avatar">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  </div>
                  <div class="aap-info">
                    <strong class="aap-name" id="simAuthorName">대표원장 의학박사 직접 집필</strong>
                    <span class="aap-desc" id="simAuthorDesc">광주 상무지구 진료 15년</span>
                  </div>
                </div>

                <!-- MEDICAL LEAD CONTENT BOX -->
                <div class="apb-lead-box" id="simLeadBox">
                  "안녕하세요. 상무지구에서 15년간 피부 진료를 이어오고 있는 대표원장입니다. 많은 환자분들이 내원하셔서 '원장님, 저한테는 울쎄라가 맞나요, 써마지가 맞나요?'라는 질문을 가장 많이 하십니다. 결론부터 말씀드리면 두 시술은 타깃하는 피부 층이 완전히 다릅니다..."
                </div>

                <!-- 3-POINT MEDICAL HIGHLIGHT -->
                <div class="apb-point-card">
                  <strong class="apc-point-title" id="simPointTitle">원장님이 짚어주는 3대 핵심 요약</strong>
                  <ul class="apc-point-list" id="simPointList">
                    <li><strong>01. 초음파 vs 고주파 :</strong> 울쎄라는 SMAS 근막층, 써마지는 진피층 콜라겐을 타깃합니다.</li>
                    <li><strong>02. 피부 두께 측정 :</strong> 볼 꺼짐 부작용을 방지하기 위해 1:1 초음파 정밀 진단이 필수입니다.</li>
                    <li><strong>03. 시술 팁 관리 :</strong> 시술 직후 인증된 시리얼 넘버 및 확인서를 제공합니다.</li>
                  </ul>
                </div>

                <!-- MEDICAL LAW COMPLIANCE BADGE -->
                <div class="apb-law-badge">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                  <span>가온엔 본사 전문 에디터 팀 1:1 맞춤 기획 및 전수 검수 완료</span>
                </div>

                <!-- CTA BUTTONS -->
                <div class="apb-action-row">
                  <a href="/board/estmate/write.php" class="apb-btn call">📞 병원 1:1 전화 상담</a>
                  <a href="/board/estmate/write.php" class="apb-btn reserve">📅 네이버 진료 예약</a>
                </div>

              </div>

            </div>
          </div>

        </div>
      </div>

      <!-- 3-PILLAR TRUST STRIP -->
      <div class="am-online-guarantee-deck wow fadeInUp" data-wow-duration="0.8s">
        <div class="aog-card">
          <div class="aog-icon-box">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
          </div>
          <div class="aog-body">
            <strong>광고 심의 및 신뢰성 검수</strong>
            <span>과장되거나 자극적인 표현을 배제하고 브랜드 신뢰도를 극대화하는 정직하고 안전한 콘텐츠</span>
          </div>
        </div>

        <div class="aog-card">
          <div class="aog-icon-box">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><polyline points="2 6 12 2 22 6"/></svg>
          </div>
          <div class="aog-body">
            <strong>주간 노출 순위 투명 보고</strong>
            <span>스마트블록 노출 순위, 유입 키워드, 광고 클릭 현황을 매주 데이터 기반으로 보고</span>
          </div>
        </div>

        <div class="aog-card">
          <div class="aog-icon-box">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <div class="aog-body">
            <strong>인하우스 1:1 전담 디렉터 배정</strong>
            <span>외주 하청 없는 가온엔 본사 전문 디렉터가 병원 홍보 전 과정을 1:1 전담 관리</span>
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
       04 SECTION 03 : 영상제작 (SMARTPHONE MOCKUP & CINEMA VIEWFINDER)
  ============================================ -->
  <section class="am-section am-bg-dark am-video-ambient-sec" id="video">
    <div class="avs-ambient-bg">
      <div class="avs-glow glow-left"></div>
      <div class="avs-glow glow-right"></div>
    </div>

    <div class="am-container" style="position:relative; z-index:2;">

      <div class="am-sec-head dark-head text-center wow fadeInUp" data-wow-duration="0.7s">
        <span class="ash-kicker gold">03 / 4K CINEMATIC &amp; SHORTS PRODUCTION</span>
        <h2 class="ash-title white">영상제작 솔루션</h2>
        <p class="ash-desc light" style="margin:0 auto;">기업·상급병원 4K 브랜드 필름부터 9:16 모바일 릴스까지 인하우스 프로덕션이 기획·촬영·편집을 원스톱으로 제작합니다.</p>
      </div>

      <!-- VIDEO PRODUCTION VISUAL CENTER STAGE -->
      <div class="am-video-hero-stage wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- HIGH-END SVG PICTOGRAM SEGMENT SWITCHER (CENTERED) -->
        <div class="avh-switcher-center-box">
          <div class="avh-mode-switcher">
            <button type="button" class="avh-mode-btn on" data-video-mode="wide">
              <svg class="avh-btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
              </svg>
              <span>16:9 와이드 시네마</span>
            </button>
            <button type="button" class="avh-mode-btn" data-video-mode="shorts">
              <svg class="avh-btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="14" height="20" x="5" y="2" rx="2.5"/><line x1="12" y1="18" x2="12" y2="18.01"/>
              </svg>
              <span>9:16 모바일 릴스·숏폼</span>
            </button>
          </div>
        </div>

        <!-- MAIN STAGE DISPLAY (CINEMA & PHONE MOCKUP) -->
        <div class="avh-display-arena" id="avhDisplayArena">
          
          <!-- 16:9 CINEMA FRAME -->
          <div class="avh-cinema-frame on" id="cinemaFrame">
            <div class="acf-bezel">
              <video autoplay muted loop playsinline class="acf-video">
                <source src="/images/movie.mp4" type="video/mp4">
              </video>
              <div class="acf-scrim"></div>
              <div class="acf-overlay-info">
                <span class="acf-tag gold">4K CINEMATIC PRODUCTION</span>
                <h3 class="acf-title" id="dynCinemaTitle">기업 · 상급병원 4K 시네마틱 브랜드 필름</h3>
                <p class="acf-sub" id="dynCinemaSub">Sony FX Cinema 풀프레임 + 4K 드론 항공촬영 + 전문 성우 더빙</p>
              </div>
            </div>
          </div>

          <!-- 9:16 SMARTPHONE MOCKUP FRAME -->
          <div class="avh-phone-mockup" id="phoneMockup">
            <div class="apm-device">
              <!-- SMARTPHONE NOTCH / DYNAMIC ISLAND -->
              <div class="apm-dynamic-island">
                <span class="apm-camera"></span>
                <span class="apm-speaker"></span>
              </div>
              
              <!-- PHONE SCREEN WITH 9:16 VIDEO -->
              <div class="apm-screen">
                <video autoplay muted loop playsinline class="apm-video">
                  <source src="/images/movie.mp4" type="video/mp4">
                </video>
                <div class="apm-reels-ui">
                  <div class="aru-right-actions">
                    <div class="aru-action-btn">❤️<span>2.4k</span></div>
                    <div class="aru-action-btn">💬<span>184</span></div>
                    <div class="aru-action-btn">↗️<span>공유</span></div>
                  </div>
                  <div class="aru-bottom-info">
                    <span class="aru-brand-tag">@GAON_N_OFFICIAL</span>
                    <h4 class="aru-title">SNS 릴스 · 틱톡 바이럴 숏폼</h4>
                    <p class="aru-desc">첫 3초 만에 시선을 사로잡는 빠른 컷 전환 &amp; 모션그래픽</p>
                  </div>
                </div>
              </div>

              <!-- PHONE HOME INDICATOR BAR -->
              <div class="apm-home-bar"></div>
            </div>
          </div>

        </div>

        <!-- 4 CLEAN VISUAL DELIVERABLE SELECTORS (BIG & BOLD) -->
        <div class="avh-selectors-grid">
          <div class="avs-item-card on" data-target-mode="wide"
               data-title="기업 · 상급병원 4K 시네마틱 브랜드 필름"
               data-sub="Sony FX Cinema 풀프레임 + 4K 드론 항공촬영 + 전문 성우 더빙">
            <span class="avs-badge">01 / BRAND FILM</span>
            <strong class="avs-title">기업 · 상급병원 브랜드 필름</strong>
            <span class="avs-sub">4K UHD 풀프레임 시네마 (3~5분)</span>
          </div>

          <div class="avs-item-card" data-target-mode="wide"
               data-title="TV CF &amp; 극장 스크린 광고 (15초 / 30초)"
               data-sub="15초/30초 고임팩트 스토리텔링 + 2D/3D 모션그래픽">
            <span class="avs-badge">02 / TV CF · THEATER</span>
            <strong class="avs-title">TV CF · 극장 스크린 광고</strong>
            <span class="avs-sub">15초/30초 초압축 임팩트 스토리텔링</span>
          </div>

          <div class="avs-item-card" data-target-mode="shorts"
               data-title="SNS 릴스 · 유튜브 쇼츠 바이럴 (9:16 세로형)"
               data-sub="인스타그램 릴스 + 유튜브 쇼츠 + 틱톡 최적화 숏폼">
            <span class="avs-badge gold">03 / SNS SHORTS</span>
            <strong class="avs-title">SNS 릴스 · 유튜브 숏폼</strong>
            <span class="avs-sub">9:16 모바일 세로형 바이럴 영상</span>
          </div>

          <div class="avs-item-card" data-target-mode="wide"
               data-title="DID 디지털 전광판 모션그래픽 (15초 풀HD)"
               data-sub="옥외 고휘도 스크린 전용 15초 풀HD 고시인성 모션">
            <span class="avs-badge">04 / DIGITAL SIGNAGE</span>
            <strong class="avs-title">DID 전광판 모션그래픽</strong>
            <span class="avs-sub">터미널·역사 고휘도 LED 송출 (15초)</span>
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
            <span class="ash-kicker">SPECIALIZED OOH MEDIA</span>
            <h2 class="ash-title">특화 옥외매체</h2>
            <p class="ash-desc">택시 양측면 래핑, 택배 탑차 3면 래핑, 대형마트 카트, DID 디지털 전광판을 맞춤 집행합니다.</p>
          </div>
          <button type="button" class="ash-guide-btn bus-guide-open" data-guide="guideTaxiDelivery">
            <span>특화 매체 실측표 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- DYNAMIC ACCORDION WITH CLEAN ELLIPSIS -->
      <div class="am-ooh-accordion wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="aoa-card on">
          <img src="/images/ev1.jpg" alt="택시 래핑 광고">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">01 / URBAN MOBILITY</span>
            <h3 class="aoa-title-ellipsis">법인 · 개인택시 양측면 래핑</h3>
            <p class="aoa-desc-ellipsis">광주 전역 200여 대 차량이 주요 번화가와 골목길을 24시간 365일 상시 운행하며, 보행자 눈높이에서 밀착 노출되어 높은 주목도를 발휘합니다.</p>
            <div class="doa-spec">실측 규격: 2,100 × 320 mm | 24시간 365일 연속 운행</div>
          </div>
        </div>

        <div class="aoa-card">
          <img src="/images/ev2.jpg" alt="택배차량 래핑 광고">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">02 / LOGISTICS BILLBOARD</span>
            <h3 class="aoa-title-ellipsis">택배 탑차 3면 와이드 래핑</h3>
            <p class="aoa-desc-ellipsis">광주 5개 구 대규모 아파트 단지와 주택가 골목길에 매일 10시간 이상 머무는 움직이는 초대형 랜드마크 빌보드로 주민 일상에 자연스럽게 각인됩니다.</p>
            <div class="doa-spec">실측 규격: 양면 3,000×1,500 + 후면 | 1일 10시간 체류</div>
          </div>
        </div>

        <div class="aoa-card">
          <img src="/images/sub_bg_02.jpg" alt="대형마트 쇼핑카트">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">03 / RETAIL PURCHASE POINT</span>
            <h3 class="aoa-title-ellipsis">대형마트 쇼핑카트 &amp; 무빙워크</h3>
            <p class="aoa-desc-ellipsis">이마트, 롯데마트 1,000여 대 카트 손잡이 정면에 위치하여 실질적 구매권을 가진 3050 주부 및 가족 고객과 60분간 1:1로 동행합니다.</p>
            <div class="doa-spec">실측 규격: 280 × 160 mm | 쇼핑 1회당 60분 연속 주시</div>
          </div>
        </div>

        <div class="aoa-card">
          <img src="/images/sub_bg_03.jpg" alt="DID 디지털 전광판">
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
       06 SECTION 05 : 성공 사례 (EXACT SCREENSHOT REPLICA: WIDE 4-COLUMN & HUGE TYPO TABS)
  ============================================ -->
  <section class="am-section am-bg-white" id="archive">
    <div class="am-container-wide">

      <!-- TOP THIN DIVIDER LINE & RESULTS META -->
      <div class="ms-meta-bar wow fadeInUp" data-wow-duration="0.6s">
        <span class="ms-results-count"><strong id="dynResultCount"><?php echo !empty($displayItems) ? count($displayItems) : 8; ?></strong> Results</span>
        <span class="ms-all-text">All</span>
      </div>

      <!-- HUGE BOLD TYPOGRAPHIC CATEGORY TABS (All / Events / Story / Thinking STYLE) -->
      <div class="ms-huge-tabs wow fadeInUp" data-wow-duration="0.7s">
        <button type="button" class="ms-tab on" data-filter="all">All</button>
        <button type="button" class="ms-tab" data-filter="bus">시내버스 <span class="ms-sub">Bus</span></button>
        <button type="button" class="ms-tab" data-filter="online">온라인 <span class="ms-sub">Online</span></button>
        <button type="button" class="ms-tab" data-filter="video">영상제작 <span class="ms-sub">Video</span></button>
        <button type="button" class="ms-tab" data-filter="taxi">특화매체 <span class="ms-sub">Special</span></button>
      </div>

      <!-- 4-COLUMN WIDE SQUARE-RECTANGLE CARDS GRID (EXACT SCREENSHOT CARD RATIO & DETAILS) -->
      <div class="ms-cards-grid-4 wow fadeInUp" data-wow-duration="0.8s" id="masterPortGrid">
        <?php 
        $archiveList = array(
          array('id'=>1, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'상무지구 대형 메디컬센터 시내버스 3면 풀래핑 광고', 'tag'=>'BUS-AD', 'date'=>'26·09·01', 'thumb'=>'/images/bs_ad/baro.jpg'),
          array('id'=>9, 'category'=>'online', 'badge'=>'AEO·GEO', 'title'=>'봉선동 대표 입시학원 네이버 스마트플레이스 1위 세팅', 'tag'=>'ONLINE', 'date'=>'26·09·01', 'thumb'=>'/images/bs_ad/baro_13.jpg'),
          array('id'=>13, 'category'=>'video', 'badge'=>'CINEMA 4K', 'title'=>'광주 대표 종합병원 4K UHD 시네마틱 브랜드 필름', 'tag'=>'VIDEO', 'date'=>'26·08·28', 'thumb'=>'/images/bs_ad/visual01.jpg'),
          array('id'=>18, 'category'=>'taxi', 'badge'=>'OOH WRAP', 'title'=>'광주 5개 구 아파트 단지 택배 탑차 3면 와이드 래핑', 'tag'=>'SPECIAL', 'date'=>'26·08·25', 'thumb'=>'/images/bs_ad/baro_18.jpg'),
          array('id'=>10, 'category'=>'online', 'badge'=>'C-RANK BLOG', 'title'=>'상무지구 피부과 C-Rank 브랜드 블로그 전문 칼럼 발행', 'tag'=>'ONLINE', 'date'=>'26·08·20', 'thumb'=>'/images/bs_ad/baro_14.jpg'),
          array('id'=>2, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'광주 주요 간선도로 시내버스 인도면 표준 래핑 광고', 'tag'=>'BUS-AD', 'date'=>'26·08·15', 'thumb'=>'/images/bs_ad/baro_3.jpg'),
          array('id'=>15, 'category'=>'video', 'badge'=>'SNS REELS', 'title'=>'인스타그램 릴스 & 유튜브 숏폼 모바일 9:16 바이럴', 'tag'=>'VIDEO', 'date'=>'26·08·10', 'thumb'=>'/images/bs_ad/visual03.jpg'),
          array('id'=>3, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'교차로 신호 대기 차량 타깃 시내버스 후면 래핑 광고', 'tag'=>'BUS-AD', 'date'=>'26·08·05', 'thumb'=>'/images/bs_ad/baro_9.jpg')
        );
        $displayItems = !empty($list) && count($list) >= 8 ? array_slice($list, 0, 8) : $archiveList;
        foreach ($displayItems as $idx => $item): 
          $badgeText = !empty($item['badge']) ? htmlspecialchars($item['badge']) : 'GAON-N';
          $tagText = !empty($item['tag']) ? htmlspecialchars($item['tag']) : 'MEDIA';
          $imgSrc = !empty($item['thumb']) ? htmlspecialchars($item['thumb']) : '/images/bs_ad/baro.jpg';
          $dateText = !empty($item['date']) ? htmlspecialchars($item['date']) : '26·09·01';
        ?>
        <div class="ms-card main-port-card" 
             data-cat="<?php echo htmlspecialchars($item['category']); ?>" 
             data-id="<?php echo (int)$item['id']; ?>" 
             data-name="<?php echo htmlspecialchars($item['title']); ?>">
          
          <!-- UPPER THUMBNAIL (ROUNDED TOP WITH INNER BADGE) -->
          <div class="ms-card-thumb">
            <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
            <span class="ms-badge-pill"><?php echo $badgeText; ?></span>
          </div>

          <!-- LOWER WHITE BODY (TITLE + ARROW + BOTTOM META) -->
          <div class="ms-card-body">
            <div class="ms-body-top">
              <h4 class="ms-card-title"><?php echo htmlspecialchars($item['title']); ?></h4>
              <div class="ms-arrow-box">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
              </div>
            </div>
            
            <div class="ms-body-bottom">
              <span class="ms-tag"><?php echo $tagText; ?></span>
              <span class="ms-date"><?php echo $dateText; ?></span>
            </div>
          </div>

        </div>
        <?php endforeach; ?>
      </div>

      <div class="am-more-box" style="margin-top:60px;">
        <a href="/contents/a_type/a_1.php" class="am-more-btn">
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
       08 GAON-N GET STARTED MASTER CTA (SOLID NAVY ROUNDED BOX & 4 FLOATING PILLS)
  ============================================ -->
  <section class="am-get-started-sec" id="getStarted">
    <div class="am-container">
      
      <!-- SOLID NAVY ROUNDED BOX WITH NICE OUTER MARGINS -->
      <div class="ags-solid-box wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- 4 FLOATING PILLS (둥둥 떠다니는 알약 4종) -->
        <div class="ags-floating-pill pill-top-left">
          <span class="afp-dot green"></span>
          <span class="afp-text">지금 바로 상담해보세요</span>
        </div>

        <div class="ags-floating-pill pill-top-right">
          <span class="afp-dot yellow"></span>
          <span class="afp-text">빠른 견적 안내 가능합니다</span>
        </div>

        <div class="ags-floating-pill pill-bottom-left">
          <span class="afp-icon-clock">⏱</span>
          <span class="afp-text">광주 500+ 신뢰 대행사</span>
        </div>

        <div class="ags-floating-pill pill-bottom-right">
          <span class="afp-dot green"></span>
          <span class="afp-text">오프라인 · 온라인 통합 운영</span>
        </div>

        <!-- CENTER HEADLINE & CTA -->
        <div class="ags-center-box">
          <span class="ags-kicker">GET STARTED</span>
          <h2 class="ags-title">
            광고, 이제<br>
            <span class="ags-highlight">제대로 시작하세요.</span>
          </h2>
          <p class="ags-desc">
            광주 104개 시내버스부터 네이버 스마트플레이스, 4K 시네마 영상까지<br class="pc-only">
            외주 없는 100% 인하우스 전문팀이 가장 확실한 맞춤 미디어 믹스를 제안해 드립니다.
          </p>

          <div class="ags-cta-wrap">
            <a href="/board/estmate/write.php" class="ags-white-pill-btn">
              <span class="awpb-text">맞춤 견적 상담받기</span>
              <span class="awpb-arrow-circle">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </span>
            </a>
            <a href="tel:062-381-1350" class="ags-call-outline-btn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
              </svg>
              <span>직통 전화 062-381-1350</span>
            </a>
          </div>
        </div>

      </div>

    </div>
  </section>

    <!-- ============================================
       10 LUXURY DIRECTORY: 104 BUS ROUTES SEARCH MODAL (CLEAN 2-COLUMN ALIGNMENT)
  ============================================ -->
  <div class="route-search-modal-overlay" id="routeSearchModal" style="display:none !important;">
    <div class="rsm-panel">
      <div class="rsm-head">
        <div class="rsm-content-wrap">
          <div class="rsm-kicker-row">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <span class="rsm-kicker-text">광주 시내버스 104개 전 노선 실시간 검색</span>
          </div>
          <h3 class="rsm-title">광주 시내버스 104개 전 노선 디렉토리</h3>
          <p class="rsm-desc">광주광역시 104개 전체 노선(급행/간선/지선)의 주요 경유 상권, 운행 대수, 배차 간격 및 타깃 정보입니다.</p>
        </div>
        <button type="button" class="rsm-close" id="btnCloseRouteSearch" aria-label="닫기">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      <div class="rsm-body">
        <div class="rsm-search-bar">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
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
          <!-- Injected dynamically with 2-column rich directory styling -->
        </div>
      </div>

      <div class="rsm-foot">
        <div class="rf-notice">
          <strong>※ 병원 / 학원 / 매장 앞 통과 노선 무료 매칭 서비스</strong>
          <span>광고주님의 사업장 위치를 알려주시면 가장 노출 빈도가 높은 골든 노선 조합을 1:1 무료 컨설팅해 드립니다.</span>
        </div>
        <a href="/board/estmate/write.php" class="rsm-foot-btn" onclick="closeRouteModal();">1:1 노선 무료 분석 신청 →</a>
      </div>
    </div>
  </div>


        <!-- ============================================
       11 HIGH-END 6-CATEGORY MASTER SPECIFICATION & PROPOSAL MODAL (CLEAN WHITE EXECUTIVE DESIGN)
  ============================================ -->
  <div class="bus-guide-overlay" id="busGuideOverlay" style="display:none !important;">
    <div class="lux-modal-panel">
      
      <!-- CLEAN WHITE EXECUTIVE HEADER (NO HEAVY DARK TINT) -->
      <div class="lux-modal-head">
        <div class="lmh-content-wrap">
          <div class="lmh-kicker-row">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <span class="lmh-label">가온엔 공식 매체 규격 &amp; 제안서 다운로드</span>
          </div>
          <h3 class="lmh-title">가온엔 통합 매체 공식 규격 및 제안서</h3>
          <p class="lmh-desc">광주 104개 시내버스 외부·내부 규격부터 택시, 온라인 5대 채널, 4K 영상, 인쇄물 규격과 공식 PDF 제안서입니다.</p>
        </div>
        <button type="button" class="lux-modal-close" id="btnCloseBusGuide" aria-label="닫기">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      <!-- 6-CATEGORY TAB NAVIGATION -->
      <div class="lux-modal-tabs">
        <button type="button" class="lmt-tab on" data-target="guideBusOut">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="14" x="3" y="3" rx="2"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/><path d="M3 10h18"/></svg>
          <span>버스 외부광고</span>
        </button>
        <button type="button" class="lmt-tab" data-target="guideBusIn">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
          <span>버스 내부·음성</span>
        </button>
        <button type="button" class="lmt-tab" data-target="guideTaxiSpec">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
          <span>택시·특화매체</span>
        </button>
        <button type="button" class="lmt-tab" data-target="guideOnline">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2.5"/><line x1="12" y1="18" x2="12" y2="18.01"/></svg>
          <span>온라인 마케팅</span>
        </button>
        <button type="button" class="lmt-tab" data-target="guideVideo">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect width="15" height="14" x="1" y="5" rx="2"/></svg>
          <span>4K 영상제작</span>
        </button>
        <button type="button" class="lmt-tab" data-target="guidePrint">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          <span>인쇄물·현수막</span>
        </button>
      </div>

      <!-- MODAL BODY -->
      <div class="lux-modal-body">
        
        <!-- 01 BUS OUTSIDE GUIDE -->
        <div class="bus-guide-page on" id="guideBusOut">
          <div class="lmg-download-banner">
            <div class="ldb-info">
              <span class="ldb-badge">OFFICIAL PDF</span>
              <strong class="ldb-title">광주 시내버스 외부광고 공식 제안서 및 단가표 (PDF)</strong>
              <p class="ldb-meta">차도면·인도면·후면 실측 도면 및 광주 104개 노선별 집행 단가표 수록 (PDF)</p>
            </div>
            <a href="/pdf/gaon_bus_outside.pdf" download="가온엔_시내버스_외부광고_공식제안서.pdf" class="ldb-btn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              <span>외부광고 제안서 다운로드</span>
            </a>
          </div>

          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">차도면 대형</span>
                <strong class="lhc-size">3,700 × 1,000 mm</strong>
                <span class="lhc-aspect">운전자 시야 정면 노출</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">차도면 대형 래핑 광고 (좌측면)</h5>
                <p class="lhc-desc">왕복 6~8차선 반대편 차량 운전자와 인도 보행자의 시야 정면에 노출되는 가장 거대한 랜드마크 규격입니다.</p>
                <div class="lhc-spec-list">
                  <div class="lsl-item"><span class="lsl-k">핵심 타깃 :</span><strong class="lsl-v">도심 간선도로 운전자 &amp; 반대편 보행자</strong></div>
                  <div class="lsl-item"><span class="lsl-k">원단 소재 :</span><strong class="lsl-v">LG 하우시스 최고급 정품 솔벤 시트</strong></div>
                </div>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">인도면 표준</span>
                <strong class="lhc-size">3,000 × 500 mm</strong>
                <span class="lhc-aspect">보행자 눈높이 1:1 밀착</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">인도면 표준 래핑 광고 (우측면)</h5>
                <p class="lhc-desc">버스 정류장 대기 승객 및 인도 보행자의 눈높이와 1:1로 밀착되어 상세 진료 과목, 상호, 전화번호 전달에 최적입니다.</p>
                <div class="lhc-spec-list">
                  <div class="lsl-item"><span class="lsl-k">핵심 타깃 :</span><strong class="lsl-v">정류소 탑승 대기 승객 &amp; 인도 보행자</strong></div>
                  <div class="lsl-item"><span class="lsl-k">원단 소재 :</span><strong class="lsl-v">LG 하우시스 최고급 내후성 솔벤 시트</strong></div>
                </div>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">후면 보조</span>
                <strong class="lhc-size">2,400 × 300 mm</strong>
                <span class="lhc-aspect">신호대기 3분 강제 주시</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">후면 번호판 상단 래핑 광고</h5>
                <p class="lhc-desc">교차로 신호 대기 및 출퇴근 도로 정체 시 후방 차량 운전자에게 3분 이상 강제 주시되는 필수 패키지 면입니다.</p>
                <div class="lhc-spec-list">
                  <div class="lsl-item"><span class="lsl-k">핵심 타깃 :</span><strong class="lsl-v">신호 대기 후방 정체 차량 운전자 전원</strong></div>
                  <div class="lsl-item"><span class="lsl-k">원단 소재 :</span><strong class="lsl-v">LG 하우시스 정품 솔벤 반사 시트 지원</strong></div>
                </div>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge purple">나주 광역</span>
                <strong class="lhc-size">2,000 × 400 mm</strong>
                <span class="lhc-aspect">혁신도시 공공기관 특화</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">나주 시내버스 후면 와이드 래핑</h5>
                <p class="lhc-desc">광주-나주 혁신도시를 왕복 운행하는 광역 간선버스 후면에 단독 부착되어 혁신도시 공공기관 임직원 타깃에 특화됩니다.</p>
                <div class="lhc-spec-list">
                  <div class="lsl-item"><span class="lsl-k">핵심 타깃 :</span><strong class="lsl-v">나주 혁신도시 공공기관 임직원 &amp; 출퇴근 차량</strong></div>
                  <div class="lsl-item"><span class="lsl-k">원단 소재 :</span><strong class="lsl-v">고접착 실사 솔벤 시트</strong></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 02 BUS INSIDE & VOICE GUIDE -->
        <div class="bus-guide-page" id="guideBusIn">
          <div class="lmg-download-banner">
            <div class="ldb-info">
              <span class="ldb-badge">OFFICIAL PDF</span>
              <strong class="ldb-title">광주 시내버스 내부광고 &amp; 음성안내 제안서 및 단가표 (PDF)</strong>
              <p class="ldb-meta">중앙창문, 하차문 사랑면, 시트커버 및 7초 성우 음성안내 노선 단가표 수록 (PDF)</p>
            </div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
              <a href="/pdf/gaon_bus_inside.pdf" download="가온엔_시내버스_내부광고_공식제안서.pdf" class="ldb-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                <span>내부광고 제안서 다운로드</span>
              </a>
              <a href="/pdf/gaon_bus_voice.pdf" download="가온엔_시내버스_음성광고_공식제안서.pdf" class="ldb-btn" style="background:#0f274e;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                <span>음성광고 제안서 다운로드</span>
              </a>
            </div>
          </div>

          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">중앙창문</span>
                <strong class="lhc-size">1,100 × 500 mm</strong>
                <span class="lhc-aspect">차량 1대당 2매 부착</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">중앙창문 대형 포스터 광고</h5>
                <p class="lhc-desc">차량 내부 좌석 및 입석 승객의 눈높이 정면에 위치하며, 차량 1대당 2매가 부착되어 높은 가독성을 제공합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">사랑면(하차문)</span>
                <strong class="lhc-size">1,000 × 500 mm</strong>
                <span class="lhc-aspect">하차 대기 승객 100% 접촉</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">하차문 측면 사랑면 광고</h5>
                <p class="lhc-desc">승객이 하차하기 위해 대기하는 동안 100% 시선이 머무는 하차문 옆 핵심 골든존 위치입니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">하차문 유리</span>
                <strong class="lhc-size">700 × 400 mm</strong>
                <span class="lhc-aspect">투명 유리면 직부착</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">하차문 유리창 포스터 광고</h5>
                <p class="lhc-desc">하차문 투명 유리면에 직접 부착되어 문이 열리고 닫힐 때마다 승객 시야에 자연스럽게 노출됩니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">시트커버</span>
                <strong class="lhc-size">240 × 120 mm</strong>
                <span class="lhc-aspect">좌석 20매 전면 부착</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">좌석 등받이 시트커버 광고</h5>
                <p class="lhc-desc">차량 1대당 18~22개 좌석 등받이에 부착되어 착석 승객이 이동 내내 1:1로 밀착 주시합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">음성안내 방송</span>
                <strong class="lhc-size">7초 이내 (56자)</strong>
                <span class="lhc-aspect">정류소 도착 전 성우 음성</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">시내버스 정류소 음성안내 방송 광고</h5>
                <p class="lhc-desc">정류소 도착 전 전문 성우 음성으로 브랜드 및 위치가 7초간 자동 송출되어 청각을 완벽 장악합니다.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 03 TAXI & SPECIALIZED OOH GUIDE -->
        <div class="bus-guide-page" id="guideTaxiSpec">
          <div class="lmg-download-banner">
            <div class="ldb-info">
              <span class="ldb-badge">OFFICIAL PDF</span>
              <strong class="ldb-title">광주 택시 래핑 광고 공식 제안서 및 단가표 (PDF)</strong>
              <p class="ldb-meta">법인·개인택시 200대 양측면 래핑 규격 및 운영 가이드 단가표 수록 (PDF)</p>
            </div>
            <a href="/pdf/gaon_taxi_ad.pdf" download="가온엔_택시광고_공식제안서.pdf" class="ldb-btn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              <span>택시광고 제안서 다운로드</span>
            </a>
          </div>

          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">택시 래핑</span>
                <strong class="lhc-size">2,000 × 370 mm</strong>
                <span class="lhc-aspect">24시간 도심 주행</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">법인 · 개인택시 양측면 래핑 광고</h5>
                <p class="lhc-desc">광주 전역 200여 대 차량이 1일 24시간, 일 평균 400km를 주행하며 유흥가, 상업지구, 주택가 구석구석을 누빕니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">택배 탑차</span>
                <strong class="lhc-size">3,000 × 1,500 mm</strong>
                <span class="lhc-aspect">아파트 단지 10시간 체류</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">택배 탑차 3면 와이드 래핑 광고</h5>
                <p class="lhc-desc">광주 5개 구 아파트 단지와 빌라촌 골목길에 매일 10시간 이상 머무르며 거주민 눈높이에서 3면으로 노출됩니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">쇼핑카트</span>
                <strong class="lhc-size">280 × 160 mm</strong>
                <span class="lhc-aspect">3050 주부 60분 동행</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">이마트 · 롯데마트 쇼핑카트 양면 광고</h5>
                <p class="lhc-desc">1,000여 대 쇼핑카트 손잡이 정면에 위치하여 실질적 구매력을 갖춘 3050 주부 고객과 60분간 동행합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge purple">DID 전광판</span>
                <strong class="lhc-size">55 ~ 85" UHD</strong>
                <span class="lhc-aspect">일 100회 이상 연속 송출</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">유스퀘어 터미널 &amp; 지하철 환승역 DID 전광판</h5>
                <p class="lhc-desc">고휘도 UHD 스크린으로 15초 영상이 하루 100회 이상 연속 송출되어 유동 인구의 시선을 압도합니다.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 04 ONLINE MARKETING GUIDE -->
        <div class="bus-guide-page" id="guideOnline">
          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">01 플레이스</span>
                <strong class="lhc-size">지도 1위 세팅</strong>
                <span class="lhc-aspect">로컬 상권 검색 장악</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">네이버 스마트플레이스 1위 세팅 &amp; 관리</h5>
                <p class="lhc-desc">로컬 1위 SEO 알고리즘 8대 평가 요소 세팅, 영수증 리뷰 빌드업, 24시간 네이버 예약/톡톡 연동으로 유입 콜 수를 극대화합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">02 C-Rank 블로그</span>
                <strong class="lhc-size">월 8~12편 칼럼</strong>
                <span class="lhc-aspect">전문 에디터 1:1 맞춤 기획</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">C-Rank 브랜드 블로그 전문 칼럼 발행</h5>
                <p class="lhc-desc">원장님과 대표님의 진료·경영 철학을 바탕으로 월 8~12편 고품격 전문 칼럼을 기획하여 스마트블록과 뷰탭을 안정적으로 점유합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge green">03 맘카페 바이럴</span>
                <strong class="lhc-size">광주 맘스홀릭</strong>
                <span class="lhc-aspect">실유저 후기 침투</span>
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
                <span class="lhc-aspect">초정밀 지역 스폰서드</span>
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
                <span class="lhc-aspect">24시간 리타깃팅</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">구글 검색광고 &amp; 유튜브 GDN 리타깃팅</h5>
                <p class="lhc-desc">구글 검색 키워드 타깃팅과 유튜브/언론사 제휴 배너 네트워크(GDN)를 통해 관심 고객에게 지속적인 리타깃팅을 집행합니다.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 05 VIDEO PRODUCTION GUIDE -->
        <div class="bus-guide-page" id="guideVideo">
          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">브랜드 필름</span>
                <strong class="lhc-size">4K UHD 풀프레임</strong>
                <span class="lhc-aspect">영화급 시네마 영상</span>
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
                <span class="lhc-aspect">알고리즘 바이럴</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">SNS 릴스 · 유튜브 쇼츠 · 틱톡 숏폼</h5>
                <p class="lhc-desc">첫 3초 만에 시선을 사로잡는 빠른 컷 전환과 자막 모션그래픽으로 수만~수십만 뷰의 유기적 알고리즘 도달을 달성합니다.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 06 PRINT & BANNER GUIDE -->
        <div class="bus-guide-page" id="guidePrint">
          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">차량 래핑 시트</span>
                <strong class="lhc-size">LG 하우시스 정품</strong>
                <span class="lhc-aspect">자외선 변색방지 UV코팅</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">차량 전용 최고급 내후성 솔벤 점착 시트</h5>
                <p class="lhc-desc">비바람과 자외선에 1년 이상 색 바램이 없는 내후성 UV 코팅 처리와 제거 시 차량 도장 손상이 없는 그레이 점착제를 사용합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">대형 현수막</span>
                <strong class="lhc-size">지정게시대 / 게릴라</strong>
                <span class="lhc-aspect">구청 추첨 대행</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">구청 지정게시대 &amp; 대형 건물 분양 현수막</h5>
                <p class="lhc-desc">광주 5개 구청 지정게시대 추첨 대행부터 텐트천 대형 현수막, 게릴라 현수막 제작·시공을 신속하게 집행합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge purple">리플렛/브로슈어</span>
                <strong class="lhc-size">A4 3단 접지 / 카탈로그</strong>
                <span class="lhc-aspect">고급 후가공 인쇄</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">병원 안내 리플렛 · 기업 브로슈어 인쇄</h5>
                <p class="lhc-desc">랑데뷰, 스노우 200g 고급 용지 사용 및 부분 에폭시, 금박/은박 후가공으로 최고급 홍보물을 제작 납품합니다.</p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- SOLID MODAL FOOTER -->
      <div class="lux-modal-foot">
        <span class="lmf-info-text">상세 단가표 및 맞춤 노선 믹스는 1:1 온라인 견적 상담을 통해 즉시 제공됩니다.</span>
        <a href="/board/estmate/write.php" class="am-more-btn" style="padding:13px 26px; font-size:14.5px;">
          <span>1:1 맞춤 견적 신청하기</span>
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>
    </div>
  </div>

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
          <a href="/board/estmate/write.php" class="pmb-cta-btn">이와 같은 광고 견적 문의하기 →</a>
        </div>
      </div>
    </div>
  </div>

	<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php";?>

</div>


</body>
</html>
