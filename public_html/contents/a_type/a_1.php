<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";

$categories = array(
    'all'    => '전체',
    'bus'    => '시내버스',
    'online' => '온라인마케팅',
    'video'  => '영상제작',
    'taxi'   => '특화매체',
    'did'    => 'DID전광판',
    'web'    => '웹·랜딩'
);

$result = mysqli_query($conn, "SELECT * FROM portfolio WHERE status='active' ORDER BY sort_order ASC, id DESC");
$list = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $list[] = $row;
    }
}

// Fallback if db empty
if (empty($list)) {
    $list = array(
        array('id'=>1, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'상무지구 대형 메디컬센터 시내버스 3면 풀래핑 광고', 'tag'=>'BUS-AD', 'date'=>'26·09·01', 'thumb'=>'/images/bs_ad/baro.jpg'),
        array('id'=>9, 'category'=>'online', 'badge'=>'PLACE SEO', 'title'=>'봉선동 대표 입시학원 네이버 스마트플레이스 1위 세팅', 'tag'=>'ONLINE', 'date'=>'26·09·01', 'thumb'=>'/images/bs_ad/baro_13.jpg'),
        array('id'=>13, 'category'=>'video', 'badge'=>'CINEMA 4K', 'title'=>'광주 대표 종합병원 4K UHD 시네마틱 브랜드 필름', 'tag'=>'VIDEO', 'date'=>'26·08·28', 'thumb'=>'/images/bs_ad/visual01.jpg'),
        array('id'=>18, 'category'=>'taxi', 'badge'=>'OOH WRAP', 'title'=>'광주 5개 구 아파트 단지 택배 탑차 3면 와이드 래핑', 'tag'=>'SPECIAL', 'date'=>'26·08·25', 'thumb'=>'/images/bs_ad/baro_18.jpg'),
        array('id'=>10, 'category'=>'online', 'badge'=>'C-RANK BLOG', 'title'=>'상무지구 피부과 C-Rank 브랜드 블로그 전문 칼럼 발행', 'tag'=>'ONLINE', 'date'=>'26·08·20', 'thumb'=>'/images/bs_ad/baro_14.jpg'),
        array('id'=>2, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'광주 주요 간선도로 시내버스 인도면 표준 래핑 광고', 'tag'=>'BUS-AD', 'date'=>'26·08·15', 'thumb'=>'/images/bs_ad/baro_3.jpg'),
        array('id'=>15, 'category'=>'video', 'badge'=>'SNS REELS', 'title'=>'인스타그램 릴스 & 유튜브 숏폼 모바일 9:16 바이럴', 'tag'=>'VIDEO', 'date'=>'26·08·10', 'thumb'=>'/images/bs_ad/visual03.jpg'),
        array('id'=>3, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'교차로 신호 대기 차량 타깃 시내버스 후면 래핑 광고', 'tag'=>'BUS-AD', 'date'=>'26·08·05', 'thumb'=>'/images/bs_ad/baro_9.jpg'),
        array('id'=>11, 'category'=>'online', 'badge'=>'VIRAL', 'title'=>'수완지구 외식 브랜드 광주 맘카페 & 당근마켓 바이럴', 'tag'=>'ONLINE', 'date'=>'26·07·30', 'thumb'=>'/images/bs_ad/baro_15.jpg'),
        array('id'=>19, 'category'=>'did', 'badge'=>'SIGNAGE', 'title'=>'유스퀘어 광주버스터미널 4K UHD 디지털 사이니지 송출', 'tag'=>'DID', 'date'=>'26·07·25', 'thumb'=>'/images/bs_ad/did_01.jpg'),
        array('id'=>4, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'광주 시내버스 내부 중앙창문 & 전문 성우 음성안내 방송', 'tag'=>'BUS-IN', 'date'=>'26·07·20', 'thumb'=>'/images/bs_ad/port_in03.jpg'),
        array('id'=>12, 'category'=>'online', 'badge'=>'META ADS', 'title'=>'광주 로컬 핫플레이스 인스타그램 릴스 스폰서 광고', 'tag'=>'META', 'date'=>'26·07·15', 'thumb'=>'/images/bs_ad/baro_16.jpg')
    );
}

$totalCount = count($list);
?>
<body class="is-sub port-archive-page">
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/blank.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/skip.php"; ?>

<div id="wrap">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php"; ?>

  <main id="container" class="port-sub-container">
    <div class="am-container-wide" style="padding-top: 140px; padding-bottom: 140px;">
      
      <!-- SUBPAGE HEADER (UNIFIED 46PX LUXURY TITLE) -->
      <div class="am-sec-head wow fadeInUp" data-wow-duration="0.7s" style="margin-bottom: 40px;">
        <div class="ash-flex">
          <div>
            <span class="ash-kicker">04 / CLIENT PORTFOLIO</span>
            <h1 class="ash-title" style="font-size: 52px; margin-bottom: 12px;">포트폴리오</h1>
            <p class="ash-desc">시내버스 옥외광고, 온라인 마케팅, 4K 브랜드 영상까지 가온엔이 직접 기획·집행한 실제 포트폴리오 아카이브입니다.</p>
          </div>
          <div class="ash-actions">
            <a href="/board/estmate/write.php" class="ash-guide-btn blue">
              <span>맞춤 광고 견적 문의하기 ➔</span>
            </a>
          </div>
        </div>
      </div>

      <!-- RESULTS COUNT & CATEGORY TABS -->
      <div class="ms-meta-bar wow fadeInUp" data-wow-duration="0.6s">
        <span class="ms-results-count"><strong id="dynResultCount"><?php echo $totalCount; ?></strong> Results</span>
        <div class="sub-port-search-box">
          <input type="text" id="subPortSearchInput" placeholder="브랜드명, 업종, 키워드 검색...">
          <button type="button" id="subPortSearchBtn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          </button>
        </div>
      </div>

      <!-- 44PX BOLD CATEGORY TABS -->
      <div class="ms-huge-tabs wow fadeInUp" data-wow-duration="0.7s">
        <button type="button" class="ms-tab on" data-filter="all">All <span class="ms-sub">전체</span></button>
        <button type="button" class="ms-tab" data-filter="bus">시내버스 <span class="ms-sub">Bus</span></button>
        <button type="button" class="ms-tab" data-filter="online">온라인 <span class="ms-sub">Online</span></button>
        <button type="button" class="ms-tab" data-filter="video">영상제작 <span class="ms-sub">Video</span></button>
        <button type="button" class="ms-tab" data-filter="taxi">특화매체 <span class="ms-sub">Special</span></button>
        <button type="button" class="ms-tab" data-filter="did">전광판·DID <span class="ms-sub">Signage</span></button>
      </div>

      <!-- 4-COLUMN CARDS GRID (EXACT SCREENSHOT CARD RATIO & DETAILS) -->
      <div class="ms-cards-grid-4 wow fadeInUp" data-wow-duration="0.8s" id="masterPortGrid">
        <?php 
        foreach ($list as $idx => $item): 
          $cat = !empty($item['category']) ? htmlspecialchars($item['category']) : 'bus';
          $badgeText = !empty($item['badge']) ? htmlspecialchars($item['badge']) : (isset($categories[$cat]) ? $categories[$cat] : 'GAON-N');
          $tagText = !empty($item['tag']) ? htmlspecialchars($item['tag']) : (isset($categories[$cat]) ? $categories[$cat] : 'MEDIA');
          $imgSrc = !empty($item['thumb']) ? htmlspecialchars($item['thumb']) : '/images/bs_ad/baro.jpg';
          $dateText = !empty($item['date']) ? htmlspecialchars($item['date']) : '26·09·01';
          $titleText = htmlspecialchars($item['title']);
        ?>
        <div class="ms-card main-port-card" 
             data-cat="<?php echo $cat; ?>" 
             data-id="<?php echo (int)$item['id']; ?>" 
             data-name="<?php echo $titleText; ?>">
          
          <!-- UPPER THUMBNAIL (ROUNDED TOP WITH INNER BADGE) -->
          <div class="ms-card-thumb">
            <img src="<?php echo $imgSrc; ?>" alt="<?php echo $titleText; ?>">
            <span class="ms-badge-pill"><?php echo $badgeText; ?></span>
            <div class="ms-hover-overlay">상세보기 ↗</div>
          </div>

          <!-- LOWER WHITE BODY (TITLE + ARROW + BOTTOM META) -->
          <div class="ms-card-body">
            <div class="ms-body-top">
              <h4 class="ms-card-title"><?php echo $titleText; ?></h4>
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

    </div>
  </main>

  <!-- LIGHTBOX MODAL -->
  <div class="portfolio-modal-backdrop" id="modalBackdrop">
    <div class="pm-modal-box">
      <button type="button" class="pm-close-btn" id="modalClose">✕</button>
      <div class="pm-img-wrap">
        <img src="" id="modalImg" alt="포트폴리오 상세 실사">
      </div>
      <div class="pm-info-wrap">
        <span class="pm-cat-badge" id="modalCat">광고사례</span>
        <h3 class="pm-title" id="modalTitle">프로젝트명</h3>
        <p class="pm-loc" id="modalLoc">광주 주요 상권 직영 시공</p>
        <div class="pm-action-row">
          <a href="/board/estmate/write.php" class="pm-cta-btn">이 광고 집행 견적 문의 ➔</a>
        </div>
      </div>
    </div>
  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php"; ?>
</div>

<script>
// SUBPAGE INSTANT TAB FILTERING & REAL-TIME SEARCH
$(document).ready(function() {
  function filterPortfolio() {
    var filter = $('.ms-tab.on').data('filter') || 'all';
    var kw = ($('#subPortSearchInput').val() || '').toLowerCase().trim();
    var visibleCount = 0;

    $('.ms-card').each(function() {
      var itemCat = $(this).data('cat');
      var itemName = ($(this).data('name') || '').toLowerCase();
      var matchCat = (filter === 'all' || itemCat === filter);
      var matchKw = (kw === '' || itemName.indexOf(kw) !== -1);

      if (matchCat && matchKw) {
        $(this).stop(true, true).fadeIn(200);
        visibleCount++;
      } else {
        $(this).stop(true, true).hide();
      }
    });

    $('#dynResultCount').text(visibleCount);
  }

  $(document).on('click', '.ms-tab', function() {
    $('.ms-tab').removeClass('on');
    $(this).addClass('on');
    filterPortfolio();
  });

  $(document).on('keyup', '#subPortSearchInput', function() {
    filterPortfolio();
  });

  $(document).on('click', '#subPortSearchBtn', function() {
    filterPortfolio();
  });
});
</script>
</body>
</html>