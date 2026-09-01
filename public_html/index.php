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
       01 HERO STAGE : KINETIC CINEMATIC BILLBOARD
  ============================================ -->
  <section class="am-hero" id="hero">
    <div class="am-container">
      
      <!-- TOP NAVIGATOR CHIPS -->
      <div class="amh-top-row wow fadeInDown" data-wow-duration="0.6s">
        <div class="amh-beacon">
          <span class="amb-dot"></span>
          <span>GAON-N TOTAL ADVERTISING GROUP 2026</span>
        </div>
        <div class="amh-nav-chips">
          <a href="#bus" class="anc-chip">시내버스 광고</a>
          <a href="#online" class="anc-chip">온라인 마케팅</a>
          <a href="#video" class="anc-chip">영상제작</a>
          <a href="#other" class="anc-chip">특화 옥외매체</a>
          <a href="#process" class="anc-chip">마스터플랜</a>
        </div>
      </div>

      <!-- HERO HEADLINE -->
      <div class="amh-copy-block wow fadeInUp" data-wow-duration="0.8s">
        <h1 class="amh-h1">
          광주 시내버스 104개 노선 독점 직영,<br>
          <span class="amh-gradient">옥외광고 · 온라인 마케팅 · 영상제작</span>
        </h1>
        <p class="amh-desc">
          광주 5개 구 1,000대 시내버스 래핑부터 네이버 1위 상위노출, 4K 시네마틱 영상제작까지 본사가 기획부터 시공까지 100% 직접 전담합니다.
        </p>
      </div>

      <!-- ACTION CTAS -->
      <div class="amh-cta-row wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
        <a href="/board/estmate/write.php" class="amh-btn-primary">
          <span>맞춤 노선 &amp; 견적 신청</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
        <button type="button" class="amh-btn-secondary bus-guide-open" data-guide="guideBus">
          <span>매체별 실측 가이드 확인 ↗</span>
        </button>
      </div>

      <!-- 21:9 CINEMA FRAME WITH LIVE COUNTERS -->
      <div class="amh-cinema-frame wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.2s">
        <div class="acf-viewport">
          <video autoplay muted loop playsinline class="acf-video">
            <source src="/images/movie.mp4" type="video/mp4">
          </video>
          <div class="acf-scrim"></div>

          <div class="acf-hud-bar">
            <div class="ahb-item">
              <span class="ahb-num counter" data-target="104">104</span><span class="ahb-unit">개</span>
              <span class="ahb-lbl">광주 전 노선 단독 직영</span>
            </div>
            <div class="ahb-item">
              <span class="ahb-num counter" data-target="1000">1000</span><span class="ahb-unit">+ 대</span>
              <span class="ahb-lbl">광주 5개 구 운행 차량</span>
            </div>
            <div class="ahb-item">
              <span class="ahb-num counter" data-target="18">18</span><span class="ahb-unit">시간</span>
              <span class="ahb-lbl">일일 도로 연속 노출</span>
            </div>
            <div class="ahb-item blue">
              <span class="ahb-num counter" data-target="100">100</span><span class="ahb-unit">%</span>
              <span class="ahb-lbl">본사 직영 책임 시공</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       02 SECTION 01 : 시내버스 광고 (CORE PROMOTIONS & SEPARATED SEARCH)
  ============================================ -->
  <section class="am-section am-bg-slate" id="bus">
    <div class="am-container">
      
      <div class="am-sec-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker">01 / OOH BUS ADVERTISING</span>
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
        
        <!-- STEP 1: DIMENSION CHIPS -->
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

        <!-- STAGE VIEWER & LIVE SPEC CARD -->
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
              <a href="/board/estmate/write.php" class="abp-btn">이 규격으로 맞춤 견적 신청 →</a>
            </div>
          </div>

        </div>

      </div>

      <!-- BUS PROMOTIONAL 3-PILLAR ADVANTAGES -->
      <div class="am-bus-promo-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="abp-promo-card">
          <span class="apc-num">01</span>
          <h3>광주 104개 전 노선 단독 직영 배차</h3>
          <p>병원, 학원, 분양 홍보관의 주 타깃 고객이 밀집된 상무·수완·봉선·첨단 등 핵심 거점을 정확하게 관통하는 맞춤형 최적 노선을 단독 설계합니다.</p>
          <div class="apc-stat">광주 5개 구 1,000대 시내버스 독점 운영</div>
        </div>

        <div class="abp-promo-card">
          <span class="apc-num">02</span>
          <h3>1일 18시간 · 일 150만 시민 눈높이 노출</h3>
          <p>새벽 5시 30분부터 밤 12시까지 도심 주요 간선도로와 교차로를 쉼 없이 순환하며, 운전자와 보행자 시선 정면에 하루 150만 회 이상 강제 노출됩니다.</p>
          <div class="apc-stat">차도면 3.7m + 인도면 3.0m + 후면 2.4m 3면 패키지</div>
        </div>

        <div class="abp-promo-card">
          <span class="apc-num">03</span>
          <h3>LG 하우시스 정품 솔벤 시트 &amp; 100% 직영 시공</h3>
          <p>외주 하청 없는 10년 경력의 본사 전문 시공팀이 내후성 정품 솔벤 시트로 직접 출력 및 부착하며, 시공 직후 번호판 포함 4면 증빙 사진을 실시간 보고합니다.</p>
          <div class="apc-stat">시공 직후 차량 4면 번호판 실사 즉시 전송</div>
        </div>

      </div>

    </div>
  </section>


  <!-- ============================================
       03 SECTION 02 : 온라인 마케팅 (EXPANDED CHANNELS & VISUAL SYMBOLS)
  ============================================ -->
  <section class="am-section" id="online">
    <div class="am-container">

      <div class="am-sec-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker">02 / INTEGRATED DIGITAL MARKETING</span>
            <h2 class="ash-title">온라인 마케팅</h2>
            <p class="ash-desc">네이버 플레이스 1위부터 블로그, 맘카페, 인스타 스폰서드, 구글 GDN, 틱톡 숏폼까지 매출로 직결되는 통합 솔루션입니다.</p>
          </div>
          <button type="button" class="ash-guide-btn bus-guide-open" data-guide="guideOnline">
            <span>온라인 전체 채널 가이드 ↗</span>
          </button>
        </div>
      </div>

      <!-- LARGE HIGH-IMPACT VISUAL SHOWCASE FRAME -->
      <div class="am-online-hero-frame wow fadeInUp" data-wow-duration="0.8s">
        <div class="aoh-image-wrap">
          <img src="/images/sub_bg_a.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="가온엔 통합 디지털 마케팅 센터">
          <div class="aoh-scrim"></div>
          <div class="aoh-badge-float">
            <span class="abf-dot"></span>
            <span>NAVER · GOOGLE · INSTAGRAM · TIKTOK INTEGRATED</span>
          </div>
          <div class="aoh-content-bottom">
            <h3>검색 1위 상위노출부터 맘카페 바이럴 &amp; SNS 스폰서드까지</h3>
            <p>스마트플레이스 + C-Rank 블로그 + 맘카페 + 인스타/당근 + 구글 GDN + 틱톡 숏폼을 원스톱 통합 실행합니다.</p>
          </div>
        </div>
      </div>

      <!-- PRACTICAL DIGITAL MARKETING 4 CHANNELS (CRISP & BOLD) -->
      <div class="am-online-practical-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="aop-card">
          <div class="aop-top">
            <span class="aop-num">01</span>
            <span class="aop-tag blue">지도 1위</span>
          </div>
          <h3 class="aop-title">스마트플레이스 1위</h3>
          <p class="aop-desc">
            '광주+진료과목/업종' 검색 시 지도 1페이지 TOP 3 안착. 대표 키워드 5종 세팅, 영수증 리뷰 자산화 및 24시간 네이버 예약을 연동합니다.
          </p>
          <div class="aop-highlight-tag">네이버 지도 1페이지 상단 노출</div>
        </div>

        <div class="aop-card">
          <div class="aop-top">
            <span class="aop-num">02</span>
            <span class="aop-tag blue">의료법 안심</span>
          </div>
          <h3 class="aop-title">C-Rank 블로그 &amp; 맘카페</h3>
          <p class="aop-desc">
            보건소 행정처분 리스크 0%의 의료법 100% 사전 법무 검수. 원장님 전문 칼럼과 광주맘스홀릭 침투 바이럴로 압도적 신뢰를 구축합니다.
          </p>
          <div class="aop-highlight-tag">월 8~12편 전문 칼럼 &amp; 맘카페 후기</div>
        </div>

        <div class="aop-card">
          <div class="aop-top">
            <span class="aop-num">03</span>
            <span class="aop-tag green">로컬 타깃</span>
          </div>
          <h3 class="aop-title">인스타 스폰서드 &amp; 당근</h3>
          <p class="aop-desc">
            병원/매장 반경 1~3km 내 실제 거주 3050 핵심 세대원 타깃. 인스타그램 피드/스토리 스폰서드와 당근마켓 로컬 광고로 문의를 폭발시킵니다.
          </p>
          <div class="aop-highlight-tag">반경 1~3km 정밀 세대원 타깃팅</div>
        </div>

        <div class="aop-card">
          <div class="aop-top">
            <span class="aop-num">04</span>
            <span class="aop-tag gold">글로벌·숏폼</span>
          </div>
          <h3 class="aop-title">구글 GDN &amp; 틱톡 숏폼</h3>
          <p class="aop-desc">
            구글 검색/디스플레이 네트워크(GDN) 정밀 리타깃팅과 틱톡 세로형 9:16 바이럴 영상 광고로 2030 영타깃 및 광역 고객을 완벽 흡수합니다.
          </p>
          <div class="aop-highlight-tag">구글 검색 키워드 + 틱톡 숏폼 바이럴</div>
        </div>

      </div>

      <!-- VISUAL SYMBOL ASSURANCE DECK -->
      <div class="am-online-guarantee-deck wow fadeInUp" data-wow-duration="0.8s">
        <div class="aog-card">
          <div class="aog-icon-box">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg>
          </div>
          <div class="aog-body">
            <strong>의료법 100% 준수 보증</strong>
            <span>허위·과장 표현 원천 차단으로 행정처분 및 보건소 리스크 0%</span>
          </div>
        </div>

        <div class="aog-card">
          <div class="aog-icon-box">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
          </div>
          <div class="aog-body">
            <strong>주간 순위 투명 리포트</strong>
            <span>플레이스 순위, 검색 키워드 유입수, 광고 CTR 매주 투명 보고</span>
          </div>
        </div>

        <div class="aog-card">
          <div class="aog-icon-box">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
          </div>
          <div class="aog-body">
            <strong>1:1 전담 마케팅 디렉터</strong>
            <span>외주 대행 없는 본사 인하우스 전담팀의 실시간 피드백 책임제</span>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- ============================================
       04 SECTION 03 : 영상제작 (CINEMATIC DARK PRODUCTION & BIG WORKFLOW)
  ============================================ -->
  <section class="am-section am-bg-dark" id="video">
    <div class="am-container">

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
        
        <!-- FORMAT SWITCH BUTTONS -->
        <div class="avc-mode-bar">
          <button type="button" class="avc-btn on" data-video-mode="wide">16:9 와이드 시네마 모드</button>
          <button type="button" class="avc-btn" data-video-mode="shorts">9:16 SNS 릴스/숏폼 모드</button>
        </div>

        <div class="avc-grid">
          
          <!-- VIDEO FRAME -->
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

          <!-- 4 DELIVERABLES (BIG HEADLINES) -->
          <div class="avc-products-col">
            
            <div class="avp-card on" data-target-mode="wide"
                 data-vtitle="기업 · 상급병원 4K 시네마틱 브랜드 필름"
                 data-vsub="Sony FX Cinema 풀프레임 + 4K 드론 항공촬영 + 전문 성우 더빙">
              <span class="avp-idx">01</span>
              <div>
                <strong class="avp-big-title">기업 · 상급병원 브랜드 필름 (3~5분)</strong>
                <p>Sony FX Cinema 풀프레임 카메라와 국토부 승인 4K 항공 드론으로 완성하는 최고급 영화급 홍보영상</p>
              </div>
            </div>

            <div class="avp-card" data-target-mode="wide"
                 data-vtitle="TV CF & 극장 스크린 광고 (15초 / 30초)"
                 data-vsub="15초/30초 고임팩트 스토리텔링 + 2D/3D 모션그래픽">
              <span class="avp-idx">02</span>
              <div>
                <strong class="avp-big-title">TV CF · 극장 광고 (15초 / 30초)</strong>
                <p>지상파/케이블 TV 및 CGV/메가박스 스크린에 송출되는 15초/30초 초압축 임팩트 스토리텔링</p>
              </div>
            </div>

            <div class="avp-card" data-target-mode="shorts"
                 data-vtitle="SNS 모바일 숏폼 바이럴 (9:16 세로형)"
                 data-vsub="인스타그램 릴스 + 유튜브 쇼츠 + 틱톡 최적화 바이럴">
              <span class="avp-idx">03</span>
              <div>
                <strong class="avp-big-title">SNS 릴스 · 틱톡 숏폼 (9:16 세로형)</strong>
                <p>첫 3초 만에 시선을 사로잡는 빠른 컷 전환과 자막 모션그래픽으로 수만~수십만 뷰의 유기적 알고리즘 도달</p>
              </div>
            </div>

            <div class="avp-card" data-target-mode="wide"
                 data-vtitle="DID 디지털 전광판 모션그래픽 (15초 풀HD)"
                 data-vsub="옥외 고휘도 스크린 전용 15초 풀HD 고시인성 모션">
              <span class="avp-idx">04</span>
              <div>
                <strong class="avp-big-title">DID 전광판 모션그래픽 (15초 풀HD)</strong>
                <p>유스퀘어 터미널, 지하철역, 관공서 로비 등의 고휘도 LED 전광판 환경에서 1초 만에 읽히는 고시인성 모션</p>
              </div>
            </div>

          </div>

        </div>

        <!-- 14-DAY BIG PRODUCTION WORKFLOW WITH EMOJI ICONS -->
        <div class="am-video-big-workflow">
          <div class="avbw-card">
            <div class="avbw-top">
              <span class="avbw-emoji">📝</span>
              <span class="avbw-day">D+3</span>
            </div>
            <span class="avbw-step">STEP 01</span>
            <strong>콘티 기획</strong>
            <p>1:1 맞춤형 스토리보드 및 연출 콘티 확정</p>
          </div>

          <div class="avbw-card">
            <div class="avbw-top">
              <span class="avbw-emoji">🎬</span>
              <span class="avbw-day">D+7</span>
            </div>
            <span class="avbw-step">STEP 02</span>
            <strong>4K 본촬영</strong>
            <p>Sony FX 풀프레임 시네마 + 4K 드론 항공촬영</p>
          </div>

          <div class="avbw-card">
            <div class="avbw-top">
              <span class="avbw-emoji">🎧</span>
              <span class="avbw-day">D+10</span>
            </div>
            <span class="avbw-step">STEP 03</span>
            <strong>편집 &amp; 더빙</strong>
            <p>전문 성우 내레이션 녹음, BGM 믹싱, 색보정</p>
          </div>

          <div class="avbw-card highlight">
            <div class="avbw-top">
              <span class="avbw-emoji">🚀</span>
              <span class="avbw-day gold">D+14</span>
            </div>
            <span class="avbw-step">STEP 04</span>
            <strong>최종 납품</strong>
            <p>14일 내 멀티 포맷(16:9 / 9:16) 완성본 납품</p>
          </div>
        </div>

      </div>

    </div>
  </section>


  <!-- ============================================
       05 SECTION 04 : 특화 옥외매체 (INTERACTIVE ACCORDION)
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

      <!-- DYNAMIC ACCORDION -->
      <div class="am-ooh-accordion wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="aoa-card on">
          <img src="/images/sub_bg_b.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="택시 래핑 광고">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">01 / URBAN MOBILITY</span>
            <h3>법인 · 개인택시 양측면 래핑</h3>
            <p>광주 전역 200여 대 차량이 주요 번화가와 골목길을 24시간 365일 상시 운행하며, 보행자 눈높이에서 밀착 노출되어 높은 주목도를 발휘합니다.</p>
            <div class="doa-spec">실측 규격: 2,100 × 320 mm | 24시간 365일 연속 운행</div>
          </div>
        </div>

        <div class="aoa-card">
          <img src="/images/sub_bg_c.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="택배차량 래핑 광고">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">02 / LOGISTICS BILLBOARD</span>
            <h3>택배 탑차 3면 와이드 래핑</h3>
            <p>광주 5개 구 대규모 아파트 단지와 주택가 골목길에 매일 10시간 이상 머무는 움직이는 초대형 랜드마크 빌보드로 주민 일상에 자연스럽게 각인됩니다.</p>
            <div class="doa-spec">실측 규격: 양면 3,000×1,500 + 후면 | 1일 10시간 체류</div>
          </div>
        </div>

        <div class="aoa-card">
          <img src="/images/sub_bg_d.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="대형마트 쇼핑카트">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">03 / RETAIL PURCHASE POINT</span>
            <h3>대형마트 쇼핑카트 &amp; 무빙워크</h3>
            <p>이마트, 롯데마트 1,000여 대 카트 손잡이 정면에 위치하여 실질적 구매권을 가진 3050 주부 및 가족 고객과 60분간 1:1로 동행합니다.</p>
            <div class="doa-spec">실측 규격: 280 × 160 mm | 쇼핑 1회당 60분 연속 주시</div>
          </div>
        </div>

        <div class="aoa-card">
          <img src="/images/sub_bg_e.jpg" onerror="this.src='/images/sample_bus.jpg';" alt="DID 디지털 전광판">
          <div class="aoa-scrim"></div>
          <div class="aoa-content">
            <span class="aoa-kicker">04 / DIGITAL SMART SIGNAGE</span>
            <h3>DID 디지털 전광판 &amp; 전자현수막</h3>
            <p>유스퀘어 터미널, 지하철 환승역, 관공서 로비에 고휘도 55~85" UHD 스크린으로 15초 영상을 하루 100회 이상 연속 송출합니다.</p>
            <div class="doa-spec">실측 규격: 55~85" UHD 패널 | 일 100회 이상 송출</div>
          </div>
        </div>

      </div>

    </div>
  </section>


  <!-- ============================================
       06 SECTION 05 : 성공 사례 (ALL-IN-ONE MASTER ARCHIVE)
  ============================================ -->
  <section class="am-section am-bg-slate" id="archive">
    <div class="am-container">

      <div class="am-sec-head wow fadeInUp" data-wow-duration="0.7s">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker">PORTFOLIO ARCHIVE</span>
            <h2 class="ash-title">성공 사례</h2>
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
       07 SECTION 06 : 마스터플랜 (VISUAL PROGRESS PIPELINE)
  ============================================ -->
  <section class="am-section" id="process">
    <div class="am-container">
      <div class="am-sec-head text-center wow fadeInUp" data-wow-duration="0.7s">
        <span class="ash-kicker">WORKFLOW PIPELINE</span>
        <h2 class="ash-title">마스터플랜</h2>
        <p class="ash-desc" style="margin:0 auto;">외주 없는 100% 본사 인하우스 전문팀이 기획부터 시공, 보고까지 완벽히 책임지는 4단계 마스터플랜입니다.</p>
      </div>

      <!-- VISUAL PROCESS PIPELINE (BIG TYPOGRAPHY & VISUAL ICONS) -->
      <div class="am-pipeline-grid wow fadeInUp" data-wow-duration="0.8s">
        
        <div class="apg-step-card">
          <div class="apg-step-header">
            <span class="apg-huge-num">01</span>
            <span class="apg-day-pill">D+1 DAY</span>
          </div>
          <div class="apg-icon-circle">🧭</div>
          <h3 class="apg-step-title">상권 분석 &amp; 노선 믹스</h3>
          <p class="apg-step-sub">타깃 상권 빅데이터 분석 및 온·오프라인 최적 미디어 믹스 설계</p>
          <div class="apg-deliverable-box">
            <span>핵심 산출물:</span>
            <strong>상권 분석 보고서 &amp; 최적 노선 믹스</strong>
          </div>
        </div>

        <div class="apg-step-card">
          <div class="apg-step-header">
            <span class="apg-huge-num">02</span>
            <span class="apg-day-pill">D+3 DAY</span>
          </div>
          <div class="apg-icon-circle">🎨</div>
          <h3 class="apg-step-title">1:1 디자인 시안 기획</h3>
          <p class="apg-step-sub">도심 속에서 3초 안에 읽히는 실사 래핑 및 영상 스토리보드 제작</p>
          <div class="apg-deliverable-box">
            <span>핵심 산출물:</span>
            <strong>3면 실측 1:1 맞춤 디자인 시안 3종</strong>
          </div>
        </div>

        <div class="apg-step-card">
          <div class="apg-step-header">
            <span class="apg-huge-num">03</span>
            <span class="apg-day-pill">D+7 DAY</span>
          </div>
          <div class="apg-icon-circle">🏗️</div>
          <h3 class="apg-step-title">직영 출력 &amp; 책임 시공</h3>
          <p class="apg-step-sub">LG 하우시스 정품 솔벤 시트 자체 출력과 본사 10년 경력팀 직접 시공</p>
          <div class="apg-deliverable-box">
            <span>핵심 산출물:</span>
            <strong>LG 하우시스 최고급 내후성 시공</strong>
          </div>
        </div>

        <div class="apg-step-card highlight">
          <div class="apg-step-header">
            <span class="apg-huge-num blue">04</span>
            <span class="apg-day-pill gold">D+14 DAY</span>
          </div>
          <div class="apg-icon-circle blue">📈</div>
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
       09 STUDIO CONSULTATION CTA
  ============================================ -->
  <section class="am-cta-sec">
    <div class="am-container">
      <div class="act-box wow fadeInUp" data-wow-duration="0.8s">
        <div class="act-left">
          <span class="act-kicker">START YOUR CAMPAIGN</span>
          <h2 class="act-headline">광고, 이제<br><em>가온엔과 함께 제대로</em> 시작하세요.</h2>
          <p class="act-sub">시내버스 옥외광고부터 스마트플레이스 SEO 검색 마케팅까지, 1:1 맞춤 견적을 신속하게 안내해 드립니다.</p>
        </div>
        <div class="act-right">
          <a href="/board/estmate/write.php" class="act-btn">
            <span>맞춤 견적 상담 신청</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
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
        <a href="/board/estmate/write.php" class="rsm-foot-btn">1:1 노선 무료 분석 신청 →</a>
      </div>
    </div>
  </div>


  <!-- ============================================
       11 SWISS-STYLE EDITORIAL SPECIFICATION MODAL (EXPANDED DIVERSE CONTENT)
  ============================================ -->
  <div class="bus-guide-overlay" id="busGuideOverlay">
    <div class="lux-modal-panel">
      
      <div class="lux-modal-head">
        <div>
          <span class="lmh-label">GAON-N OFFICIAL SPECIFICATION DECK</span>
          <h3 class="lmh-title">가온엔 통합 미디어 실측 규격 &amp; 마케팅 종합 가이드</h3>
          <p class="lmh-desc">시내버스 7대 규격부터 택시·택배, 마트·DID, 네이버·구글·인스타·틱톡 6대 온라인 전략, 4K 영상제작 공정까지 확인하세요.</p>
        </div>
        <button type="button" class="lux-modal-close" id="btnCloseBusGuide">✕</button>
      </div>

      <div class="lux-modal-tabs">
        <button type="button" class="lmt-tab on" data-target="guideBus">시내버스 광고</button>
        <button type="button" class="lmt-tab" data-target="guideOnline">온라인 통합 마케팅</button>
        <button type="button" class="lmt-tab" data-target="guideVideo">영상제작 (4K Production)</button>
        <button type="button" class="lmt-tab" data-target="guideTaxiDelivery">택시 · 택배차량</button>
        <button type="button" class="lmt-tab" data-target="guideMartDid">대형마트 · DID</button>
      </div>

      <div class="lux-modal-body">
        
        <!-- 01 BUS (STRUCTURED PARAGRAPH CARDS) -->
        <div class="bus-guide-page on" id="guideBus">
          <h4 class="lmg-sec-title">시내버스 외부 광고 4대 부착면 실측 규격</h4>
          <div class="lmg-card-grid">
            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge blue">차도면 대형</span>
                <span class="lmc-dim">3,700 × 1,000 mm</span>
              </div>
              <strong class="lmc-name">차도면 대형 광고 (Driver Side)</strong>
              <p class="lmc-desc">왕복 6~8차선 반대편 차량 운전자와 인도 보행자의 시야 정면에 노출되는 대표 대형 래핑면입니다.</p>
              <div class="lmc-meta">
                <span><strong>핵심 타깃:</strong> 운전자 &amp; 반대편 보행자</span>
                <span><strong>소재:</strong> LG 하우시스 정품 솔벤 시트</span>
              </div>
            </div>

            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge blue">인도면 표준</span>
                <span class="lmc-dim">3,000 × 500 mm</span>
              </div>
              <strong class="lmc-name">인도면 표준 광고 (Curb Side)</strong>
              <p class="lmc-desc">정류소 대기 승객 및 인도 보행자의 눈높이와 1:1로 밀착되어 높은 가독성을 자랑합니다.</p>
              <div class="lmc-meta">
                <span><strong>핵심 타깃:</strong> 정류소 승객 &amp; 인도 보행자</span>
                <span><strong>소재:</strong> LG 하우시스 정품 솔벤 시트</span>
              </div>
            </div>

            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge blue">후면 보조</span>
                <span class="lmc-dim">2,400 × 300 mm</span>
              </div>
              <strong class="lmc-name">후면 번호판 상단 광고 (Rear Side)</strong>
              <p class="lmc-desc">신호 대기 및 도로 정체 시 후방 차량 운전자에게 3분 이상 강제 주시되는 필수 패키지 면입니다.</p>
              <div class="lmc-meta">
                <span><strong>핵심 타깃:</strong> 후방 정체 차량 운전자</span>
                <span><strong>소재:</strong> 정품 솔벤 반사 시트 지원</span>
              </div>
            </div>

            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge blue">사랑면</span>
                <span class="lmc-dim">1,000 × 500 mm</span>
              </div>
              <strong class="lmc-name">사랑면 승하차문 보조 광고</strong>
              <p class="lmc-desc">승하차문 측면에 부착되어 탑승객 및 접근 보행자의 즉각적인 주목도를 확보합니다.</p>
              <div class="lmc-meta">
                <span><strong>핵심 타깃:</strong> 승하차 탑승객</span>
                <span><strong>소재:</strong> 고접착 실사 솔벤 시트</span>
              </div>
            </div>
          </div>
        </div>

        <!-- 02 ONLINE (EXPANDED DIVERSE CHANNELS) -->
        <div class="bus-guide-page" id="guideOnline">
          <h4 class="lmg-sec-title">가온엔 통합 온라인 마케팅 6대 채널 종합 가이드</h4>
          <div class="lmg-card-grid">
            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge blue">01 스마트플레이스</span>
                <span class="lmc-dim">지도 TOP 3</span>
              </div>
              <strong class="lmc-name">네이버 스마트플레이스 1위 SEO</strong>
              <p class="lmc-desc">로컬 1위 SEO 알고리즘 8대 평가 요소 세팅, 영수증 리뷰 빌드업, 24시간 네이버 예약/톡톡 연동으로 유입 콜 수를 극대화합니다.</p>
            </div>

            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge blue">02 C-Rank 블로그</span>
                <span class="lmc-dim">의료법 100% 검수</span>
              </div>
              <strong class="lmc-name">C-Rank 브랜드 블로그 파워콘텐츠</strong>
              <p class="lmc-desc">의료법 제56조 100% 사전 법무 검수로 행정처분 위험 0%. 원장님 진료 철학 기반 월 8~12편 전문 칼럼으로 스마트블록/뷰탭을 점유합니다.</p>
            </div>

            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge green">03 맘카페 바이럴</span>
                <span class="lmc-dim">광주맘스홀릭</span>
              </div>
              <strong class="lmc-name">광주 대표 맘카페 &amp; 커뮤니티 바이럴</strong>
              <p class="lmc-desc">광주맘스홀릭, 광주맘수다방, 당근마켓 동네생활 실유저 침투로 자연스러운 내방 후기와 3050 주부 신뢰 여론을 100% 형성합니다.</p>
            </div>

            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge gold">04 인스타/당근</span>
                <span class="lmc-dim">반경 1~3km</span>
              </div>
              <strong class="lmc-name">SNS 릴스 &amp; 당근 로컬 스폰서드</strong>
              <p class="lmc-desc">병원/매장 반경 1~3km 내 실제 거주 세대원만을 정밀 타깃팅하여 인스타그램 숏폼 영상 광고와 당근 피드로 문의를 폭발시킵니다.</p>
            </div>

            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge gold">05 구글 GDN</span>
                <span class="lmc-dim">검색 &amp; 배너</span>
              </div>
              <strong class="lmc-name">구글 검색광고 &amp; GDN 디스플레이</strong>
              <p class="lmc-desc">구글 검색 키워드 타깃팅과 유튜브/언론사 제휴 배너 네트워크(GDN)를 통해 관심 고객에게 지속적인 리타깃팅을 집행합니다.</p>
            </div>

            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge gold">06 틱톡 숏폼</span>
                <span class="lmc-dim">9:16 바이럴</span>
              </div>
              <strong class="lmc-name">틱톡 &amp; 유튜브 쇼츠 숏폼 바이럴</strong>
              <p class="lmc-desc">첫 3초 시선 장악 컷 전환과 자막 모션그래픽으로 수만~수십만 뷰의 유기적 알고리즘 도달을 달성하는 모바일 최적화 영상입니다.</p>
            </div>
          </div>
        </div>

        <!-- 03 VIDEO (4K PRODUCTION) -->
        <div class="bus-guide-page" id="guideVideo">
          <h4 class="lmg-sec-title">4K 시네마틱 영상제작 &amp; SNS 숏폼 프로덕션 공정</h4>
          <div class="lmg-card-grid">
            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge gold">브랜드 필름</span>
                <span class="lmc-dim">4K UHD</span>
              </div>
              <strong class="lmc-name">기업 · 상급병원 브랜드 필름</strong>
              <p class="lmc-desc">Sony FX Cinema 풀프레임 + 4K 드론 항공촬영으로 최상의 품격을 완성하며 홈페이지 메인 및 TV CF에 최적화됩니다.</p>
            </div>

            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge gold">모바일 숏폼</span>
                <span class="lmc-dim">9:16 FHD</span>
              </div>
              <strong class="lmc-name">SNS 릴스 · 틱톡 숏폼</strong>
              <p class="lmc-desc">첫 3초 만에 시선을 사로잡는 빠른 템포의 모바일 영상으로 수만 뷰 이상의 유기적 도달을 달성합니다.</p>
            </div>
          </div>
        </div>

        <!-- 04 TAXI & DELIVERY -->
        <div class="bus-guide-page" id="guideTaxiDelivery">
          <h4 class="lmg-sec-title">택시 &amp; 택배차량 래핑 실측 가이드</h4>
          <div class="lmg-card-grid">
            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge blue">택시 래핑</span>
                <span class="lmc-dim">2,100 × 320 mm</span>
              </div>
              <strong class="lmc-name">법인 · 개인택시 양측면 래핑</strong>
              <p class="lmc-desc">광주 전역 200여 대 차량이 주요 번화가와 골목길까지 24시간 연속 운행하며 보행자 눈높이에서 밀착 노출됩니다.</p>
            </div>
            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge blue">택배 탑차</span>
                <span class="lmc-dim">3,000 × 1,500 mm</span>
              </div>
              <strong class="lmc-name">택배 탑차 3면 와이드 래핑</strong>
              <p class="lmc-desc">광주 5개 구 아파트 단지와 주택가 골목길에 매일 10시간 이상 머무는 움직이는 초대형 랜드마크 빌보드입니다.</p>
            </div>
          </div>
        </div>

        <!-- 05 MART & DID -->
        <div class="bus-guide-page" id="guideMartDid">
          <h4 class="lmg-sec-title">대형마트 쇼핑카트 &amp; DID 전광판 규격</h4>
          <div class="lmg-card-grid">
            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge gold">쇼핑카트</span>
                <span class="lmc-dim">280 × 160 mm</span>
              </div>
              <strong class="lmc-name">대형마트 쇼핑카트 양면 플레이트</strong>
              <p class="lmc-desc">이마트, 롯데마트 1,000여 대 카트 손잡이 정면에 장착되어 60분 쇼핑 내내 3050 주부 및 가족 고객과 동행합니다.</p>
            </div>
            <div class="lmg-card">
              <div class="lmc-head">
                <span class="lmc-badge gold">DID 전광판</span>
                <span class="lmc-dim">55 ~ 85" UHD</span>
              </div>
              <strong class="lmc-name">DID 전자현수막 &amp; 도심 전광판</strong>
              <p class="lmc-desc">유스퀘어 터미널, 지하철 환승역, 관공서 로비에 고휘도 LED로 15~20초 영상이 일 100회 이상 연속 송출됩니다.</p>
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
          <a href="/board/estmate/write.php" class="pmb-cta-btn">이와 같은 광고 견적 문의하기 →</a>
        </div>
      </div>
    </div>
  </div>

	<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php";?>

</div>

</body>
</html>
