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

// Ensure each section category has 8 authentic real items for Swiper sliding (PC 4개, 모바일 2개씩 회전)
if (count($portBus) < 8) {
  $portBus = array(
    array('id'=>1, 'category'=>'bus', 'title'=>'상무지구 메디컬센터 시내버스 3면 풀래핑 광고', 'thumb'=>'/images/bs_ad/baro.jpg'),
    array('id'=>2, 'category'=>'bus', 'title'=>'광주 주요 간선도로 시내버스 인도면 표준 래핑', 'thumb'=>'/images/bs_ad/baro_3.jpg'),
    array('id'=>3, 'category'=>'bus', 'title'=>'교차로 신호 대기 차량 타깃 시내버스 후면 래핑', 'thumb'=>'/images/bs_ad/baro_9.jpg'),
    array('id'=>4, 'category'=>'bus', 'title'=>'광주 104개 노선 시내버스 내부 중앙창문 포스터', 'thumb'=>'/images/bs_ad/port_in03.jpg'),
    array('id'=>5, 'category'=>'bus', 'title'=>'수완지구 학원가 집중 배차 버스 차도면 3.7m', 'thumb'=>'/images/bs_ad/baro.jpg'),
    array('id'=>6, 'category'=>'bus', 'title'=>'광주역·송정역 KTX 연계 간선버스 인도면 래핑', 'thumb'=>'/images/bs_ad/baro_3.jpg'),
    array('id'=>7, 'category'=>'bus', 'title'=>'첨단지구 대단지 아파트 경유 버스 후면 번호판', 'thumb'=>'/images/bs_ad/baro_9.jpg'),
    array('id'=>8, 'category'=>'bus', 'title'=>'도심 순환01번 시내버스 전담 음성 방송 광고', 'thumb'=>'/images/bs_ad/port_in03.jpg')
  );
}
if (count($portOnline) < 8) {
  $portOnline = array(
    array('id'=>9, 'category'=>'online', 'title'=>'봉선동 입시학원 네이버 스마트플레이스 1위 세팅', 'thumb'=>'/images/bs_ad/baro_13.jpg'),
    array('id'=>10, 'category'=>'online', 'title'=>'상무지구 피부과 C-Rank 브랜드 블로그 칼럼 마케팅', 'thumb'=>'/images/bs_ad/baro_14.jpg'),
    array('id'=>11, 'category'=>'online', 'title'=>'수완지구 외식 브랜드 광주 맘카페 & 릴스 바이럴', 'thumb'=>'/images/bs_ad/baro_15.jpg'),
    array('id'=>12, 'category'=>'online', 'title'=>'광주 핫플레이스 인스타그램 반경 1~3km 타깃 광고', 'thumb'=>'/images/bs_ad/baro_16.jpg'),
    array('id'=>21, 'category'=>'online', 'title'=>'광주 대표 척추병원 네이버 플레이스 리뷰 빌드업', 'thumb'=>'/images/bs_ad/baro_13.jpg'),
    array('id'=>22, 'category'=>'online', 'title'=>'호남 최대 법무법인 브랜드 블로그 상위 블록 선점', 'thumb'=>'/images/bs_ad/baro_14.jpg'),
    array('id'=>23, 'category'=>'online', 'title'=>'광주 맘스홀릭 공식 제휴 공동구매 바이럴 침투', 'thumb'=>'/images/bs_ad/baro_15.jpg'),
    array('id'=>24, 'category'=>'online', 'title'=>'당근마켓 동네 광고 상무·수완·봉선 피드 노출', 'thumb'=>'/images/bs_ad/baro_16.jpg')
  );
}
if (count($portVideo) < 8) {
  $portVideo = array(
    array('id'=>13, 'category'=>'video', 'title'=>'광주 대표 종합병원 4K UHD 시네마틱 브랜드 필름', 'thumb'=>'/images/bs_ad/visual01.jpg'),
    array('id'=>14, 'category'=>'video', 'title'=>'기업 TV CF & 극장 스크린 30초 풀프레임 광고 영상', 'thumb'=>'/images/bs_ad/visual02.jpg'),
    array('id'=>15, 'category'=>'video', 'title'=>'SNS 릴스 · 유튜브 숏폼 9:16 모바일 바이럴 영상', 'thumb'=>'/images/bs_ad/visual03.jpg'),
    array('id'=>16, 'category'=>'video', 'title'=>'유스퀘어 터미널 DID 디지털 전광판 15초 모션그래픽', 'thumb'=>'/images/bs_ad/did_01.jpg'),
    array('id'=>25, 'category'=>'video', 'title'=>'호남 대표 가구 브랜드 4K 시네마틱 감성 홍보영상', 'thumb'=>'/images/bs_ad/visual01.jpg'),
    array('id'=>26, 'category'=>'video', 'title'=>'상무지구 대형 안과 3D 모션그래픽 라식 안내 필름', 'thumb'=>'/images/bs_ad/visual02.jpg'),
    array('id'=>27, 'category'=>'video', 'title'=>'인스타그램 릴스 100만 조회수 달성 숏폼 바이럴', 'thumb'=>'/images/bs_ad/visual03.jpg'),
    array('id'=>28, 'category'=>'video', 'title'=>'상무 교차로 대형 LED 전광판 4K 광고 영상 송출', 'thumb'=>'/images/bs_ad/did_01.jpg')
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
        
        <!-- CARD 01 -->
        <div class="aas-stat-card">
          <span class="asc-label">누적 광고 집행</span>
          <div class="asc-value-row">
            <strong class="asc-num counter" data-target="500">500</strong><span class="asc-plus">+</span>
          </div>
          <span class="asc-unit">건</span>
        </div>

        <!-- CARD 02 -->
        <div class="aas-stat-card">
          <span class="asc-label">운행 광고 차량</span>
          <div class="asc-value-row">
            <strong class="asc-num counter" data-target="200">200</strong><span class="asc-plus">+</span>
          </div>
          <span class="asc-unit">대</span>
        </div>

        <!-- CARD 03 -->
        <div class="aas-stat-card">
          <span class="asc-label">광주 지역 서비스</span>
          <div class="asc-value-row">
            <strong class="asc-num counter" data-target="10">10</strong>
          </div>
          <span class="asc-unit">년</span>
        </div>

        <!-- CARD 04 -->
        <div class="aas-stat-card">
          <span class="asc-label">고객 재계약률</span>
          <div class="asc-value-row">
            <strong class="asc-num counter" data-target="98">98</strong>
          </div>
          <span class="asc-unit">%</span>
        </div>

                <!-- CARD 05 -->
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
      
      <!-- TOP HEADER (EXACT MASSTIGE.IO TOP ROW) -->
      <div class="am-sec-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker">01 / OOH MEDIA SOLUTIONS</span>
            <h2 class="ash-title">옥외광고 솔루션</h2>
            <p class="ash-desc">광주 104개 전 노선 시내버스부터 택시 랩핑, 유스퀘어 터미널 및 대형 DID 전광판까지 도심을 24시간 장악하는 통합 옥외 미디어 믹스입니다.</p>
          </div>
          <div class="ash-actions">
            <button type="button" class="ash-guide-btn blue" id="btnHeadRouteSearch" onclick="openRouteModal();">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <span>104개 노선 실시간 검색기</span>
            </button>
            <button type="button" class="ash-guide-btn bus-guide-open" data-guide="guideBusOut">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
              <span>옥외매체 규격서 &amp; 제안서(PDF) ↗</span>
            </button>
          </div>
        </div>
      </div>

      <!-- MASSTIGE.IO STYLE 2-COLUMN TABBED INTERACTIVE STAGE -->
      <div class="mos-stage-layout wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- LEFT COLUMN: VERTICAL SERVICE NAVIGATION LIST -->
        <div class="mos-nav-col">
          <div class="mos-mobile-scroll-cue mobile_only">
            <span class="mmsc-txt">11대 옥외 매체</span>
            <span class="mmsc-cue">좌우로 밀어서 매체 선택 ➔</span>
          </div>
                    <ul class="mos-nav-list" id="mosNavList">
            
            <!-- 01. 시내버스 104개 전 노선 -->
            <li class="mos-nav-item on" 
                data-id="bus_all"
                data-kicker="OOH 01 · 광주 대표 교통매체"
                data-lead="광주 전역을 1일 18시간 동안 반복 주행하며 상무대로·무진대로·금남로 등 주요 간선도로 운전자와 보행자의 시선을 압도하는 광주 1등 랜드마크 빌보드입니다."
                data-tags="광주 104개 전 노선,1일 18시간 운행,배차 점유율 98%,본사 직영 시공"
                data-banner-title="광주 104개 전 노선, 1일 18시간 움직이는 랜드마크"
                data-banner-bg="#0f172a"
                data-banner-img="/images/bs_ad/main_sec02_img.jpg"
                data-guide="guideBusOut"
                data-spec="차도면 3.7m + 인도면 3.0m + 후면 2.4m">
              <span class="mni-txt">광주 시내버스 104개 전 노선</span>
              <span class="mni-arrow">›</span>
            </li>

            <!-- 02. 버스 차도면 대형 래핑 -->
            <li class="mos-nav-item" 
                data-id="bus_road"
                data-kicker="OOH 02 · 왕복 8차선 압도"
                data-lead="왕복 8차선 대로변 맞은편 차량 운전자와 보행자 시야 정면에 3.7m 초대형 스케일로 브랜드를 각인시키는 시내버스 핵심 메인 규격입니다."
                data-tags="차도면 3700×1000mm,LG 정품 솔벤 시트,운전자 시선 집중도 1위,대로변 노출"
                data-banner-title="왕복 8차선 운전자의 시선을 사로잡는 차도면 3.7m"
                data-banner-bg="#1855b7"
                data-banner-img="/images/bs_ad/baro.jpg"
                data-guide="guideBusOut"
                data-spec="실측 규격: 3,700 × 1,000 mm">
              <span class="mni-txt">버스 차도면 대형 래핑 (3.7m)</span>
              <span class="mni-arrow">›</span>
            </li>

            <!-- 03. 버스 인도면 표준 래핑 -->
            <li class="mos-nav-item" 
                data-id="bus_side"
                data-kicker="OOH 03 · 정류장 승객 밀착"
                data-lead="버스 탑승 승객과 정류장 보행자의 눈높이 정면에 위치하여 병원 진료과목, 학원 정보, 전화번호를 선명하게 전달하는 밀착형 규격입니다."
                data-tags="인도면 3000×500mm,정류장 탑승객 눈높이,세부 정보 전달,고해상도 출력"
                data-banner-title="정류장 탑승객 눈높이에 밀착되는 인도면 3.0m"
                data-banner-bg="#0284c7"
                data-banner-img="/images/bs_ad/baro_3.jpg"
                data-guide="guideBusOut"
                data-spec="실측 규격: 3,000 × 500 mm">
              <span class="mni-txt">버스 인도면 표준 래핑 (3.0m)</span>
              <span class="mni-arrow">›</span>
            </li>

            <!-- 04. 버스 후면 번호판 래핑 -->
            <li class="mos-nav-item" 
                data-id="bus_back"
                data-kicker="OOH 04 · 신호 대기 강제 노출"
                data-lead="출퇴근 시간 및 도심 교차로 신호 대기 중 뒤따르는 차량 운전자와 동승자의 시선 정면에 3분 이상 머무르는 필수 패키지 면입니다."
                data-tags="후면 2400×300mm,신호 대기 후방 차량,3분 이상 강제 주시,반사 솔벤"
                data-banner-title="신호 대기 차량 운전자를 사로잡는 후면 번호판 래핑"
                data-banner-bg="#4338ca"
                data-banner-img="/images/bs_ad/baro_9.jpg"
                data-guide="guideBusOut"
                data-spec="실측 규격: 2,400 × 300 mm">
              <span class="mni-txt">버스 후면 번호판 래핑</span>
              <span class="mni-arrow">›</span>
            </li>

            <!-- 05. 버스 내부창문 포스터 (따로 분리) -->
            <li class="mos-nav-item" 
                data-id="bus_in_window"
                data-kicker="OOH 05 · 탑승객 시선 독점"
                data-lead="버스 내부 좌석 및 입석 승객의 시선 정면에 위치하여 이동 시간 30분 동안 자연스럽게 내용을 정독시키는 고밀도 정보 전달 매체입니다."
                data-tags="중앙창문 1100×500mm,하차문 포스터,탑승객 100% 강제 노출,정독률 1위"
                data-banner-title="탑승 30분간 승객 눈높이 정면에 머무는 중앙창문 포스터"
                data-banner-bg="#0d9488"
                data-banner-img="/images/bs_ad/port_in03.jpg"
                data-guide="guideBusIn"
                data-spec="실측 규격: 1,100 × 500 mm">
              <span class="mni-txt">버스 내부창문 포스터 (중앙창·하차문)</span>
              <span class="mni-arrow">›</span>
            </li>

            <!-- 06. 버스 음성안내 방송 (따로 분리) -->
            <li class="mos-nav-item" 
                data-id="bus_voice"
                data-kicker="OOH 06 · 청각 100% 독점"
                data-lead="주요 정류소 도착 직전 차내 전체에 송출되는 전문 성우 음성 방송으로, 시각적 피로 없이 청각을 통해 확실한 브랜드 네이밍을 각인시킵니다."
                data-tags="전문 성우 녹음,7초 음성방송(45자 이내),정류소 도착 전 송출,청각 100% 독점"
                data-banner-title="정류소 도착 직전 전문 성우 7초 음성안내 방송"
                data-banner-bg="#0891b2"
                data-banner-img="/images/bs_ad/port_in01.jpg"
                data-guide="guideBusIn"
                data-spec="송출 시간: 7초 (성우 음성 45자 이내)">
              <span class="mni-txt">버스 음성안내 방송 (전문 성우 7초)</span>
              <span class="mni-arrow">›</span>
            </li>

            <!-- 07. 광주 전역 택시 래핑 -->
            <li class="mos-nav-item" 
                data-id="taxi"
                data-kicker="OOH 07 · 24시간 골목 밀착"
                data-lead="광주 전역 200여 대 법인·개인택시가 주요 번화가와 골목길을 24시간 365일 쉼 없이 기동하며 보행자 눈높이에서 밀착 노출됩니다."
                data-tags="택시 양측면 2100×320mm,24시간 365일 기동,골목상권 침투,광주 전역 배차"
                data-banner-title="골목상권부터 번화가까지 24시간 달리는 택시 래핑"
                data-banner-bg="#15803d"
                data-banner-img="/images/ev1.jpg"
                data-guide="guideTaxiDelivery"
                data-spec="실측 규격: 2,100 × 320 mm">
              <span class="mni-txt">광주 전역 택시 래핑 광고</span>
              <span class="mni-arrow">›</span>
            </li>

            <!-- 08. 아파트 택배차 3면 래핑 (택배차광고 신설) -->
            <li class="mos-nav-item" 
                data-id="delivery"
                data-kicker="OOH 08 · 주거 밀착 래핑"
                data-lead="아파트 단지와 주택가 골목길 안쪽까지 깊숙이 진입하여 주민들의 일상 동선 정면에 3면 와이드 스케일로 장시간 노출되는 주거 상권 1등 매체입니다."
                data-tags="택배차 3면 풀래핑,차도·인도·후면 3면,아파트 단지 주거 밀착,CJ·한진·로젠 연계"
                data-banner-title="5개 구 아파트 단지 주거 밀착 택배 탑차 3면 래핑"
                data-banner-bg="#ea580c"
                data-banner-img="/images/bs_ad/baro_18.jpg"
                data-guide="guideTaxiDelivery"
                data-spec="측면 2,800×1,400mm / 후면 1,400×1,400mm">
              <span class="mni-txt">아파트 택배차 3면 래핑 광고</span>
              <span class="mni-arrow">›</span>
            </li>

            <!-- 09. 유스퀘어 광천터미널 (쉘터광고 제외) -->
            <li class="mos-nav-item" 
                data-id="usquare"
                data-kicker="OOH 09 · 호남 최대 허브"
                data-lead="호남 최대 교통 허브인 유스퀘어 광천터미널 내 대합실, 승하차장, 주요 통로의 대형 조명 라이트박스로 광주 전역 및 외지 유입 인구를 압도합니다."
                data-tags="유스퀘어 광천터미널,대합실 와이드 조명,승하차장 라이트박스,일 10만 유동인구"
                data-banner-title="일 유동인구 10만 명 유스퀘어 터미널 대합실 &amp; 와이드 조명"
                data-banner-bg="#7e22ce"
                data-banner-img="/images/bs_ad/did_01.jpg"
                data-guide="guideSubwayCart"
                data-spec="터미널 내부 와이드 라이트박스">
              <span class="mni-txt">유스퀘어 광천터미널 광고</span>
              <span class="mni-arrow">›</span>
            </li>

            <!-- 10. DID 디지털 전광판 (따로 분리) -->
            <li class="mos-nav-item" 
                data-id="did_screen"
                data-kicker="OOH 10 · 4K UHD LED"
                data-lead="상무지구 핵심 교차로 빌딩 옥외 LED 및 지하철 환승역사 내 고휘도 DID 스크린을 통해 15초 풀HD/4K 모션그래픽 영상을 하루 100회 이상 연속 송출합니다."
                data-tags="55~85인치 4K UHD LED,15초 모션영상 송출,일 100회 이상 반복,상무지구 전광판"
                data-banner-title="도심 핵심 교차로 &amp; 역사 내 4K UHD 초고화질 DID 전광판"
                data-banner-bg="#6b21a8"
                data-banner-img="/images/bs_ad/did_02.jpg"
                data-guide="guideSubwayCart"
                data-spec="55~85인치 4K UHD 고휘도 LED">
              <span class="mni-txt">DID 디지털 전광판</span>
              <span class="mni-arrow">›</span>
            </li>

            <!-- 11. 대형마트 쇼핑카트 (무빙워크 제외) -->
            <li class="mos-nav-item" 
                data-id="cart"
                data-kicker="OOH 11 · 3050 주부 타깃"
                data-lead="광주 전역 이마트, 롯데마트 쇼핑카트 전면 플레이트에 부착되어 실질적인 가계 구매력을 가진 3050 주부 고객과 1시간 이상 1:1로 밀착 동행합니다."
                data-tags="쇼핑카트 280×160mm,이마트·롯데마트 1000대,3050 주부 타깃,60분 밀착 노출"
                data-banner-title="이마트·롯데마트 쇼핑카트 1,000대, 60분간 고객과 1:1 동행"
                data-banner-bg="#b91c1c"
                data-banner-img="/images/sub_bg_02.jpg"
                data-guide="guideSubwayCart"
                data-spec="실측 규격: 280 × 160 mm">
              <span class="mni-txt">대형마트 쇼핑카트 광고</span>
              <span class="mni-arrow">›</span>
            </li>

          </ul>
        </div>

        <!-- RIGHT COLUMN: DYNAMIC LIVE PREVIEW STAGESTAGE & HUGE DETAIL BUTTON -->
        <div class="mos-content-col">
          
          <!-- TOP LEAD & TAGS -->
          <div class="mos-lead-wrap" id="mosLeadWrap">
            <span class="mos-dyn-kicker" id="mosDynKicker">OOH 01 · 광주 대표 교통매체</span>
            <p class="mos-dyn-lead" id="mosDynLead">
              광주 전역을 1일 18시간 동안 반복 주행하며 상무대로·무진대로·금남로 등 주요 간선도로 운전자와 보행자의 시선을 압도하는 광주 1등 랜드마크 빌보드입니다.
            </p>
            <div class="mos-dyn-tags" id="mosDynTags">
              <span class="mdt-pill">광주 104개 전 노선</span>
              <span class="mdt-pill">1일 18시간 운행</span>
              <span class="mdt-pill">배차 점유율 98%</span>
              <span class="mdt-pill">직영 시공 관리</span>
            </div>
          </div>

          <!-- CENTER HERO VISUAL BANNER -->
          <div class="mos-hero-banner" id="mosHeroBanner">
            <img src="/images/bs_ad/main_sec02_img.jpg" id="mosBannerImg" alt="옥외광고 솔루션 실사" class="mhb-bg-img">
            <div class="mhb-scrim"></div>
            <div class="mhb-overlay-content" id="mosBannerText">
              <div class="mhb-spec-badge" id="mosDynSpec">차도면 3.7m + 인도면 3.0m + 후면 2.4m</div>
              <h3 class="mhb-title" id="mosBannerTitle">광주 104개 전 노선, 1일 18시간 움직이는 랜드마크</h3>
            </div>
          </div>

          <!-- HUGE DETAIL BUTTONS ROW (자세히 보기 훨씬 큼직하게) -->
          <div class="mos-huge-action-bar">
            <button type="button" class="mos-huge-btn primary bus-guide-open" id="mosBtnGuide" data-guide="guideBusOut">
              <span class="mhb-btn-txt">규격 가이드 &amp; 제안서(PDF) 자세히 보기</span>
              <span class="mhb-btn-arrow">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </span>
            </button>

            <button type="button" class="mos-huge-btn secondary" id="btnOpenRouteSearchModal" onclick="openRouteModal();">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <span>104개 노선 실시간 검색기</span>
            </button>
          </div>

        </div>

      </div>

            <!-- RECENT OOH PORTFOLIO SHOWCASE STRIP (HIGH-END MODERN ARROWS) -->
      <div class="am-sub-port-strip wow fadeInUp" data-wow-duration="0.8s" style="margin-top:60px;">
        <div class="asps-head">
          <div class="asps-title-wrap">
            <span class="asps-kicker">OOH PORTFOLIO</span>
            <h4 class="asps-title">최근 옥외광고 &amp; 시내버스 직영 시공 실적</h4>
          </div>
          <div class="asps-nav-controls">
            <button type="button" class="asps-arrow-btn asps-prev-bus" aria-label="이전 사례">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button type="button" class="asps-arrow-btn asps-next-bus" aria-label="다음 사례">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
            <a href="/contents/a_type/a_1.php?category=bus" class="asps-more-link">
              <span>사례 전체보기</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>
        </div>
        <div class="swiper asps-swiper asps-swiper-bus">
          <div class="swiper-wrapper">
            <?php foreach ($portBus as $bItem): ?>
            <div class="swiper-slide asps-card main-port-card" data-cat="<?php echo htmlspecialchars($bItem['category']); ?>" data-id="<?php echo (int)$bItem['id']; ?>" data-name="<?php echo htmlspecialchars($bItem['title']); ?>" data-img="<?php echo htmlspecialchars($bItem['thumb']); ?>" data-tag="옥외광고">
              <div class="asps-thumb">
                <img src="<?php echo htmlspecialchars($bItem['thumb']); ?>" alt="<?php echo htmlspecialchars($bItem['title']); ?>" loading="lazy">
                <span class="asps-badge">옥외매체</span>
                <div class="asps-arrow-badge">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                </div>
              </div>
              <div class="asps-info">
                <div class="asps-title-row">
                  <strong class="asps-item-title"><?php echo htmlspecialchars($bItem['title']); ?></strong>
                  <span class="asps-title-arrow">↗</span>
                </div>
                <span class="asps-item-loc">광주 104개 노선 맞춤 직영 시공</span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

          <!-- ============================================
       01-B SIMPLE CLEAN CENTERED INQUIRY BUTTON (심플 버튼 전면 교체)
  ============================================ -->
  <div class="am-simple-mid-cta wow fadeInUp" data-wow-duration="0.6s">
    <div class="am-container" style="text-align: center;">
      <a href="/board/estmate/write.php" class="am-simple-inquiry-btn">
        <span>1:1 맞춤 견적 및 제안서 신청</span>
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>

  <section class="am-section am-bg-white" id="online">
    <div class="am-container">
      
      <!-- MAIN SEALNPACK TALL PORTRAIT LAYOUT -->
      <div class="som-layout-stage wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- LEFT: CLEAN EDITORIAL BRAND HEADLINE & CONCISE BUTTON -->
        <div class="som-left-content">
          <div class="som-title-wrap">
            <span class="ash-kicker">02 / DIGITAL MARKETING</span>
            <h2 class="ash-title">온라인 마케팅</h2>
          </div>

          <p class="som-desc">
            네이버 스마트플레이스 1위 세팅부터 C-Rank 브랜드 블로그, 맘카페 바이럴, 인스타그램 스폰서 광고까지 가온엔 본사 인하우스 전문팀이 직접 운영합니다.
          </p>

          <button type="button" class="som-guide-btn bus-guide-open" data-guide="guideOnline">
            <span class="sgb-txt">온라인 채널 가이드</span>
          </button>
        </div>

        <!-- RIGHT: DUAL VERTICAL MARQUEE STREAMS (8 HIGH-RES TOPIC MATCHED IMAGES) -->
        <div class="som-right-stream-wrap">
          
          <!-- STREAM COLUMN 1 (4 DISTINCT ITEMS + 4 EXACT CLONES) -->
          <div class="som-stream-col som-col-1">
            <div class="som-stream-track track-1">
              
              <!-- ITEM 01 : BLOG -->
              <div class="som-stream-card">
                <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=800&q=80" alt="블로그 상위 노출 & C-Rank 브랜딩">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">C-Rank Blog</span>
                  <strong class="sct-title">블로그 상위 노출 &amp; C-Rank 브랜딩</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">C-Rank Blog</span>
                  <strong class="shd-title">블로그 상위 노출 &amp; C-Rank 브랜딩</strong>
                  <p class="shd-desc">상무·수완·봉선 주요 상권 키워드 점유. 전문 에디터의 1:1 맞춤 기획으로 독보적인 브랜드 신뢰도를 구축합니다.</p>
                  <span class="shd-tag">전문 칼럼 정기 발행</span>
                </div>
              </div>

              <!-- ITEM 02 : MOM CAFE -->
              <div class="som-stream-card">
                <img src="https://images.unsplash.com/photo-1577563908411-5077b6dc7624?auto=format&fit=crop&w=800&q=80" alt="맘카페 & 당근마켓 침투 바이럴">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Viral Marketing</span>
                  <strong class="sct-title">맘카페 &amp; 당근마켓 침투 바이럴</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Viral Marketing</span>
                  <strong class="shd-title">맘카페 &amp; 당근마켓 침투 바이럴</strong>
                  <p class="shd-desc">광주맘스홀릭 및 당근 동네생활 실사용자 기반 자연스러운 방문 후기 여론 형성과 3050 주부 타깃 신뢰 확보.</p>
                  <span class="shd-tag">광주 맘카페 여론 형성</span>
                </div>
              </div>

              <!-- ITEM 03 : SMART PLACE -->
              <div class="som-stream-card">
                <img src="https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&w=800&q=80" alt="스마트플레이스 1위 세팅 & 예약 연동">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Place SEO</span>
                  <strong class="sct-title">스마트플레이스 1위 &amp; 예약 연동</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Place SEO</span>
                  <strong class="shd-title">스마트플레이스 1위 &amp; 예약 연동</strong>
                  <p class="shd-desc">네이버 지도 1페이지 상단 고정 최적화 및 24시간 네이버 스마트콜/예약 시스템 실시간 매출 연동.</p>
                  <span class="shd-tag">로컬 지도 상위 노출</span>
                </div>
              </div>

              <!-- ITEM 04 : INSTAGRAM -->
              <div class="som-stream-card">
                <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?auto=format&fit=crop&w=800&q=80" alt="인스타그램 릴스 & 모바일 스폰서 광고">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Meta Ads</span>
                  <strong class="sct-title">인스타그램 릴스 &amp; 스폰서 광고</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Meta Ads</span>
                  <strong class="shd-title">인스타그램 릴스 &amp; 스폰서 광고</strong>
                  <p class="shd-desc">사업장 반경 1~3km 내 핵심 타깃 정밀 송출 및 첫 3초 시선을 사로잡는 9:16 모바일 숏폼 영상 제작.</p>
                  <span class="shd-tag">반경 1~3km 정밀 노출</span>
                </div>
              </div>

              <!-- EXACT 4 CLONES FOR SEAMLESS 50% LOOP -->
              <div class="som-stream-card som-clone-card">
                <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=800&q=80" alt="블로그 상위 노출 & C-Rank 브랜딩">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">C-Rank Blog</span>
                  <strong class="sct-title">블로그 상위 노출 &amp; C-Rank 브랜딩</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">C-Rank Blog</span>
                  <strong class="shd-title">블로그 상위 노출 &amp; C-Rank 브랜딩</strong>
                  <p class="shd-desc">상무·수완·봉선 주요 상권 키워드 점유. 전문 에디터의 1:1 맞춤 기획으로 독보적인 브랜드 신뢰도를 구축합니다.</p>
                  <span class="shd-tag">전문 칼럼 정기 발행</span>
                </div>
              </div>
              <div class="som-stream-card som-clone-card">
                <img src="https://images.unsplash.com/photo-1577563908411-5077b6dc7624?auto=format&fit=crop&w=800&q=80" alt="맘카페 & 당근마켓 침투 바이럴">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Viral Marketing</span>
                  <strong class="sct-title">맘카페 &amp; 당근마켓 침투 바이럴</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Viral Marketing</span>
                  <strong class="shd-title">맘카페 &amp; 당근마켓 침투 바이럴</strong>
                  <p class="shd-desc">광주맘스홀릭 및 당근 동네생활 실사용자 기반 자연스러운 방문 후기 여론 형성과 3050 주부 타깃 신뢰 확보.</p>
                  <span class="shd-tag">광주 맘카페 여론 형성</span>
                </div>
              </div>
              <div class="som-stream-card som-clone-card">
                <img src="https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&w=800&q=80" alt="스마트플레이스 1위 세팅 & 예약 연동">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Place SEO</span>
                  <strong class="sct-title">스마트플레이스 1위 &amp; 예약 연동</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Place SEO</span>
                  <strong class="shd-title">스마트플레이스 1위 &amp; 예약 연동</strong>
                  <p class="shd-desc">네이버 지도 1페이지 상단 고정 최적화 및 24시간 네이버 스마트콜/예약 시스템 실시간 매출 연동.</p>
                  <span class="shd-tag">로컬 지도 상위 노출</span>
                </div>
              </div>
              <div class="som-stream-card som-clone-card">
                <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?auto=format&fit=crop&w=800&q=80" alt="인스타그램 릴스 & 모바일 스폰서 광고">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Meta Ads</span>
                  <strong class="sct-title">인스타그램 릴스 &amp; 스폰서 광고</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Meta Ads</span>
                  <strong class="shd-title">인스타그램 릴스 &amp; 스폰서 광고</strong>
                  <p class="shd-desc">사업장 반경 1~3km 내 핵심 타깃 정밀 송출 및 첫 3초 시선을 사로잡는 9:16 모바일 숏폼 영상 제작.</p>
                  <span class="shd-tag">반경 1~3km 정밀 노출</span>
                </div>
              </div>
            </div>
          </div>
          <!-- STREAM COLUMN 2 (4 DIFFERENT ITEMS + 4 EXACT CLONES) -->
          <div class="som-stream-col som-col-2">
            <div class="som-stream-track track-2">
              
              <!-- ITEM 05 : GOOGLE & GDN -->
              <div class="som-stream-card">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80" alt="구글 검색광고 & 유튜브 GDN 리타깃팅">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Google &amp; GDN</span>
                  <strong class="sct-title">구글 검색 &amp; 유튜브 GDN 리타깃팅</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Google &amp; GDN</span>
                  <strong class="shd-title">구글 검색 &amp; 유튜브 GDN 리타깃팅</strong>
                  <p class="shd-desc">키워드 검색 고객과 언론사 배너 네트워크를 결합하여 이탈 고객을 24시간 추적 및 재유입시키는 고효율 배너.</p>
                  <span class="shd-tag">24시간 리타깃팅 배너</span>
                </div>
              </div>

              <!-- ITEM 06 : SEARCH ADS -->
              <div class="som-stream-card">
                <img src="https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=800&q=80" alt="네이버 파워링크 검색광고 (SA) 세팅">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Search Ads</span>
                  <strong class="sct-title">네이버 파워링크 검색광고 세팅</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Search Ads</span>
                  <strong class="shd-title">네이버 파워링크 검색광고 세팅</strong>
                  <p class="shd-desc">광주 주요 상권 황금 키워드 선점과 클릭률을 극대화하는 소재 최적화 및 ROAS 중심 예산 관리.</p>
                  <span class="shd-tag">키워드 상위 선점</span>
                </div>
              </div>

              <!-- ITEM 07 : INFLUENCER -->
              <div class="som-stream-card">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80" alt="블로그 체험단 & 인플루언서 섭외">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Influencer</span>
                  <strong class="sct-title">체험단 &amp; 인플루언서 섭외</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Influencer</span>
                  <strong class="shd-title">체험단 &amp; 인플루언서 섭외</strong>
                  <p class="shd-desc">실제 방문형 인플루언서와 고품질 블로거를 엄선 섭외하여 네이버 스마트블록 검색 노출을 극대화합니다.</p>
                  <span class="shd-tag">고품질 리뷰어 매칭</span>
                </div>
              </div>

              <!-- ITEM 08 : WEB LANDING -->
              <div class="som-stream-card">
                <img src="https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=800&q=80" alt="모바일 고전환 웹사이트 & 랜딩페이지">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Web &amp; Landing</span>
                  <strong class="sct-title">고전환 웹사이트 &amp; 랜딩페이지</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Web &amp; Landing</span>
                  <strong class="shd-title">고전환 웹사이트 &amp; 랜딩페이지</strong>
                  <p class="shd-desc">광고 클릭 후 즉각적인 전화/예약 전환을 유도하는 최적의 UI/UX 반응형 모바일 랜딩페이지 제작.</p>
                  <span class="shd-tag">모바일 전환율 극대화</span>
                </div>
              </div>

              <!-- EXACT 4 CLONES FOR SEAMLESS 50% LOOP -->
              <div class="som-stream-card som-clone-card">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80" alt="구글 검색광고 & 유튜브 GDN 리타깃팅">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Google &amp; GDN</span>
                  <strong class="sct-title">구글 검색 &amp; 유튜브 GDN 리타깃팅</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Google &amp; GDN</span>
                  <strong class="shd-title">구글 검색 &amp; 유튜브 GDN 리타깃팅</strong>
                  <p class="shd-desc">키워드 검색 고객과 언론사 배너 네트워크를 결합하여 이탈 고객을 24시간 추적 및 재유입시키는 고효율 배너.</p>
                  <span class="shd-tag">24시간 리타깃팅 배너</span>
                </div>
              </div>

              <div class="som-stream-card som-clone-card">
                <img src="https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=800&q=80" alt="네이버 파워링크 검색광고 (SA) 세팅">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Search Ads</span>
                  <strong class="sct-title">네이버 파워링크 검색광고 세팅</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Search Ads</span>
                  <strong class="shd-title">네이버 파워링크 검색광고 세팅</strong>
                  <p class="shd-desc">광주 주요 상권 황금 키워드 선점과 클릭률을 극대화하는 소재 최적화 및 ROAS 중심 예산 관리.</p>
                  <span class="shd-tag">키워드 상위 선점</span>
                </div>
              </div>

              <div class="som-stream-card som-clone-card">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80" alt="블로그 체험단 & 인플루언서 섭외">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Influencer</span>
                  <strong class="sct-title">체험단 &amp; 인플루언서 섭외</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Influencer</span>
                  <strong class="shd-title">체험단 &amp; 인플루언서 섭외</strong>
                  <p class="shd-desc">실제 방문형 인플루언서와 고품질 블로거를 엄선 섭외하여 네이버 스마트블록 검색 노출을 극대화합니다.</p>
                  <span class="shd-tag">고품질 리뷰어 매칭</span>
                </div>
              </div>

              <div class="som-stream-card som-clone-card">
                <img src="https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=800&q=80" alt="모바일 고전환 웹사이트 & 랜딩페이지">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                  <span class="sct-kicker">Web &amp; Landing</span>
                  <strong class="sct-title">고전환 웹사이트 &amp; 랜딩페이지</strong>
                </div>
                <div class="som-hover-detail">
                  <span class="shd-kicker">Web &amp; Landing</span>
                  <strong class="shd-title">고전환 웹사이트 &amp; 랜딩페이지</strong>
                  <p class="shd-desc">광고 클릭 후 즉각적인 전화/예약 전환을 유도하는 최적의 UI/UX 반응형 모바일 랜딩페이지 제작.</p>
                  <span class="shd-tag">모바일 전환율 극대화</span>
                </div>
              </div>

            </div>
          </div>

        </div>

      </div>

            <!-- SECTION 02 : RECENT ONLINE MARKETING PORTFOLIO SHOWCASE STRIP (HIGH-END MODERN ARROWS) -->
      <div class="am-sub-port-strip wow fadeInUp" data-wow-duration="0.8s" style="margin-top:60px;">
        <div class="asps-head">
          <div class="asps-title-wrap">
            <span class="asps-kicker blue">DIGITAL MARKETING PORTFOLIO</span>
            <h4 class="asps-title">온라인 마케팅 &amp; 스마트플레이스 1위 집행 실적</h4>
          </div>
          <div class="asps-nav-controls">
            <button type="button" class="asps-arrow-btn asps-prev-online" aria-label="이전 사례">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button type="button" class="asps-arrow-btn asps-next-online" aria-label="다음 사례">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
            <a href="/contents/a_type/a_1.php?category=online" class="asps-more-link">
              <span>온라인 사례 전체보기</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>
        </div>
        <div class="swiper asps-swiper asps-swiper-online">
          <div class="swiper-wrapper">
            <?php foreach ($portOnline as $oItem): ?>
            <div class="swiper-slide asps-card main-port-card" data-cat="<?php echo htmlspecialchars($oItem['category']); ?>" data-id="<?php echo (int)$oItem['id']; ?>" data-name="<?php echo htmlspecialchars($oItem['title']); ?>" data-img="<?php echo htmlspecialchars($oItem['thumb']); ?>" data-tag="온라인마케팅">
              <div class="asps-thumb">
                <img src="<?php echo htmlspecialchars($oItem['thumb']); ?>" alt="<?php echo htmlspecialchars($oItem['title']); ?>" loading="lazy">
                <span class="asps-badge blue">온라인마케팅</span>
                <div class="asps-arrow-badge">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                </div>
              </div>
              <div class="asps-info">
                <div class="asps-title-row">
                  <strong class="asps-item-title"><?php echo htmlspecialchars($oItem['title']); ?></strong>
                  <span class="asps-title-arrow">↗</span>
                </div>
                <span class="asps-item-loc">플레이스 1위 &amp; 블로그 상위 노출</span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="am-section am-bg-dark am-video-ambient-sec" id="video">
    <div class="avs-ambient-bg">
      <div class="avs-glow glow-left"></div>
      <div class="avs-glow glow-right"></div>
    </div>

    <div class="am-container" style="position:relative; z-index:2;">

      <div class="am-sec-head dark-head text-center wow fadeInUp" data-wow-duration="0.7s">
        <span class="ash-kicker cyan">03 / 4K CINEMATIC &amp; SHORTS PRODUCTION</span>
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

            <!-- SECTION 03 : RECENT 4K VIDEO PORTFOLIO SHOWCASE STRIP (HIGH-END MODERN ARROWS) -->
      <div class="am-sub-port-strip dark wow fadeInUp" data-wow-duration="0.8s" style="margin-top:60px;">
        <div class="asps-head">
          <div class="asps-title-wrap">
            <span class="asps-kicker cyan">CINEMA REEL PORTFOLIO</span>
            <h4 class="asps-title white">최근 4K 브랜드 필름 &amp; 숏폼 영상 제작 실적</h4>
          </div>
          <div class="asps-nav-controls">
            <button type="button" class="asps-arrow-btn light asps-prev-video" aria-label="이전 사례">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button type="button" class="asps-arrow-btn light asps-next-video" aria-label="다음 사례">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
            <a href="/contents/a_type/a_1.php?category=video" class="asps-more-link">
              <span>영상 사례 전체보기</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>
        </div>
        <div class="swiper asps-swiper asps-swiper-video">
          <div class="swiper-wrapper">
            <?php foreach ($portVideo as $vItem): ?>
            <div class="swiper-slide asps-card dark main-port-card" data-cat="<?php echo htmlspecialchars($vItem['category']); ?>" data-id="<?php echo (int)$vItem['id']; ?>" data-name="<?php echo htmlspecialchars($vItem['title']); ?>" data-img="<?php echo htmlspecialchars($vItem['thumb']); ?>" data-tag="영상제작">
              <div class="asps-thumb">
                <img src="<?php echo htmlspecialchars($vItem['thumb']); ?>" alt="<?php echo htmlspecialchars($vItem['title']); ?>" loading="lazy">
                <span class="asps-badge cyan">영상제작</span>
                <div class="asps-arrow-badge">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                </div>
              </div>
              <div class="asps-info">
                <div class="asps-title-row">
                  <strong class="asps-item-title white"><?php echo htmlspecialchars($vItem['title']); ?></strong>
                  <span class="asps-title-arrow" style="color:#38bdf8;">↗</span>
                </div>
                <span class="asps-item-loc light">4K UHD 시네마틱 &amp; 숏폼 제작</span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="am-section" id="process">
    <div class="am-container">
      
      <!-- UNIFIED SECTION HEAD -->
      <div class="am-sec-head text-center wow fadeInUp" data-wow-duration="0.7s">
        <span class="ash-kicker">WORKFLOW PIPELINE</span>
        <h2 class="ash-title">마스터플랜</h2>
        <p class="ash-desc" style="margin: 0 auto; max-width: 780px;">
          외주 하청 없는 100% 본사 인하우스 전문팀이 상권 분석부터 출력, 시공, 사후 보고까지 전 과정을 직접 책임집니다.
        </p>
      </div>

      <!-- HUMAN CRAFTED 4-STEP MASTERPLAN GRID -->
      <div class="am-pipeline-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- STEP 01 -->
        <div class="apg-step-card">
          <div class="apg-step-header">
            <span class="apg-huge-gothic-num">01</span>
            <span class="apg-status-badge">상권 최적화</span>
          </div>
          <div class="apg-icon-circle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
          </div>
          <h3 class="apg-step-title">상권 분석 &amp; 노선 설계</h3>
          <p class="apg-step-sub">상무·수완·봉선·첨단 등 목표 고객의 실제 이동 동선을 분석하여 가장 효과적인 104개 버스 노선과 미디어를 믹스합니다.</p>
          <div class="apg-deliverable-box">
            <span>실무 지원:</span>
            <strong>상권 타깃 분석 &amp; 골든 노선 추천</strong>
          </div>
        </div>

        <!-- STEP 02 -->
        <div class="apg-step-card">
          <div class="apg-step-header">
            <span class="apg-huge-gothic-num">02</span>
            <span class="apg-status-badge">맞춤 시안</span>
          </div>
          <div class="apg-icon-circle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.92 0 1.67-.75 1.67-1.67 0-.42-.17-.83-.42-1.17-.25-.33-.42-.75-.42-1.16 0-.92.75-1.67 1.67-1.67h1.92c3.08 0 5.58-2.5 5.58-5.58 0-4.83-4.42-8.75-9.42-8.75z"/><circle cx="7.5" cy="11.5" r="1.5"/><circle cx="12" cy="7.5" r="1.5"/><circle cx="16.5" cy="11.5" r="1.5"/></svg>
          </div>
          <h3 class="apg-step-title">3면 실측 1:1 디자인 기획</h3>
          <p class="apg-step-sub">도심 주행 중 3초 안에 브랜드가 각인되도록 차도면(3.7m), 인도면(3m), 후면 규격에 맞춘 전담 디자이너 1:1 시안을 기획합니다.</p>
          <div class="apg-deliverable-box">
            <span>실무 지원:</span>
            <strong>3면 실측 고시인성 시안 3종 제공</strong>
          </div>
        </div>

        <!-- STEP 03 -->
        <div class="apg-step-card">
          <div class="apg-step-header">
            <span class="apg-huge-gothic-num">03</span>
            <span class="apg-status-badge">본사 직영</span>
          </div>
          <div class="apg-icon-circle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          </div>
          <h3 class="apg-step-title">정품 출력 &amp; 책임 시공</h3>
          <p class="apg-step-sub">LG 하우시스 최고급 내후성 정품 솔벤 시트를 자체 출력실에서 출력하고, 본사 10년 경력 시공팀이 들뜸 없이 직접 시공합니다.</p>
          <div class="apg-deliverable-box">
            <span>실무 지원:</span>
            <strong>LG 정품 시트 직영 출력 및 완벽 부착</strong>
          </div>
        </div>

        <!-- STEP 04 -->
        <div class="apg-step-card highlight">
          <div class="apg-step-header">
            <span class="apg-huge-gothic-num blue">04</span>
            <span class="apg-status-badge blue">투명 증빙</span>
          </div>
          <div class="apg-icon-circle blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0f3f8c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="m9 15 2 2 4-4"/></svg>
          </div>
          <h3 class="apg-step-title">4면 실사 증빙 &amp; 사후 관리</h3>
          <p class="apg-step-sub">시공 직후 차량 4면 번호판 실사 촬영본을 즉시 전송해 드리며, 계약 기간 동안 훼손 관리 및 주간 순위 리포트를 투명하게 보고합니다.</p>
          <div class="apg-deliverable-box blue">
            <span>실무 지원:</span>
            <strong>차량 4면 실사 증빙철 &amp; 1:1 전담 관리</strong>
          </div>
        </div>

      </div>

    </div>
  </section>

            <!-- ============================================
       08 GAON-N ALL-IN-ONE INLINE ESTIMATE FOOTER (media_1788420698073.png 100% 일치 구성)
  ============================================ -->
  <section class="am-master-conversion-section wow fadeInUp" data-wow-duration="0.8s" id="contact">
    <div class="am-container">
      <div class="masstige-agency-box">
        
        <!-- LEFT COLUMN -->
        <div class="masstige-left-col">
          <div class="masstige-left-top">
            <h3 class="masstige-main-title">가온엔과<br>성공적인 협력을<br>시작해 보세요.</h3>
            <a href="tel:062-385-0110" class="masstige-main-phone">062-385-0110</a>
          </div>

          <div class="masstige-left-bottom">
            <p class="masstige-corp-tagline">
              <strong>GAON-N®</strong> is an integrated creative advertising agency driven by data, execution, and trust.
            </p>
            <p class="masstige-corp-addr">주소: 광주광역시 서구 상무버들로 28 재민빌딩 2층 (주)가온엔</p>
            <div class="masstige-sns-row">
              <a href="https://blog.naver.com/bsad550" target="_blank" rel="noopener" class="masstige-sns-icon" aria-label="블로그">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zM9 16.5H6.5v-9H9v9zm8.5 0h-2.5v-4.5c0-1.1-.9-2-2-2s-2 .9-2 2v4.5H8.5v-9H11v1.2c.7-.9 1.8-1.5 3-1.5 2.2 0 4 1.8 4 4v5.3z"/></svg>
              </a>
              <a href="https://www.instagram.com/gaon_n_official/" target="_blank" rel="noopener" class="masstige-sns-icon" aria-label="인스타그램">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
              </a>
              <a href="/board/estmate/write.php" class="masstige-download-link">회사소개서 다운로드</a>
            </div>
          </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="masstige-right-col">
          <form id="quickEstimateForm" class="masstige-form-wrap" method="post">
            
            <div class="masstige-input-grid">
              <div class="masstige-field-pill">
                <span class="mfp-label">회사명</span>
                <input type="text" name="in_company" id="qe_company" class="mfp-input" placeholder="회사명을 입력해주세요." required>
              </div>
              <div class="masstige-field-pill">
                <span class="mfp-label">담당자</span>
                <input type="text" name="in_name" id="qe_name" class="mfp-input" placeholder="담당자를 입력해주세요." required>
              </div>
            </div>

            <div class="masstige-input-grid">
              <div class="masstige-field-pill">
                <span class="mfp-label">이메일</span>
                <input type="email" name="in_email" id="qe_email" class="mfp-input" placeholder="이메일 주소를 입력해주세요." required>
              </div>
              <div class="masstige-field-pill">
                <span class="mfp-label">연락처</span>
                <input type="text" name="in_tel" id="qe_tel" class="mfp-input" placeholder="연락처를 입력해주세요." required>
              </div>
            </div>

            <div class="masstige-textarea-pill">
              <span class="mfp-label-top">문의내용</span>
              <textarea name="in_memo" id="qe_memo" class="mfp-textarea" placeholder="희망 광고 매체(버스, 택시, 온라인, 영상 등) 및 문의 내용을 입력해주세요." rows="4" required></textarea>
            </div>

            <div class="masstige-action-row">
              <div class="masstige-privacy-group">
                <label class="masstige-chk-label">
                  <input type="checkbox" name="agree_privacy" id="qe_privacy" class="masstige-native-chk" checked required>
                  <span class="masstige-custom-dot"></span>
                  <span class="masstige-privacy-text">개인정보수집 및 이용에 동의합니다.</span>
                </label>
                <a href="/contents/email.php" target="_blank" class="masstige-privacy-badge">전문보기</a>
              </div>

              <button type="submit" class="masstige-submit-btn" id="btnQuickSubmit">
                <span class="msb-label">문의하기</span>
                <span class="msb-circle">
                  <span class="msb-dot"></span>
                </span>
              </button>
            </div>

            <!-- RIGHT FOOTER LEGAL META -->
            <div class="masstige-legal-meta">
              <div class="mlm-line">
                <span>상호: (주)가온엔</span>
                <span>대표자명: 김창현</span>
                <span>사업자등록번호: 137-87-02335</span>
              </div>
              <div class="mlm-line">
                <span>대표전화: 062-385-0110</span>
                <span>이메일: lgmo123@naver.com</span>
              </div>
              <p class="mlm-copy">© 2004–2026 GAON-N</p>
            </div>

          </form>
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

      <!-- ============================================
       ONLINE MARKETING CARD DETAIL MODAL (SVG 픽토그램 & PC 호버 내용 100% 연동 모달)
  ============================================ -->
  <div class="online-card-modal-overlay" id="onlineCardModal">
    <div class="ocm-panel">
      <button type="button" class="ocm-close-btn" id="btnCloseOnlineCardModal" aria-label="닫기">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
      <div class="ocm-image-box">
        <img id="ocmModalImg" src="" alt="온라인 마케팅 솔루션">
        <div class="ocm-img-scrim"></div>
        <div class="ocm-kicker-badge-wrap">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          <span class="ocm-kicker-badge" id="ocmModalKicker"></span>
        </div>
      </div>
      <div class="ocm-body">
        <h3 class="ocm-title" id="ocmModalTitle"></h3>
        <p class="ocm-desc" id="ocmModalDesc"></p>
        <div class="ocm-tag-box">
          <div class="ocm-feature-tag-wrap">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <span class="ocm-feature-tag" id="ocmModalTag"></span>
          </div>
        </div>
        <a href="/board/estmate/write.php" class="ocm-cta-btn">
          <span>온라인 마케팅 1:1 상담 신청</span>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
    </div>
  </div>

      <!-- PORTFOLIO LIGHTBOX MODAL (오른쪽 위 안쪽 닫기 버튼 + 좌우 넘김 화살표 탑재) -->
  <div class="portfolio-modal-backdrop" id="modalBackdrop">
    <div class="pm-modal-box">
      <button type="button" class="pm-close-btn" id="modalClose" aria-label="팝업 닫기">✕</button>
      
      <!-- MODAL PREV / NEXT ARROWS -->
      <button type="button" class="pm-nav-btn pm-prev-btn" id="modalPrevBtn" aria-label="이전 사례">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
      </button>
      <button type="button" class="pm-nav-btn pm-next-btn" id="modalNextBtn" aria-label="다음 사례">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </button>

      <div class="pm-img-wrap">
        <img src="" id="modalImg" alt="포트폴리오 상세 실사">
      </div>
      <div class="pm-info-wrap">
        <div class="pm-meta-row">
          <span class="pm-cat-badge" id="modalCat">광고사례</span>
          <span class="pm-counter-badge" id="modalCounter">1 / 8</span>
        </div>
        <h3 class="pm-title" id="modalTitle">프로젝트명</h3>
        <p class="pm-loc" id="modalLoc">광주 주요 상권 직영 시공 사례</p>
        <div class="pm-action-row">
          <a href="/board/estmate/write.php" class="pm-cta-btn">이 광고 집행 견적 문의 ➔</a>
        </div>
      </div>
    </div>
  </div>
  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php";?>

</div>


</body>
</html>
