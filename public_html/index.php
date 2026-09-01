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
  'video'  => '영상제작 (4K Production)',
  'mart'   => '대형마트 리테일',
);

$result = mysqli_query($conn, "SELECT * FROM portfolio WHERE status='active' ORDER BY sort_order ASC, id DESC");
$list   = array();
while ($row = mysqli_fetch_assoc($result)) {
  $list[] = $row;
}
$total = count($list);

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

<div id="wrap" class="dynamic-agency-wrap">

	<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php";?>
  
  <!-- ============================================
       01 HERO STAGE : KINETIC CINEMATIC BILLBOARD
  ============================================ -->
  <section class="dyn-hero-stage" id="hero">
    <div class="dyn-container">
      
      <!-- TOP NAVIGATOR CHIPS -->
      <div class="dhn-chip-row wow fadeInDown" data-wow-duration="0.6s">
        <span class="dhn-status-dot"></span>
        <span class="dhn-title-label">GAON-N TOTAL MEDIA AGENCY 2026</span>
        <div class="dhn-quick-nav">
          <a href="#bus" class="dqn-item">01 시내버스 광고</a>
          <a href="#online" class="dqn-item">02 온라인 마케팅</a>
          <a href="#video" class="dqn-item">03 영상제작 (4K)</a>
          <a href="#other" class="dqn-item">04 특화 옥외매체</a>
        </div>
      </div>

      <!-- HERO HEADLINE -->
      <div class="dhn-headline-area wow fadeInUp" data-wow-duration="0.8s">
        <h1 class="dhn-h1">
          광주 시내버스 104개 노선 독점 직영,<br>
          <span class="dhn-highlight">옥외광고 · 네이버 1위 마케팅 · 영상제작</span>
        </h1>
        <p class="dhn-sub">
          광주 5개 구 1,000대 시내버스 래핑부터 스마트플레이스 상위노출, 4K 시네마틱 영상제작까지 가온엔 본사가 기획부터 시공까지 100% 직접 전담합니다.
        </p>
      </div>

      <!-- DIRECT CTAS -->
      <div class="dhn-actions wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
        <a href="/board/estmate/write.php" class="dhn-btn-primary">
          <span>맞춤 노선 &amp; 견적 신청</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
        <button type="button" class="dhn-btn-secondary bus-guide-open" data-guide="guideBus">
          <span>매체별 실측 상세 가이드 ↗</span>
        </button>
      </div>

      <!-- 21:9 CINEMA STAGE -->
      <div class="dhn-cinema-display wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.2s">
        <div class="dcd-viewport">
          <video autoplay muted loop playsinline class="dcd-video">
            <source src="/images/movie.mp4" type="video/mp4">
          </video>
          <div class="dcd-scrim"></div>

          <div class="dcd-live-ticker">
            <div class="dlt-card">
              <span class="dlt-val counter" data-target="104">104</span><span class="dlt-unit">개</span>
              <span class="dlt-lbl">광주 전 노선 단독 직영</span>
            </div>
            <div class="dlt-card">
              <span class="dlt-val counter" data-target="1000">1000</span><span class="dlt-unit">+ 대</span>
              <span class="dlt-lbl">광주 5개 구 운행 차량</span>
            </div>
            <div class="dlt-card">
              <span class="dlt-val counter" data-target="18">18</span><span class="dlt-unit">시간</span>
              <span class="dlt-lbl">일일 도로 연속 노출</span>
            </div>
            <div class="dlt-card blue">
              <span class="dlt-val counter" data-target="100">100</span><span class="dlt-unit">%</span>
              <span class="dlt-lbl">본사 직영 책임 시공</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       02 SECTION 01 : BUS ADVERTISING (DETAILED CLICK CONSOLE)
  ============================================ -->
  <section class="dyn-section dyn-bg-slate" id="bus">
    <div class="dyn-container">
      
      <div class="ds-head-box wow fadeInUp" data-wow-duration="0.7s">
        <div class="dsh-flex">
          <div>
            <span class="ds-num-tag">01 / BUS ADVERTISING</span>
            <h2 class="ds-title">광주 시내버스 외부 · 내부 옥외광고</h2>
            <p class="ds-desc">원하는 부착 위치 칩을 클릭하시면 상세한 실측 규격, 노출 타깃, 최적의 상권 전략이 즉시 표시됩니다.</p>
          </div>
          <button type="button" class="dsh-guide-btn bus-guide-open" data-guide="guideBus">
            <span>시내버스 7대 규격 상세 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- BUS INTERACTIVE CONSOLE -->
      <div class="dyn-bus-console wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- STEP 1: INTERACTIVE DIMENSION CHIP SELECTOR -->
        <div class="dbc-selector-bar">
          <button type="button" class="dbc-chip bus-spot-btn on"
                  data-name="차도면 대형 래핑"
                  data-size="3,700 × 1,000 mm"
                  data-target="왕복 6~8차선 반대편 차량 운전자 &amp; 반대편 보행자 정면 100% 노출"
                  data-material="LG 하우시스 최고급 내후성 정품 솔벤 시트 (1년 이상 변색 방지)"
                  data-benefit="도심 간선도로 주행 시 시야를 완벽하게 장악하는 가장 대표적인 초대형 래핑면입니다. 상무지구, 광천터미널 등 핵심 도로에서 3초 안에 브랜드를 각인시킵니다.">
            차도면 (3,700×1,000)
          </button>
          <button type="button" class="dbc-chip bus-spot-btn"
                  data-name="인도면 표준 래핑"
                  data-size="3,000 × 500 mm"
                  data-target="버스 정류소 대기 승객 &amp; 인도 보행자 눈높이 1:1 밀착"
                  data-material="LG 하우시스 최고급 내후성 정품 솔벤 시트"
                  data-benefit="승객 탑승 시 눈높이 정면에 위치하여 전화번호, 진료과목, 핵심 진료 안내 등 상세 정보 전달에 가장 효과적인 밀착형 규격입니다.">
            인도면 (3,000×500)
          </button>
          <button type="button" class="dbc-chip bus-spot-btn"
                  data-name="후면 번호판 상단 래핑"
                  data-size="2,400 × 300 mm"
                  data-target="신호 대기 및 출퇴근 정체 시 후방 차량 운전자 3분 이상 강제 주시"
                  data-material="LG 하우시스 정품 솔벤 반사 시트 지원"
                  data-benefit="출퇴근 시간 및 교차로 신호 대기 중 뒤따르는 차량 운전자와 동승자 시선 정면에 장시간 강제 노출되는 가온엔 필수 패키지 면입니다.">
            후면 (2,400×300)
          </button>
          <button type="button" class="dbc-chip bus-spot-btn"
                  data-name="사랑면 (승하차문 측면)"
                  data-size="1,000 × 500 mm"
                  data-target="승객 승하차 시 즉각적인 시선 유도"
                  data-material="고접착 실사 솔벤 시트"
                  data-benefit="하차문 바로 옆에 위치하여 탑승객이 내릴 때 100% 마주치게 되며, 보행자가 버스에 접근할 때 즉각적인 주목도를 형성합니다.">
            사랑면 (1,000×500)
          </button>
          <button type="button" class="dbc-chip bus-spot-btn"
                  data-name="내부 중앙창문 포스터"
                  data-size="1,100 × 500 mm"
                  data-target="좌석 및 통로 탑승객 15~30분간 시선 독점"
                  data-material="실내 고선명 페트(PET) 출력"
                  data-benefit="목적지까지 이동하는 15~30분 동안 승객 시선 정면에 머물며 병원/학원의 세부 강점과 브랜드 스토리를 정독시키는 고밀도 매체입니다.">
            내부 창문 (1,100×500)
          </button>
          <button type="button" class="dbc-chip bus-spot-btn"
                  data-name="정류소 음성 안내 방송"
                  data-size="1회 7초 성우 음성"
                  data-target="해당 정류소 도착 전 탑승 승객 전원 청각 100% 각인"
                  data-material="전문 성우 육성 녹음 + 공식 오디오 마스터링"
                  data-benefit="'이번 정류소는 ○○병원 앞입니다.' 정류소당 단 1개 광고주만 독점 송출되어 시각적 한계를 넘어 청각으로 확실하게 기억시킵니다.">
            음성 안내 방송 (7초)
          </button>
        </div>

        <!-- STAGE VIEWER & LIVE DETAILED SPEC CARD -->
        <div class="dbc-stage-grid">
          
          <div class="dbc-visual-stage">
            <div class="dvs-frame">
              <img src="/images/sample_bus.jpg" id="dynBusImg" alt="시내버스 래핑 광고 실사">
              <div class="dvs-pulse-marker" id="dvsMarker" style="top:35%; left:25%;"></div>
            </div>
          </div>

          <div class="dbc-spec-console">
            <div class="dsc-badge" id="dynBusBadge">차도면 대형 래핑</div>
            <h3 class="dsc-dim" id="dynBusSize">3,700 × 1,000 mm</h3>
            
            <div class="dsc-row">
              <span class="dsc-lbl">노출 타깃</span>
              <strong class="dsc-val" id="dynBusTarget">왕복 6~8차선 반대편 차량 운전자 &amp; 반대편 보행자 정면 100% 노출</strong>
            </div>

            <div class="dsc-row">
              <span class="dsc-lbl">소재 및 재질</span>
              <strong class="dsc-val" id="dynBusMaterial">LG 하우시스 최고급 내후성 정품 솔벤 시트 (1년 이상 변색 방지)</strong>
            </div>
            
            <div class="dsc-row">
              <span class="dsc-lbl">전략적 특장점 상세 설명</span>
              <p class="dsc-desc" id="dynBusBenefit">도심 간선도로 주행 시 시야를 완벽하게 장악하는 가장 대표적인 초대형 래핑면입니다. 상무지구, 광천터미널 등 핵심 도로에서 3초 안에 브랜드를 각인시킵니다.</p>
            </div>

            <div class="dsc-action">
              <a href="/board/estmate/write.php" class="dsc-btn">이 규격으로 맞춤 견적 신청 →</a>
            </div>
          </div>

        </div>

        <!-- STEP 2: DYNAMIC ROUTE SEARCH & FILTER -->
        <div class="dbc-routes-filter-box">
          <div class="drf-header">
            <h4>광주 104개 노선 상권별 빠른 분류 및 타깃 안내</h4>
            <div class="drf-tabs">
              <button type="button" class="drf-tab on" data-route-cat="all">전체 노선</button>
              <button type="button" class="drf-tab" data-route-cat="express">급행 (광역 도심)</button>
              <button type="button" class="drf-tab" data-route-cat="main">간선 (주거·업무)</button>
              <button type="button" class="drf-tab" data-route-cat="feeder">지선 (골목·학원)</button>
            </div>
          </div>

          <div class="drf-grid" id="dynRouteGrid">
            <div class="drg-card" data-cat="express">
              <span class="drgc-badge red">급행 (Express)</span>
              <strong>순환01, 첨단09, 수완03</strong>
              <p>상무지구 ↔ 광천터미널 ↔ 충장로 ↔ 전남대·조선대 최단 시간 관통. 광주 전역 광역 브랜드 인지도 구축에 최적입니다.</p>
            </div>
            <div class="drg-card" data-cat="main">
              <span class="drgc-badge blue">간선 (Main Line)</span>
              <strong>매월16, 문흥18, 지원15</strong>
              <p>문흥·금호·풍암 등 대규모 아파트 밀집지와 시청·법원 중심 업무지구를 직통 연결하여 출퇴근 직장인을 집중 공략합니다.</p>
            </div>
            <div class="drg-card" data-cat="main">
              <span class="drgc-badge blue">간선 (Main Line)</span>
              <strong>봉선37, 일곡28, 첨단30</strong>
              <p>봉선동 학원가, 일곡지구, 첨단산단 핵심 주거 라인을 관통하여 학생, 학부모 및 전문직 타깃에 일상 반복 각인합니다.</p>
            </div>
            <div class="drg-card" data-cat="feeder">
              <span class="drgc-badge green">지선 (Feeder)</span>
              <strong>수완12, 첨단20, 용봉83</strong>
              <p>아파트 단지 앞 정류소, 학원가, 마트, 골목길을 촘촘히 이어 지역 로컬 단골 환자 및 고객과의 친밀도를 극대화합니다.</p>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>


  <!-- ============================================
       03 SECTION 02 : ONLINE MARKETING (DETAILED CLICK COCKPIT)
  ============================================ -->
  <section class="dyn-section" id="online">
    <div class="dyn-container">

      <div class="ds-head-box wow fadeInUp" data-wow-duration="0.7s">
        <div class="dsh-flex">
          <div>
            <span class="ds-num-tag">02 / ONLINE MARKETING &amp; SEO</span>
            <h2 class="ds-title">네이버 스마트플레이스 1위 &amp; 통합 온라인 마케팅</h2>
            <p class="ds-desc">업종 키워드 칩이나 우측 전략 카드를 클릭하시면 세부적인 검색 로직과 실행 방안이 자세히 표시됩니다.</p>
          </div>
          <button type="button" class="dsh-guide-btn bus-guide-open" data-guide="guideOnline">
            <span>온라인 6대 전략 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- DYNAMIC SEARCH COCKPIT -->
      <div class="dyn-seo-cockpit wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- KEYWORD SELECTOR STRIP -->
        <div class="dsc-kw-strip">
          <span class="dks-label">업종별 시뮬레이션 클릭:</span>
          <button type="button" class="dks-btn on" data-kw="광주 상무지구 안과" data-rank="1" data-review="2,840+" data-calls="480" data-strategy="상무지구 라식/라섹/백내장 키워드 최적화 및 네이버 예약 활성화">광주 상무지구 안과</button>
          <button type="button" class="dks-btn" data-kw="광주 수완지구 치과" data-rank="1" data-review="1,920+" data-calls="390" data-strategy="수완지구 임플란트/교정 C-Rank 블로그 칼럼 및 영수증 리뷰 빌드업">광주 수완지구 치과</button>
          <button type="button" class="dks-btn" data-kw="광주 첨단 피부과" data-rank="1" data-review="2,450+" data-calls="510" data-strategy="첨단지구 리프팅/여드름 SNS 릴스 숏폼 & 당근 로컬 반경 타깃팅">광주 첨단 피부과</button>
          <button type="button" class="dks-btn" data-kw="광주 봉선동 입시학원" data-rank="1" data-review="1,240+" data-calls="320" data-strategy="봉선동 학부모 맘카페 바이럴 및 수능/내신 대비 플레이스 상위 안착">광주 봉선동 입시학원</button>
        </div>

        <div class="dsc-cockpit-grid">
          
          <!-- LEFT: LIVE SEARCH MOCKUP -->
          <div class="dsm-frame">
            <div class="dsm-search-bar">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              <span id="dynKwText">광주 상무지구 안과</span>
            </div>
            
            <div class="dsm-place-box">
              <div class="dpb-header">
                <span class="dpb-rank" id="dynRankBadge">#1 네이버 스마트플레이스 1위</span>
                <span class="dpb-live-badge">LIVE 랭킹</span>
              </div>
              <h3 class="dpb-title">가온엔 파트너스 병원 · 브랜드</h3>
              <div class="dpb-rating">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <strong>5.0</strong>
                <span id="dynReviewCount">(방문자 영수증 리뷰 2,840+)</span>
              </div>
              <p class="dpb-addr">광주광역시 서구 상무중앙로 · 진료중 / 영업중</p>
              <div class="dpb-action-strip">
                <span class="das-btn blue" id="dynCallCount">네이버 예약 (월 480건)</span>
                <span class="das-btn">전화 문의</span>
                <span class="das-btn">길찾기</span>
              </div>
            </div>

            <div class="dsm-detail-box" style="margin-top:16px; padding:14px; background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0;">
              <span style="font-size:11px; font-weight:800; color:#1855b7; display:block; margin-bottom:4px;">적용된 1위 최적화 공식</span>
              <p id="dynStrategyDesc" style="font-size:12.5px; color:#475569; margin:0; line-height:1.5;">상무지구 라식/라섹/백내장 키워드 최적화 및 네이버 예약 활성화</p>
            </div>
          </div>

          <!-- RIGHT: 3 DETAILED STRATEGIC CARDS (CLICKABLE) -->
          <div class="dsm-strategy-col">
            <div class="dstrat-card on" data-strat-title="스마트플레이스 1위 SEO 상세" data-strat-body="'진료과목/업종 + 광주/상무/수완/첨단/봉선' 로컬 키워드 알고리즘을 100% 최적화하여 1페이지 지도 상위에 안착시키고 방문자 예약/리뷰 자산을 구축합니다.">
              <div class="dst-num">01</div>
              <div class="dst-body">
                <h4>스마트플레이스 1위 알고리즘 최적화</h4>
                <p>소비자가 모바일에서 '광주+진료과목/업종' 검색 시 지도 1페이지 상단 TOP 3에 진입하도록 플레이스 정보, 대표 키워드, 영수증 리뷰, 네이버 예약을 통합 관리합니다.</p>
              </div>
            </div>

            <div class="dstrat-card" data-strat-title="C-Rank 브랜드 블로그 상세" data-strat-body="의료법 사전 법무 검수를 통과한 월 8~12편의 고품질 정보성 칼럼으로 네이버 뷰탭 상위 노출과 환자들의 높은 신뢰를 구축합니다.">
              <div class="dst-num">02</div>
              <div class="dst-body">
                <h4>C-Rank &amp; DIA+ 브랜드 블로그 &amp; 맘카페</h4>
                <p>의료법 100% 사전 법무 검수를 통과한 월 8~12편의 전문 칼럼과 광주 대표 맘카페 바이럴을 통해 과장 광고 없는 청정한 정보성 콘텐츠로 신뢰 여론을 형성합니다.</p>
              </div>
            </div>

            <div class="dstrat-card" data-strat-title="SNS 릴스 & 당근 로컬 상세" data-strat-body="병원 반경 1~3km 지역 거주민을 정밀 타깃팅하여 즉각적인 문의 전화와 예약 전환을 만들어냅니다.">
              <div class="dst-num">03</div>
              <div class="dst-body">
                <h4>SNS 릴스 &amp; 당근 로컬 비즈니스 타깃</h4>
                <p>매장 및 병원 반경 1~3km 로컬 주민에게 인스타그램 세로형 숏폼 영상 광고와 당근마켓 피드 광고를 집행하여 즉각적인 전화 문의와 내방 예약을 촉진합니다.</p>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>
  </section>


  <!-- ============================================
       04 SECTION 03 : 영상제작 (4K CINEMATIC PRODUCTION - DARK THEME)
  ============================================ -->
  <section class="dyn-section dyn-bg-dark" id="video">
    <div class="dyn-container">

      <div class="ds-head-box dark-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="dsh-flex">
          <div>
            <span class="ds-num-tag gold">03 / 4K VIDEO PRODUCTION</span>
            <h2 class="ds-title white">4K 시네마틱 영상제작 &amp; SNS 숏폼 스튜디오</h2>
            <p class="ds-desc light">기업·병원 브랜드 필름부터 TV CF, 9:16 모바일 숏폼, 옥외 DID 모션까지 인하우스 프로덕션이 14일 Fast-Track으로 제작합니다.</p>
          </div>
          <button type="button" class="dsh-guide-btn dark bus-guide-open" data-guide="guideVideo">
            <span>영상제작 공정 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- VIDEO STUDIO DUAL CONSOLE -->
      <div class="dyn-video-console dark-console wow fadeInUp" data-wow-duration="0.8s">
        
        <!-- FORMAT SWITCH BUTTONS -->
        <div class="dvc-mode-bar">
          <button type="button" class="dvc-mode-btn dark on" data-video-mode="wide">16:9 와이드 시네마 모드</button>
          <button type="button" class="dvc-mode-btn dark" data-video-mode="shorts">9:16 SNS 릴스/숏폼 모드</button>
        </div>

        <div class="dvc-player-grid">
          
          <!-- MAIN VIDEO DISPLAY -->
          <div class="dvc-display-frame dark-frame" id="dynVideoFrame">
            <video autoplay muted loop playsinline class="dvc-video-element" id="dynMainVideo">
              <source src="/images/movie.mp4" type="video/mp4">
            </video>
            <div class="dvc-video-scrim"></div>
            
            <div class="dvc-video-caption">
              <span class="dvc-tag gold" id="dynVideoTag">16:9 4K BRAND FILM</span>
              <h3 id="dynVideoTitle">기업 · 상급병원 4K 시네마틱 브랜드 필름</h3>
              <p id="dynVideoSub">Sony FX Cinema 풀프레임 + 4K 드론 항공촬영 + 전문 성우 더빙</p>
            </div>
          </div>

          <!-- 4 CLEAR DELIVERABLES WITH EXPANDED EXPLANATIONS -->
          <div class="dvc-products-list dark-list">
            
            <div class="dvp-item dark on" data-target-mode="wide"
                 data-vtitle="기업 · 상급병원 4K 시네마틱 브랜드 필름"
                 data-vsub="Sony FX Cinema 풀프레임 + 4K 드론 항공촬영 + 전문 성우 더빙">
              <span class="dvp-idx">01</span>
              <div>
                <strong>기업 · 상급병원 브랜드 필름 (3~5분)</strong>
                <p>홈페이지 메인 및 공식 채널에 최적화된 영화급 홍보영상으로 Sony FX Cinema 풀프레임 카메라와 국토부 승인 4K 항공 드론으로 기업의 품격을 완성합니다.</p>
              </div>
            </div>

            <div class="dvp-item dark" data-target-mode="wide"
                 data-vtitle="TV CF & 극장 스크린 광고 (15초 / 30초)"
                 data-vsub="15초/30초 고임팩트 스토리텔링 + 2D/3D 모션그래픽">
              <span class="dvp-idx">02</span>
              <div>
                <strong>TV CF · 극장 광고 (15초 / 30초)</strong>
                <p>지상파/케이블 TV 및 CGV/메가박스 스크린에 송출되는 광고로, 짧은 시간 안에 강렬한 메시지를 각인시키는 임팩트 중심 스토리텔링을 제작합니다.</p>
              </div>
            </div>

            <div class="dvp-item dark" data-target-mode="shorts"
                 data-vtitle="SNS 모바일 숏폼 바이럴 (9:16 세로형)"
                 data-vsub="인스타그램 릴스 + 유튜브 쇼츠 + 틱톡 최적화 바이럴">
              <span class="dvp-idx">03</span>
              <div>
                <strong>SNS 릴스 · 유튜브 쇼츠 (9:16 세로형)</strong>
                <p>첫 3초 만에 시선을 사로잡는 빠른 컷 전환과 자막 모션그래픽으로 수만~수십만 뷰의 알고리즘 유기적 도달을 달성하는 모바일 최적화 영상입니다.</p>
              </div>
            </div>

            <div class="dvp-item dark" data-target-mode="wide"
                 data-vtitle="DID 디지털 전광판 모션그래픽 (15초 풀HD)"
                 data-vsub="옥외 고휘도 스크린 전용 15초 풀HD 고시인성 모션">
              <span class="dvp-idx">04</span>
              <div>
                <strong>DID 전광판 모션그래픽 (15초 풀HD)</strong>
                <p>유스퀘어 터미널, 지하철역, 관공서 로비 등의 고휘도 LED 전광판 환경에서 텍스트와 비주얼이 멀리서도 1초 만에 읽히는 고시인성 모션을 제작합니다.</p>
              </div>
            </div>

          </div>

        </div>

        <!-- 4-STEP FAST-TRACK PRODUCTION STRIP -->
        <div class="dyn-prod-workflow">
          <div class="dpw-step">
            <span class="dpw-badge">STEP 01</span>
            <strong>콘티 기획 (D+3)</strong>
            <span>1:1 맞춤 스토리보드 확정</span>
          </div>
          <div class="dpw-step">
            <span class="dpw-badge">STEP 02</span>
            <strong>4K 본촬영 (D+7)</strong>
            <span>Sony FX + 항공 드론 현장 촬영</span>
          </div>
          <div class="dpw-step">
            <span class="dpw-badge">STEP 03</span>
            <strong>가편집 &amp; 더빙 (D+10)</strong>
            <span>전문 성우 녹음 및 BGM 믹싱</span>
          </div>
          <div class="dpw-step highlight">
            <span class="dpw-badge">STEP 04</span>
            <strong>최종 납품 (D+14)</strong>
            <span>14일 내 멀티포맷 완성본 납품</span>
          </div>
        </div>

      </div>

    </div>
  </section>


  <!-- ============================================
       05 SECTION 04 : SPECIALIZED OOH ACCORDION (DETAILED CLICK)
  ============================================ -->
  <section class="dyn-section" id="other">
    <div class="dyn-container">

      <div class="ds-head-box wow fadeInUp" data-wow-duration="0.7s">
        <div class="dsh-flex">
          <div>
            <span class="ds-num-tag">04 / SPECIALIZED OOH MEDIA</span>
            <h2 class="ds-title">택시 · 택배 · 대형마트 · DID 4대 특화 옥외매체</h2>
            <p class="ds-desc">각 매체 카드를 클릭하시면 상세한 실측 규격, 운영 시간, 최적의 타깃 분석을 확인하실 수 있습니다.</p>
          </div>
          <button type="button" class="dsh-guide-btn bus-guide-open" data-guide="guideTaxiDelivery">
            <span>특화 매체 실측표 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- DYNAMIC INTERACTIVE ACCORDION GRID -->
      <div class="dyn-ooh-accordion wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="doa-card on">
          <img src="/images/sub_bg_b.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="택시 래핑 광고">
          <div class="doa-scrim"></div>
          <div class="doa-content">
            <span class="doa-kicker">01 / URBAN MOBILITY</span>
            <h3>법인 · 개인택시 양측면 래핑</h3>
            <p>광주 전역 200여 대 차량이 주요 번화가와 골목길을 24시간 365일 상시 운행하며, 보행자 눈높이에서 밀착 노출되어 높은 주목도를 발휘합니다.</p>
            <div class="doa-spec">실측 규격: 2,100 × 320 mm | 24시간 365일 연속 운행</div>
          </div>
        </div>

        <div class="doa-card">
          <img src="/images/sub_bg_c.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="택배차량 래핑 광고">
          <div class="doa-scrim"></div>
          <div class="doa-content">
            <span class="doa-kicker">02 / LOGISTICS BILLBOARD</span>
            <h3>택배 탑차 3면 와이드 래핑</h3>
            <p>광주 5개 구 대규모 아파트 단지와 주택가 골목길에 매일 10시간 이상 머무는 움직이는 초대형 랜드마크 빌보드로 주민 일상에 자연스럽게 각인됩니다.</p>
            <div class="doa-spec">실측 규격: 양면 3,000×1,500 + 후면 | 1일 10시간 체류</div>
          </div>
        </div>

        <div class="doa-card">
          <img src="/images/sub_bg_d.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="대형마트 쇼핑카트">
          <div class="doa-scrim"></div>
          <div class="doa-content">
            <span class="doa-kicker">03 / RETAIL PURCHASE POINT</span>
            <h3>대형마트 쇼핑카트 &amp; 무빙워크</h3>
            <p>이마트, 롯데마트 1,000여 대 카트 손잡이 정면에 위치하여 실질적 구매권을 가진 3050 주부 및 가족 고객과 60분간 1:1로 동행합니다.</p>
            <div class="doa-spec">실측 규격: 280 × 160 mm | 쇼핑 1회당 60분 연속 주시</div>
          </div>
        </div>

        <div class="doa-card">
          <img src="/images/sub_bg_e.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="DID 디지털 전광판">
          <div class="doa-scrim"></div>
          <div class="doa-content">
            <span class="doa-kicker">04 / DIGITAL SMART SIGNAGE</span>
            <h3>DID 디지털 전광판 &amp; 전자현수막</h3>
            <p>유스퀘어 터미널, 지하철 환승역, 관공서 로비에 고휘도 55~85" UHD 스크린으로 15초 영상을 하루 100회 이상 연속 송출합니다.</p>
            <div class="doa-spec">실측 규격: 55~85" UHD 패널 | 일 100회 이상 송출</div>
          </div>
        </div>

      </div>

    </div>
  </section>


  <!-- ============================================
       06 ALL-IN-ONE MASTER PORTFOLIO ARCHIVE
  ============================================ -->
  <section class="dyn-section dyn-bg-slate" id="archive">
    <div class="dyn-container">

      <div class="ds-head-box wow fadeInUp" data-wow-duration="0.7s">
        <span class="ds-num-tag">ALL-IN-ONE ARCHIVE</span>
        <h2 class="ds-title">성공 광고 집행 사례 포트폴리오</h2>
        <p class="ds-desc">카테고리 탭을 클릭하여 고화질 실사 사례를 확인하고, 즉시 1:1 맞춤 견적을 문의하세요.</p>
        
        <div class="dyn-filter-bar">
          <button type="button" class="dfb-btn on" data-filter="all">전체보기</button>
          <button type="button" class="dfb-btn" data-filter="bus">시내버스</button>
          <button type="button" class="dfb-btn" data-filter="online">온라인 마케팅</button>
          <button type="button" class="dfb-btn" data-filter="video">영상제작</button>
          <button type="button" class="dfb-btn" data-filter="taxi">택시·택배</button>
          <button type="button" class="dfb-btn" data-filter="mart">마트·DID</button>
        </div>
      </div>

      <!-- MASTER GRID -->
      <div class="dyn-port-grid wow fadeInUp" data-wow-duration="0.8s" id="masterPortGrid">
        <?php foreach (array_slice($list, 0, 8) as $item): ?>
        <div class="dpg-card main-port-card" data-cat="<?php echo htmlspecialchars($item['category']); ?>" data-id="<?php echo (int)$item['id']; ?>" data-name="<?php echo htmlspecialchars($item['title']); ?>">
          <div class="dpg-thumb">
            <?php if (!empty($item['thumb'])): ?>
            <img src="<?php echo htmlspecialchars($item['thumb']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
            <?php else: ?>
            <div class="dpg-empty">이미지 준비 중</div>
            <?php endif; ?>
            <div class="dpg-scrim"></div>
            <span class="dpg-tag"><?php echo isset($categories[$item['category']]) ? $categories[$item['category']] : '광고사례'; ?></span>
            <div class="dpg-hover-btn">상세보기 &amp; 견적조회 ↗</div>
          </div>
          <div class="dpg-info">
            <span class="dpg-cat"><?php echo isset($categories[$item['category']]) ? $categories[$item['category']] : '광고집행'; ?></span>
            <strong class="dpg-title"><?php echo htmlspecialchars($item['title']); ?></strong>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="dyn-more-box">
        <a href="/portfolio.php" class="dyn-more-btn">
          <span>포트폴리오 전체 100+ 사례 더보기</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>

    </div>
  </section>


  <!-- ============================================
       07 4-STEP MASTER PIPELINE
  ============================================ -->
  <section class="dyn-section" id="process">
    <div class="dyn-container">
      <div class="ds-head-box text-center wow fadeInUp" data-wow-duration="0.7s">
        <span class="ds-num-tag">WORKFLOW PIPELINE</span>
        <h2 class="ds-title">가온엔 4단계 원스톱 책임 마스터플랜</h2>
        <p class="ds-desc">외주 없는 100% 본사 인하우스 전문팀이 기획부터 시공, 보고까지 책임집니다.</p>
      </div>

      <div class="dyn-process-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="dp-step-card">
          <div class="dps-top">
            <span class="dps-num">01</span>
            <span class="dps-day">D+1</span>
          </div>
          <h3>상권 분석 &amp; 노선 믹스</h3>
          <p>병원, 학원, 기업의 주 타깃 고객 동선을 정밀 분석하여 최적의 노선과 매체를 제안합니다.</p>
        </div>

        <div class="dp-step-card">
          <div class="dps-top">
            <span class="dps-num">02</span>
            <span class="dps-day">D+3</span>
          </div>
          <h3>1:1 디자인 시안 기획</h3>
          <p>도심 속에서 3초 안에 메시지가 전달되도록 가독성 높은 실사 래핑 및 영상 콘티를 제작합니다.</p>
        </div>

        <div class="dp-step-card">
          <div class="dps-top">
            <span class="dps-num">03</span>
            <span class="dps-day">D+7</span>
          </div>
          <h3>직영 출력 &amp; 책임 시공</h3>
          <p>내후성 정품 솔벤 시트와 10년 이상 경력의 본사 전문 시공팀이 직접 깔끔하게 부착합니다.</p>
        </div>

        <div class="dp-step-card">
          <div class="dps-top">
            <span class="dps-num">04</span>
            <span class="dps-day">D+14</span>
          </div>
          <h3>실시간 증빙 &amp; 리포트</h3>
          <p>시공 직후 차량 4면 촬영본을 전송해 드리며, 온라인 노출 성과 데이터를 투명하게 보고합니다.</p>
        </div>

      </div>
    </div>
  </section>


  <!-- ============================================
       08 PARTNERS MARQUEE
  ============================================ -->
  <section class="dyn-partners-sec">
    <div class="dyn-container">
      <div class="dpt-title">TRUSTED BY INDUSTRY LEADERS</div>
    </div>
    <div class="dpt-marquee-box">
      <div class="dpt-track track-left">
        <span class="dpt-chip">전남대학교병원</span><span class="dpt-chip">조선대학교병원</span><span class="dpt-chip">광주안과</span><span class="dpt-chip">센트럴치과병원</span><span class="dpt-chip">이루다어학원</span><span class="dpt-chip">중흥건설</span><span class="dpt-chip">광주도시공사</span><span class="dpt-chip">그린모빌리티</span>
        <span class="dpt-chip">전남대학교병원</span><span class="dpt-chip">조선대학교병원</span><span class="dpt-chip">광주안과</span><span class="dpt-chip">센트럴치과병원</span><span class="dpt-chip">이루다어학원</span><span class="dpt-chip">중흥건설</span><span class="dpt-chip">광주도시공사</span><span class="dpt-chip">그린모빌리티</span>
      </div>
      <div class="dpt-track track-right">
        <span class="dpt-chip">원광대한방병원</span><span class="dpt-chip">바른정형외과</span><span class="dpt-chip">법무법인 광산</span><span class="dpt-chip">드림공인중개사</span><span class="dpt-chip">홀리데이호텔</span><span class="dpt-chip">라붐웨딩홀</span><span class="dpt-chip">베비에르</span><span class="dpt-chip">봉선어학센터</span>
        <span class="dpt-chip">원광대한방병원</span><span class="dpt-chip">바른정형외과</span><span class="dpt-chip">법무법인 광산</span><span class="dpt-chip">드림공인중개사</span><span class="dpt-chip">홀리데이호텔</span><span class="dpt-chip">라붐웨딩홀</span><span class="dpt-chip">베비에르</span><span class="dpt-chip">봉선어학센터</span>
      </div>
    </div>
  </section>


  <!-- ============================================
       09 STUDIO CONSULTATION CTA
  ============================================ -->
  <section class="dyn-cta-sec">
    <div class="dyn-container">
      <div class="dcta-box wow fadeInUp" data-wow-duration="0.8s">
        <div class="dcta-left">
          <span class="dcta-kicker">START YOUR CAMPAIGN</span>
          <h2 class="dcta-headline">광고, 이제<br><em>가온엔과 함께 제대로</em> 시작하세요.</h2>
          <p class="dcta-sub">시내버스 옥외광고부터 스마트플레이스 SEO 검색 마케팅까지, 1:1 맞춤 견적을 신속하게 안내해 드립니다.</p>
        </div>
        <div class="dcta-right">
          <a href="/board/estmate/write.php" class="dcta-btn">
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
          <p class="lmh-desc">광주 시내버스 104개 전 노선 실측 치수부터 택시·택배, 마트·DID, 온라인 SEO 및 4K 영상제작 스펙을 확인하세요.</p>
        </div>
        <button type="button" class="lux-modal-close" id="btnCloseBusGuide">✕</button>
      </div>

      <div class="lux-modal-tabs">
        <button type="button" class="lmt-tab on" data-target="guideBus">시내버스 옥외광고</button>
        <button type="button" class="lmt-tab" data-target="guideTaxiDelivery">택시 · 택배차량</button>
        <button type="button" class="lmt-tab" data-target="guideMartDid">대형마트 · DID</button>
        <button type="button" class="lmt-tab" data-target="guideOnline">온라인 마케팅 &amp; SEO</button>
        <button type="button" class="lmt-tab" data-target="guideVideo">영상제작 (4K Production)</button>
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
            <h4 class="ltb-title">01 4K 시네마틱 영상제작 &amp; SNS 숏폼 프로덕션</h4>
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
