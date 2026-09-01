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
  'bus'    => '시내버스 옥외광고',
  'taxi'   => '택시 래핑광고',
  'did'    => 'DID 디지털 사이니지',
  'print'  => '인쇄물·대형현수막',
  'online' => '통합 온라인 마케팅',
  'web'    => '웹 & UI/UX 제작',
  'video'  => '4K 영상 제작',
  'mart'   => '대형마트 리테일',
);

$result = mysqli_query($conn, "SELECT * FROM portfolio WHERE status='active' ORDER BY sort_order ASC, id DESC");
$list   = array();
while ($row = mysqli_fetch_assoc($result)) {
  $list[] = $row;
}
$total = count($list);

$portOutdoor = array();
$portBus = array();
$portOnline = array();
$portVideo = array();
$portTaxi = array();
$portMart = array();

foreach ($list as $item) {
  if (in_array($item['category'], array('bus','taxi','did','print','mart'))) $portOutdoor[] = $item;
  if ($item['category'] == 'bus') $portBus[] = $item;
  if ($item['category'] == 'online') $portOnline[] = $item;
  if ($item['category'] == 'video') $portVideo[] = $item;
  if ($item['category'] == 'taxi') $portTaxi[] = $item;
  if ($item['category'] == 'mart') $portMart[] = $item;
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

<div id="wrap" class="agency-master-wrap">

	<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php";?>
  
  <!-- ============================================
       01 HERO STAGE : ASYMMETRIC CINEMATIC SPLIT (GOLD PRIZE)
  ============================================ -->
  <section class="gp-hero-stage" id="hero">
    <div class="gph-container">
      
      <div class="gph-split-row">
        <!-- LEFT: EDITORIAL TYPOGRAPHY & BEACON -->
        <div class="gph-editorial wow fadeInLeft" data-wow-duration="0.8s">
          <div class="gph-beacon">
            <span class="gphb-dot"></span>
            <span class="gphb-text">2026 KOREA TOP MEDIA GROUP</span>
          </div>
          
          <h1 class="gph-title">
            도시의 시선을 점유하는<br>
            <span class="gph-accent">압도적 옥외광고</span>,<br>
            데이터 기반 마케팅.
          </h1>
          
          <p class="gph-desc">
            가온엔은 광주 시내버스 104개 전 노선 단독 직영 인프라와 네이버 스마트플레이스 1위 SEO, 4K 시네마틱 영상 제작을 아우르는 종합 광고대행사입니다.
          </p>

          <div class="gph-cta-group">
            <a href="/board/estmate/write.php" class="gph-btn-primary">
              <span>노선 &amp; 매체 맞춤 견적 신청</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
            <button type="button" class="gph-btn-secondary bus-guide-open" data-guide="guideBus">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.3 8.7 8.7 21.3c-1 1-2.5 1-3.4 0l-2.6-2.6c-1-1-1-2.5 0-3.4L15.3 2.7c1-1 2.5-1 3.4 0l2.6 2.6c1 1 1 2.5 0 3.4Z"></path><path d="m14.5 5.5 2 2"></path><path d="m11.5 8.5 2 2"></path><path d="m8.5 11.5 2 2"></path></svg>
              <span>실측 규격 가이드</span>
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
            </button>
          </div>

          <div class="gph-stats-bar">
            <div class="gpsb-item">
              <strong>104개</strong>
              <span>전 노선 직영</span>
            </div>
            <div class="gpsb-item">
              <strong>18시간</strong>
              <span>일일 연속 노출</span>
            </div>
            <div class="gpsb-item">
              <strong>98.4%</strong>
              <span>광고주 재계약률</span>
            </div>
          </div>
        </div>

        <!-- RIGHT: SCULPTED CINEMA CANVAS -->
        <div class="gph-cinema-wrap wow fadeInRight" data-wow-duration="0.9s">
          <div class="gph-cinema-frame">
            <video autoplay muted loop playsinline class="gph-video">
              <source src="/images/movie.mp4" type="video/mp4">
            </video>
            <div class="gph-scrim"></div>
            
            <div class="gph-video-hud">
              <div class="gvh-pill">
                <span class="gvh-dot"></span>
                <span>GAON-N 4K SHOWREEL</span>
              </div>
              <h2 class="gvh-caption">광주 5개 구 1,000여 대 전 노선 직영 미디어 네트워크</h2>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       02 SHOWCASE 01 : BUS BLUEPRINT STUDIO (UNIQUE BESPOKE LAYOUT)
  ============================================ -->
  <?php
  $busStageImage = '';
  if (count($portBus) > 0 && !empty($portBus[0]['thumb'])) {
    $busStageImage = $portBus[0]['thumb'];
  }
  ?>
  <section class="gp-bus-studio-sec" id="bus">
    <div class="gph-container">
      
      <div class="gpb-header wow fadeInUp" data-wow-duration="0.7s">
        <div class="gpb-header-left">
          <span class="gpb-kicker">01 / FLAGSHIP BUS ADVERTISING</span>
          <h2 class="gpb-title">
            도심을 누비는 움직이는 랜드마크,<br>
            <em>광주 시내버스 104개 전 노선 단독 직영.</em>
          </h2>
          <p class="gpb-desc">
            광주 5개 구 핵심 간선도로를 매일 18시간 동안 순환하며 보행자와 운전자의 눈높이에 브랜드를 확실하게 각인시킵니다.
          </p>
        </div>
        <div class="gpb-header-right">
          <button type="button" class="gpb-spec-btn bus-guide-open" data-guide="guideBus">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.3 8.7 8.7 21.3c-1 1-2.5 1-3.4 0l-2.6-2.6c-1-1-1-2.5 0-3.4L15.3 2.7c1-1 2.5-1 3.4 0l2.6 2.6c1 1 1 2.5 0 3.4Z"></path><path d="m14.5 5.5 2 2"></path><path d="m11.5 8.5 2 2"></path><path d="m8.5 11.5 2 2"></path></svg>
            <span>도면 &amp; 실측 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- BESPOKE 2-COLUMN BLUEPRINT STUDIO -->
      <div class="gpb-studio-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- LEFT: INTERACTIVE VEHICLE BLUEPRINT STAGE -->
        <div class="gpb-blueprint-stage">
          <div class="gpb-media-box">
            <img id="busStageImg" src="<?php echo htmlspecialchars($busStageImage); ?>" alt="시내버스 광고" style="<?php echo empty($busStageImage) ? 'display:none;' : ''; ?>">
            <?php if (empty($busStageImage)): ?>
            <div class="gpb-empty">시내버스 광고 대표 이미지</div>
            <?php endif; ?>
            <div class="gpb-media-scrim"></div>
            
            <!-- Dimension Hotspots -->
            <div class="gpb-hotspots">
              <button type="button" class="gpb-spot bus-service-tab on"
                      data-index="외부 대형 래핑"
                      data-title="외부 광고 (차도면 3,700×1,000 / 인도면 3,000×500)"
                      data-desc="왕복 6~8차선 반대편 차량 운전자와 인도 보행자의 시야 정면에 브랜드를 확실하게 전달합니다."
                      data-image="<?php echo htmlspecialchars($busStageImage); ?>"
                      style="top:30%; left:20%;">
                <span>차도면 3,700×1,000</span>
              </button>
              <button type="button" class="gpb-spot bus-service-tab"
                      data-index="내부 승객 밀착"
                      data-title="내부 광고 (중앙창문 1,100×500 / 하차문 500×700)"
                      data-desc="탑승 승객이 목적지까지 15~30분 동안 머무르는 동안 시선 정면에 밀착되어 정밀한 메시지를 전달합니다."
                      data-image=""
                      style="top:45%; left:60%;">
                <span>내부 창문 1,100×500</span>
              </button>
              <button type="button" class="gpb-spot bus-service-tab"
                      data-index="후면 보조 패키지"
                      data-title="후면 광고 (2,400 × 300 mm)"
                      data-desc="후방 정체 차량 운전자에게 신호 대기 시간 동안 장시간 강제 노출되는 필수 패키지 면입니다."
                      data-image=""
                      style="top:30%; right:15%;">
                <span>후면 2,400×300</span>
              </button>
            </div>
          </div>

          <div class="gpb-stage-summary">
            <div class="gpss-tag" id="busStageIndex">외부 대형 래핑</div>
            <h3 class="gpss-title" id="busStageTitle">외부 광고 (차도면 3,700×1,000 / 인도면 3,000×500)</h3>
            <p class="gpss-desc" id="busStageDesc">왕복 6~8차선 반대편 차량 운전자와 인도 보행자의 시야 정면에 브랜드를 확실하게 전달합니다.</p>
          </div>
        </div>

        <!-- RIGHT: ROUTE NETWORK & PORTFOLIO -->
        <div class="gpb-routes-col">
          <div class="gpb-tier-card">
            <div class="gtc-badge red">급행 노선 (Express)</div>
            <div class="gtc-routes">순환01, 첨단09, 수완03 등</div>
            <div class="gtc-desc">광주 주요 상권, 대학가, 환승역을 최단 시간 연결하여 광역 노출 극대화</div>
          </div>
          <div class="gpb-tier-card">
            <div class="gtc-badge blue">간선 노선 (Main Line)</div>
            <div class="gtc-routes">매월16, 문흥18, 지원15 등</div>
            <div class="gtc-desc">광주 5개 구 전역 주거 밀집지와 중심 업무지구를 직통 연결</div>
          </div>
          <div class="gpb-tier-card">
            <div class="gtc-badge green">지선 노선 (Feeder)</div>
            <div class="gtc-routes">수완12, 용봉83, 첨단20 등</div>
            <div class="gtc-desc">아파트 단지, 학원가, 마트, 골목길을 촘촘하게 이어 높은 일상 친밀도 확보</div>
          </div>
          
          <div class="gpb-cta-box">
            <span>내 병원/업체 위치에 딱 맞는 노선이 궁금하신가요?</span>
            <a href="/board/estmate/write.php" class="gpb-cta-link">1:1 노선 분석 견적 받기 →</a>
          </div>
        </div>

      </div>

      <!-- PORTFOLIO CASES -->
      <div class="gpb-cases-bar">
        <h4 class="gcb-title">시내버스 광고 집행 사례</h4>
        <a href="/portfolio.php?category=bus" class="gcb-more">전체보기 →</a>
      </div>

      <div class="gp-grid-3">
        <?php foreach (array_slice($portBus, 0, 3) as $item): ?>
        <div class="gp-card main-port-card" data-cat="<?php echo htmlspecialchars($item['category']); ?>" data-id="<?php echo (int)$item['id']; ?>" data-name="<?php echo htmlspecialchars($item['title']); ?>">
          <div class="gpc-thumb">
            <?php if (!empty($item['thumb'])): ?>
            <img src="<?php echo htmlspecialchars($item['thumb']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
            <?php else: ?>
            <div class="gpc-empty">이미지 준비 중</div>
            <?php endif; ?>
            <div class="gpc-scrim"></div>
            <span class="gpc-tag">BUS WRAPPING</span>
          </div>
          <div class="gpc-info">
            <span class="gpc-cat">시내버스 옥외광고</span>
            <strong class="gpc-title"><?php echo htmlspecialchars($item['title']); ?></strong>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>


  <!-- ============================================
       03 SHOWCASE 02 : ONLINE SEO ENGINE (BESPOKE SERP SIMULATOR)
  ============================================ -->
  <section class="gp-online-engine-sec" id="online">
    <div class="gph-container">

      <div class="gpb-header wow fadeInUp" data-wow-duration="0.7s">
        <div class="gpb-header-left">
          <span class="gpb-kicker">02 / INTEGRATED ONLINE MARKETING</span>
          <h2 class="gpb-title">
            오프라인의 인지도를<br>
            <em>실제 검색과 방문 매출로 전환합니다.</em>
          </h2>
          <p class="gpb-desc">
            옥외광고를 접한 소비자가 네이버에 검색했을 때 1순위로 찾아오도록 스마트플레이스 1위 세팅, 병원 전문 C-Rank 바이럴, SNS 릴스 퍼포먼스를 통합 운영합니다.
          </p>
        </div>
        <div class="gpb-header-right">
          <button type="button" class="gpb-spec-btn bus-guide-open" data-guide="guideOnline">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.3 8.7 8.7 21.3c-1 1-2.5 1-3.4 0l-2.6-2.6c-1-1-1-2.5 0-3.4L15.3 2.7c1-1 2.5-1 3.4 0l2.6 2.6c1 1 1 2.5 0 3.4Z"></path><path d="m14.5 5.5 2 2"></path><path d="m11.5 8.5 2 2"></path><path d="m8.5 11.5 2 2"></path></svg>
            <span>온라인 전략 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- BESPOKE SERP SIMULATOR ROW -->
      <div class="gp-serp-row wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- LEFT: REALISTIC SMARTPLACE SERP MOCKUP -->
        <div class="gpo-serp-mockup">
          <div class="gsm-search-bar">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>광주 상무지구 안과 / 수완지구 학원</span>
          </div>
          <div class="gsm-place-card">
            <div class="gpc-rank-badge">#1 네이버 스마트플레이스 1위</div>
            <h3 class="gpc-brand-name">가온엔 파트너스 병원 · 브랜드</h3>
            <div class="gpc-stars">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="13" height="13" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="13" height="13" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="13" height="13" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="13" height="13" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
              <strong>5.0</strong>
              <span>(방문자 리뷰 2,450+)</span>
            </div>
            <p class="gpc-location">광주광역시 서구 상무중앙로 · 진료중 / 영업중</p>
            <div class="gpc-actions">
              <span class="gpa-btn blue">네이버 예약</span>
              <span class="gpa-btn gray">전화 문의</span>
              <span class="gpa-btn gray">길찾기</span>
            </div>
          </div>
        </div>

        <!-- RIGHT: 3 STRATEGY PILLARS -->
        <div class="gpo-strategy-col">
          <div class="gsc-item">
            <div class="gsci-num">01</div>
            <div class="gsci-body">
              <h4>스마트플레이스 1위 SEO</h4>
              <p>'진료과목/업종+지역명' 검색 시 1페이지 지도 상위에 안착시키고 예약/리뷰 자산을 구축합니다.</p>
            </div>
          </div>
          <div class="gsc-item">
            <div class="gsci-num">02</div>
            <div class="gsci-body">
              <h4>C-Rank 브랜드 블로그 &amp; 맘카페</h4>
              <p>의료법 100% 사전 검수를 거친 고품질 정보성 콘텐츠로 광주 로컬 환자의 높은 신뢰를 형성합니다.</p>
            </div>
          </div>
          <div class="gsc-item">
            <div class="gsci-num">03</div>
            <div class="gsci-body">
              <h4>SNS 릴스 &amp; 당근 로컬 타깃</h4>
              <p>매장 반경 1~3km 로컬 세대원과 인스타그램 숏폼 영상 광고를 결합하여 즉각적인 문의를 유도합니다.</p>
            </div>
          </div>
        </div>

      </div>

      <!-- KPI STRIP -->
      <div class="gp-kpi-strip">
        <div class="gpk-item">
          <span class="gpk-lbl">TARGET KPI</span>
          <strong class="gpk-val">지도 TOP 3</strong>
          <p class="gpk-sub">네이버 플레이스 지역 검색 상위 안착</p>
        </div>
        <div class="gpk-item">
          <span class="gpk-lbl">CONVERSION</span>
          <strong class="gpk-val">+320%</strong>
          <p class="gpk-sub">월간 유입 전화 및 네이버 예약 증가율</p>
        </div>
        <div class="gpk-item">
          <span class="gpk-lbl">COMPLIANCE</span>
          <strong class="gpk-val">의료법 100%</strong>
          <p class="gpk-sub">사전 광고 심의 및 과장 표현 원천 차단</p>
        </div>
      </div>

      <!-- PORTFOLIO CASES -->
      <div class="gpb-cases-bar">
        <h4 class="gcb-title">온라인 마케팅 집행 사례</h4>
        <a href="/portfolio.php?category=online" class="gcb-more">전체보기 →</a>
      </div>

      <div class="gp-grid-4">
        <?php foreach (array_slice($portOnline, 0, 4) as $item): ?>
        <div class="gp-card main-port-card" data-cat="<?php echo htmlspecialchars($item['category']); ?>" data-id="<?php echo (int)$item['id']; ?>" data-name="<?php echo htmlspecialchars($item['title']); ?>">
          <div class="gpc-thumb">
            <?php if (!empty($item['thumb'])): ?>
            <img src="<?php echo htmlspecialchars($item['thumb']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
            <?php else: ?>
            <div class="gpc-empty">이미지 준비 중</div>
            <?php endif; ?>
            <div class="gpc-scrim"></div>
            <span class="gpc-tag">ONLINE SEO</span>
          </div>
          <div class="gpc-info">
            <span class="gpc-cat">온라인 마케팅</span>
            <strong class="gpc-title"><?php echo htmlspecialchars($item['title']); ?></strong>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>


  <!-- ============================================
       04 SHOWCASE 03 : 4K VIDEO DUAL STAGE (BESPOKE VIDEO CANVAS)
  ============================================ -->
  <section class="gp-video-stage-sec" id="video">
    <div class="gph-container">

      <div class="gpb-header wow fadeInUp" data-wow-duration="0.7s">
        <div class="gpb-header-left">
          <span class="gpb-kicker">03 / 4K CINEMA PRODUCTION</span>
          <h2 class="gpb-title">
            브랜드의 위상을 완성하는<br>
            <em>4K 시네마틱 영상 크리에이티브.</em>
          </h2>
          <p class="gpb-desc">
            기획부터 촬영, 모션그래픽, 최종 납품까지 인하우스 프로덕션이 원스톱으로 제작합니다. 브랜드 홍보영상, TV CF, SNS 숏폼, 옥외 DID 모션까지 완벽 대응합니다.
          </p>
        </div>
        <div class="gpb-header-right">
          <button type="button" class="gpb-spec-btn bus-guide-open" data-guide="guideVideo">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.3 8.7 8.7 21.3c-1 1-2.5 1-3.4 0l-2.6-2.6c-1-1-1-2.5 0-3.4L15.3 2.7c1-1 2.5-1 3.4 0l2.6 2.6c1 1 1 2.5 0 3.4Z"></path><path d="m14.5 5.5 2 2"></path><path d="m11.5 8.5 2 2"></path><path d="m8.5 11.5 2 2"></path></svg>
            <span>영상 제작 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- DUAL VIDEO CANVAS (16:9 WIDE + 9:16 VERTICAL PHONE) -->
      <div class="gp-video-dual-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- WIDE CINEMA FRAME -->
        <div class="gpv-wide-frame">
          <video autoplay muted loop playsinline class="gpv-video-asset">
            <source src="/images/movie.mp4" type="video/mp4">
          </video>
          <div class="gpv-wide-scrim"></div>
          <div class="gpv-wide-info">
            <span class="gwi-pill">CINEMATIC BRAND FILM</span>
            <h3>4K 기업 · 상급병원 시네마틱 홍보영상</h3>
            <p>Sony FX Cinema &amp; 4K 항공 드론 촬영으로 브랜드의 품격을 극대화합니다.</p>
          </div>
        </div>

        <!-- VERTICAL PHONE SHORTS MOCKUP -->
        <div class="gpv-phone-mockup">
          <div class="gpm-screen">
            <video autoplay muted loop playsinline class="gpm-video">
              <source src="/images/movie_mo.mp4" type="video/mp4" onerror="this.src='/images/movie.mp4';">
            </video>
            <div class="gpm-overlay">
              <span class="gpmo-tag">9:16 SHORTS &amp; REELS</span>
              <div class="gpmo-stats">
                <span>❤️ 24.8K</span>
                <span>💬 1.2K</span>
                <span>↗ 5.6K</span>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- PRODUCTION GEAR BAR -->
      <div class="gp-gear-bar">
        <div class="gpg-item">
          <strong>Sony FX Cinema Line</strong>
          <span>4K 고감도 시네마 센서</span>
        </div>
        <div class="gpg-item">
          <strong>DJI Ronin Gimbal</strong>
          <span>흔들림 없는 다이내믹 무빙</span>
        </div>
        <div class="gpg-item">
          <strong>4K Drone Footage</strong>
          <span>도심 및 건물 전경 항공 촬영</span>
        </div>
        <div class="gpg-item">
          <strong>14-Day Fast-Track</strong>
          <span>콘티 확정 후 2주 내 최종 납품</span>
        </div>
      </div>

      <!-- PORTFOLIO CASES -->
      <div class="gpb-cases-bar" style="margin-top:50px;">
        <h4 class="gcb-title">영상 제작 포트폴리오</h4>
        <a href="/portfolio.php?category=video" class="gcb-more">전체보기 →</a>
      </div>

      <div class="gp-grid-3">
        <?php foreach (array_slice($portVideo, 0, 3) as $item): ?>
        <div class="gp-card main-port-card" data-cat="<?php echo htmlspecialchars($item['category']); ?>" data-id="<?php echo (int)$item['id']; ?>" data-name="<?php echo htmlspecialchars($item['title']); ?>">
          <div class="gpc-thumb">
            <?php if (!empty($item['thumb'])): ?>
            <img src="<?php echo htmlspecialchars($item['thumb']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
            <?php else: ?>
            <div class="gpc-empty">영상 준비 중</div>
            <?php endif; ?>
            <div class="gpc-scrim"></div>
            <div class="gpc-play-btn">PLAY SHOWREEL</div>
          </div>
          <div class="gpc-info">
            <span class="gpc-cat">영상 콘텐츠</span>
            <strong class="gpc-title"><?php echo htmlspecialchars($item['title']); ?></strong>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>


  <!-- ============================================
       05 SHOWCASE 04 : SPECIALIZED MOBILITY & RETAIL (4-QUADRANT MATRIX)
  ============================================ -->
  <section class="gp-mobility-sec" id="other">
    <div class="gph-container">

      <div class="gpb-header wow fadeInUp" data-wow-duration="0.7s">
        <div class="gpb-header-left">
          <span class="gpb-kicker">04 / SPECIALIZED OOH MEDIA</span>
          <h2 class="gpb-title">
            도심 구석구석과 구매 접점까지,<br>
            <em>빈틈없는 4대 특화 옥외매체 네트워크.</em>
          </h2>
          <p class="gpb-desc">
            골목길을 누비는 택시·택배차량부터 주부와 가족 고객을 잡는 대형마트, 관공서 DID까지 타깃 맞춤형 매체를 지원합니다.
          </p>
        </div>
        <div class="gpb-header-right">
          <button type="button" class="gpb-spec-btn bus-guide-open" data-guide="guideTaxiDelivery">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.3 8.7 8.7 21.3c-1 1-2.5 1-3.4 0l-2.6-2.6c-1-1-1-2.5 0-3.4L15.3 2.7c1-1 2.5-1 3.4 0l2.6 2.6c1 1 1 2.5 0 3.4Z"></path><path d="m14.5 5.5 2 2"></path><path d="m11.5 8.5 2 2"></path><path d="m8.5 11.5 2 2"></path></svg>
            <span>특화 매체 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- 4-QUADRANT MATRIX -->
      <div class="gp-quad-matrix wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="gqm-card">
          <div class="gqm-img">
            <img src="/images/sub_bg_b.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="택시 래핑 광고">
            <span class="gqm-chip">24H 365D 운행</span>
          </div>
          <div class="gqm-body">
            <span class="gqm-sub">01 / URBAN MOBILITY</span>
            <h3 class="gqm-name">법인·개인택시 양측면 래핑</h3>
            <p class="gqm-txt">광주 전역 200여 대 차량이 주요 번화가와 골목길까지 24시간 연속 운행하며 보행자 시선 정면에 밀착 노출됩니다.</p>
            <div class="gqm-spec">규격: 2,100 × 320 mm | 24시간 상시 기동</div>
          </div>
        </div>

        <div class="gqm-card">
          <div class="gqm-img">
            <img src="/images/sub_bg_c.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="택배차량 래핑 광고">
            <span class="gqm-chip">아파트 단지 10H 체류</span>
          </div>
          <div class="gqm-body">
            <span class="gqm-sub">02 / LOGISTICS BILLBOARD</span>
            <h3 class="gqm-name">택배 탑차 3면 와이드 래핑</h3>
            <p class="gqm-txt">광주 5개 구 아파트 단지와 주택가 골목길에 매일 10시간 이상 정차하며 주민들의 일상 동선에 자연스럽게 녹아듭니다.</p>
            <div class="gqm-spec">규격: 양면 3,000×1,500 + 후면 | 1일 10시간 체류</div>
          </div>
        </div>

        <div class="gqm-card">
          <div class="gqm-img">
            <img src="/images/sub_bg_d.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="대형마트 쇼핑카트 광고">
            <span class="gqm-chip">주부 고객 60분 동행</span>
          </div>
          <div class="gqm-body">
            <span class="gqm-sub">03 / RETAIL PURCHASE POINT</span>
            <h3 class="gqm-name">대형마트 쇼핑카트 &amp; 무빙워크</h3>
            <p class="gqm-txt">이마트, 롯데마트 1,000여 대 카트 손잡이 정면에 위치하여 실질적 구매 결정권을 가진 주부 및 가족 고객과 동행합니다.</p>
            <div class="gqm-spec">규격: 280 × 160 mm | 쇼핑 1회당 60분 주시</div>
          </div>
        </div>

        <div class="gqm-card">
          <div class="gqm-img">
            <img src="/images/sub_bg_e.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="DID 디지털 전광판">
            <span class="gqm-chip">UHD 초고화질 송출</span>
          </div>
          <div class="gqm-body">
            <span class="gqm-sub">04 / DIGITAL SMART SIGNAGE</span>
            <h3 class="gqm-name">DID 전자현수막 &amp; 도심 전광판</h3>
            <p class="gqm-txt">유스퀘어 터미널, 지하철 환승역, 관공서 로비에 고휘도 55~85인치 UHD 스크린으로 15~20초 영상을 하루 100회 이상 송출합니다.</p>
            <div class="gqm-spec">규격: 55~85" UHD 패널 | 일 100회 이상 송출</div>
          </div>
        </div>

      </div>

      <!-- PORTFOLIO CASES -->
      <div class="gpb-cases-bar" style="margin-top:60px;">
        <h4 class="gcb-title">특화 매체 시공 사례</h4>
        <div class="gp-filters">
          <button type="button" class="gpf-btn other-port-filter-btn on" data-filter="all">전체</button>
          <button type="button" class="gpf-btn other-port-filter-btn" data-filter="taxi">택시</button>
          <button type="button" class="gpf-btn other-port-filter-btn" data-filter="mart">마트</button>
          <button type="button" class="gpf-btn other-port-filter-btn" data-filter="did">DID/인쇄</button>
        </div>
      </div>

      <?php if (count($portOutdoor) > 0): ?>
      <div class="gp-grid-4" id="otherPortGrid">
        <?php foreach (array_slice($portOutdoor, 0, 4) as $item): ?>
        <div class="gp-card main-port-card other-port-item" data-cat="<?php echo htmlspecialchars($item['category']); ?>" data-id="<?php echo (int)$item['id']; ?>" data-name="<?php echo htmlspecialchars($item['title']); ?>">
          <div class="gpc-thumb">
            <?php if (!empty($item['thumb'])): ?>
            <img src="<?php echo htmlspecialchars($item['thumb']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
            <?php else: ?>
            <div class="gpc-empty">이미지 준비 중</div>
            <?php endif; ?>
            <div class="gpc-scrim"></div>
            <span class="gpc-tag"><?php echo isset($categories[$item['category']]) ? $categories[$item['category']] : '옥외매체'; ?></span>
          </div>
          <div class="gpc-info">
            <span class="gpc-cat">특화 옥외매체</span>
            <strong class="gpc-title"><?php echo htmlspecialchars($item['title']); ?></strong>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

    </div>
  </section>


  <!-- ============================================
       06 WORKFLOW : 4-STEP MASTER METHOD (RIBBON PIPELINE)
  ============================================ -->
  <section class="gp-workflow-sec" id="process">
    <div class="gph-container">
      <div class="gpb-header text-center wow fadeInUp" data-wow-duration="0.7s">
        <div class="gpb-header-left" style="max-width:720px; margin:0 auto;">
          <span class="gpb-kicker">WORKFLOW PIPELINE</span>
          <h2 class="gpb-title">
            상담부터 시공 및 성과 보고까지,<br>
            <em>가온엔이 함께하는 4단계 마스터플랜.</em>
          </h2>
          <p class="gpb-desc">
            외주 대행 없는 100% 본사 인하우스 전문팀이 전 과정을 책임지고 전담합니다.
          </p>
        </div>
      </div>

      <div class="gp-process-ribbon wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="gpr-card">
          <div class="gprc-top">
            <span class="gprc-num">01</span>
            <span class="gprc-milestone">D+1</span>
          </div>
          <h3 class="gprc-title">상권 분석 &amp; 노선 믹스</h3>
          <p class="gprc-desc">병원, 학원, 기업의 주 타깃 고객 동선을 정밀 분석하여 가장 효과적인 노선과 온·오프라인 미디어를 제안합니다.</p>
        </div>

        <div class="gpr-card">
          <div class="gprc-top">
            <span class="gprc-num">02</span>
            <span class="gprc-milestone">D+3</span>
          </div>
          <h3 class="gprc-title">1:1 디자인 시안 기획</h3>
          <p class="gprc-desc">도심 속에서 3초 안에 메시지가 읽히도록 가독성 높은 실사 래핑 디자인 및 4K 영상 스토리보드를 제작합니다.</p>
        </div>

        <div class="gpr-card">
          <div class="gprc-top">
            <span class="gprc-num">03</span>
            <span class="gprc-milestone">D+7</span>
          </div>
          <h3 class="gprc-title">직영 출력 &amp; 책임 시공</h3>
          <p class="gprc-desc">내후성 정품 솔벤 시트와 10년 이상 경력의 본사 전문 시공팀이 직접 투입되어 깔끔하게 부착합니다.</p>
        </div>

        <div class="gpr-card">
          <div class="gprc-top">
            <span class="gprc-num">04</span>
            <span class="gprc-milestone">D+14</span>
          </div>
          <h3 class="gprc-title">실시간 증빙 &amp; 리포트</h3>
          <p class="gprc-desc">시공 직후 차량 4면 촬영본을 전송해 드리며, 온라인 노출 성과 데이터를 투명하게 공유합니다.</p>
        </div>

      </div>
    </div>
  </section>


  <!-- ============================================
       07 PARTNERS TRUST MARQUEE
  ============================================ -->
  <section class="gp-partners-marquee-sec">
    <div class="gph-container">
      <div class="gpm-title">TRUSTED BY INDUSTRY LEADERS</div>
    </div>
    <div class="gpm-marquee-box">
      <div class="gpm-track track-left">
        <span class="gpm-chip">전남대학교병원</span><span class="gpm-chip">조선대학교병원</span><span class="gpm-chip">광주안과</span><span class="gpm-chip">센트럴치과병원</span><span class="gpm-chip">이루다어학원</span><span class="gpm-chip">중흥건설</span><span class="gpm-chip">광주도시공사</span><span class="gpm-chip">그린모빌리티</span>
        <span class="gpm-chip">전남대학교병원</span><span class="gpm-chip">조선대학교병원</span><span class="gpm-chip">광주안과</span><span class="gpm-chip">센트럴치과병원</span><span class="gpm-chip">이루다어학원</span><span class="gpm-chip">중흥건설</span><span class="gpm-chip">광주도시공사</span><span class="gpm-chip">그린모빌리티</span>
      </div>
      <div class="gpm-track track-right">
        <span class="gpm-chip">원광대한방병원</span><span class="gpm-chip">바른정형외과</span><span class="gpm-chip">법무법인 광산</span><span class="gpm-chip">드림공인중개사</span><span class="gpm-chip">홀리데이호텔</span><span class="gpm-chip">라붐웨딩홀</span><span class="gpm-chip">베비에르</span><span class="gpm-chip">봉선어학센터</span>
        <span class="gpm-chip">원광대한방병원</span><span class="gpm-chip">바른정형외과</span><span class="gpm-chip">법무법인 광산</span><span class="gpm-chip">드림공인중개사</span><span class="gpm-chip">홀리데이호텔</span><span class="gpm-chip">라붐웨딩홀</span><span class="gpm-chip">베비에르</span><span class="gpm-chip">봉선어학센터</span>
      </div>
    </div>
  </section>


  <!-- ============================================
       08 STUDIO CONSULTATION CTA
  ============================================ -->
  <section class="gp-studio-cta-sec">
    <div class="gph-container">
      <div class="gsc-box wow fadeInUp" data-wow-duration="0.8s">
        <div class="gsc-left">
          <span class="gsc-kicker">START YOUR CAMPAIGN</span>
          <h2 class="gsc-headline">광고, 이제<br><em>가온엔과 함께 제대로</em> 시작하세요.</h2>
          <p class="gsc-sub">시내버스 옥외광고부터 스마트플레이스 SEO 검색 마케팅까지, 1:1 맞춤 견적을 신속하게 안내해 드립니다.</p>
        </div>
        <div class="gsc-right">
          <a href="/board/estmate/write.php" class="gsc-btn">
            <span>맞춤 견적 상담 신청</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================
       09 SWISS-STYLE EDITORIAL SPECIFICATION MODAL (5 TABS)
  ============================================ -->
  <div class="bus-guide-overlay" id="busGuideOverlay">
    <div class="lux-modal-panel">
      
      <div class="lux-modal-head">
        <div>
          <span class="lmh-label">GAON-N SPECIFICATION ARCHIVE</span>
          <h3 class="lmh-title">가온엔 통합 미디어 실측 규격 &amp; 운영 가이드</h3>
          <p class="lmh-desc">광주 시내버스 104개 전 노선 실측 치수부터 택시·택배, 마트·DID, 온라인 SEO 및 4K 영상 제작 스펙을 확인하세요.</p>
        </div>
        <button type="button" class="lux-modal-close" id="btnCloseBusGuide">✕</button>
      </div>

      <div class="lux-modal-tabs">
        <button type="button" class="lmt-tab on" data-target="guideBus">시내버스 옥외광고</button>
        <button type="button" class="lmt-tab" data-target="guideTaxiDelivery">택시 · 택배차량</button>
        <button type="button" class="lmt-tab" data-target="guideMartDid">대형마트 · DID</button>
        <button type="button" class="lmt-tab" data-target="guideOnline">온라인 마케팅 &amp; SEO</button>
        <button type="button" class="lmt-tab" data-target="guideVideo">4K 영상 &amp; 숏폼 제작</button>
      </div>

      <div class="lux-modal-body">
        
        <!-- 01 BUS -->
        <div class="bus-guide-page on" id="guideBus">
          
          <div class="lux-table-block">
            <h4 class="ltb-title">01 시내버스 외부 광고 실측 규격</h4>
            <div class="lux-spec-table">
              <div class="lst-row">
                <div class="lst-name">차도면 대형 (Driver Side)</div>
                <div class="lst-val">3,700 × 1,000 mm</div>
                <div class="lst-desc">왕복 6~8차선 반대편 차량 운전자와 보행자 시야 정면에 노출되는 대표 대형 래핑면입니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">인도면 표준 (Curb Side)</div>
                <div class="lst-val">3,000 × 500 mm</div>
                <div class="lst-desc">정류소 대기 승객 및 인도 보행자의 눈높이와 1:1로 밀착되어 높은 가독성을 자랑합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">후면 보조 (Rear Side)</div>
                <div class="lst-val">2,400 × 300 mm</div>
                <div class="lst-desc">후방 정체 차량 운전자에게 신호 대기 시간 동안 장시간 강제 노출되는 필수 패키지 면입니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">사랑면 (승하차문 보조)</div>
                <div class="lst-val">1,000 × 500 mm</div>
                <div class="lst-desc">승하차문 측면에 부착되어 탑승객 및 접근 보행자의 즉각적인 주목도를 확보합니다.</div>
              </div>
            </div>
          </div>

          <div class="lux-table-block" style="margin-top:36px;">
            <h4 class="ltb-title">02 시내버스 내부 광고 &amp; 멀티미디어</h4>
            <div class="lux-spec-table">
              <div class="lst-row">
                <div class="lst-name">내부 중앙창문 포스터</div>
                <div class="lst-val">1,100 × 500 mm</div>
                <div class="lst-desc">승객 좌석 및 통로에서 15~30분간 시선이 가장 오래 머무는 프리미엄 부착면입니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">하차문 옆 포스터</div>
                <div class="lst-val">500 × 700 mm</div>
                <div class="lst-desc">하차 전 모든 승객이 100% 응시하는 핵심 하차 동선 타깃 면입니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">정류소 음성 안내 방송</div>
                <div class="lst-val">1회 7초 성우 육성</div>
                <div class="lst-desc">"이번 정류소는 ○○병원 앞입니다." 정류소당 1개 광고주 독점 방송으로 청각에 강력 각인됩니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">실내 DID 모니터 영상</div>
                <div class="lst-val">15초 Full HD 영상</div>
                <div class="lst-desc">정류소 도착 전 고화질 모니터에 풀스크린 영상 또는 2D/3D 모션그래픽으로 자동 송출됩니다.</div>
              </div>
            </div>
          </div>

          <div class="lux-table-block" style="margin-top:36px;">
            <h4 class="ltb-title">03 광주 시내버스 104개 노선 분류 체계</h4>
            <div class="lux-spec-table">
              <div class="lst-row">
                <div class="lst-name">급행 노선 (Express)</div>
                <div class="lst-val">순환01, 첨단09, 수완03 등</div>
                <div class="lst-desc">광주 주요 상권, 대학가, 환승역을 최단 시간 연결하여 광역 노출을 극대화합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">간선 노선 (Main Line)</div>
                <div class="lst-val">매월16, 문흥18, 지원15 등</div>
                <div class="lst-desc">광주 5개 구 전역의 주거 밀집지와 중심 업무지구를 직통 연결합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">지선 노선 (Feeder)</div>
                <div class="lst-val">수완12, 용봉83, 첨단20 등</div>
                <div class="lst-desc">아파트 단지, 학원가, 마트, 골목길을 촘촘하게 이어 높은 일상 친밀도를 확보합니다.</div>
              </div>
            </div>
          </div>

        </div>

        <!-- 02 TAXI & DELIVERY -->
        <div class="bus-guide-page" id="guideTaxiDelivery">
          <div class="lux-table-block">
            <h4 class="ltb-title">01 택시 &amp; 택배차량 래핑 실측 가이드</h4>
            <div class="lux-spec-table">
              <div class="lst-row">
                <div class="lst-name">법인·개인택시 양측면</div>
                <div class="lst-val">2,100 × 320 mm</div>
                <div class="lst-desc">광주 전역 200여 대 차량이 주요 번화가와 골목길까지 24시간 연속 운행하며 보행자 눈높이에서 밀착 노출됩니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">택배 탑차 양측면</div>
                <div class="lst-val">3,000 × 1,500 mm</div>
                <div class="lst-desc">광주 5개 구 아파트 단지와 주택가 골목길에 매일 10시간 이상 머무는 움직이는 초대형 랜드마크 빌보드입니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">택배 탑차 후면</div>
                <div class="lst-val">1,500 × 1,200 mm</div>
                <div class="lst-desc">골목길 주행 및 정차 시 뒤따르는 차량 및 보행자 정면에 100% 단독 시야를 확보합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">시공 및 원단 스펙</div>
                <div class="lst-val">내후성 정품 솔벤 시트</div>
                <div class="lst-desc">눈, 비, 세차에도 1년 이상 색바램이 없으며 시공 직후 차량 번호판과 4면 사진을 전송합니다.</div>
              </div>
            </div>
          </div>
        </div>

        <!-- 03 MART & DID -->
        <div class="bus-guide-page" id="guideMartDid">
          <div class="lux-table-block">
            <h4 class="ltb-title">01 대형마트 쇼핑카트 &amp; DID 디지털 전광판 규격</h4>
            <div class="lux-spec-table">
              <div class="lst-row">
                <div class="lst-name">쇼핑카트 양면 플레이트</div>
                <div class="lst-val">280 × 160 mm</div>
                <div class="lst-desc">이마트, 롯데마트 1,000여 대 카트 손잡이 정면에 장착되어 60분 쇼핑 내내 3050 주부 및 가족 고객과 동행합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">무빙워크 진입로 조명</div>
                <div class="lst-val">3,000 × 1,200 mm</div>
                <div class="lst-desc">매장 진입 및 층간 이동 시 모든 쇼핑객의 시선 정면에 위치하는 대형 백라이트 라이트패널입니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">DID 전자현수막 스크린</div>
                <div class="lst-val">55 ~ 85인치 UHD 패널</div>
                <div class="lst-desc">광천터미널, 지하철 환승역, 관공서 로비에 고휘도 LED로 15~20초 영상이 일 100회 이상 연속 송출됩니다.</div>
              </div>
            </div>
          </div>
        </div>

        <!-- 04 ONLINE -->
        <div class="bus-guide-page" id="guideOnline">
          <div class="lux-table-block">
            <h4 class="ltb-title">01 가온엔 통합 온라인 마케팅 6대 핵심 전략</h4>
            <div class="lux-spec-table">
              <div class="lst-row">
                <div class="lst-name">01 스마트플레이스 SEO</div>
                <div class="lst-val">지역 1순위 TOP 3</div>
                <div class="lst-desc">광주 지역 고객이 '진료과목/업종+지역명' 검색 시 1페이지 지도 상위에 노출되도록 키워드 및 리뷰를 관리합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">02 C-Rank 브랜드 블로그</div>
                <div class="lst-val">월 8~12건 전문 포스팅</div>
                <div class="lst-desc">의료법 100% 준수 가이드라인에 맞춘 고품질 정보성 콘텐츠를 네이버 알고리즘에 최적화하여 상위 노출합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">03 지역 맘카페 바이럴</div>
                <div class="lst-val">실제 내방 후기 생태계</div>
                <div class="lst-desc">광주 대표 맘카페 및 블로그 체험단을 정밀 운영하여 자연스러운 추천 여론을 형성하고 신뢰도를 극대화합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">04 SNS 퍼포먼스 광고</div>
                <div class="lst-val">인스타 릴스 &amp; 당근 로컬</div>
                <div class="lst-desc">매장 반경 1~3km 반경 타깃팅과 인스타그램 숏폼 영상 광고를 결합하여 즉각적인 문의 전화와 방문 예약을 유도합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">05 의료법 사전 100% 케어</div>
                <div class="lst-val">인하우스 사전 법무 검수</div>
                <div class="lst-desc">병·의원 마케팅 시 발생할 수 있는 과장/허위 표현을 원천 차단하여 행정처분 위험 없는 성장을 지원합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">06 실시간 순위 리포트</div>
                <div class="lst-val">주간/월간 투명 리포트</div>
                <div class="lst-desc">플레이스 노출 순위, 블로그 유입 키워드, SNS 광고 클릭률 및 유입 콜 수를 매주 투명한 리포트로 보고합니다.</div>
              </div>
            </div>
          </div>
        </div>

        <!-- 05 VIDEO -->
        <div class="bus-guide-page" id="guideVideo">
          <div class="lux-table-block">
            <h4 class="ltb-title">01 4K 시네마틱 영상 &amp; SNS 숏폼 제작 프로덕션</h4>
            <div class="lux-spec-table">
              <div class="lst-row">
                <div class="lst-name">01 시네마틱 브랜드 필름</div>
                <div class="lst-val">Sony FX Cinema + 드론</div>
                <div class="lst-desc">기업과 병원의 프리미엄 가치를 담아내는 4K 영화급 홍보영상으로 홈페이지 메인 및 TV CF에 최적화됩니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">02 SNS 모바일 숏폼</div>
                <div class="lst-val">세로형 9:16 FHD 바이럴</div>
                <div class="lst-desc">첫 3초 만에 시선을 사로잡는 빠른 템포의 모바일 영상으로 수만 뷰 이상의 유기적 도달을 달성합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">03 DID 전광판 모션그래픽</div>
                <div class="lst-val">고휘도 옥외 맞춤 2D/3D</div>
                <div class="lst-desc">도심 전광판과 터미널 스크린 환경에서 텍스트와 핵심 비주얼이 한눈에 읽히도록 2D/3D 모션을 제작합니다.</div>
              </div>
              <div class="lst-row">
                <div class="lst-name">04 2주 Fast-Track 납품</div>
                <div class="lst-val">기획부터 납품까지 14일</div>
                <div class="lst-desc">스토리보드 콘티 확정 → 1일 촬영 → 가편집 및 성우 녹음 → 2주 내 멀티 포맷 최종 파일 납품을 보장합니다.</div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="lux-modal-foot">
        <a href="/board/estmate/write.php" class="lmf-btn">원하는 매체 &amp; 마케팅 맞춤 견적 문의하기 →</a>
      </div>

    </div>
  </div>


  <!-- ============================================
       10 PORTFOLIO CINEMATIC LIGHTBOX MODAL
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
          <a href="/board/estmate/write.php" class="pmb-cta-btn">이와 같은 광고 견적 문의하기 →</a>
        </div>
      </div>
    </div>
  </div>

	<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php";?>

</div>

</body>
</html>
