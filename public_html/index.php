<?php
function normalize_port_img($url) {
    if (empty($url)) return '/images/bs_ad/baro.jpg';
    return str_replace('/admin/bbs/portfolio/uploads/bus/', '/images/port/', $url);
}
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/admin/bbs/portfolio/portfolio_seed_data.php")) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/bbs/portfolio/portfolio_seed_data.php";
}
?>

<body class="is-main">
<?php
$sql = "SELECT COUNT(*) FROM popup";
$result = mysqli_query($conn, $sql);
$temp = mysqli_fetch_array($result);
$totals = $temp[0];

$categories = array(
  'bus'     => '시내버스 광고',
  'shelter' => '버스 승강장·쉘터',
  'did'     => '터미널 광고',
  'taxi'    => '택시·택배·특화매체',
  'online'  => '온라인 마케팅',
  'video'   => '영상제작',
  'mart'    => '대형마트 카트',
  'print'   => '인쇄물·현수막',
  'web'     => '홈페이지제작'
);

$result = mysqli_query($conn, "SELECT * FROM portfolio WHERE status='active' ORDER BY sort_order ASC, id DESC");
$list   = array();
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $row['thumb'] = normalize_port_img($row['thumb']);
    $list[] = $row;
  }
}

$portBus = array();
$portOnline = array();
$portVideo = array();
$portOther = array();

foreach ($list as $item) {
  if (in_array($item['category'], array('bus', 'shelter', 'did', 'taxi', 'mart'))) $portBus[] = $item;
  if ($item['category'] == 'online' || $item['category'] == 'web') $portOnline[] = $item;
  if ($item['category'] == 'video') $portVideo[] = $item;
  if (in_array($item['category'], array('taxi','mart','did','print'))) $portOther[] = $item;
}

// 01 옥외광고 (버스/택시/택배 등) 기본 샘플 데이터 및 보충 (최신 등록 사례 최우선 배치)
$defaultBus = array(
  array('id'=>65, 'category'=>'taxi', 'badge'=>'TAXI·WRAP', 'title'=>'광주안과의원 전면·측면 고광택 택시 랩핑 광고', 'thumb'=>'/images/port/port_taxi_01.jpg', 'images'=>array('/images/port/port_taxi_01.jpg','/images/port/port_taxi_02.jpg'), 'client'=>'광주안과의원', 'location'=>'광주 전역 택시 영업구역', 'sort_order'=>1),
  array('id'=>66, 'category'=>'bus', 'badge'=>'BUS·WRAP', 'title'=>'해태아이스 부라보콘 지원45번 버스 3면 풀래핑 광고', 'thumb'=>'/images/port/port_bus_bravo_01.jpg', 'images'=>array('/images/port/port_bus_bravo_01.jpg','/images/port/port_bus_bravo_02.jpg','/images/port/port_bus_bravo_03.jpg'), 'client'=>'해태아이스', 'location'=>'광주 지원45번 간선버스', 'sort_order'=>2),
  array('id'=>67, 'category'=>'bus', 'badge'=>'BUS·REAR', 'title'=>'제3회 광산 세계야시장 광주시내버스 후면 광고', 'thumb'=>'/images/port/port_bus_gwangsan_night_01.jpg', 'images'=>array('/images/port/port_bus_gwangsan_night_01.jpg','/images/port/port_bus_gwangsan_night_02.jpg'), 'client'=>'광산구청', 'location'=>'광주 지곡196번 / 일곡10번', 'sort_order'=>3),
  array('id'=>68, 'category'=>'bus', 'badge'=>'BUS·REAR', 'title'=>'호남최대규모 전기난방업체 대륙 시내버스 후면 광고', 'thumb'=>'/images/port/port_bus_daeruk_heating_01.jpg', 'images'=>array('/images/port/port_bus_daeruk_heating_01.jpg'), 'client'=>'(주)대륙난방', 'location'=>'광주 지곡196번 시내버스', 'sort_order'=>4),
  array('id'=>69, 'category'=>'bus', 'badge'=>'BUS·SIDE', 'title'=>'신신제약 신신파스 아렉스 좌석02번 버스 인도면 광고', 'thumb'=>'/images/port/port_bus_sinshin_02.jpg', 'images'=>array('/images/port/port_bus_sinshin_02.jpg','/images/port/port_bus_sinshin_01.jpg'), 'client'=>'신신제약', 'location'=>'광주 좌석02번 급행버스', 'sort_order'=>5),
  array('id'=>70, 'category'=>'bus', 'badge'=>'BUS·SIDE', 'title'=>'베스트장례문화원 OPEN 시내버스 차도면 와이드 광고', 'thumb'=>'/images/port/port_bus_best_funeral_02.jpg', 'images'=>array('/images/port/port_bus_best_funeral_02.jpg','/images/port/port_bus_best_funeral_01.jpg'), 'client'=>'베스트장례문화원', 'location'=>'광주 공항 맞은편', 'sort_order'=>6),
  array('id'=>71, 'category'=>'bus', 'badge'=>'BUS·REAR', 'title'=>'세계로 앞서가는 전남과학대학교 시내버스 후면 광고', 'thumb'=>'/images/port/port_bus_chunnam_sci_01.jpg', 'images'=>array('/images/port/port_bus_chunnam_sci_01.jpg'), 'client'=>'전남과학대학교', 'location'=>'광주 좌석02번 급행버스', 'sort_order'=>7),
  array('id'=>72, 'category'=>'bus', 'badge'=>'BUS·SIDE', 'title'=>'No.1 K-슈즈 탠디(TANDY) 금호36번 버스 인도면 광고', 'thumb'=>'/images/port/port_bus_tandy_01.jpg', 'images'=>array('/images/port/port_bus_tandy_01.jpg','/images/port/port_bus_tandy_02.jpg'), 'client'=>'탠디(TANDY)', 'location'=>'광주 금호36번 간선버스', 'sort_order'=>8),
  array('id'=>73, 'category'=>'bus', 'badge'=>'BUS·SIDE', 'title'=>'국립아시아문화전당 코레오커넥션 수소전기버스 차도면 광고', 'thumb'=>'/images/port/port_bus_acc_choreo_02.jpg', 'images'=>array('/images/port/port_bus_acc_choreo_02.jpg','/images/port/port_bus_acc_choreo_01.jpg'), 'client'=>'국립아시아문화전당', 'location'=>'광주 수소전기버스', 'sort_order'=>9),
  array('id'=>74, 'category'=>'bus', 'badge'=>'BUS·SIDE', 'title'=>'월드드림랜드(찜질방·수영장) 시내버스 차도면 와이드 광고', 'thumb'=>'/images/port/port_bus_worlddream_01.jpg', 'images'=>array('/images/port/port_bus_worlddream_01.jpg','/images/port/port_bus_worlddream_02.jpg'), 'client'=>'월드드림랜드', 'location'=>'광주 대창운수 간선버스', 'sort_order'=>10),
  array('id'=>75, 'category'=>'taxi', 'badge'=>'PARCEL·AD', 'title'=>'더스마트병원 골절·관절 전문케어 택배차량 래핑 광고', 'thumb'=>'/images/port/port_truck_smart_01.jpg', 'images'=>array('/images/port/port_truck_smart_01.jpg','/images/port/port_truck_smart_02.jpg','/images/port/port_truck_smart_03.jpg'), 'client'=>'더스마트병원', 'location'=>'광주 전역 택배 배송 권역', 'sort_order'=>11),
  array('id'=>76, 'category'=>'taxi', 'badge'=>'PARCEL·AD', 'title'=>'삼성스토어 광천점 오픈·가전 페스타 택배차량 30대 래핑 광고', 'thumb'=>'/images/port/port_truck_samsung_01.jpg', 'images'=>array('/images/port/port_truck_samsung_01.jpg','/images/port/port_truck_samsung_02.jpg','/images/port/port_truck_samsung_03.jpg'), 'client'=>'삼성스토어', 'location'=>'광주 30대 배송 권역', 'sort_order'=>12),
  array('id'=>77, 'category'=>'taxi', 'badge'=>'PARCEL·AD', 'title'=>'스마트인재개발원 IT·AI 취업과정 모집 택배차량 10대 래핑 광고', 'thumb'=>'/images/port/port_truck_smhrd_01.jpg', 'images'=>array('/images/port/port_truck_smhrd_01.jpg','/images/port/port_truck_smhrd_02.jpg','/images/port/port_truck_smhrd_03.jpg'), 'client'=>'스마트인재개발원', 'location'=>'광주 10대 배송 권역', 'sort_order'=>13),
  array('id'=>78, 'category'=>'taxi', 'badge'=>'PARCEL·AD', 'title'=>'신수정 시의원 의정보고 택배차량 10대 홍보 래핑', 'thumb'=>'/images/port/port_truck_sinsujeong_01.jpg', 'images'=>array('/images/port/port_truck_sinsujeong_01.jpg','/images/port/port_truck_sinsujeong_02.jpg'), 'client'=>'신수정 시의원', 'location'=>'광주 북구 10대', 'sort_order'=>14),
  array('id'=>79, 'category'=>'taxi', 'badge'=>'PARCEL·AD', 'title'=>'정다은 변호사 무료법률상담·전문클리닉 택배차량 40대 래핑 광고', 'thumb'=>'/images/port/port_truck_jungdaeun_01.jpg', 'images'=>array('/images/port/port_truck_jungdaeun_01.jpg','/images/port/port_truck_jungdaeun_02.jpg','/images/port/port_truck_jungdaeun_03.jpg'), 'client'=>'정다은 변호사', 'location'=>'광주 40대 플릿', 'sort_order'=>15),
  array('id'=>80, 'category'=>'taxi', 'badge'=>'PARCEL·AD', 'title'=>'하트치과 분과별 전문진료 택배차량 5대 양면 래핑 광고', 'thumb'=>'/images/port/port_truck_heartdental_01.jpg', 'images'=>array('/images/port/port_truck_heartdental_01.jpg','/images/port/port_truck_heartdental_02.jpg','/images/port/port_truck_heartdental_03.jpg'), 'client'=>'하트치과의원', 'location'=>'광주 5대 권역', 'sort_order'=>16),
  array('id'=>81, 'category'=>'did', 'badge'=>'TERMINAL·AD', 'title'=>'상무힐링재활요양병원 유스퀘어 광천터미널 중앙통로 조명 광고', 'thumb'=>'/images/port/port_terminal_usquare_01.jpg', 'images'=>array('/images/port/port_terminal_usquare_01.jpg','/images/port/port_terminal_usquare_02.jpg'), 'client'=>'상무힐링재활요양병원', 'location'=>'광주 유스퀘어 광천터미널 1층 중앙통로', 'sort_order'=>17),
  array('id'=>82, 'category'=>'mart', 'badge'=>'MART·CART', 'title'=>'365열린야간의원 연중무휴 야간진료 대형마트 카트광고', 'thumb'=>'/images/port/mart/mart_365open_01.jpg', 'images'=>array('/images/port/mart/mart_365open_01.jpg','/images/port/mart/mart_365open_02.jpg'), 'client'=>'365열린야간의원', 'location'=>'광주 대형마트 (운암동)', 'sort_order'=>18),
  array('id'=>83, 'category'=>'mart', 'badge'=>'MART·CART', 'title'=>'광주 최대 창고형 메가하이약국 365일 영업 마트 카트광고', 'thumb'=>'/images/port/mart/mart_megahi_01.jpg', 'images'=>array('/images/port/mart/mart_megahi_01.jpg','/images/port/mart/mart_megahi_02.jpg'), 'client'=>'메가하이약국', 'location'=>'광주 대형마트 쇼핑카트', 'sort_order'=>19),
  array('id'=>84, 'category'=>'mart', 'badge'=>'MART·CART', 'title'=>'굿플란트치과의원 4인원장 협진진료 마트 카트광고', 'thumb'=>'/images/port/mart/mart_goodplant_01.jpg', 'images'=>array('/images/port/mart/mart_goodplant_01.jpg'), 'client'=>'굿플란트치과의원', 'location'=>'광주 남구 대형마트', 'sort_order'=>20),
  array('id'=>85, 'category'=>'did', 'badge'=>'TERMINAL·AD', 'title'=>'더스마트병원 유스퀘어 광천터미널 매표소 상단 대형 LED 전광판 광고', 'thumb'=>'/images/port/port_usquare_led_01.jpg', 'images'=>array('/images/port/port_usquare_led_01.jpg'), 'client'=>'더스마트병원', 'location'=>'광주 유스퀘어 광천터미널 1층 매표소 상단', 'sort_order'=>21),
  array('id'=>1, 'category'=>'bus', 'badge'=>'BUS·SIDE', 'title'=>'상무지구 메디컬센터 시내버스 3면 풀래핑 광고', 'thumb'=>'/images/bs_ad/ooh11/차도면광고.png', 'images'=>array('/images/bs_ad/ooh11/차도면광고.png'), 'client'=>'메디컬센터', 'location'=>'상무지구 노선', 'sort_order'=>100),
  array('id'=>64, 'category'=>'mart', 'badge'=>'MART·CART', 'title'=>'더스마트병원 대형마트 쇼핑카트 양면 플레이트 광고', 'thumb'=>'/images/port/mart/mart_01.jpg', 'images'=>array('/images/port/mart/mart_01.jpg'), 'client'=>'더스마트병원', 'location'=>'광주 대형마트', 'sort_order'=>102)
);
if (empty($portBus)) {
  $portBus = $defaultBus;
} else if (count($portBus) < 8) {
  foreach ($defaultBus as $df) {
    if (count($portBus) >= 8) break;
    $portBus[] = $df;
  }
}

// 02 온라인마케팅 기본 샘플 데이터 및 보충
$defaultOnline = array(
    array('id'=>9, 'category'=>'online', 'title'=>'스마트플레이스 정보·콘텐츠 통합 운영', 'thumb'=>'/images/online/online_place.jpg'),
    array('id'=>10, 'category'=>'online', 'title'=>'브랜드 블로그 콘텐츠 기획 및 운영', 'thumb'=>'/images/online/online_blog.jpg'),
    array('id'=>11, 'category'=>'online', 'title'=>'지역 커뮤니티 & 콘텐츠 마케팅', 'thumb'=>'/images/online/online_local.jpg'),
    array('id'=>12, 'category'=>'online', 'title'=>'인스타그램 릴스 & 타깃 광고 운영', 'thumb'=>'/images/online/online_instagram.jpg'),
    array('id'=>21, 'category'=>'online', 'title'=>'구글 검색 & 디스플레이 광고', 'thumb'=>'/images/online/online_analytics.jpg'),
    array('id'=>22, 'category'=>'online', 'title'=>'네이버 검색광고 키워드 캠페인 운영', 'thumb'=>'/images/online/online_search.jpg'),
    array('id'=>23, 'category'=>'online', 'title'=>'체험단 & 인플루언서 콘텐츠 마케팅', 'thumb'=>'/images/online/online_influencer.jpg'),
    array('id'=>24, 'category'=>'online', 'title'=>'홈페이지 & 랜딩페이지 제작', 'thumb'=>'/images/online/online_web.jpg')
  );
if (empty($portOnline)) {
  $portOnline = $defaultOnline;
} else if (count($portOnline) < 8) {
  foreach ($defaultOnline as $df) {
    if (count($portOnline) >= 8) break;
    $portOnline[] = $df;
  }
}

// 03 영상제작 기본 샘플 데이터 및 보충
$defaultVideo = array(
  array('id'=>54, 'category'=>'video', 'title'=>'달라온도시락 브랜드 홍보영상', 'thumb'=>'/images/port/video_thumb_01.jpg', 'video'=>'/images/port/video/video_clip_01.mp4', 'client'=>'달라온도시락'),
  array('id'=>55, 'category'=>'video', 'title'=>'더다르다김밥 숏폼 릴스/쇼츠 홍보영상', 'thumb'=>'/images/port/video_thumb_02.jpg', 'video'=>'/images/port/video/video_clip_02.mp4', 'client'=>'더다르다김밥'),
  array('id'=>56, 'category'=>'video', 'title'=>'삼미가 정통 한식 백반 홍보영상', 'thumb'=>'/images/port/video_thumb_03.jpg', 'video'=>'/images/port/video/video_clip_03.mp4', 'client'=>'삼미가'),
  array('id'=>57, 'category'=>'video', 'title'=>'신우네닭칼국수 시그니처 메뉴 홍보영상', 'thumb'=>'/images/port/video_thumb_04.jpg', 'video'=>'/images/port/video/video_clip_04.mp4', 'client'=>'신우네닭칼국수'),
  array('id'=>58, 'category'=>'video', 'title'=>'장어먹자 숯불구이 전문점 홍보영상', 'thumb'=>'/images/port/video_thumb_05.jpg', 'video'=>'/images/port/video/video_clip_05.mp4', 'client'=>'장어먹자'),
  array('id'=>63, 'category'=>'video', 'title'=>'정초밥 프리미엄 일식 스시 홍보영상', 'thumb'=>'/images/port/video_thumb_06.jpg', 'video'=>'/images/port/video/video_clip_06.mp4', 'client'=>'정초밥')
);
if (empty($portVideo)) {
  $portVideo = $defaultVideo;
} else if (count($portVideo) < 6) {
  foreach ($defaultVideo as $df) {
    if (count($portVideo) >= 6) break;
    $portVideo[] = $df;
  }
}

// ACTIVE POPUPS FETCH
$today = date('Y-m-d');
$pop_sql = "SELECT * FROM popup WHERE pop_view='Y' AND (pop_start <= '$today' AND pop_end >= '$today') AND pop_file0 != '' ORDER BY pop_uid DESC";
$pop_res = mysqli_query($conn, $pop_sql);
$active_popups = array();
if ($pop_res && mysqli_num_rows($pop_res) > 0) {
  while ($p_row = mysqli_fetch_array($pop_res)) {
    if (empty($_COOKIE["todayCookie_".$p_row['pop_uid']]) && empty($_COOKIE["todayPopupAll_done"])) {
      $active_popups[] = $p_row;
    }
  }
}

if (!empty($active_popups)) {
?>
<!-- ============================================
     GAON-N ULTRA-MODERN MODAL POPUP (OVERLAY & SWIPER CAROUSEL)
============================================ -->
<script>document.documentElement.classList.add('modal-popup-active');</script>
<div id="mainModalPopupOverlay" class="main-modal-popup-overlay">
  <div class="main-modal-popup-card">
    
    <!-- TOP BAR -->
    <div class="mmp-header">
      <?php if (count($active_popups) > 1) { ?>
        <div class="mmp-slide-counter"><span class="mmp-current">1</span> / <span class="mmp-total"><?php echo count($active_popups); ?></span></div>
      <?php } else { ?>
        <div></div>
      <?php } ?>
      <button type="button" class="mmp-close-x" id="btnModalPopupCloseX" aria-label="팝업 닫기">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
    </div>

    <!-- SWIPER CONTAINER -->
    <div class="mmp-body">
      <div class="swiper mainModalPopupSwiper">
        <div class="swiper-wrapper">
          <?php foreach ($active_popups as $idx => $pop) { ?>
            <div class="swiper-slide mmp-slide" data-popid="<?php echo $pop['pop_uid']; ?>">
              <div class="mmp-img-wrap">
                <img src="/admin/popup/uploads/<?php echo $pop['pop_file0']; ?>" alt="<?php echo htmlspecialchars($pop['pop_title']); ?>" class="mmp-img">
              </div>
            </div>
          <?php } ?>
        </div>
        
        <?php if (count($active_popups) > 1) { ?>
          <!-- ARROW CONTROLS -->
          <div class="swiper-button-prev mmp-arrow mmp-arrow-prev"></div>
          <div class="swiper-button-next mmp-arrow mmp-arrow-next"></div>
          <div class="swiper-pagination mmp-pagination"></div>
        <?php } ?>
      </div>
    </div>

    <!-- BOTTOM FOOTER TOOLBAR -->
    <div class="mmp-footer">
      <label class="mmp-today-check">
        <input type="checkbox" id="chkModalPopupToday">
        <span class="mmp-check-custom"></span>
        <span class="mmp-check-label">오늘 하루 동안 열지 않기</span>
      </label>
      <button type="button" class="mmp-btn-close" id="btnModalPopupClose">닫기</button>
    </div>

  </div>
</div>
<?php } ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/blank.php";?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/skip.php";?>

<div id="wrap" class="agency-master-system">

	<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php";?>
  
  <!-- ============================================
       01 HERO STAGE : AGENCY BESPOKE EDITORIAL HERO
  ============================================ -->
  <section class="gh-hero-editorial" id="hero">
    <div class="gh-video-wrap">
      <video autoplay muted loop playsinline class="gh-video-bg">
        <source src="/images/movie.mp4" type="video/mp4">
      </video>
      <div class="gh-scrim"></div>
    </div>

    <div class="gh-container">

      <!-- CENTER HEADLINE & SUBCOPY -->
      <div class="gh-center-block wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.1s">
        <h1 class="gh-headline">
          브랜드가 필요한 순간,<br>
          가장 알맞은 방식으로 연결합니다.
        </h1>
        <p class="gh-sub">
          옥외광고부터 온라인 마케팅, 영상, 홈페이지까지<br>
          브랜드와 고객이 만나는 다양한 접점을 연결합니다.
        </p>
      </div>

      <!-- BOTTOM CTA & SCOPE ROW -->
      <div class="gh-bottom-row wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.25s">
        <a href="/board/estmate/write.php" class="gh-btn-cta">
          <span>프로젝트 문의하기</span>
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>

        <div class="gh-scope-list pc_only">
          <span>OOH MEDIA</span>
          <span class="gsl-dot">/</span>
          <span>DIGITAL</span>
          <span class="gsl-dot">/</span>
          <span>CONTENT</span>
          <span class="gsl-dot">/</span>
          <span>WEB</span>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       01-B HERO ➔ ABOUT TYPOGRAPHY TRANSITION STRIP
  ============================================ -->
  <div class="gh-transition-strip" aria-hidden="true">
    <div class="gts-track">
      <span class="gts-word outline">OOH</span>
      <span class="gts-word">DIGITAL</span>
      <span class="gts-word outline">CONTENT</span>
      <span class="gts-word">WEB</span>
      <span class="gts-word outline">OOH</span>
      <span class="gts-word">DIGITAL</span>
      <span class="gts-word outline">CONTENT</span>
      <span class="gts-word">WEB</span>
    </div>
  </div>


  <!-- ============================================
       01-C ABOUT SECTION : EDITORIAL 2-COLUMN & SERVICE LIST
  ============================================ -->
  <section class="ga-about-editorial" id="about">
    <div class="gae-container">
      <div class="gae-grid">
        
        <!-- LEFT: KICKER & TITLE -->
        <div class="gae-left wow fadeInUp" data-wow-duration="0.8s">
          <span class="gae-kicker">ABOUT GAON-N</span>
          <h2 class="gae-title">
            온라인에서 거리까지,<br>
            브랜드와 고객이 만나는<br>
            접점을 연결합니다.
          </h2>
        </div>

        <!-- RIGHT: DESCRIPTION & SERVICE LIST -->
        <div class="gae-right wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.15s">
          <p class="gae-desc">
            가온엔은 하나의 광고 방식에 머무르지 않습니다.<br>
            광주 주요 생활권을 잇는 옥외매체부터 온라인 마케팅, 콘텐츠와 홈페이지까지<br>
            브랜드의 목적에 맞는 접점을 함께 설계합니다.
          </p>

          <div class="gae-service-list">
            
            <div class="gae-service-item">
              <div class="gsi-left">
                <span class="gsi-num">01</span>
                <strong class="gsi-name">OOH MEDIA</strong>
              </div>
              <span class="gsi-sub">옥외 · 교통광고</span>
              <span class="gsi-arrow">→</span>
            </div>

            <div class="gae-service-item">
              <div class="gsi-left">
                <span class="gsi-num">02</span>
                <strong class="gsi-name">DIGITAL</strong>
              </div>
              <span class="gsi-sub">온라인 마케팅</span>
              <span class="gsi-arrow">→</span>
            </div>

            <div class="gae-service-item">
              <div class="gsi-left">
                <span class="gsi-num">03</span>
                <strong class="gsi-name">CONTENT</strong>
              </div>
              <span class="gsi-sub">영상 · 콘텐츠</span>
              <span class="gsi-arrow">→</span>
            </div>

            <div class="gae-service-item">
              <div class="gsi-left">
                <span class="gsi-num">04</span>
                <strong class="gsi-name">WEB</strong>
              </div>
              <span class="gsi-sub">홈페이지 · 랜딩페이지</span>
              <span class="gsi-arrow">→</span>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ============================================
       02 SECTION 01 : OOH MEDIA SOLUTIONS (3-TIER EDITORIAL HIERARCHY)
  ============================================ -->
  <section class="am-section go-ooh-editorial-sec" id="bus">
    <div class="go-container">
      
      <!-- TOP HEADER ROW -->
      <div class="go-header-row">
        <div class="go-header-left">
          <span class="go-kicker">01 / OOH MEDIA</span>
          <h2 class="go-title">옥외광고 솔루션</h2>
          <p class="go-desc">
            시내버스부터 택시, 유스퀘어 터미널, 특화매체까지 생활권 곳곳에서 만나는 다양한 옥외매체를 운영합니다.
          </p>
        </div>
      </div>

      <!-- MAIN 2-COLUMN EDITORIAL STAGE -->
      <div class="go-stage-grid">
        
        <!-- LEFT: 4 PRIMARY ACCORDION CATEGORIES -->
        <div class="go-left-col">
          
          <div class="go-primary-accordions" id="goAccordionList">

            <!-- 01. 버스 외부광고 -->
            <div class="go-primary-item on" 
                 data-cat="bus_out" 
                 data-num="01" 
                 data-eng="BUS OUTDOOR" 
                 data-title="버스 외부광고" 
                 data-guide="guideBusOut">
              <div class="gpi-header-btn">
                <div class="gpi-title-wrap">
                  <div class="gpi-eyebrow-row">
                    <span class="gpi-eyebrow">01 / BUS OUTDOOR</span>
                  </div>
                  <h3 class="gpi-title">버스 외부광고</h3>
                  <p class="gpi-sub">차도면 · 인도면 · 후면 · 하차문</p>
                </div>
                <div class="gpi-toggle-icon">
                  <span class="gpi-icon-bar h"></span>
                  <span class="gpi-icon-bar v"></span>
                </div>
              </div>

              <!-- NESTED DETAIL ACCORDION BODY -->
              <div class="gpi-accordion-body">
                <div class="gpi-body-inner">
                  <div class="gds-sub-list">
                    <button type="button" class="gds-item on" 
                            data-id="bus_side_road" 
                            data-cat="bus_out"
                            data-num="01"
                            data-eng="BUS OUTDOOR"
                            data-img="/images/bs_ad/ooh11/차도면광고.png" 
                            data-sub="차도면 광고" 
                            data-guide="guideBusOut">
                      <span class="gds-item-num">01</span>
                      <span class="gds-item-txt">차도면 광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="bus_side_pave" 
                            data-cat="bus_out"
                            data-num="01"
                            data-eng="BUS OUTDOOR"
                            data-img="/images/bs_ad/ooh11/인도면광고.png" 
                            data-sub="인도면 광고" 
                            data-guide="guideBusOut">
                      <span class="gds-item-num">02</span>
                      <span class="gds-item-txt">인도면 광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="bus_rear" 
                            data-cat="bus_out"
                            data-num="01"
                            data-eng="BUS OUTDOOR"
                            data-img="/images/bs_ad/ooh11/후면광고.png" 
                            data-sub="후면 광고" 
                            data-guide="guideBusOut">
                      <span class="gds-item-num">03</span>
                      <span class="gds-item-txt">후면 광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="bus_getoff" 
                            data-cat="bus_out"
                            data-num="01"
                            data-eng="BUS OUTDOOR"
                            data-img="/images/bs_ad/ooh11/하차문광고.png" 
                            data-sub="하차문 광고" 
                            data-guide="guideBusOut">
                      <span class="gds-item-num">04</span>
                      <span class="gds-item-txt">하차문 광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                  </div>
                  <!-- MOBILE INLINE PREVIEW -->
                  <div class="go-mobile-preview">
                    <div class="gmp-image-wrap">
                      <img class="gmp-image" src="/images/bs_ad/ooh11/차도면광고.png" alt="차도면 광고">
                    </div>
                    <div class="gmp-caption">
                      <span class="gmp-meta">01 / BUS OUTDOOR</span>
                      <strong class="gmp-title">차도면 광고</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 02. 버스 내부광고 -->
            <div class="go-primary-item" 
                 data-cat="bus_in" 
                 data-num="02" 
                 data-eng="BUS INTERIOR" 
                 data-title="버스 내부광고" 
                 data-guide="guideBusIn">
              <div class="gpi-header-btn">
                <div class="gpi-title-wrap">
                  <div class="gpi-eyebrow-row">
                    <span class="gpi-eyebrow">02 / BUS INTERIOR</span>
                  </div>
                  <h3 class="gpi-title">버스 내부광고</h3>
                  <p class="gpi-sub">중앙문 · 노선도 · 시트커버 · 음성안내</p>
                </div>
                <div class="gpi-toggle-icon">
                  <span class="gpi-icon-bar h"></span>
                  <span class="gpi-icon-bar v"></span>
                </div>
              </div>

              <!-- NESTED DETAIL ACCORDION BODY -->
              <div class="gpi-accordion-body">
                <div class="gpi-body-inner">
                  <div class="gds-sub-list">
                    <button type="button" class="gds-item on" 
                            data-id="bus_in_center" 
                            data-cat="bus_in"
                            data-num="02"
                            data-eng="BUS INTERIOR"
                            data-img="/images/bs_ad/ooh11/중앙문광고.png" 
                            data-sub="중앙문 광고" 
                            data-guide="guideBusIn">
                      <span class="gds-item-num">01</span>
                      <span class="gds-item-txt">중앙문 광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="bus_in_route" 
                            data-cat="bus_in"
                            data-num="02"
                            data-eng="BUS INTERIOR"
                            data-img="/images/bs_ad/ooh11/노선도01.png" 
                            data-sub="노선도 광고" 
                            data-guide="guideBusIn">
                      <span class="gds-item-num">02</span>
                      <span class="gds-item-txt">노선도 광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="bus_in_sheet" 
                            data-cat="bus_in"
                            data-num="02"
                            data-eng="BUS INTERIOR"
                            data-img="/images/bs_ad/ooh11/시트커버광고.png" 
                            data-sub="시트커버 광고" 
                            data-guide="guideBusIn">
                      <span class="gds-item-num">03</span>
                      <span class="gds-item-txt">시트커버 광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="bus_in_voice" 
                            data-cat="bus_in"
                            data-num="02"
                            data-eng="BUS INTERIOR"
                            data-img="/images/bs_ad/ooh11/버스음성광고.png" 
                            data-sub="음성안내 방송" 
                            data-guide="guideBusIn">
                      <span class="gds-item-num">04</span>
                      <span class="gds-item-txt">음성안내 방송</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                  </div>
                  <!-- MOBILE INLINE PREVIEW -->
                  <div class="go-mobile-preview">
                    <div class="gmp-image-wrap">
                      <img class="gmp-image" src="/images/bs_ad/ooh11/중앙문광고.png" alt="중앙문 광고">
                    </div>
                    <div class="gmp-caption">
                      <span class="gmp-meta">02 / BUS INTERIOR</span>
                      <strong class="gmp-title">중앙문 광고</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 03. 터미널 광고 (유스퀘어 & 일반 터미널 분리) -->
            <div class="go-primary-item" 
                 data-cat="terminal" 
                 data-num="03" 
                 data-eng="TERMINAL MEDIA" 
                 data-title="터미널 광고" 
                 data-guide="guideUsquare">
              <div class="gpi-header-btn">
                <div class="gpi-title-wrap">
                  <div class="gpi-eyebrow-row">
                    <span class="gpi-eyebrow">03 / TERMINAL MEDIA</span>
                  </div>
                  <h3 class="gpi-title">터미널 광고</h3>
                  <p class="gpi-sub">광주 유스퀘어 터미널 (3종) · 전남 시외·고속 버스터미널</p>
                </div>
                <div class="gpi-toggle-icon">
                  <span class="gpi-icon-bar h"></span>
                  <span class="gpi-icon-bar v"></span>
                </div>
              </div>

              <!-- NESTED DETAIL ACCORDION BODY -->
              <div class="gpi-accordion-body">
                <div class="gpi-body-inner">
                  
                  <!-- SUB-SECTION 1: 광주 유스퀘어 -->
                  <div style="font-size:11px; font-weight:800; color:#4f46e5; padding:6px 12px 3px; letter-spacing:0.02em; display:flex; align-items:center; gap:6px;">
                    <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#4f46e5;"></span>
                    광주 유스퀘어 터미널
                  </div>
                  <div class="gds-sub-list" style="margin-bottom:8px;">
                    <button type="button" class="gds-item on" 
                            data-id="usquare_led" 
                            data-cat="terminal"
                            data-num="03"
                            data-eng="TERMINAL MEDIA"
                            data-img="/images/bs_ad/ooh11/유스퀘어_매표소광고.jpg" 
                            data-sub="유스퀘어 매표소 상단 전광판" 
                            data-guide="guideUsquare">
                      <span class="gds-item-num">01</span>
                      <span class="gds-item-txt">매표소 상단 대형 전광판</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="usquare_corridor" 
                            data-cat="terminal"
                            data-num="03"
                            data-eng="TERMINAL MEDIA"
                            data-img="/images/bs_ad/ooh11/유스퀘어_통로광고.jpg" 
                            data-sub="유스퀘어 중앙통로 조명 광고" 
                            data-guide="guideUsquare">
                      <span class="gds-item-num">02</span>
                      <span class="gds-item-txt">중앙통로 조명 광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="usquare_shelter" 
                            data-cat="terminal"
                            data-num="03"
                            data-eng="TERMINAL MEDIA"
                            data-img="/images/bs_ad/ooh11/유스퀘어광고.png" 
                            data-sub="유스퀘어 승강장 쉘터광고" 
                            data-guide="guideShelter">
                      <span class="gds-item-num">03</span>
                      <span class="gds-item-txt">터미널 승강장 쉘터광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                  </div>

                  <!-- SUB-SECTION 2: 일반 시외·고속 버스터미널 -->
                  <div style="font-size:11px; font-weight:800; color:#0284c7; padding:10px 12px 3px; border-top:1px dashed #e2e8f0; letter-spacing:0.02em; display:flex; align-items:center; gap:6px;">
                    <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#0284c7;"></span>
                    일반 시외·고속 버스터미널 (지역별)
                  </div>
                  <div class="gds-sub-list">
                    <button type="button" class="gds-item" 
                            data-id="terminal_regional" 
                            data-cat="terminal"
                            data-num="03"
                            data-eng="TERMINAL MEDIA"
                            data-img="/images/port/port_16_1.jpg" 
                            data-sub="지역 버스터미널 조명 광고 (영광·목포 등)" 
                            data-guide="guideUsquare">
                      <span class="gds-item-num">04</span>
                      <span class="gds-item-txt">지역 버스터미널 광고 (영광·목포 등)</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                  </div>

                  <!-- MOBILE INLINE PREVIEW -->
                  <div class="go-mobile-preview">
                    <div class="gmp-image-wrap">
                      <img class="gmp-image" src="/images/bs_ad/ooh11/유스퀘어_매표소광고.jpg" alt="매표소 상단 대형 전광판">
                    </div>
                    <div class="gmp-caption">
                      <span class="gmp-meta">03 / TERMINAL MEDIA</span>
                      <strong class="gmp-title">매표소 상단 대형 전광판</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 04. 특화 옥외매체 -->
            <div class="go-primary-item" 
                 data-cat="special" 
                 data-num="04" 
                 data-eng="SPECIAL MEDIA" 
                 data-title="특화 옥외매체" 
                 data-guide="guideTaxiSpec">
              <div class="gpi-header-btn">
                <div class="gpi-title-wrap">
                  <div class="gpi-eyebrow-row">
                    <span class="gpi-eyebrow">04 / SPECIAL MEDIA</span>
                  </div>
                  <h3 class="gpi-title">특화 옥외매체</h3>
                  <p class="gpi-sub">DID · 택시 · 택배차 · 대형마트 카트</p>
                </div>
                <div class="gpi-toggle-icon">
                  <span class="gpi-icon-bar h"></span>
                  <span class="gpi-icon-bar v"></span>
                </div>
              </div>

              <!-- NESTED DETAIL ACCORDION BODY -->
              <div class="gpi-accordion-body">
                <div class="gpi-body-inner">
                  <div class="gds-sub-list">
                    <button type="button" class="gds-item on" 
                            data-id="did" 
                            data-cat="special"
                            data-num="04"
                            data-eng="SPECIAL MEDIA"
                            data-img="/images/bs_ad/ooh11/유스퀘어_매표소광고.jpg" 
                            data-sub="DID 디지털 전광판" 
                            data-guide="guideTaxiSpec">
                      <span class="gds-item-num">01</span>
                      <span class="gds-item-txt">DID 디지털 전광판</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="taxi" 
                            data-cat="special"
                            data-num="04"
                            data-eng="SPECIAL MEDIA"
                            data-img="/images/bs_ad/ooh11/택시광고01.png" 
                            data-sub="택시 광고" 
                            data-guide="guideTaxiSpec">
                      <span class="gds-item-num">02</span>
                      <span class="gds-item-txt">택시 광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="delivery" 
                            data-cat="special"
                            data-num="04"
                            data-eng="SPECIAL MEDIA"
                            data-img="/images/bs_ad/ooh11/택배차광고01.png" 
                            data-sub="택배차 래핑광고" 
                            data-guide="guideTaxiSpec">
                      <span class="gds-item-num">03</span>
                      <span class="gds-item-txt">택배차 래핑광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                    <button type="button" class="gds-item" 
                            data-id="mart" 
                            data-cat="special"
                            data-num="04"
                            data-eng="SPECIAL MEDIA"
                            data-img="/images/bs_ad/ooh11/mart_cart_01.jpg" 
                            data-sub="대형마트 카트광고" 
                            data-guide="guideTaxiSpec">
                      <span class="gds-item-num">04</span>
                      <span class="gds-item-txt">대형마트 카트광고</span>
                      <span class="gds-item-arrow">→</span>
                    </button>
                  </div>
                  <!-- MOBILE INLINE PREVIEW -->
                  <div class="go-mobile-preview">
                    <div class="gmp-image-wrap">
                      <img class="gmp-image" src="/images/bs_ad/ooh11/유스퀘어_매표소광고.jpg" alt="DID 디지털 전광판">
                    </div>
                    <div class="gmp-caption">
                      <span class="gmp-meta">04 / SPECIAL MEDIA</span>
                      <strong class="gmp-title">DID 디지털 전광판</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

        <!-- RIGHT: PILL CTA BUTTONS + HERO ARTWORK SHOWCASE -->
        <div class="go-right-col">
          
          <!-- TOP PILL CTA ACTION ROW (ABOVE PHOTO) -->
          <div class="go-photo-actions">
            <button type="button" class="go-pill-btn bus-guide-open" id="goBtnGuide" data-guide="guideBusOut">
              <span>규격 가이드 &amp; 제안서 보기</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
            </button>
            <button type="button" class="go-pill-btn open-route-search" onclick="openRouteModal();">
              <span>광주 시내버스 노선 검색</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
            </button>
          </div>

          <div class="go-photo-frame" id="goPhotoFrame">
            <div class="go-single-visual" id="goSingleVisual">
              <!-- DUAL LAYER FOR SILKY CINEMATIC CROSSFADE -->
              <img src="/images/bs_ad/ooh11/차도면광고.png" id="goPhotoBack" alt="옥외광고 배경" class="go-photo-img go-photo-back">
              <img src="/images/bs_ad/ooh11/차도면광고.png" id="goPhotoFront" alt="옥외광고 솔루션 실사" class="go-photo-img go-photo-front">
              <div class="go-photo-scrim"></div>
              <div class="go-photo-caption" id="goPhotoCaption">
                <span class="gpc-tag" id="goCapNumEng">01 / BUS OUTDOOR</span>
                <strong class="gpc-title" id="goCapTitle">차도면 광고</strong>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- RECENT OOH PORTFOLIO SHOWCASE STRIP (KEPT INTACT) -->
      <div class="am-sub-port-strip wow fadeInUp" data-wow-duration="0.8s" style="margin-top:70px;">
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
            <?php foreach ($portBus as $bItem): 
              $bThumb = normalize_port_img(!empty($bItem['thumb']) ? $bItem['thumb'] : '');
              $bImages = array($bThumb);
              if (!empty($bItem['images'])) {
                $bDec = is_array($bItem['images']) ? $bItem['images'] : json_decode($bItem['images'], true);
                if (is_array($bDec) && count($bDec) > 0) {
                  $bImages = array_map('normalize_port_img', $bDec);
                }
              }
              $bHasMulti = count($bImages) > 1;
              $bImagesJson = htmlspecialchars(json_encode($bImages), ENT_QUOTES, 'UTF-8');
              $bBadge = !empty($bItem['badge']) ? htmlspecialchars($bItem['badge']) : '옥외매체';
              $bTag = !empty($bItem['tag']) ? htmlspecialchars($bItem['tag']) : '옥외광고';
              $bClient = !empty($bItem['client']) ? htmlspecialchars($bItem['client']) : '';
              $bLoc = !empty($bItem['location']) ? htmlspecialchars($bItem['location']) : '광주 맞춤 직영 시공';
            ?>
            <div class="swiper-slide asps-card main-port-card" data-cat="<?php echo htmlspecialchars($bItem['category']); ?>" data-id="<?php echo (int)$bItem['id']; ?>" data-name="<?php echo htmlspecialchars($bItem['title']); ?>" data-img="<?php echo $bThumb; ?>" data-images='<?php echo $bImagesJson; ?>' data-tag="<?php echo $bTag; ?>">
              <div class="asps-thumb">
                <img src="<?php echo $bThumb; ?>" alt="<?php echo htmlspecialchars($bItem['title']); ?>" loading="lazy">
                <span class="asps-badge"><?php echo $bBadge; ?></span>
                <?php if ($bHasMulti): ?>
                <!-- Main Card Photo Dots -->
                <div class="asps-card-photo-dots" onclick="event.stopPropagation();">
                  <?php foreach ($bImages as $dIdx => $dUrl): ?>
                  <button type="button" class="asps-card-dot-btn <?php echo $dIdx === 0 ? 'active' : ''; ?>" data-img-url="<?php echo htmlspecialchars($dUrl, ENT_QUOTES, 'UTF-8'); ?>" data-idx="<?php echo $dIdx; ?>" title="<?php echo ($dIdx + 1); ?>번 사진 보기" aria-label="<?php echo ($dIdx + 1); ?>번 사진 보기"></button>
                  <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <div class="asps-arrow-badge">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                </div>
              </div>
              <div class="asps-info">
                <div class="asps-title-row">
                  <strong class="asps-item-title"><?php echo htmlspecialchars($bItem['title']); ?></strong>
                  <span class="asps-title-arrow">↗</span>
                </div>
                <span class="asps-item-loc"><?php echo $bClient ? $bClient . ' · ' : ''; ?><?php echo $bLoc; ?></span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

    </div>
  </section>

<!-- ============================================
       03 SECTION 02 : 온라인 마케팅 솔루션 (위/아래 영문 타이포 스타일)
  ============================================ -->
  <section class="am-section am-bg-white" id="online">
    <div class="am-container">
      
      <!-- MAIN SEALNPACK TALL PORTRAIT LAYOUT -->
      <div class="som-layout-stage">
        
        <!-- LEFT: STICKY BRAND TITLE, DESCRIPTION, GUIDE BUTTON & KEYWORD TAG CLOUD -->
        <div class="som-left-content">
          
          <div class="som-title-wrap">
            <span class="ash-kicker">02 / DIGITAL MARKETING</span>
            <h2 class="ash-title">온라인 마케팅</h2>
          </div>

          <p class="som-desc">
          검색, 플레이스, 블로그, SNS, 홈페이지까지 고객이 브랜드를 발견하고 정보를 확인하는 다양한 온라인 접점을 함께 운영합니다.
          업종과 지역, 고객의 이용 흐름을 살펴 필요한 채널을 연결하고 콘텐츠와 광고를 지속적으로 관리합니다.
          </p>

          <button type="button" class="som-guide-btn bus-guide-open" data-guide="guideOnline">
            <span class="sgb-txt">온라인 채널 가이드</span>
          </button>

          <!-- PC ONLY: CUSTOM BRANDED KEYWORD TAG CLOUD -->
          <div class="som-tag-cloud pc_only" aria-label="온라인 마케팅 핵심 키워드"> 
            <span class="stc-item stc-highlight">병원마케팅<i class="stc-dot"></i></span> 
            <span class="stc-item stc-sub">의료기관 맞춤운영</span> 
            <span class="stc-item stc-sub">스마트플레이스</span> 
            <span class="stc-item stc-highlight">홈페이지 제작<i class="stc-dot"></i></span>
            <span class="stc-item stc-sub">네이버 검색마케팅</span> 
            
            <span class="stc-item stc-highlight">블로그 마케팅<i class="stc-dot"></i></span> 
            <span class="stc-item stc-sub">콘텐츠 기획</span> 
            
            <span class="stc-item stc-sub">지역 타깃 마케팅</span> 
            
            <span class="stc-item stc-highlight">SNS 마케팅<i class="stc-dot"></i></span> 
            <span class="stc-item stc-sub">타깃 광고</span> 
            
            <span class="stc-item stc-highlight">카페 바이럴<i class="stc-dot"></i></span> 
            <span class="stc-item stc-sub">키워드 전략</span> 
            
            <span class="stc-item stc-sub">브랜드 콘텐츠</span> 
            
            <span class="stc-item stc-highlight">검색광고<i class="stc-dot"></i></span> 
            <span class="stc-item stc-sub">온라인 통합 운영</span> 
            
            <span class="stc-item stc-highlight">당근 비즈니스<i class="stc-dot"></i></span> 
            <span class="stc-item stc-sub">지역 기반 광고</span> 
            
            <span class="stc-item stc-sub">숏폼 콘텐츠</span> 
            
            <span class="stc-item stc-highlight">SEO 최적화<i class="stc-dot"></i></span> 
            <span class="stc-item stc-sub">데이터 분석</span> 
            
            <span class="stc-item stc-sub">체험단 마케팅</span>
          </div>
        </div>

        <!-- RIGHT: DUAL VERTICAL MARQUEE STREAMS -->
        <div class="som-right-stream-wrap">
          
          <!-- STREAM COLUMN 1 -->
          <div class="som-stream-col som-col-1">
            <div class="som-stream-track track-1">
              
              <!-- ITEM 01 : BLOG -->
                <div class="som-stream-card">
                <img src="/images/online/online_blog.jpg" alt="브랜드 블로그 콘텐츠 운영">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Blog Content</span>
                    <strong class="sct-title">브랜드 블로그 &amp; 콘텐츠 운영</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Blog Content</span>
                    <strong class="shd-title">브랜드 블로그 &amp; 콘텐츠 운영</strong>
                    <p class="shd-desc">업종과 고객이 궁금해하는 주제를 바탕으로 검색 흐름을 고려한 콘텐츠를 기획하고 꾸준히 운영합니다.</p>
                    <span class="shd-tag">검색형 콘텐츠 운영</span>
                </div>
                </div>

                <!-- ITEM 02 : MOM CAFE -->
                <div class="som-stream-card">
                <img src="/images/online/online_local.jpg" alt="지역 커뮤니티 & 당근 마케팅">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Local Community</span>
                    <strong class="sct-title">지역 커뮤니티 &amp; 당근 마케팅</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Local Community</span>
                    <strong class="shd-title">지역 커뮤니티 &amp; 당근 마케팅</strong>
                    <p class="shd-desc">지역 커뮤니티와 생활권 플랫폼의 특성을 고려해 브랜드와 고객이 자연스럽게 만날 수 있는 접점을 만들어갑니다.</p>
                    <span class="shd-tag">지역 생활권 채널 운영</span>
                </div>
                </div>

                <!-- ITEM 03 : SMART PLACE -->
                <div class="som-stream-card">
                <img src="/images/online/online_place.jpg" alt="스마트플레이스 운영 & 예약 연동">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Smart Place</span>
                    <strong class="sct-title">스마트플레이스 &amp; 예약 연동</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Smart Place</span>
                    <strong class="shd-title">스마트플레이스 &amp; 예약 연동</strong>
                    <p class="shd-desc">매장 정보와 콘텐츠, 예약·톡톡 등 주요 기능을 정리해 검색 고객이 필요한 정보를 편리하게 확인할 수 있도록 관리합니다.</p>
                    <span class="shd-tag">플레이스 통합 관리</span>
                </div>
                </div>

                <!-- ITEM 04 : INSTAGRAM -->
                <div class="som-stream-card">
                <img src="/images/online/online_instagram.jpg" alt="인스타그램 콘텐츠 & 타깃 광고">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Social Media</span>
                    <strong class="sct-title">인스타그램 콘텐츠 &amp; 타깃 광고</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Social Media</span>
                    <strong class="shd-title">인스타그램 콘텐츠 &amp; 타깃 광고</strong>
                    <p class="shd-desc">브랜드에 맞는 피드와 릴스 콘텐츠를 제작하고 지역·연령·관심사 등을 고려한 타깃 광고를 함께 운영합니다.</p>
                    <span class="shd-tag">SNS 콘텐츠·광고 운영</span>
                </div>
                </div>

                <!-- EXACT 4 CLONES FOR SEAMLESS 50% LOOP -->
                <div class="som-stream-card som-clone-card">
                <img src="/images/online/online_blog.jpg" alt="브랜드 블로그 콘텐츠 운영">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Blog Content</span>
                    <strong class="sct-title">브랜드 블로그 &amp; 콘텐츠 운영</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Blog Content</span>
                    <strong class="shd-title">브랜드 블로그 &amp; 콘텐츠 운영</strong>
                    <p class="shd-desc">업종과 고객이 궁금해하는 주제를 바탕으로 검색 흐름을 고려한 콘텐츠를 기획하고 꾸준히 운영합니다.</p>
                    <span class="shd-tag">검색형 콘텐츠 운영</span>
                </div>
                </div>

                <div class="som-stream-card som-clone-card">
                <img src="/images/online/online_local.jpg" alt="지역 커뮤니티 & 당근 마케팅">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Local Community</span>
                    <strong class="sct-title">지역 커뮤니티 &amp; 당근 마케팅</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Local Community</span>
                    <strong class="shd-title">지역 커뮤니티 &amp; 당근 마케팅</strong>
                    <p class="shd-desc">지역 커뮤니티와 생활권 플랫폼의 특성을 고려해 브랜드와 고객이 자연스럽게 만날 수 있는 접점을 만들어갑니다.</p>
                    <span class="shd-tag">지역 생활권 채널 운영</span>
                </div>
                </div>

                <div class="som-stream-card som-clone-card">
                <img src="/images/online/online_place.jpg" alt="스마트플레이스 운영 & 예약 연동">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Smart Place</span>
                    <strong class="sct-title">스마트플레이스 &amp; 예약 연동</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Smart Place</span>
                    <strong class="shd-title">스마트플레이스 &amp; 예약 연동</strong>
                    <p class="shd-desc">매장 정보와 콘텐츠, 예약·톡톡 등 주요 기능을 정리해 검색 고객이 필요한 정보를 편리하게 확인할 수 있도록 관리합니다.</p>
                    <span class="shd-tag">플레이스 통합 관리</span>
                </div>
                </div>

                <div class="som-stream-card som-clone-card">
                <img src="/images/online/online_instagram.jpg" alt="인스타그램 콘텐츠 & 타깃 광고">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Social Media</span>
                    <strong class="sct-title">인스타그램 콘텐츠 &amp; 타깃 광고</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Social Media</span>
                    <strong class="shd-title">인스타그램 콘텐츠 &amp; 타깃 광고</strong>
                    <p class="shd-desc">브랜드에 맞는 피드와 릴스 콘텐츠를 제작하고 지역·연령·관심사 등을 고려한 타깃 광고를 함께 운영합니다.</p>
                    <span class="shd-tag">SNS 콘텐츠·광고 운영</span>
                </div>
            </div>

            </div>
          </div>
          <!-- STREAM COLUMN 2 -->
          <div class="som-stream-col som-col-2">
            <div class="som-stream-track track-2">
              
              <!-- ITEM 05 : GOOGLE & GDN -->
                <div class="som-stream-card">
                <img src="/images/online/online_analytics.jpg" alt="구글 검색 & 디스플레이 광고">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Google Ads</span>
                    <strong class="sct-title">구글 검색 &amp; 디스플레이 광고</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Google Ads</span>
                    <strong class="shd-title">구글 검색 &amp; 디스플레이 광고</strong>
                    <p class="shd-desc">검색과 디스플레이 네트워크를 활용해 관심 고객과의 접점을 넓히고 캠페인 목적에 맞춰 광고를 운영합니다.</p>
                    <span class="shd-tag">검색·디스플레이 운영</span>
                </div>
                </div>

                <!-- ITEM 06 : SEARCH ADS -->
                <div class="som-stream-card">
                <img src="/images/online/online_search.jpg" alt="네이버 검색광고 운영">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Search Ads</span>
                    <strong class="sct-title">네이버 검색광고 운영</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Search Ads</span>
                    <strong class="shd-title">네이버 검색광고 운영</strong>
                    <p class="shd-desc">업종과 지역에 맞는 키워드를 검토하고 광고 문구와 예산을 조정해 검색 과정에서 브랜드를 효과적으로 알릴 수 있도록 운영합니다.</p>
                    <span class="shd-tag">키워드·예산 관리</span>
                </div>
                </div>

                <!-- ITEM 07 : INFLUENCER -->
                <div class="som-stream-card">
                <img src="/images/online/online_influencer.jpg" alt="체험단 & 인플루언서 마케팅">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Experience Marketing</span>
                    <strong class="sct-title">체험단 &amp; 인플루언서 마케팅</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Experience Marketing</span>
                    <strong class="shd-title">체험단 &amp; 인플루언서 마케팅</strong>
                    <p class="shd-desc">업종과 브랜드에 맞는 참여자를 연결하고 실제 경험을 바탕으로 다양한 콘텐츠가 만들어질 수 있도록 운영합니다.</p>
                    <span class="shd-tag">체험형 콘텐츠 운영</span>
                </div>
                </div>

                <!-- ITEM 08 : WEB LANDING -->
                <div class="som-stream-card">
                <img src="/images/online/online_web.jpg" alt="홈페이지 & 랜딩페이지 제작">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Web &amp; Landing</span>
                    <strong class="sct-title">홈페이지 &amp; 랜딩페이지 제작</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Web &amp; Landing</span>
                    <strong class="shd-title">홈페이지 &amp; 랜딩페이지 제작</strong>
                    <p class="shd-desc">브랜드 정보와 고객의 이용 동선을 고려해 PC와 모바일에서 편리하게 사용할 수 있는 반응형 홈페이지와 랜딩페이지를 제작합니다.</p>
                    <span class="shd-tag">반응형 웹 제작</span>
                </div>
                </div>

                <!-- EXACT 4 CLONES FOR SEAMLESS 50% LOOP -->
                <div class="som-stream-card som-clone-card">
                <img src="/images/online/online_analytics.jpg" alt="구글 검색 & 디스플레이 광고">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Google Ads</span>
                    <strong class="sct-title">구글 검색 &amp; 디스플레이 광고</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Google Ads</span>
                    <strong class="shd-title">구글 검색 &amp; 디스플레이 광고</strong>
                    <p class="shd-desc">검색과 디스플레이 네트워크를 활용해 관심 고객과의 접점을 넓히고 캠페인 목적에 맞춰 광고를 운영합니다.</p>
                    <span class="shd-tag">검색·디스플레이 운영</span>
                </div>
                </div>

                <div class="som-stream-card som-clone-card">
                <img src="/images/online/online_search.jpg" alt="네이버 검색광고 운영">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Search Ads</span>
                    <strong class="sct-title">네이버 검색광고 운영</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Search Ads</span>
                    <strong class="shd-title">네이버 검색광고 운영</strong>
                    <p class="shd-desc">업종과 지역에 맞는 키워드를 검토하고 광고 문구와 예산을 조정해 검색 과정에서 브랜드를 효과적으로 알릴 수 있도록 운영합니다.</p>
                    <span class="shd-tag">키워드·예산 관리</span>
                </div>
                </div>

                <div class="som-stream-card som-clone-card">
                <img src="/images/online/online_influencer.jpg" alt="체험단 & 인플루언서 마케팅">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Experience Marketing</span>
                    <strong class="sct-title">체험단 &amp; 인플루언서 마케팅</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Experience Marketing</span>
                    <strong class="shd-title">체험단 &amp; 인플루언서 마케팅</strong>
                    <p class="shd-desc">업종과 브랜드에 맞는 참여자를 연결하고 실제 경험을 바탕으로 다양한 콘텐츠가 만들어질 수 있도록 운영합니다.</p>
                    <span class="shd-tag">체험형 콘텐츠 운영</span>
                </div>
                </div>

                <div class="som-stream-card som-clone-card">
                <img src="/images/online/online_web.jpg" alt="홈페이지 & 랜딩페이지 제작">
                <div class="som-card-scrim"></div>
                <div class="som-default-txt">
                    <span class="sct-kicker">Web &amp; Landing</span>
                    <strong class="sct-title">홈페이지 &amp; 랜딩페이지 제작</strong>
                </div>
                <div class="som-hover-detail">
                    <span class="shd-kicker">Web &amp; Landing</span>
                    <strong class="shd-title">홈페이지 &amp; 랜딩페이지 제작</strong>
                    <p class="shd-desc">브랜드 정보와 고객의 이용 동선을 고려해 PC와 모바일에서 편리하게 사용할 수 있는 반응형 홈페이지와 랜딩페이지를 제작합니다.</p>
                    <span class="shd-tag">반응형 웹 제작</span>
                </div>
                </div>

            </div>
          </div>

        </div>

      </div>

      <!-- ====================================================
           SECTION 02-B : HOW WE WORK (DIGITAL FLOW EDITORIAL)
      ==================================================== -->
      <div class="dflow-section">
        
        <!-- SUBTLE BACKGROUND WATERMARK TYPOGRAPHY -->
        <div class="dflow-bg-typo" aria-hidden="true">DIGITAL FLOW</div>

        <!-- SECTION HEADER -->
        <div class="dflow-header">
          <span class="dflow-kicker">HOW WE WORK</span>
          <h3 class="dflow-main-title">온라인에서 고객이 브랜드를 발견하고<br>문의하기까지의 흐름을 연결합니다.</h3>
          <p class="dflow-sub-desc">검색과 콘텐츠, 광고, 홈페이지를 각각 따로 보지 않고<br class="pc_only">고객의 이용 흐름에 맞춰 필요한 채널을 함께 운영합니다.</p>
        </div>

        <!-- 4-COLUMN EDITORIAL FLOW GRID -->
        <div class="dflow-grid" id="dflowGrid">
          
          <!-- ITEM 01 -->
          <div class="dflow-col" data-step="01">
            <div class="dflow-line-box">
              <div class="dflow-base-line"></div>
              <div class="dflow-accent-line"></div>
            </div>
            <div class="dflow-content">
              <div class="dflow-mask-reveal dflow-num-reveal">
                <span class="dflow-num">01</span>
              </div>
              <div class="dflow-mask-reveal dflow-eng-reveal">
                <span class="dflow-eng">FIND</span>
              </div>
              <div class="dflow-body-reveal">
                <h4 class="dflow-ko-title">검색 · 플레이스 · 키워드</h4>
                <p class="dflow-desc-text">고객이 필요한 정보를 검색에서 발견할 수 있도록<br class="pc_only">주요 검색 접점을 정리합니다.</p>
              </div>
            </div>
          </div>

          <!-- ITEM 02 -->
          <div class="dflow-col" data-step="02">
            <div class="dflow-line-box">
              <div class="dflow-base-line"></div>
              <div class="dflow-accent-line"></div>
            </div>
            <div class="dflow-content">
              <div class="dflow-mask-reveal dflow-num-reveal">
                <span class="dflow-num">02</span>
              </div>
              <div class="dflow-mask-reveal dflow-eng-reveal">
                <span class="dflow-eng">CONTENT</span>
              </div>
              <div class="dflow-body-reveal">
                <h4 class="dflow-ko-title">블로그 · SNS · 지역 커뮤니티</h4>
                <p class="dflow-desc-text">채널의 특성과 고객이 궁금해하는 내용을 고려해<br class="pc_only">브랜드 콘텐츠를 기획하고 운영합니다.</p>
              </div>
            </div>
          </div>

          <!-- ITEM 03 -->
          <div class="dflow-col" data-step="03">
            <div class="dflow-line-box">
              <div class="dflow-base-line"></div>
              <div class="dflow-accent-line"></div>
            </div>
            <div class="dflow-content">
              <div class="dflow-mask-reveal dflow-num-reveal">
                <span class="dflow-num">03</span>
              </div>
              <div class="dflow-mask-reveal dflow-eng-reveal">
                <span class="dflow-eng">ADVERTISING</span>
              </div>
              <div class="dflow-body-reveal">
                <h4 class="dflow-ko-title">검색광고 · SNS광고 · 디스플레이</h4>
                <p class="dflow-desc-text">캠페인 목적에 맞는 채널과 타깃을 설정해<br class="pc_only">필요한 고객과 만날 수 있도록 광고를 운영합니다.</p>
              </div>
            </div>
          </div>

          <!-- ITEM 04 -->
          <div class="dflow-col" data-step="04">
            <div class="dflow-line-box">
              <div class="dflow-base-line"></div>
              <div class="dflow-accent-line"></div>
            </div>
            <div class="dflow-content">
              <div class="dflow-mask-reveal dflow-num-reveal">
                <span class="dflow-num">04</span>
              </div>
              <div class="dflow-mask-reveal dflow-eng-reveal">
                <span class="dflow-eng">CONVERSION</span>
              </div>
              <div class="dflow-body-reveal">
                <h4 class="dflow-ko-title">홈페이지 · 랜딩페이지 · 문의 동선</h4>
                <p class="dflow-desc-text">광고와 콘텐츠에서 홈페이지와 랜딩페이지,<br class="pc_only">문의로 이어지는 흐름을 함께 정리합니다.</p>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>

  <!-- ============================================
       04 SECTION 03 : VIDEO PRODUCTION
  ============================================ -->
  <section class="am-section am-bg-dark am-video-ambient-sec" id="video">
    <div class="avs-ambient-bg">
      <div class="avs-glow glow-left"></div>
      <div class="avs-glow glow-right"></div>
    </div>

    <div class="am-container am-sec-head" style="position:relative; z-index:2; text-align:left; margin-bottom:120px;">
      <span class="ash-kicker cyan">03 / VIDEO &amp; CONTENT PRODUCTION</span>
      <h2 class="ash-title white">영상제작 솔루션</h2>
      <p class="ash-desc light" style="margin:0; text-align:left;">브랜드 홍보영상부터 SNS 릴스·숏폼, DID 등 매체별 영상 콘텐츠를 기획·촬영·편집합니다.</p>
    </div>

    <!-- VIDEO PRODUCTION VISUAL CENTER STAGE -->
    <div class="am-video-hero-stage wow fadeInUp" data-wow-duration="0.8s">
      
      <!-- HIGH-END SVG PICTOGRAM SEGMENT SWITCHER -->
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

      <!-- MAIN STAGE DISPLAY -->
      <div class="avh-display-arena" id="avhDisplayArena">
        
        <!-- 16:9 CINEMA FRAME -->
        <div class="avh-cinema-frame on" id="cinemaFrame">
          <div class="acf-bezel">
            <video autoplay muted loop playsinline class="acf-video">
              <source src="/images/movie.mp4" type="video/mp4">
            </video>
            <div class="acf-scrim"></div>
            <div class="acf-overlay-info">
              <span class="acf-tag gold">VIDEO &amp; CONTENT PRODUCTION</span>
              <h3 class="acf-title" id="dynCinemaTitle">기업 · 병원 브랜드 홍보영상</h3>
              <p class="acf-sub" id="dynCinemaSub">브랜드와 서비스의 특징을 담은 기획 · 촬영 · 편집</p>
            </div>
          </div>
        </div>

        <!-- 9:16 SMARTPHONE MOCKUP FRAME -->
        <div class="avh-phone-mockup" id="phoneMockup">
          <div class="apm-device">
            <div class="apm-dynamic-island">
              <span class="apm-camera"></span>
              <span class="apm-speaker"></span>
            </div>
            
            <div class="apm-screen">
              <video autoplay muted loop playsinline class="apm-video">
                <source src="/images/movie.mp4" type="video/mp4">
              </video>
              <div class="apm-reels-ui">
                <div class="aru-right-actions">
                  <div class="aru-action-btn">❤️</div>
                  <div class="aru-action-btn">💬</div>
                  <div class="aru-action-btn">↗️</div>
                </div>
                <div class="aru-bottom-info">
                  <span class="aru-brand-tag">@GAON_N_OFFICIAL</span>
                  <h4 class="aru-title">SNS 릴스 · 유튜브 숏폼</h4>
                  <p class="aru-desc">모바일 환경에 맞춘 세로형 영상 콘텐츠</p>
                </div>
              </div>
            </div>

            <div class="apm-home-bar"></div>
          </div>
        </div>

      </div>

      <!-- 3 CLEAN VISUAL DELIVERABLE SELECTORS -->
      <div class="avh-selectors-grid">

          <div class="avs-item-card on" data-target-mode="wide"
              data-title="기업 · 병원 · 브랜드 홍보영상"
              data-sub="브랜드와 서비스의 특징을 담은 기획·촬영·편집">
          <span class="avs-badge">01 / BRAND CONTENT</span>
          <strong class="avs-title">기업 · 병원 홍보영상</strong>
          <span class="avs-sub">브랜드 소개 · 인터뷰 · 홍보 콘텐츠</span>
          </div>

          <div class="avs-item-card" data-target-mode="shorts"
              data-title="SNS 릴스 · 유튜브 쇼츠 · 숏폼"
              data-sub="모바일 환경에 맞춘 세로형 영상 콘텐츠">
          <span class="avs-badge gold">02 / SOCIAL SHORTFORM</span>
          <strong class="avs-title">SNS 릴스 · 유튜브 숏폼</strong>
          <span class="avs-sub">9:16 모바일 세로형 콘텐츠</span>
          </div>

          <!-- 03 DID 전광판 영상 (숨김 처리)
          <div class="avs-item-card" data-target-mode="wide"
              data-title="DID 디지털 사이니지 영상"
              data-sub="설치 매체의 규격과 송출 환경에 맞춘 광고영상">
          <span class="avs-badge">03 / DIGITAL SIGNAGE</span>
          <strong class="avs-title">DID 전광판 영상</strong>
          <span class="avs-sub">매체 규격 맞춤 영상 콘텐츠</span>
          </div>
          -->

          <div class="avs-item-card" data-target-mode="wide"
              data-title="광고 · 캠페인 영상 콘텐츠"
              data-sub="온라인과 오프라인 광고에 활용할 수 있는 영상 제작">
          <span class="avs-badge">03 / AD CONTENT</span>
          <strong class="avs-title">광고 · 캠페인 영상</strong>
          <span class="avs-sub">기획 · 촬영 · 편집</span>
          </div>

      </div>

      <!-- SECTION 03 : RECENT 4K VIDEO PORTFOLIO SHOWCASE STRIP -->
      <div class="am-sub-port-strip dark wow fadeInUp" data-wow-duration="0.8s" style="margin-top:60px;">
        <div class="asps-head">
          <div class="asps-title-wrap">
            <span class="asps-kicker cyan">SELECTED VIDEO WORK</span>
            <h4 class="asps-title white">영상 · 콘텐츠 제작 사례</h4>
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
            <?php foreach ($portVideo as $vItem): 
              $vVideo = !empty($vItem['video']) ? $vItem['video'] : '';
              if (empty($vVideo) && !empty($vItem['id'])) {
                $vIdxMap = array(54 => '01', 55 => '02', 56 => '03', 57 => '04', 58 => '05', 63 => '06');
                if (isset($vIdxMap[$vItem['id']])) {
                  $vVideo = '/images/port/video/video_clip_' . $vIdxMap[$vItem['id']] . '.mp4';
                }
              }
              $vClient = !empty($vItem['client']) ? htmlspecialchars($vItem['client']) : '가온엔 기획 · 제작';
            ?>
            <div class="swiper-slide asps-card dark main-port-card" data-cat="<?php echo htmlspecialchars($vItem['category']); ?>" data-id="<?php echo (int)$vItem['id']; ?>" data-name="<?php echo htmlspecialchars($vItem['title']); ?>" data-img="<?php echo htmlspecialchars($vItem['thumb']); ?>" data-video="<?php echo htmlspecialchars($vVideo); ?>" data-tag="10초 영상 (스틸컷 캡쳐본)">
              <div class="asps-thumb">
                <img src="<?php echo htmlspecialchars($vItem['thumb']); ?>" alt="<?php echo htmlspecialchars($vItem['title']); ?>" loading="lazy">
                <span class="asps-badge cyan">10초 영상</span>
                <div class="asps-arrow-badge">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                </div>
              </div>
              <div class="asps-info">
                <div class="asps-title-row">
                  <strong class="asps-item-title white"><?php echo htmlspecialchars($vItem['title']); ?></strong>
                  <span class="asps-title-arrow" style="color:#ffffff;">▶</span>
                </div>
                <span class="asps-item-loc light"><?php echo $vClient; ?> · 스틸컷 캡쳐본</span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================
       04 SECTION : BROADCAST PROGRAM (#broadcast)
       SINGLE UNIFIED STICKY & EDITORIAL SHOWCASE
  ============================================ -->
  <section class="broadcast is-step-1" id="broadcast">
    <div class="broadcast-track">
      <div class="broadcast-sticky">
        
        <!-- SECTION HEADER -->
        <div class="broadcast-head wow fadeInUp" data-wow-duration="0.8s">
          <span class="broadcast-kicker">04 / TV BROADCAST</span>
          <h2 class="broadcast-head-title">TV 방송 프로그램</h2>
          <p class="broadcast-head-desc">
            지역 방송과 의료기관을 연결해<br class="pc_only">
            방송 프로그램 연계부터 진행까지 함께합니다.
          </p>
          <div class="broadcast-mob-tabs mob_only">
            <button type="button" class="bmt-btn is-active" data-step="1">
              <span class="bmt-num">01</span>
              <span class="bmt-name">닥터365</span>
              <span class="bmt-badge">독점</span>
            </button>
            <button type="button" class="bmt-btn" data-step="2">
              <span class="bmt-num">02</span>
              <span class="bmt-name">건강365</span>
            </button>
          </div>
        </div>

        <!-- MAIN SHOWCASE STAGE -->
        <div class="broadcast-stage">
          
          <!-- STEP 01 (1P) : KBC 닥터365 (EXCLUSIVE) -->
          <div class="broadcast-card is-kbc">
            <div class="broadcast-copy">
              <div class="broadcast-logo">
                <img src="/images/broadcast/kbc.png" alt="KBC" class="broadcast-logo-img">
              </div>
              <div class="broadcast-title-row">
                <h3 class="broadcast-title">닥터365</h3>
                <span class="broadcast-exclusive-badge">가온엔 독점 연계</span>
              </div>
              <p class="broadcast-desc">
                의료진의 전문성과 병원의 핵심 정보를 방송 콘텐츠로 구성해<br class="pc_only">
                지역 시청자에게 효과적으로 전달하는 KBC 건강정보 프로그램입니다.
              </p>
              <div class="broadcast-features">
                <span class="broadcast-feat-label">PROGRAM FEATURES</span>
                <ul class="broadcast-feat-list">
                  <li><span class="bf-num">01</span><span class="bf-txt">의료진 전문 콘텐츠 기획 및 구성</span></li>
                  <li><span class="bf-num">02</span><span class="bf-txt">지역 방송망을 통한 높은 신뢰도 확보</span></li>
                  <li><span class="bf-num">03</span><span class="bf-txt">가온엔 독점 프로그램 공식 연계 지원</span></li>
                </ul>
              </div>
              <div class="broadcast-cta">
                <a href="#contact" class="broadcast-cta-btn broadcast-cta-exclusive">
                  <span>닥터365 독점 연계 문의</span>
                  <span class="broadcast-cta-arrow">↗</span>
                </a>
              </div>
            </div>
            <div class="broadcast-visual">
              <img src="/images/broadcast/broadcast_kbc_365.jpg?v=<?php echo time(); ?>" alt="KBC 닥터365 가온엔 독점 연계 프로그램" class="broadcast-img" loading="lazy">
            </div>
          </div>

          <!-- STEP 02 (2P) : 광주MBC 건강365 -->
          <div class="broadcast-card is-mbc">
            <div class="broadcast-copy">
              <div class="broadcast-logo">
                <img src="/images/broadcast/mbc.png?v=<?php echo time(); ?>" alt="MBC" class="broadcast-logo-img">
              </div>
              <h3 class="broadcast-title">건강365</h3>
              <p class="broadcast-desc">
                의료진의 전문적인 건강 정보를 방송 콘텐츠로 전달하여<br class="pc_only">
                지역 시청자에게 쉽고 신뢰감 있게 전달하는 대표 의료·건강 정보 프로그램입니다.
              </p>
              <div class="broadcast-features">
                <span class="broadcast-feat-label">PROGRAM FEATURES</span>
                <ul class="broadcast-feat-list">
                  <li><span class="bf-num">01</span><span class="bf-txt">의료진 전문성 및 임상 정보 전달</span></li>
                  <li><span class="bf-num">02</span><span class="bf-txt">시청자 눈높이에 맞춘 건강정보 구성</span></li>
                  <li><span class="bf-num">03</span><span class="bf-txt">지역 시청자 대상 방송 연계 및 송출</span></li>
                </ul>
              </div>
              <div class="broadcast-cta">
                <a href="#contact" class="broadcast-cta-btn">
                  <span>건강365 문의</span>
                  <span class="broadcast-cta-arrow">↗</span>
                </a>
              </div>
            </div>
            <div class="broadcast-visual">
              <img src="/images/broadcast/broadcast_mbc_365.jpg?v=<?php echo time(); ?>" alt="MBC 건강365 방송 연계 프로그램" class="broadcast-img" loading="lazy">
            </div>
          </div>

          <!-- MOBILE CIRCULAR INDICATORS (01 ● 02) -->
          <div class="broadcast-mob-dots mob_only" aria-label="프로그램 전환">
            <button type="button" class="bmd-dot is-active" data-step="1" aria-label="KBC 닥터365"></button>
            <button type="button" class="bmd-dot" data-step="2" aria-label="MBC 건강365"></button>
          </div>

          <!-- NAVIGATION (01 ━━━━ 02) -->
          <div class="broadcast-nav" aria-label="프로그램 진행 순서">
            <button type="button" class="broadcast-nav-btn bnb-01" aria-label="KBC 닥터365">01</button>
            <div class="broadcast-nav-track"><div class="broadcast-nav-bar"></div></div>
            <button type="button" class="broadcast-nav-btn bnb-02" aria-label="MBC 건강365">02</button>
          </div>

        </div>

      </div>
    </div>
  </section>

  <!-- ============================================
       04-B SECTION : CLIENTS & PARTNERS (DIAGONAL WAVE SHOWCASE)
  ============================================ -->
  <section class="ga-partners-sec" id="partners">
    <div class="gp-container">
      
      <!-- STANDARD EDITORIAL HEADER -->
      <div class="gp-header-row wow fadeInUp" data-wow-duration="0.8s">
        <span class="gp-kicker">CLIENTS &amp; PARTNERS</span>
        <h2 class="gp-title">함께하는 파트너</h2>
        <p class="gp-desc">
          다양한 기업과 기관, 미디어 파트너와 함께<br class="pc_only">
          브랜드와 고객이 만나는 다양한 접점을 만들어갑니다.
        </p>
      </div>

      <!-- MOTION ACCENT LINE -->
      <div class="gp-motion-line-track wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s" aria-hidden="true">
        <div class="gp-motion-line-segment"></div>
      </div>

      <!-- PARTNERS 2-ROW DIAGONAL STAGE -->
      <div class="gp-stage-wrapper wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.15s">
        <div class="gp-diagonal-stage" id="gpDiagonalStage" aria-live="off">
          
          <!-- ROW A (5 Items) -->
          <div class="gp-row gp-row-a">
            <div class="gp-slot" data-row="0" data-col="0">
              <img src="/images/partners/kbc.png" alt="KBC" class="gp-partner-logo opt-compact is-active" loading="lazy">
            </div>
            <div class="gp-slot" data-row="0" data-col="1">
              <img src="/images/partners/mbc.jpg" alt="광주MBC" class="gp-partner-logo opt-compact is-active" loading="lazy">
            </div>
            <div class="gp-slot" data-row="0" data-col="2">
              <img src="/images/partners/광주광역시청.jpg" alt="광주광역시청" class="gp-partner-logo opt-standard is-active" loading="lazy">
            </div>
            <div class="gp-slot" data-row="0" data-col="3">
              <img src="/images/partners/폴리텍대학.svg" alt="한국폴리텍대학" class="gp-partner-logo opt-standard is-active" loading="lazy">
            </div>
            <div class="gp-slot" data-row="0" data-col="4">
              <img src="/images/partners/롯데하이마트.png" alt="롯데하이마트" class="gp-partner-logo opt-standard is-active" loading="lazy">
            </div>
          </div>

          <!-- ROW B (5 Items - Organic Offset) -->
          <div class="gp-row gp-row-b">
            <div class="gp-slot" data-row="1" data-col="0">
              <img src="/images/partners/국립목포대학교.jpg" alt="국립목포대학교" class="gp-partner-logo opt-wide is-active" loading="lazy">
            </div>
            <div class="gp-slot" data-row="1" data-col="1">
              <img src="/images/partners/김대중컨벤션센터로고.jpg" alt="김대중컨벤션센터" class="gp-partner-logo opt-boost is-active" loading="lazy">
            </div>
            <div class="gp-slot" data-row="1" data-col="2">
              <img src="/images/partners/더스마트병원.jpg" alt="더스마트병원" class="gp-partner-logo opt-standard is-active" loading="lazy">
            </div>
            <div class="gp-slot" data-row="1" data-col="3">
              <img src="/images/partners/스마트인재개발원.png" alt="스마트인재개발원" class="gp-partner-logo opt-standard is-active" loading="lazy">
            </div>
            <div class="gp-slot" data-row="1" data-col="4">
              <img src="/images/partners/봉선한방병원.png" alt="봉선한방병원" class="gp-partner-logo opt-standard is-active" loading="lazy">
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>

  <!-- ============================================
       05 SECTION 04 : EDITORIAL WORKFLOW PIPELINE (#process)
  ============================================ -->
  <section class="am-section ga-process-editorial-sec" id="process">
    <div class="go-container">
      
      <!-- SECTION HEADER -->
      <div class="gpe-header-row wow fadeInUp" data-wow-duration="0.7s">
        <span class="gpe-kicker">04 / WORKFLOW PIPELINE</span>
        <h2 class="gpe-title">프로젝트 진행 과정</h2>
        <p class="gpe-desc">상담부터 기획, 제작, 운영까지 필요한 과정을 하나의 흐름으로 연결합니다.</p>
      </div>

      <!-- MAIN 2-COLUMN EDITORIAL STAGE -->
      <div class="gpe-stage-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- LEFT: STICKY GIANT STEP NUMBER -->
        <div class="gpe-left-col pc_only">
          <div class="gpe-giant-wrap">
            <span class="gpe-giant-num" id="gpeActiveNum">01</span>
            <div class="gpe-giant-meta">
              <span class="gpe-giant-tag" id="gpeActiveEng">CONSULTING</span>
              <strong class="gpe-giant-title" id="gpeActiveTitle">상담 · 매체 검토</strong>
            </div>
          </div>
        </div>

        <!-- RIGHT: 4 EDITORIAL PROCESS STEPS -->
        <div class="gpe-right-col" id="gpeStepList">
          
          <!-- STEP 01 -->
          <div class="gpe-step-item on" data-step="01" data-eng="CONSULTING" data-title="상담 · 매체 검토">
            <div class="gpe-item-num-wrap">
              <span class="gpe-item-num">01</span>
            </div>
            <div class="gpe-item-content">
              <div class="gpe-item-head">
                <span class="gpe-item-eng">CONSULTING</span>
                <h3 class="gpe-item-title">상담 · 매체 검토</h3>
              </div>
              <p class="gpe-item-desc">목표와 상황을 살펴 필요한 광고 채널과 진행 방향을 검토합니다.</p>
            </div>
          </div>

          <!-- STEP 02 -->
          <div class="gpe-step-item" data-step="02" data-eng="PLANNING" data-title="기획 · 디자인">
            <div class="gpe-item-num-wrap">
              <span class="gpe-item-num">02</span>
            </div>
            <div class="gpe-item-content">
              <div class="gpe-item-head">
                <span class="gpe-item-eng">PLANNING</span>
                <h3 class="gpe-item-title">기획 · 디자인</h3>
              </div>
              <p class="gpe-item-desc">매체와 고객 접점을 고려해 광고와 콘텐츠의 방향을 설계합니다.</p>
            </div>
          </div>

          <!-- STEP 03 -->
          <div class="gpe-step-item" data-step="03" data-eng="PRODUCTION" data-title="제작 · 시공 · 콘텐츠">
            <div class="gpe-item-num-wrap">
              <span class="gpe-item-num">03</span>
            </div>
            <div class="gpe-item-content">
              <div class="gpe-item-head">
                <span class="gpe-item-eng">PRODUCTION</span>
                <h3 class="gpe-item-title">제작 · 시공 · 콘텐츠</h3>
              </div>
              <p class="gpe-item-desc">직영 출력 및 전문 시공팀의 정밀 부착, 영상 촬영·편집, 웹 개발을 완성도 높게 실행합니다.</p>
            </div>
          </div>

          <!-- STEP 04 -->
          <div class="gpe-step-item" data-step="04" data-eng="MANAGEMENT" data-title="운영 · 사후관리">
            <div class="gpe-item-num-wrap">
              <span class="gpe-item-num">04</span>
            </div>
            <div class="gpe-item-content">
              <div class="gpe-item-head">
                <span class="gpe-item-eng">MANAGEMENT</span>
                <h3 class="gpe-item-title">운영 · 사후관리</h3>
              </div>
              <p class="gpe-item-desc">시공 증빙 자료 제공 및 집행 기간 동안 지속적인 모니터링과 데이터 피드백을 진행합니다.</p>
            </div>
          </div>

        </div>

      </div>

    </div>
  </section>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/bottom_conversion.php"; ?>

  <!-- ============================================
       10 LUXURY DIRECTORY: 104 BUS ROUTES SEARCH MODAL
  ============================================ -->
  <div class="route-search-modal-overlay" id="routeSearchModal" style="display:none;">
    <div class="rsm-panel">
      <div class="rsm-head">
        <div class="rsm-content-wrap">
          <div class="rsm-kicker-row">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <span class="rsm-kicker-text">광주 시내버스 주요 노선 실시간 검색</span>
          </div>
          <h3 class="rsm-title">광주 시내버스 주요 노선 디렉토리</h3>
          <p class="rsm-desc">광주광역시 주요 노선(급행/간선/지선)의 주요 경유 상권, 운행 대수, 배차 간격 및 타깃 정보입니다.</p>
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
          <button type="button" class="rsm-tab on" data-filter-cat="all">버스 노선</button>
          <button type="button" class="rsm-tab" data-filter-cat="express">급행 노선 (6)</button>
          <button type="button" class="rsm-tab" data-filter-cat="main">간선 노선 (24)</button>
          <button type="button" class="rsm-tab" data-filter-cat="feeder">지선 노선 (74)</button>
          <button type="button" class="rsm-tab" data-filter-cat="seo">서구 (상무·광천)</button>
          <button type="button" class="rsm-tab" data-filter-cat="nam">남구 (봉선·풍암)</button>
          <button type="button" class="rsm-tab" data-filter-cat="buk">북구 (용봉·일곡)</button>
          <button type="button" class="rsm-tab" data-filter-cat="gwangsan">광산구 (수완·첨단)</button>
          <a href="http://bus.gwangju.go.kr" target="_blank" rel="noopener noreferrer" class="rsm-tab rsm-external-tab" title="광주광역시 버스운행정보시스템 공식 사이트 새창 열기">
            <span>광주버스(BIS) 전체 노선보기</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          </a>
        </div>

        <div class="rsm-directory-list" id="modalBusRouteFullGrid">
          <!-- Injected dynamically -->
        </div>
      </div>

      <div class="rsm-foot">
        <div class="rf-notice">
          <strong>※ 병원 / 학원 / 매장 앞 통과 노선 맞춤 매칭 안내</strong>
          <span>광고주님의 사업장 위치를 알려주시면 가장 유효 노출 빈도가 높은 최적 노선 조합을 1:1 맞춤 컨설팅해 드립니다.</span>
        </div>
        <div class="rsm-foot-actions">
          <a href="http://bus.gwangju.go.kr" target="_blank" rel="noopener noreferrer" class="rsm-bis-btn" title="광주광역시 버스운행정보시스템 새창 열기">
            <span>광주버스(BIS) 전체 노선보기</span>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          </a>
          <a href="/board/estmate/write.php" class="rsm-foot-btn" onclick="closeRouteModal();">1:1 노선 맞춤 분석 신청 →</a>
        </div>
      </div>
    </div>
  </div>


  <!-- ============================================
       11 HIGH-END 6-CATEGORY MASTER SPECIFICATION & PROPOSAL MODAL
  ============================================ -->
  <div class="bus-guide-overlay" id="busGuideOverlay" style="display:none;">
    <div class="lux-modal-panel">
      
      <!-- CLEAN WHITE EXECUTIVE HEADER -->
      <div class="lux-modal-head">
        <div class="lmh-content-wrap">
          <div class="lmh-kicker-row">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <span class="lmh-label">가온엔 공식 매체 규격 &amp; 제안서 다운로드</span>
          </div>
          <h3 class="lmh-title">가온엔 통합 매체 공식 규격 및 제안서</h3>
          <p class="lmh-desc">시내버스 외부·내부광고부터 터미널 전광판, 특화 옥외매체, 온라인 마케팅, 영상·인쇄물까지 주요 서비스의 규격과 안내자료를 확인할 수 있습니다.</p>
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
        <button type="button" class="lmt-tab" data-target="guideUsquare">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
          <span>유스퀘어·터미널</span>
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
          
          <!-- TOP PROPOSAL DOWNLOAD BANNER -->
          <div class="lmg-download-banner">
            <div class="ldb-info">
              <span class="ldb-badge">OFFICIAL PDF</span>
              <strong class="ldb-title">광주 시내버스 외부광고 공식 제안서 및 단가표 (PDF)</strong>
              <p class="ldb-meta">광주 1,040대 인가 차량 실측 도면 · 차종별 정밀 규격 및 101개 노선별 공식 단가표 수록</p>
            </div>
            <a href="/pdf/gaon_bus_outside.pdf" download="가온엔_광주시내버스_외부광고_매체제안서.pdf" class="ldb-btn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              <span>공식 제안서 다운로드</span>
            </a>
          </div>

          <!-- KEY METRICS STATS BAR -->
          <div class="lmg-stats-strip">
            <div class="lss-card">
              <span class="lss-num">1,040<span style="font-size:16px; font-weight:700;">대</span></span>
              <strong class="lss-label">차량 인가대수</strong>
              <span class="lss-desc">광주광역시 시내버스 운행 차량</span>
            </div>
            <div class="lss-card">
              <span class="lss-num">101<span style="font-size:16px; font-weight:700;">개</span></span>
              <strong class="lss-label">운행 노선망</strong>
              <span class="lss-desc">급행 6 · 간선 31 · 지선 64개</span>
            </div>
            <div class="lss-card">
              <span class="lss-num">7~9<span style="font-size:16px; font-weight:700;">회</span></span>
              <strong class="lss-label">1일 평균 왕복</strong>
              <span class="lss-desc">1일 18시간 고정 노선 반복 운행</span>
            </div>
            <div class="lss-card">
              <span class="lss-num">3면<span style="font-size:16px; font-weight:700;">구성</span></span>
              <strong class="lss-label">기본 부착 구성</strong>
              <span class="lss-desc">차도면 + 인도면 + 하차문</span>
            </div>
          </div>

          <!-- 01. OFFICIAL ADVERTISING RATES -->
          <h4 class="lmg-sec-heading">시내버스 외부광고 기본 단가표 (월 기준 / 1대당)</h4>
          <div class="lmg-rate-grid">
            
            <!-- 측면광고 -->
            <div class="lrg-card">
              <div class="lrg-title-row">
                <h5 class="lrg-title">시내버스 측면광고</h5>
                <span class="lrg-sub">차도면 + 인도면 + 하차문 3면 구성</span>
              </div>
              <div class="lrg-price-box">
                <div class="lrg-row">
                  <span class="lrg-k">광고료 (月)</span>
                  <strong class="lrg-v">700,000<span style="font-size:13px; font-weight:700;">원</span></strong>
                </div>
                <div class="lrg-row">
                  <span class="lrg-k">초기 제작비 (1회)</span>
                  <strong class="lrg-v small">150,000원</strong>
                </div>
              </div>
              <div class="lrg-spec-tag">
                차도면(370×100) + 인도면(270×50) + 하차문(85×100)
              </div>
            </div>

            <!-- 후면광고 -->
            <div class="lrg-card">
              <div class="lrg-title-row">
                <h5 class="lrg-title">시내버스 후면광고</h5>
                <span class="lrg-sub">후방 대기 운전자 시선 정면 배치</span>
              </div>
              <div class="lrg-price-box">
                <div class="lrg-row">
                  <span class="lrg-k">광고료 (月)</span>
                  <strong class="lrg-v">300,000<span style="font-size:13px; font-weight:700;">원</span></strong>
                </div>
                <div class="lrg-row">
                  <span class="lrg-k">초기 제작비 (1회)</span>
                  <strong class="lrg-v small">70,000원</strong>
                </div>
              </div>
              <div class="lrg-spec-tag">
                차량 후면 전용 규격 적용 (세부 실측 규격은 제안서 수록)
              </div>
            </div>

            <!-- 세트광고 -->
            <div class="lrg-card featured">
              <span class="lrg-ribbon">패키지</span>
              <div class="lrg-title-row">
                <h5 class="lrg-title">시내버스 세트광고</h5>
                <span class="lrg-sub">측면 3면 + 후면 통합 집행</span>
              </div>
              <div class="lrg-price-box">
                <div class="lrg-row">
                  <span class="lrg-k">광고료 (月)</span>
                  <strong class="lrg-v" style="color:#1d4ed8;">1,000,000<span style="font-size:13px; font-weight:700;">원</span></strong>
                </div>
                <div class="lrg-row">
                  <span class="lrg-k">초기 제작비 (1회)</span>
                  <strong class="lrg-v small">200,000원</strong>
                </div>
              </div>
              <div class="lrg-spec-tag" style="background:#eff6ff; border-color:#bfdbfe; color:#1d4ed8;">
                차도면 + 인도면 + 하차문 + 후면 통합 부착
              </div>
            </div>

          </div>

          <!-- 나주 광역 & 마을버스 단가 미니 그리드 -->
          <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:16px; margin-bottom:28px;">
            <div class="lrg-card" style="padding:18px 20px;">
              <div style="display:flex; justify-content:space-between; align-items:center;">
                <strong style="font-size:15.5px; color:#0f172a; font-weight:900;">나주 광역버스 (999번 등)</strong>
                <span style="font-size:11px; background:#faf5ff; color:#9333ea; border:1px solid #e9d5ff; padding:2px 8px; border-radius:4px; font-weight:800;">혁신도시 노선</span>
              </div>
              <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:8px; padding-top:8px; border-top:1px dashed #e2e8f0;">
                <span>측면: <strong>600,000원</strong> <span style="font-size:11px; color:#64748b;">(제작비 10만)</span></span>
                <span>후면: <strong>250,000원</strong> <span style="font-size:11px; color:#64748b;">(제작비 6만)</span></span>
              </div>
            </div>

            <div class="lrg-card" style="padding:18px 20px;">
              <div style="display:flex; justify-content:space-between; align-items:center;">
                <strong style="font-size:15.5px; color:#0f172a; font-weight:900;">광주 마을버스</strong>
                <span style="font-size:11px; background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; padding:2px 8px; border-radius:4px; font-weight:800;">지역 생활권</span>
              </div>
              <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:8px; padding-top:8px; border-top:1px dashed #e2e8f0;">
                <span>측면: <strong>600,000원</strong> <span style="font-size:11px; color:#64748b;">(제작비 10만 / 빛고을면 10만)</span></span>
                <span>후면: <strong>250,000원</strong> <span style="font-size:11px; color:#64748b;">(제작비 6만)</span></span>
              </div>
            </div>
          </div>

          <!-- 02. DETAILED VEHICLE SPECIFICATION TABLE -->
          <h4 class="lmg-sec-heading">시내버스 차종별 실측 정밀 규격 (단위 : cm)</h4>
          <div class="lmg-table-wrap">
            <table class="lmg-spec-table">
              <thead>
                <tr>
                  <th style="width:14%;">구분</th>
                  <th style="width:20%;">부착 위치</th>
                  <th style="width:23%;">대형 / 저상버스</th>
                  <th style="width:21%;">중형버스</th>
                  <th style="width:22%;">좌석버스</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td rowspan="2" style="font-weight:800; background:#f8fafc; text-align:center;">측면 광고</td>
                  <td><strong>차도면 (좌측면)</strong></td>
                  <td>
                    일반 <strong class="lmg-size-val">370 × 100</strong> cm<br>
                    저상 <strong class="lmg-size-val">370 × 90</strong> cm
                  </td>
                  <td><strong class="lmg-size-val">300 × 100</strong> cm</td>
                  <td><strong class="lmg-size-val">370 × 90</strong> cm</td>
                </tr>
                <tr>
                  <td><strong>인도면 (우측면) + 하차문</strong></td>
                  <td>
                    인도면 <strong class="lmg-size-val">270 × 50</strong> cm<br>
                    하차문 <strong class="lmg-size-val">85 × 100</strong> cm<br>
                    <span class="lmg-note">※ 저상버스 하차문 옆면 70×60 cm</span>
                  </td>
                  <td>
                    인도면 <strong class="lmg-size-val">230 × 50</strong> cm<br>
                    하차문 <strong class="lmg-size-val">85 × 100</strong> cm
                  </td>
                  <td>
                    인도면 <strong class="lmg-size-val">250 × 50</strong> cm<br>
                    하차문 <strong class="lmg-size-val">75 × 90</strong> cm
                  </td>
                </tr>
                <tr>
                  <td style="font-weight:800; background:#f8fafc; text-align:center;">후면 광고</td>
                  <td><strong>후면 번호판 상/중/하단</strong></td>
                  <td colspan="3">
                    차종별 맞춤 규격 적용 <span class="lmg-note">(※ 현대·대우·전기차 등 차종별 상세 도면 및 치수는 공식 제안서 참조)</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- 03. 4 KEY ADVERTISING FEATURES -->
          <h4 class="lmg-sec-heading">시내버스 외부광고 주요 매체 특징</h4>
          <div class="lmg-high-contrast-grid">
            
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">01. 접촉 빈도</span>
                <strong class="lhc-size">도심 집중 노출</strong>
                <span class="lhc-aspect">도심 이동 동선 중심</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">보행자 및 차량 운전자 대상 상시 노출</h5>
                <p class="lhc-desc">광주 주요 간선도로와 교차로를 순환하며 보행자 및 차량 운전자의 시선에 자연스럽게 전달됩니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">02. 노선 타깃팅</span>
                <strong class="lhc-size">1일 18시간 운행</strong>
                <span class="lhc-aspect">1일 7~9회 반복 순환</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">핵심 생활권 중심의 지정 노선 운행</h5>
                <p class="lhc-desc">상무지구, 수완지구, 첨단지구 등 광고주의 타깃 상권을 경유하는 노선을 선택해 지속적인 지역 마케팅이 가능합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge green">03. 대형 규격</span>
                <strong class="lhc-size">3.7m 와이드</strong>
                <span class="lhc-aspect">차도면 3,700 × 1,000 mm</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">선명한 비주얼과 높은 시인성</h5>
                <p class="lhc-desc">차도면 대형 규격과 차량 전용 실사 원단을 적용해 원거리에서도 상호와 주요 메시지를 명확히 전달합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge purple">04. 맞춤 배정</span>
                <strong class="lhc-size">노선 맞춤 기획</strong>
                <span class="lhc-aspect">상권 및 이동 동선 분석</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">광고주 사업장 위치에 맞춘 최적 노선 제안</h5>
                <p class="lhc-desc">병원, 학원, 매장 등 광고주의 타깃 권역과 주요 이동 동선을 분석하여 가장 효율적인 노선 조합을 제안합니다.</p>
              </div>
            </div>

          </div>

        </div>

        <!-- 02 BUS INSIDE & VOICE GUIDE -->
        <div class="bus-guide-page" id="guideBusIn">
          <div class="lmg-download-banner">
            <div class="ldb-info">
              <span class="ldb-badge">OFFICIAL PDF</span>
              <strong class="ldb-title">광주 시내버스 내부광고 &amp; 음성안내 공식 제안서 (PDF)</strong>
              <p class="ldb-meta">노선도, 하차문, 좌석시트, 천정/유리창 및 정류소 음성안내 광고 규격 수록</p>
            </div>
            <div class="ldb-actions-right">
              <a href="/pdf/gaon_bus_inside.pdf" download="가온엔_시내버스_내부광고_공식제안서.pdf" class="ldb-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                <span>내부광고 제안서</span>
              </a>
              <a href="/pdf/gaon_bus_voice.pdf" download="가온엔_시내버스_음성광고_공식제안서.pdf" class="ldb-btn ldb-btn-dark">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                <span>음성광고 제안서</span>
              </a>
            </div>
          </div>

          <!-- 01. BUS INTERIOR SUMMARY SPEC TABLE -->
          <h4 class="lmg-sec-heading">시내버스 내부광고 매체별 규격 및 부착 위치</h4>
          <div class="lmg-table-wrap" style="margin-bottom:28px;">
            <table class="lmg-spec-table">
              <thead>
                <tr>
                  <th style="width:18%;">매체 구분</th>
                  <th style="width:22%;">부착 위치</th>
                  <th style="width:20%;">표준 규격 (가로×세로)</th>
                  <th style="width:16%;">1대당 수량</th>
                  <th style="width:24%;">매체 특장점</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="font-weight:800; background:#f8fafc; text-align:center;">노선도 광고</td>
                  <td>차량 내부 상단 노선도 부근</td>
                  <td><strong class="lmg-size-val">110 × 50</strong> cm</td>
                  <td>1대당 2매</td>
                  <td>탑승객 시선이 오래 머무는 위치</td>
                </tr>
                <tr>
                  <td style="font-weight:800; background:#f8fafc; text-align:center;">하차문 광고</td>
                  <td>하차문 유리창 및 측면부</td>
                  <td><strong class="lmg-size-val">100 × 50</strong> cm</td>
                  <td>1대당 1매</td>
                  <td>하차 직전 승객 대상 시선 접촉</td>
                </tr>
                <tr>
                  <td style="font-weight:800; background:#f8fafc; text-align:center;">좌석시트 광고</td>
                  <td>승객 좌석 등받이 후면</td>
                  <td><strong class="lmg-size-val">24 × 12</strong> cm</td>
                  <td>1대당 약 20매</td>
                  <td>이동 시간 동안 착석 승객 노출</td>
                </tr>
                <tr>
                  <td style="font-weight:800; background:#f8fafc; text-align:center;">천정/유리창 광고</td>
                  <td>내부 측면 유리창 상단</td>
                  <td><strong class="lmg-size-val">55 × 25</strong> cm</td>
                  <td>1대당 다수 매</td>
                  <td>입석 및 착석 승객 시야 확보</td>
                </tr>
                <tr>
                  <td style="font-weight:800; background:#f8fafc; text-align:center;">정류소 음성안내</td>
                  <td>차내 자동 안내방송</td>
                  <td><strong class="lmg-size-val">7초 이내 (56자)</strong></td>
                  <td>1개 정류소 1구좌</td>
                  <td>하차 안내 시 성우 음성 송출</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- 02. BUS INTERIOR CARDS -->
          <h4 class="lmg-sec-heading">내부 매체별 상세 안내</h4>
          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">노선도 광고</span>
                <strong class="lhc-size">1,100 × 500 mm</strong>
                <span class="lhc-aspect">1대당 2매 부착</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">노선도 광고</h5>
                <p class="lhc-desc">버스 내부 상단 노선도 옆에 부착되어 탑승객이 이동하는 동안 시선이 자연스럽게 머무는 매체입니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">하차문 광고</span>
                <strong class="lhc-size">1,000 × 500 mm</strong>
                <span class="lhc-aspect">하차문 주변 부착</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">하차문 광고</h5>
                <p class="lhc-desc">하차문 주변에 부착되어 버스에서 내리는 승객들에게 자연스럽게 노출됩니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">좌석시트 광고</span>
                <strong class="lhc-size">240 × 120 mm</strong>
                <span class="lhc-aspect">좌석 등받이 부착</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">좌석 시트 광고</h5>
                <p class="lhc-desc">승객 좌석 등받이 후면에 설치되어 착석 승객에게 가까운 거리에서 반복 노출됩니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">천정/유리창 광고</span>
                <strong class="lhc-size">550 × 250 mm</strong>
                <span class="lhc-aspect">유리창 상단 부착</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">천정 / 유리창 광고</h5>
                <p class="lhc-desc">버스 내부 측면 유리창 상단 공간을 활용하여 승객들에게 부담 없이 노출됩니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">음성안내 방송</span>
                <strong class="lhc-size">7초 이내 (56자)</strong>
                <span class="lhc-aspect">정류소 도착 전 방송</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">정류소 음성안내 방송</h5>
                <p class="lhc-desc">지정 정류소 도착 전 차내 안내방송을 통해 상호와 위치 정보를 음성으로 전달합니다.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 03 TERMINAL GUIDE (U-SQUARE & REGIONAL TERMINAL SEPARATED) -->
        <div class="bus-guide-page" id="guideUsquare">
          
          <!-- PART 1 : 광주 유스퀘어 터미널 광고 (3종) -->
          <div class="lmg-terminal-group" style="margin-bottom: 36px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
              <span class="lhc-badge purple" style="font-size:12px; font-weight:800; padding:4px 10px;">유스퀘어 광고</span>
              <h4 style="font-size:18px; font-weight:800; color:#0f172a; margin:0;">01. 광주 유스퀘어 터미널 광고</h4>
              <span style="font-size:13px; color:#64748b;">(호남 최대 복합교통문화공간)</span>
            </div>
            
            <div class="lmg-high-contrast-grid">
              <div class="lhc-card">
                <div class="lhc-side">
                  <span class="lhc-badge purple">유스퀘어 전광판</span>
                  <strong class="lhc-size">2,500 × 1,500 mm</strong>
                  <span class="lhc-aspect">고속버스 매표소 상단</span>
                </div>
                <div class="lhc-main">
                  <h5 class="lhc-title">유스퀘어 매표소 상단 대형 LED 전광판</h5>
                  <p class="lhc-desc">
                    유스퀘어 고속버스 매표소 상단에 위치하여 표를 예매하거나 대기하는 유동인구에게 고정이미지 및 동영상 광고를 선명하게 송출합니다.
                  </p>
                </div>
              </div>
              <div class="lhc-card">
                <div class="lhc-side">
                  <span class="lhc-badge purple">중앙통로 광고</span>
                  <strong class="lhc-size">벽면 조명 패널</strong>
                  <span class="lhc-aspect">1층 메인 이동동선</span>
                </div>
                <div class="lhc-main">
                  <h5 class="lhc-title">유스퀘어 1층 중앙통로 조명 광고</h5>
                  <p class="lhc-desc">
                    유스퀘어 1층 출입구 및 편의시설로 이어지는 핵심 중앙통로 벽면에 설치되어 보행자 시선 정면에 선명하게 노출됩니다.
                  </p>
                </div>
              </div>
              <div class="lhc-card">
                <div class="lhc-side">
                  <span class="lhc-badge purple">터미널 쉘터</span>
                  <strong class="lhc-size">정류소 양면 쉘터</strong>
                  <span class="lhc-aspect">시내·시외버스 승강장</span>
                </div>
                <div class="lhc-main">
                  <h5 class="lhc-title">유스퀘어 광천터미널 승강장 쉘터 광고</h5>
                  <p class="lhc-desc">
                    광천터미널 앞 시내버스 환승 승강장 및 시외버스 승차 구역에 위치하여 버스를 기다리는 탑승객과 차량 이용자에게 주야간 높은 주목도를 제공합니다.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- PART 2 : 일반 시외·고속 버스터미널 광고 (지역별 터미널) -->
          <div class="lmg-terminal-group" style="padding: 24px; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 16px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:14px; flex-wrap:wrap;">
              <span class="lhc-badge blue" style="font-size:12px; font-weight:800; padding:4px 10px;">지역 터미널</span>
              <h4 style="font-size:18px; font-weight:800; color:#0f172a; margin:0;">02. 일반 시외·고속 버스터미널 광고</h4>
              <span style="font-size:13px; font-weight:600; color:#475569;">(영광 · 목포 · 해남 · 나주 · 순천 등 전남·광역권)</span>
            </div>
            
            <div class="lhc-card" style="background:#ffffff; border-color:#cbd5e1; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
              <div class="lhc-side">
                <span class="lhc-badge blue">일반 터미널</span>
                <strong class="lhc-size" style="font-size:14px; color:#1e293b;">지역별 규격 상이</strong>
                <span class="lhc-aspect">대합실 · 승차홈 벽면</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">각 지역 버스터미널 대합실 조명 광고 및 내부 광고판</h5>
                <p class="lhc-desc" style="line-height:1.65;">
                  일반 버스터미널 광고는 각 지역 터미널의 건물 구조와 대합실 환경에 따라 설치 규격 및 사이즈에 차이가 있습니다.<br>
                  영광종합버스터미널, 목포종합버스터미널 등 희망하시는 지역을 문의해 주시면 해당 터미널의 실측 규격과 광고 위치를 안내해 드립니다.
                </p>
              </div>
            </div>
          </div>

        </div>

        <!-- 04 TAXI & SPECIALIZED OOH GUIDE (AUTHENTIC TAXI PROPOSAL DATA) -->
        <div class="bus-guide-page" id="guideTaxiSpec">
          
          <!-- TOP PROPOSAL DOWNLOAD BANNER -->
          <div class="lmg-download-banner">
            <div class="ldb-info">
              <span class="ldb-badge">OFFICIAL PDF</span>
              <strong class="ldb-title">광주 택시 래핑 광고 공식 제안서 및 단가표 (PDF)</strong>
              <p class="ldb-meta">운전석·조수석 양측면 래핑 규격(220×50cm) 및 월 광고료 단가표 수록 (PDF)</p>
            </div>
            <a href="/pdf/gaon_taxi_ad.pdf" download="가온엔_택시광고_공식제안서.pdf" class="ldb-btn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              <span>택시광고 제안서 다운로드</span>
            </a>
          </div>

          <!-- 01. TAXI RATE & SPEC CARD -->
          <h4 class="lmg-sec-heading">택시 외부 래핑 광고 공식 단가표 (월 기준 / 1대당)</h4>
          <div class="lmg-rate-grid" style="grid-template-columns:repeat(2, minmax(0, 1fr));">
            
            <div class="lrg-card featured">
              <span class="lrg-ribbon">기본 구성</span>
              <div class="lrg-title-row">
                <h5 class="lrg-title">택시 양측면 래핑 광고</h5>
                <span class="lrg-sub">운전석 + 조수석 양측 도어 래핑</span>
              </div>
              <div class="lrg-price-box">
                <div class="lrg-row">
                  <span class="lrg-k">광고료 (月 / 1대)</span>
                  <strong class="lrg-v" style="color:#1d4ed8;">50,000<span style="font-size:13px; font-weight:700;">원</span></strong>
                </div>
                <div class="lrg-row">
                  <span class="lrg-k">초기 제작비 (1회)</span>
                  <strong class="lrg-v small">50,000원</strong>
                </div>
              </div>
              <div class="lrg-spec-tag" style="background:#eff6ff; border-color:#bfdbfe; color:#1d4ed8;">
                규격: <strong>220 × 50 cm</strong> (양측면) · 최소 100여 대 단위 권역 분산 집행
              </div>
            </div>

            <div class="lrg-card">
              <div class="lrg-title-row">
                <h5 class="lrg-title">택시 매체 주요 특징</h5>
                <span class="lrg-sub">광주 시내 전역 이동형 매체</span>
              </div>
              <div style="display:flex; flex-direction:column; gap:8px; font-size:13px; color:#334155; padding-top:4px;">
                <div>• <strong>도심 전역 운행</strong>: 특정 노선에 한정되지 않고 시내 전역을 자유롭게 순환</div>
                <div>• <strong>지속적인 노출</strong>: 주·야간 유동인구 동선에 맞춘 자연스러운 시선 접촉</div>
                <div>• <strong>전용 실사 래핑</strong>: 차량 전용 시트 출력으로 깔끔한 외관 및 시인성 유지</div>
                <div>• <strong>분산 배차 집행</strong>: 100여 대 규모 분산 배차로 주요 생활권 다각도 노출</div>
              </div>
            </div>

          </div>

          <!-- 02. OTHER SPECIAL OOH MEDIA (TRUCK, CART, DID) -->
          <h4 class="lmg-sec-heading">기타 특화 옥외매체 규격 안내</h4>
          <div class="lmg-high-contrast-grid">
            
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">택배 탑차</span>
                <strong class="lhc-size">3,000 × 1,500 mm</strong>
                <span class="lhc-aspect">차량 3면 와이드 래핑</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">택배 탑차 3면 래핑 광고</h5>
                <p class="lhc-desc">택배 차량의 외부 면을 활용해 아파트 단지와 주거 밀집 지역의 배송 동선에서 브랜드를 노출하는 래핑 광고입니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">쇼핑카트</span>
                <strong class="lhc-size">280 × 160 mm</strong>
                <span class="lhc-aspect">양면 플레이트 부착</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">대형마트 쇼핑카트 광고</h5>
                <p class="lhc-desc">대형마트 쇼핑카트에 광고를 부착해 매장 이용 고객의 쇼핑 동선에서 자연스럽게 브랜드와 정보를 전달합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge purple">DID 전광판</span>
                <strong class="lhc-size">매체별 상이</strong>
                <span class="lhc-aspect">설치 위치별 송출 조건 상이</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">지역 거점 DID 디지털 전광판</h5>
                <p class="lhc-desc">터미널 등 지역 거점에 설치된 디지털 전광판을 통해 이미지와 영상 광고를 송출하는 옥외매체입니다.</p>
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
                <strong class="lhc-size">통합 정보 관리</strong>
                <span class="lhc-aspect">검색 · 정보 · 예약 연결</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">네이버 스마트플레이스 운영 &amp; 관리</h5>
                <p class="lhc-desc">기본 정보와 사진, 소식, 예약·톡톡 등 고객이 검색 후 확인하는 주요 요소를 정리하고 지속적으로 관리합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">02 블로그 마케팅</span>
                <strong class="lhc-size">콘텐츠 정기 운영</strong>
                <span class="lhc-aspect">업종별 맞춤 콘텐츠 기획</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">브랜드 블로그 콘텐츠 기획 &amp; 운영</h5>
                <p class="lhc-desc">업종의 전문성과 브랜드 특성을 바탕으로 고객이 궁금해하는 주제를 기획하고 검색 흐름에 맞는 콘텐츠를 꾸준히 운영합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge green">03 지역 커뮤니티</span>
                <strong class="lhc-size">지역 · 관심사 기반</strong>
                <span class="lhc-aspect">생활권 채널 활용</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">카페 &amp; 지역 커뮤니티 마케팅</h5>
                <p class="lhc-desc">지역 커뮤니티와 생활권 플랫폼의 특성을 고려해 브랜드 소식과 필요한 정보를 자연스럽게 전달할 수 있도록 채널별 운영 방향을 설계합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">04 SNS 마케팅</span>
                <strong class="lhc-size">지역 · 관심사 타깃</strong>
                <span class="lhc-aspect">릴스 · 피드 · 광고</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">인스타그램 콘텐츠 &amp; 타깃 광고</h5>
                <p class="lhc-desc">피드와 릴스 등 브랜드 콘텐츠를 제작하고 지역·연령·관심사 등 캠페인 목적에 맞는 타깃을 설정해 광고를 운영합니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge purple">05 구글 광고</span>
                <strong class="lhc-size">검색 &amp; 디스플레이</strong>
                <span class="lhc-aspect">관심 고객 재접점</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">구글 검색광고 &amp; 디스플레이 네트워크</h5>
                <p class="lhc-desc">검색 키워드와 디스플레이 광고를 활용해 브랜드와 고객의 접점을 넓히고 필요에 따라 리마케팅 캠페인을 함께 운영합니다.</p>
              </div>
            </div>

          </div>
        </div>

        <!-- 05 VIDEO PRODUCTION GUIDE -->
        <div class="bus-guide-page" id="guideVideo">
          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">브랜드 영상</span>
                <strong class="lhc-size">기업 · 병원 · 브랜드 콘텐츠</strong>
                <span class="lhc-aspect">기획 · 촬영 · 편집</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">기업 · 병원 브랜드 홍보영상</h5>
                <p class="lhc-desc">브랜드의 목적과 활용 매체에 맞춰 기획부터 촬영, 편집까지 진행하는 홍보영상 콘텐츠입니다.</p>
              </div>
            </div>

            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge gold">모바일 숏폼</span>
                <strong class="lhc-size">9:16 FHD 세로형</strong>
                <span class="lhc-aspect">모바일 세로형 콘텐츠</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">SNS 릴스 · 유튜브 쇼츠 · 틱톡 숏폼</h5>
                <p class="lhc-desc">모바일 시청 환경에 맞는 세로형 영상으로 짧은 시간 안에 핵심 메시지를 전달할 수 있도록 기획·제작합니다.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- 06 PRINT & BANNER GUIDE -->
        <div class="bus-guide-page" id="guidePrint">
          <div class="lmg-high-contrast-grid">
            <div class="lhc-card">
              <div class="lhc-side">
                <span class="lhc-badge blue">대형 현수막</span>
                <strong class="lhc-size">지정게시대 / 대형 현수막</strong>
                <span class="lhc-aspect">구청 추첨 대행</span>
              </div>
              <div class="lhc-main">
                <h5 class="lhc-title">구청 지정게시대 &amp; 대형 건물 분양 현수막</h5>
                <p class="lhc-desc">지정게시대 접수부터 다양한 규격의 현수막 제작과 시공까지 목적에 맞춰 진행합니다.</p>
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
                <p class="lhc-desc">랑데뷰, 스노우 200g 고급 용지 사용 및 부분 에폭시, 금박/은박 후가공으로 홍보물을 제작 납품합니다.</p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- SOLID MODAL FOOTER -->
      <div class="lux-modal-foot">
        <span class="lmf-info-text">상세 단가와 매체 구성은 1:1 견적 상담을 통해 안내해드립니다.</span>
        <a href="/board/estmate/write.php" class="am-more-btn" style="padding:13px 26px; font-size:14.5px;">
          <span>1:1 맞춤 견적 신청하기</span>
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>
    </div>
  </div>

  <!-- ============================================
       ONLINE MARKETING CARD DETAIL MODAL
  ============================================ -->
  <div class="online-card-modal-overlay" id="onlineCardModal">
    <div class="ocm-panel">
      <button type="button" class="ocm-close-btn" id="btnCloseOnlineCardModal" aria-label="닫기">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
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
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>
    </div>
  </div>

  <!-- PORTFOLIO LIGHTBOX MODAL -->
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
        <video id="modalVideo" src="" controls playsinline loop muted style="display:none; width:100%; height:auto; max-height:70vh; background:#000; object-fit:contain; border-radius:8px;"></video>
        <!-- Modal Multi-photo Dots Selector -->
        <div class="pm-photo-dots" id="modalPhotoDots" style="display:none;"></div>
      </div>
      <div class="pm-info-wrap">
        <div class="pm-meta-row">
          <span class="pm-cat-badge" id="modalCat">광고사례</span>
          <span class="pm-counter-badge" id="modalCounter">1 / 8</span>
        </div>
        <h3 class="pm-title" id="modalTitle">프로젝트명</h3>
        <p class="pm-loc" id="modalLoc">광주 주요 상권 직영 시공 사례</p>
        <p class="pm-sub-notice" id="modalSubNotice" style="display:none; font-size:12px; color:#38bdf8; margin-top:6px; font-weight:600;">🎬 10초 하이라이트 영상 (대표 화면 스틸컷 캡쳐본)</p>
        <div class="pm-action-row">
          <a href="/board/estmate/write.php" class="pm-cta-btn" id="modalCtaBtn">이 광고 집행 견적 문의 ➔</a>
        </div>
      </div>
    </div>
  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php";?>

</div>

</body>
</html>