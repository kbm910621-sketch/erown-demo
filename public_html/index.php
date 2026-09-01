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

$portBus = array();
$portOnline = array();
$portVideo = array();
$portOther = array();

foreach ($list as $item) {
  if ($item['category'] == 'bus') $portBus[] = $item;
  else if ($item['category'] == 'online') $portOnline[] = $item;
  else if ($item['category'] == 'video') $portVideo[] = $item;
  else $portOther[] = $item;
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

<div id="wrap" class="agency-gold-wrap">

	<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php";?>
  
  <!-- ============================================
       01 HERO STAGE : 100% DIRECT, CRISP & CINEMATIC
  ============================================ -->
  <section class="gold-hero" id="hero">
    <div class="gold-container">
      
      <!-- TOP LIVE BADGE -->
      <div class="gh-top-row wow fadeInDown" data-wow-duration="0.6s">
        <div class="gh-tag">
          <span class="gh-dot"></span>
          <span>광주 전역 옥외광고 &amp; 디지털 마케팅 종합대행사</span>
        </div>
        <div class="gh-sub-info">광주 시내버스 104개 전 노선 단독 직영 · 네이버 SEO · 4K 프로덕션</div>
      </div>

      <!-- DIRECT CRISP HEADLINE -->
      <div class="gh-headline-box wow fadeInUp" data-wow-duration="0.8s">
        <h1 class="gh-title">
          광주 시내버스 104개 노선 독점 직영,<br>
          <span class="gh-accent">옥외광고부터 네이버 1위 마케팅까지.</span>
        </h1>
        <p class="gh-desc">
          시내버스 1,000대 래핑 광고, 네이버 스마트플레이스 1위 상위노출, 4K 브랜드 홍보영상을 가온엔 본사가 기획부터 시공까지 100% 직접 책임집니다.
        </p>
      </div>

      <!-- DIRECT ACTION BUTTONS -->
      <div class="gh-btn-group wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
        <a href="/board/estmate/write.php" class="gh-btn-primary">
          <span>노선 &amp; 매체 견적 문의하기</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
        <button type="button" class="gh-btn-secondary bus-guide-open" data-guide="guideBus">
          <span>실측 규격 가이드 확인</span>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
        </button>
      </div>

      <!-- FULL-WIDTH 21:9 CINEMA FRAME -->
      <div class="gh-cinema-box wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.2s">
        <div class="ghc-viewport">
          <video autoplay muted loop playsinline class="ghc-video">
            <source src="/images/movie.mp4" type="video/mp4">
          </video>
          <div class="ghc-scrim"></div>

          <!-- BOTTOM 4 FACTS HUD -->
          <div class="ghc-hud">
            <div class="gh-hud-card">
              <div class="gh-hud-num">104<em>개</em></div>
              <div class="gh-hud-lbl">광주 시내버스 전 노선 직영</div>
            </div>
            <div class="gh-hud-card">
              <div class="gh-hud-num">1,000<em>여 대</em></div>
              <div class="gh-hud-lbl">광주 전역 독점 운행 차량</div>
            </div>
            <div class="gh-hud-card">
              <div class="gh-hud-num">18<em>시간</em></div>
              <div class="gh-hud-lbl">매일 도로 연속 노출 시간</div>
            </div>
            <div class="gh-hud-card highlight">
              <div class="gh-hud-num">100<em>%</em></div>
              <div class="gh-hud-lbl">본사 전문 시공팀 직접 부착</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       02 SECTION 01 : BUS OOH (DIRECT 3D BLUEPRINT STUDIO)
  ============================================ -->
  <?php
  $busStageImage = '';
  if (count($portBus) > 0 && !empty($portBus[0]['thumb'])) {
    $busStageImage = $portBus[0]['thumb'];
  }
  ?>
  <section class="gold-sec gold-bg-slate" id="bus">
    <div class="gold-container">
      
      <div class="gs-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="gs-head-left">
          <span class="gs-kicker">01 / BUS ADVERTISING</span>
          <h2 class="gs-title">광주 시내버스 외부 · 내부 옥외광고</h2>
          <p class="gs-desc">
            차도면(3.7m), 인도면(3.0m), 후면 3면 패키지 부착으로 반대편 차량 운전자와 정류소 보행자 시야 정면에 매일 18시간 반복 노출됩니다.
          </p>
        </div>
        <div class="gs-head-right">
          <button type="button" class="gs-guide-btn bus-guide-open" data-guide="guideBus">
            <span>시내버스 7대 실측 규격표 확인 ↗</span>
          </button>
        </div>
      </div>

      <!-- 2-COLUMN BLUEPRINT STUDIO -->
      <div class="gs-bus-studio wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- LEFT: VEHICLE BLUEPRINT & HOTSPOTS -->
        <div class="gbb-visual-panel">
          <div class="gbb-canvas">
            <img id="busStageImg" src="<?php echo htmlspecialchars($busStageImage); ?>" alt="시내버스 광고 실사" style="<?php echo empty($busStageImage) ? 'display:none;' : ''; ?>">
            <?php if (empty($busStageImage)): ?>
            <div class="gbb-empty">시내버스 광고 대표 이미지</div>
            <?php endif; ?>
            <div class="gbb-scrim"></div>
            
            <!-- Exact Hotspots -->
            <div class="gbb-hotspots">
              <button type="button" class="gbb-spot bus-service-tab on"
                      data-index="차도면 대형 래핑"
                      data-title="차도면 대형 광고 (3,700 × 1,000 mm)"
                      data-desc="왕복 6~8차선 반대편 차량 운전자와 인도 보행자의 시야 정면에 노출되는 대표 규격입니다."
                      data-target="차량 운전자 &amp; 반대편 보행자 100% 강제 노출"
                      data-image="<?php echo htmlspecialchars($busStageImage); ?>"
                      style="top:32%; left:22%;">
                <span>차도면 3,700×1,000</span>
              </button>

              <button type="button" class="gbb-spot bus-service-tab"
                      data-index="인도면 표준 래핑"
                      data-title="인도면 표준 광고 (3,000 × 500 mm)"
                      data-desc="정류소 대기 승객 및 인도 보행자의 눈높이와 1:1로 밀착되어 높은 가독성을 발휘합니다."
                      data-target="정류소 승객 &amp; 인도 보행자 1:1 밀착"
                      data-image=""
                      style="top:48%; left:58%;">
                <span>인도면 3,000×500</span>
              </button>

              <button type="button" class="gbb-spot bus-service-tab"
                      data-index="후면 집중 패키지"
                      data-title="후면 번호판 상단 광고 (2,400 × 300 mm)"
                      data-desc="신호 대기 및 도로 정체 시 후방 차량 운전자에게 3분 이상 강제 주시되는 필수 면입니다."
                      data-target="후방 정체 차량 운전자 장시간 주시"
                      data-image=""
                      style="top:32%; right:14%;">
                <span>후면 2,400×300</span>
              </button>
            </div>
          </div>

          <!-- Dynamic Brief Card below vehicle -->
          <div class="gbb-brief">
            <div class="gb-brief-header">
              <span class="gbb-tag" id="busStageIndex">차도면 대형 래핑</span>
              <span class="gbb-target-text" id="busStageTarget">타깃: 차량 운전자 &amp; 반대편 보행자 100% 강제 노출</span>
            </div>
            <h3 class="gbb-name" id="busStageTitle">차도면 대형 광고 (3,700 × 1,000 mm)</h3>
            <p class="gbb-txt" id="busStageDesc">왕복 6~8차선 반대편 차량 운전자와 인도 보행자의 시야 정면에 노출되는 대표 규격입니다.</p>
            <div class="gbb-action-row">
              <a href="/board/estmate/write.php" class="gbb-cta-btn">이 규격으로 견적 신청하기 →</a>
            </div>
          </div>
        </div>

        <!-- RIGHT: 104 ROUTE CLASSIFICATION -->
        <div class="gbb-routes-panel">
          
          <div class="gbr-card red">
            <div class="gbr-top">
              <span class="gbr-badge">급행 노선 (Express)</span>
              <h4>순환01, 첨단09, 수완03 등</h4>
            </div>
            <p>상무지구, 광천터미널, 충장로, 전남대·조선대를 최단 시간 관통하여 광주 전역 광역 노출을 극대화합니다.</p>
          </div>

          <div class="gbr-card blue">
            <div class="gbr-top">
              <span class="gbr-badge">간선 노선 (Main Line)</span>
              <h4>매월16, 문흥18, 지원15, 봉선37 등</h4>
            </div>
            <p>광주 5개 구 대규모 아파트 주거단지와 중심 상업·업무지구를 직통 연결하여 매일 반복 각인시킵니다.</p>
          </div>

          <div class="gbr-card green">
            <div class="gbr-top">
              <span class="gbr-badge">지선 노선 (Feeder)</span>
              <h4>수완12, 첨단20, 용봉83 등</h4>
            </div>
            <p>병원, 학원, 마트 밀집 골목 상권을 촘촘하게 연결하여 로컬 단골 환자 및 고객의 친밀도를 확보합니다.</p>
          </div>

          <div class="gbr-promo">
            <div class="gp-text">
              <strong>내 병원/업체에 딱 맞는 추천 노선은?</strong>
              <span>빅데이터 기반 1:1 맞춤 노선 믹스를 무료로 분석해 드립니다.</span>
            </div>
            <a href="/board/estmate/write.php" class="gp-btn">노선 무료 분석 신청 →</a>
          </div>

        </div>

      </div>

    </div>
  </section>


  <!-- ============================================
       03 SECTION 02 : ONLINE SEO COCKPIT (DIRECT SMARTPLACE FACT)
  ============================================ -->
  <section class="gold-sec" id="online">
    <div class="gold-container">

      <div class="gs-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="gs-head-left">
          <span class="gs-kicker">02 / INTEGRATED ONLINE MARKETING &amp; SEO</span>
          <h2 class="gs-title">네이버 스마트플레이스 1위 &amp; C-Rank 바이럴</h2>
          <p class="gs-desc">
            버스를 보고 검색한 잠재 고객이 실제로 찾아오도록, 로컬 검색 1페이지 상위 노출과 고품질 리뷰 자산을 구축합니다.
          </p>
        </div>
        <div class="gs-head-right">
          <button type="button" class="gs-guide-btn bus-guide-open" data-guide="guideOnline">
            <span>온라인 전략 가이드 확인 ↗</span>
          </button>
        </div>
      </div>

      <!-- COCKPIT ROW -->
      <div class="gs-online-cockpit wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- LEFT: REAL SMARTPLACE CARD -->
        <div class="goc-mockup">
          <div class="gom-search">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>광주 상무지구 안과 / 수완지구 학원</span>
          </div>
          
          <div class="gom-card">
            <div class="gom-badge-row">
              <span class="gom-rank">#1 네이버 스마트플레이스 1위 랭크</span>
              <span class="gom-live">LIVE</span>
            </div>
            <h3 class="gom-name">가온엔 파트너스 병원 · 브랜드</h3>
            <div class="gom-rating">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
              <strong>5.0</strong>
              <span>(방문자 영수증 리뷰 2,480+)</span>
            </div>
            <p class="gom-addr">광주광역시 서구 상무중앙로 · 진료중 / 영업중</p>
            <div class="gom-btns">
              <span class="gb-btn blue">네이버 예약 (월 420건)</span>
              <span class="gb-btn">전화 문의</span>
              <span class="gb-btn">길찾기</span>
            </div>
          </div>
        </div>

        <!-- RIGHT: 3 CLEAR SERVICES -->
        <div class="goc-services">
          <div class="gos-item">
            <div class="gos-num">01</div>
            <div class="gos-body">
              <h4>스마트플레이스 1위 세팅</h4>
              <p>'진료과목/업종 + 광주/상무/수완/첨단/봉선' 로컬 키워드 알고리즘을 최적화하여 1페이지 지도 상위에 안착시킵니다.</p>
            </div>
          </div>

          <div class="gos-item">
            <div class="gos-num">02</div>
            <div class="gos-body">
              <h4>C-Rank 브랜드 블로그 &amp; 맘카페</h4>
              <p>의료법 100% 사전 법무 검수를 거친 전문 칼럼과 광주 대표 맘카페 바이럴로 실질적 내방 신뢰를 구축합니다.</p>
            </div>
          </div>

          <div class="gos-item">
            <div class="gos-num">03</div>
            <div class="gos-body">
              <h4>SNS 릴스 &amp; 당근 로컬 타깃</h4>
              <p>매장 반경 1~3km 로컬 거주민과 인스타그램 숏폼 영상 광고를 결합하여 즉각적인 문의 콜을 유도합니다.</p>
            </div>
          </div>
        </div>

      </div>

      <!-- KPI STRIP -->
      <div class="gs-kpi-strip">
        <div class="gk-col">
          <span class="gk-lbl">TARGET GOAL</span>
          <strong class="gk-val">지도 TOP 3</strong>
          <p class="gk-sub">네이버 스마트플레이스 1페이지 상위 안착</p>
        </div>
        <div class="gk-col">
          <span class="gk-lbl">CONVERSION RATE</span>
          <strong class="gk-val">+320%</strong>
          <p class="gk-sub">월간 유입 전화 및 네이버 예약 증가율</p>
        </div>
        <div class="gk-col">
          <span class="gk-lbl">LEGAL COMPLIANCE</span>
          <strong class="gk-val">의료법 100%</strong>
          <p class="gk-sub">사전 광고 심의 및 과장 표현 원천 차단</p>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       04 SECTION 03 : 4K VIDEO DUAL STUDIO (ZERO FLUFF)
  ============================================ -->
  <section class="gold-sec gold-bg-slate" id="video">
    <div class="gold-container">

      <div class="gs-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="gs-head-left">
          <span class="gs-kicker">03 / 4K VIDEO PRODUCTION</span>
          <h2 class="gs-title">4K 기업 홍보영상 · TV CF · SNS 숏폼 제작</h2>
          <p class="gs-desc">
            기획 콘티부터 4K 촬영, 전문 성우 더빙, 모션그래픽 편집까지 14일 이내 원스톱 납품을 보장합니다.
          </p>
        </div>
        <div class="gs-head-right">
          <button type="button" class="gs-guide-btn bus-guide-open" data-guide="guideVideo">
            <span>영상 제작 가이드 확인 ↗</span>
          </button>
        </div>
      </div>

      <!-- DUAL VIDEO CANVAS -->
      <div class="gs-video-dual wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- WIDE 16:9 CINEMA -->
        <div class="gvd-wide">
          <video autoplay muted loop playsinline class="gvd-video">
            <source src="/images/movie.mp4" type="video/mp4">
          </video>
          <div class="gvd-scrim"></div>
          <div class="gvd-info">
            <span class="gvd-tag">4K BRAND FILM</span>
            <h3>기업 · 상급병원 4K 시네마틱 홍보영상</h3>
            <p>Sony FX Cinema 풀프레임 &amp; 4K 항공 드론 촬영으로 최상의 완성도를 제공합니다.</p>
          </div>
        </div>

        <!-- 9:16 PHONE MOCKUP -->
        <div class="gvd-phone">
          <div class="gvp-screen">
            <video autoplay muted loop playsinline class="gvp-video">
              <source src="/images/movie_mo.mp4" type="video/mp4" onerror="this.src='/images/movie.mp4';">
            </video>
            <div class="gvp-overlay">
              <span class="gvp-tag">9:16 SNS 릴스 &amp; 쇼츠</span>
              <div class="gvp-stats">
                <span>❤️ 24.8K</span>
                <span>💬 1.2K</span>
                <span>↗ 5.6K</span>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- 4 CRISP VIDEO PRODUCTS -->
      <div class="gs-products-strip">
        <div class="gsp-card">
          <span class="gsp-num">01</span>
          <h4>기업·병원 브랜드 필름</h4>
          <p>홈페이지 및 공식 채널용 풀프레임 4K 촬영 + 드론 + 성우 더빙</p>
        </div>
        <div class="gsp-card">
          <span class="gsp-num">02</span>
          <h4>TV CF · 극장 광고</h4>
          <p>15초/30초 고임팩트 스토리텔링 및 2D/3D 모션그래픽 제작</p>
        </div>
        <div class="gsp-card">
          <span class="gsp-num">03</span>
          <h4>SNS 릴스 · 유튜브 쇼츠</h4>
          <p>모바일 9:16 세로형 숏폼 영상으로 높은 바이럴 도달 달성</p>
        </div>
        <div class="gsp-card">
          <span class="gsp-num">04</span>
          <h4>DID 전광판 모션그래픽</h4>
          <p>옥외 고휘도 스크린에 최적화된 15초 풀HD 고시인성 모션</p>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       05 SECTION 04 : SPECIALIZED OOH (4-QUADRANT MAGAZINE)
  ============================================ -->
  <section class="gold-sec" id="other">
    <div class="gold-container">

      <div class="gs-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="gs-head-left">
          <span class="gs-kicker">04 / SPECIALIZED OOH MEDIA</span>
          <h2 class="gs-title">택시 · 택배 · 대형마트 · DID 특화 옥외매체</h2>
          <p class="gs-desc">
            골목길을 누비는 택시·택배차량부터 마트 쇼핑카트, 관공서 DID까지 타깃별 맞춤 옥외광고를 제공합니다.
          </p>
        </div>
        <div class="gs-head-right">
          <button type="button" class="gs-guide-btn bus-guide-open" data-guide="guideTaxiDelivery">
            <span>특화 매체 실측표 확인 ↗</span>
          </button>
        </div>
      </div>

      <!-- 4-QUADRANT GRID -->
      <div class="gs-quad-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="gq-card">
          <div class="gq-img">
            <img src="/images/sub_bg_b.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="택시 래핑 광고">
            <span class="gq-chip">24시간 상시 운행</span>
          </div>
          <div class="gq-body">
            <span class="gq-num">01 / MOBILITY</span>
            <h3>법인 · 개인택시 양측면 래핑</h3>
            <p>광주 전역 200여 대 차량이 주요 번화가와 골목길까지 24시간 연속 운행하며 보행자 시선에 밀착 노출됩니다.</p>
            <div class="gq-meta">실측 규격: 2,100 × 320 mm | 24시간 상시 기동</div>
          </div>
        </div>

        <div class="gq-card">
          <div class="gq-img">
            <img src="/images/sub_bg_c.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="택배차량 래핑 광고">
            <span class="gq-chip">아파트 10시간 체류</span>
          </div>
          <div class="gq-body">
            <span class="gq-num">02 / LOGISTICS</span>
            <h3>택배 탑차 3면 와이드 래핑</h3>
            <p>광주 5개 구 아파트 단지와 주택가 골목길에 매일 10시간 이상 정차하며 주민들의 일상 동선에 자연스럽게 노출됩니다.</p>
            <div class="gq-meta">실측 규격: 양면 3,000×1,500 + 후면 | 1일 10시간 체류</div>
          </div>
        </div>

        <div class="gq-card">
          <div class="gq-img">
            <img src="/images/sub_bg_d.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="대형마트 쇼핑카트 광고">
            <span class="gq-chip">주부 고객 60분 동행</span>
          </div>
          <div class="gq-body">
            <span class="gq-num">03 / RETAIL</span>
            <h3>대형마트 쇼핑카트 &amp; 무빙워크</h3>
            <p>이마트, 롯데마트 1,000여 대 카트 손잡이 정면에 위치하여 실질적 구매 결정권을 가진 주부 및 가족 고객과 60분간 동행합니다.</p>
            <div class="gq-meta">실측 규격: 280 × 160 mm | 쇼핑 1회당 60분 주시</div>
          </div>
        </div>

        <div class="gq-card">
          <div class="gq-img">
            <img src="/images/sub_bg_e.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="DID 디지털 전광판">
            <span class="gq-chip">UHD 초고화질</span>
          </div>
          <div class="gq-body">
            <span class="gq-num">04 / DIGITAL</span>
            <h3>DID 전자현수막 &amp; 도심 전광판</h3>
            <p>유스퀘어 터미널, 지하철 환승역, 관공서 로비에 고휘도 55~85인치 UHD 스크린으로 15~20초 영상을 하루 100회 이상 송출합니다.</p>
            <div class="gq-meta">실측 규격: 55~85" UHD 패널 | 일 100회 이상 송출</div>
          </div>
        </div>

      </div>

    </div>
  </section>


  <!-- ============================================
       06 MASTER PORTFOLIO ARCHIVE (ALL-IN-ONE SINGLE DECK)
  ============================================ -->
  <section class="gold-sec gold-bg-slate" id="archive">
    <div class="gold-container">

      <div class="gs-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="gs-head-left">
          <span class="gs-kicker">ALL-IN-ONE MASTER ARCHIVE</span>
          <h2 class="gs-title">성공 광고 집행 사례 포트폴리오</h2>
          <p class="gs-desc">카테고리별 탭을 클릭하여 고화질 실사 사례를 확인하고, 원하는 믹스의 견적을 즉시 문의하세요.</p>
        </div>
        <div class="gs-filters">
          <button type="button" class="gsf-btn on" data-filter="all">전체보기</button>
          <button type="button" class="gsf-btn" data-filter="bus">시내버스</button>
          <button type="button" class="gsf-btn" data-filter="online">온라인 SEO</button>
          <button type="button" class="gsf-btn" data-filter="video">4K 영상</button>
          <button type="button" class="gsf-btn" data-filter="taxi">택시·택배</button>
          <button type="button" class="gsf-btn" data-filter="mart">마트·DID</button>
        </div>
      </div>

      <!-- MASTER GRID -->
      <div class="gs-master-grid wow fadeInUp" data-wow-duration="0.8s" id="masterPortGrid">
        <?php foreach (array_slice($list, 0, 8) as $item): ?>
        <div class="gsm-card main-port-card" data-cat="<?php echo htmlspecialchars($item['category']); ?>" data-id="<?php echo (int)$item['id']; ?>" data-name="<?php echo htmlspecialchars($item['title']); ?>">
          <div class="gsmc-thumb">
            <?php if (!empty($item['thumb'])): ?>
            <img src="<?php echo htmlspecialchars($item['thumb']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
            <?php else: ?>
            <div class="gsmc-empty">이미지 준비 중</div>
            <?php endif; ?>
            <div class="gsmc-scrim"></div>
            <span class="gsmc-tag"><?php echo isset($categories[$item['category']]) ? $categories[$item['category']] : '광고사례'; ?></span>
            <div class="gsmc-hover-btn">상세보기 &amp; 견적조회 ↗</div>
          </div>
          <div class="gsmc-info">
            <span class="gsmc-cat"><?php echo isset($categories[$item['category']]) ? $categories[$item['category']] : '광고집행'; ?></span>
            <strong class="gsmc-title"><?php echo htmlspecialchars($item['title']); ?></strong>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="gs-more-box">
        <a href="/portfolio.php" class="gs-more-btn">
          <span>포트폴리오 전체 100+ 사례 더보기</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>

    </div>
  </section>


  <!-- ============================================
       07 WORKFLOW : 4-STEP PIPELINE
  ============================================ -->
  <section class="gold-sec" id="process">
    <div class="gold-container">
      <div class="gs-head text-center wow fadeInUp" data-wow-duration="0.7s">
        <div class="gs-head-left" style="max-width:720px; margin:0 auto;">
          <span class="gs-kicker">WORKFLOW PIPELINE</span>
          <h2 class="gs-title">가온엔 4단계 원스톱 마스터플랜</h2>
          <p class="gs-desc">외주 대행 없는 100% 본사 인하우스 전문팀이 전 과정을 책임지고 전담합니다.</p>
        </div>
      </div>

      <div class="gs-process-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="gsp-proc-card">
          <div class="gpc-top">
            <span class="gpc-num">01</span>
            <span class="gpc-milestone">D+1</span>
          </div>
          <h3 class="gpc-title">상권 분석 &amp; 노선 믹스</h3>
          <p class="gpc-desc">병원, 학원, 기업의 주 타깃 고객 동선을 정밀 분석하여 가장 효과적인 노선과 온·오프라인 미디어를 제안합니다.</p>
        </div>

        <div class="gsp-proc-card">
          <div class="gpc-top">
            <span class="gpc-num">02</span>
            <span class="gpc-milestone">D+3</span>
          </div>
          <h3 class="gpc-title">1:1 디자인 시안 기획</h3>
          <p class="gpc-desc">도심 속에서 3초 안에 메시지가 읽히도록 가독성 높은 실사 래핑 디자인 및 4K 영상 스토리보드를 제작합니다.</p>
        </div>

        <div class="gsp-proc-card">
          <div class="gpc-top">
            <span class="gpc-num">03</span>
            <span class="gpc-milestone">D+7</span>
          </div>
          <h3 class="gpc-title">직영 출력 &amp; 책임 시공</h3>
          <p class="gpc-desc">내후성 정품 솔벤 시트와 10년 이상 경력의 본사 전문 시공팀이 직접 투입되어 깔끔하게 부착합니다.</p>
        </div>

        <div class="gsp-proc-card">
          <div class="gpc-top">
            <span class="gpc-num">04</span>
            <span class="gpc-milestone">D+14</span>
          </div>
          <h3 class="gpc-title">실시간 증빙 &amp; 리포트</h3>
          <p class="gpc-desc">시공 직후 차량 4면 촬영본을 전송해 드리며, 온라인 노출 성과 데이터를 투명하게 공유합니다.</p>
        </div>

      </div>
    </div>
  </section>


  <!-- ============================================
       08 PARTNERS MARQUEE
  ============================================ -->
  <section class="gold-partners-sec">
    <div class="gold-container">
      <div class="gpt-title">TRUSTED BY INDUSTRY LEADERS</div>
    </div>
    <div class="gpt-marquee-box">
      <div class="gpt-track track-left">
        <span class="gpt-chip">전남대학교병원</span><span class="gpt-chip">조선대학교병원</span><span class="gpt-chip">광주안과</span><span class="gpt-chip">센트럴치과병원</span><span class="gpt-chip">이루다어학원</span><span class="gpt-chip">중흥건설</span><span class="gpt-chip">광주도시공사</span><span class="gpt-chip">그린모빌리티</span>
        <span class="gpt-chip">전남대학교병원</span><span class="gpt-chip">조선대학교병원</span><span class="gpt-chip">광주안과</span><span class="gpt-chip">센트럴치과병원</span><span class="gpt-chip">이루다어학원</span><span class="gpt-chip">중흥건설</span><span class="gpt-chip">광주도시공사</span><span class="gpt-chip">그린모빌리티</span>
      </div>
      <div class="gpt-track track-right">
        <span class="gpt-chip">원광대한방병원</span><span class="gpt-chip">바른정형외과</span><span class="gpt-chip">법무법인 광산</span><span class="gpt-chip">드림공인중개사</span><span class="gpt-chip">홀리데이호텔</span><span class="gpt-chip">라붐웨딩홀</span><span class="gpt-chip">베비에르</span><span class="gpt-chip">봉선어학센터</span>
        <span class="gpt-chip">원광대한방병원</span><span class="gpt-chip">바른정형외과</span><span class="gpt-chip">법무법인 광산</span><span class="gpt-chip">드림공인중개사</span><span class="gpt-chip">홀리데이호텔</span><span class="gpt-chip">라붐웨딩홀</span><span class="gpt-chip">베비에르</span><span class="gpt-chip">봉선어학센터</span>
      </div>
    </div>
  </section>


  <!-- ============================================
       09 STUDIO CONSULTATION CTA
  ============================================ -->
  <section class="gold-cta-sec">
    <div class="gold-container">
      <div class="gcta-box wow fadeInUp" data-wow-duration="0.8s">
        <div class="gcta-left">
          <span class="gcta-kicker">START YOUR CAMPAIGN</span>
          <h2 class="gcta-headline">광고, 이제<br><em>가온엔과 함께 제대로</em> 시작하세요.</h2>
          <p class="gcta-sub">시내버스 옥외광고부터 스마트플레이스 SEO 검색 마케팅까지, 1:1 맞춤 견적을 신속하게 안내해 드립니다.</p>
        </div>
        <div class="gcta-right">
          <a href="/board/estmate/write.php" class="gcta-btn">
            <span>맞춤 견적 상담 신청</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================
       10 SWISS-STYLE EDITORIAL SPECIFICATION MODAL (5 TABS - HIGH POLISH)
  ============================================ -->
  <div class="bus-guide-overlay" id="busGuideOverlay">
    <div class="lux-modal-panel">
      
      <div class="lux-modal-head">
        <div>
          <span class="lmh-label">GAON-N OFFICIAL SPECIFICATION DECK</span>
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
       11 PORTFOLIO CINEMATIC LIGHTBOX MODAL
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
