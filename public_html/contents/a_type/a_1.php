<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";

$categories = array(
    'all'    => 'ALL',
    'bus'    => '시내버스 광고',
    'online' => '온라인 마케팅',
    'video'  => '영상제작',
    'taxi'   => '택시·특화매체',
    'did'    => 'DID·전광판',
    'mart'   => '대형마트 카트'
);

$sql = "SELECT * FROM portfolio WHERE status='active' ORDER BY sort_order ASC, id DESC";
$result = mysqli_query($conn, $sql);
$list = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $list[] = $row;
    }
}

// 24+ Rich fallback items if DB empty
if (empty($list)) {
    $list = array(
        // BUS
        array('id'=>1, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'상무지구 메디컬센터 시내버스 3면 풀래핑 광고', 'tag'=>'광주 시내버스', 'date'=>'2026·09', 'thumb'=>'/images/bs_ad/baro.jpg'),
        array('id'=>2, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'광주 주요 간선도로 시내버스 인도면 표준 래핑', 'tag'=>'광주 시내버스', 'date'=>'2026·09', 'thumb'=>'/images/bs_ad/baro_3.jpg'),
        array('id'=>3, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'교차로 신호 대기 차량 타깃 시내버스 후면 래핑', 'tag'=>'광주 시내버스', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/baro_9.jpg'),
        array('id'=>4, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'광주 104개 노선 시내버스 내부 중앙창문 포스터', 'tag'=>'버스 내부광고', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/port_in03.jpg'),
        array('id'=>5, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'수완지구 학원가 집중 배차 버스 차도면 3.7m', 'tag'=>'광주 시내버스', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/baro.jpg'),
        array('id'=>6, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'순환01번 시내버스 정류소 음성안내 방송', 'tag'=>'버스 음성방송', 'date'=>'2026·07', 'thumb'=>'/images/bs_ad/port_in01.jpg'),

        // ONLINE
        array('id'=>9, 'category'=>'online', 'badge'=>'PLACE SEO', 'title'=>'봉선동 입시학원 네이버 스마트플레이스 1위 세팅', 'tag'=>'네이버 플레이스', 'date'=>'2026·09', 'thumb'=>'/images/bs_ad/baro_13.jpg'),
        array('id'=>10, 'category'=>'online', 'badge'=>'C-RANK BLOG', 'title'=>'상무지구 피부과 C-Rank 브랜드 블로그 칼럼 마케팅', 'tag'=>'브랜드 블로그', 'date'=>'2026·09', 'thumb'=>'/images/bs_ad/baro_14.jpg'),
        array('id'=>11, 'category'=>'online', 'badge'=>'VIRAL', 'title'=>'수완지구 외식 브랜드 광주 맘카페 & 릴스 바이럴', 'tag'=>'맘카페 바이럴', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/baro_15.jpg'),
        array('id'=>12, 'category'=>'online', 'badge'=>'META ADS', 'title'=>'광주 핫플레이스 인스타그램 반경 1~3km 타깃 광고', 'tag'=>'인스타그램 광고', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/baro_16.jpg'),
        array('id'=>21, 'category'=>'online', 'badge'=>'PLACE SEO', 'title'=>'광주 대표 척추병원 네이버 플레이스 리뷰 빌드업', 'tag'=>'네이버 플레이스', 'date'=>'2026·07', 'thumb'=>'/images/bs_ad/baro_13.jpg'),
        array('id'=>22, 'category'=>'online', 'badge'=>'C-RANK BLOG', 'title'=>'호남 최대 법무법인 브랜드 블로그 상위 블록 선점', 'tag'=>'브랜드 블로그', 'date'=>'2026·07', 'thumb'=>'/images/bs_ad/baro_14.jpg'),

        // VIDEO
        array('id'=>13, 'category'=>'video', 'badge'=>'CINEMA 4K', 'title'=>'광주 대표 종합병원 4K UHD 시네마틱 브랜드 필름', 'tag'=>'시네마틱 영상', 'date'=>'2026·09', 'thumb'=>'/images/bs_ad/visual01.jpg'),
        array('id'=>14, 'category'=>'video', 'badge'=>'TV CF', 'title'=>'기업 TV CF & 극장 스크린 30초 풀프레임 광고 영상', 'tag'=>'TV CF', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/visual02.jpg'),
        array('id'=>15, 'category'=>'video', 'badge'=>'SNS REELS', 'title'=>'SNS 릴스 · 유튜브 숏폼 9:16 모바일 바이럴 영상', 'tag'=>'숏폼 바이럴', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/visual03.jpg'),
        array('id'=>16, 'category'=>'video', 'badge'=>'DID MOTION', 'title'=>'유스퀘어 터미널 DID 디지털 전광판 15초 모션그래픽', 'tag'=>'전광판 영상', 'date'=>'2026·07', 'thumb'=>'/images/bs_ad/did_01.jpg'),

        // TAXI & DELIVERY
        array('id'=>17, 'category'=>'taxi', 'badge'=>'TAXI WRAP', 'title'=>'광주 전역 법인·개인택시 200대 양측면 래핑 광고', 'tag'=>'택시 래핑', 'date'=>'2026·09', 'thumb'=>'/images/ev1.jpg'),
        array('id'=>18, 'category'=>'taxi', 'badge'=>'DELIVERY', 'title'=>'광주 5개 구 아파트 단지 택배 탑차 3면 와이드 래핑', 'tag'=>'택배차 래핑', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/baro_18.jpg'),

        // DID
        array('id'=>19, 'category'=>'did', 'badge'=>'SIGNAGE', 'title'=>'유스퀘어 광주버스터미널 4K UHD 디지털 사이니지 송출', 'tag'=>'터미널 전광판', 'date'=>'2026·09', 'thumb'=>'/images/bs_ad/did_01.jpg'),
        array('id'=>20, 'category'=>'did', 'badge'=>'LED SIGN', 'title'=>'상무 교차로 대형 빌딩 LED 전광판 4K 광고 영상 송출', 'tag'=>'빌딩 전광판', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/did_02.jpg'),

        // MART
        array('id'=>23, 'category'=>'mart', 'badge'=>'CART AD', 'title'=>'광주 이마트 쇼핑카트 1,000대 양면 플레이트 광고', 'tag'=>'마트 카트광고', 'date'=>'2026·09', 'thumb'=>'/images/sub_bg_02.jpg'),
        array('id'=>24, 'category'=>'mart', 'badge'=>'CART AD', 'title'=>'광주 롯데마트 쇼핑카트 3050 주부 타깃 밀착 광고', 'tag'=>'마트 카트광고', 'date'=>'2026·08', 'thumb'=>'/images/sub_bg_02.jpg')
    );
}

$totalCount = count($list);
?>
<body class="is-sub sub-body portfolio-body">
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/blank.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/skip.php"; ?>

<div id="wrap">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php"; ?>

  <main id="container" class="mbp-main-wrap">
    
    <!-- 1. SUBPAGE TOP HEADER & SEARCH PILL -->
    <section class="mbp-top-sec">
      <div class="am-container-wide">
        
        <!-- BREADCRUMB -->
        <nav class="mbp-breadcrumb" aria-label="breadcrumb">
          <a href="/" class="mbp-bc-home">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
          </a>
          <span class="mbp-bc-sep">›</span>
          <span class="mbp-bc-item">포트폴리오</span>
          <span class="mbp-bc-sep">›</span>
          <span class="mbp-bc-current" id="mbpCurrentCatLabel">ALL</span>
        </nav>

        <!-- TITLE & SEARCH PILL ROW -->
        <div class="mbp-title-row wow fadeInUp" data-wow-duration="0.6s">
          <div class="mbp-title-wrap">
            <h1 class="mbp-main-title">포트폴리오</h1>
            <p class="mbp-sub-desc">시내버스 옥외광고, 온라인 마케팅, 4K 영상제작까지 가온엔의 온·오프라인 집행 실적입니다.</p>
          </div>

          <!-- SEARCH PILL -->
          <div class="mbp-search-pill">
            <input type="text" id="mbpSearchInput" placeholder="프로젝트명을 입력해주세요" aria-label="포트폴리오 검색">
            <button type="button" id="mbpSearchBtn" class="mbp-search-btn" aria-label="검색">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
          </div>
        </div>

      </div>
    </section>

    <!-- 2. FILTER BAR (TOTAL COUNT + TEXT CATEGORY TABS) -->
    <section class="mbp-filter-sec">
      <div class="am-container-wide">
        
        <div class="mbp-filter-bar wow fadeInUp" data-wow-duration="0.6s">
          
          <!-- TOTAL COUNTER -->
          <div class="mbp-total-counter">
            <strong id="mbpTotalNum"><?php echo $totalCount; ?></strong>
            <span class="mbp-total-unit">eXperience</span>
          </div>

          <!-- CATEGORY TABS -->
          <ul class="mbp-category-list" id="mbpCatList">
            <?php foreach ($categories as $k => $v): 
              $isActive = ($k === 'all') ? 'on' : '';
            ?>
            <li class="mbp-cat-item">
              <button type="button" class="mbp-cat-link <?php echo $isActive; ?>" data-cat="<?php echo $k; ?>">
                <h2><?php echo $v; ?></h2>
              </button>
            </li>
            <?php endforeach; ?>
          </ul>

        </div>

      </div>
    </section>

    <!-- 3. PORTFOLIO CARDS GRID -->
    <section class="mbp-grid-sec" id="mbpGridSec">
      <div class="am-container-wide">
        
        <div class="mbp-portfolio-grid" id="mbpGrid">
          <?php foreach ($list as $item): 
            $cat = !empty($item['category']) ? htmlspecialchars($item['category']) : 'bus';
            $badgeText = !empty($item['badge']) ? htmlspecialchars($item['badge']) : (isset($categories[$cat]) ? $categories[$cat] : 'GAON-N');
            $tagText = !empty($item['tag']) ? htmlspecialchars($item['tag']) : (isset($categories[$cat]) ? $categories[$cat] : 'MEDIA');
            $imgSrc = !empty($item['thumb']) ? htmlspecialchars($item['thumb']) : '/images/bs_ad/baro.jpg';
            $dateText = !empty($item['date']) ? htmlspecialchars($item['date']) : '2026·09';
            $titleText = htmlspecialchars($item['title']);
          ?>
          <div class="mbp-card-item wow fadeInUp" data-wow-duration="0.7s"
               data-cat="<?php echo $cat; ?>"
               data-id="<?php echo (int)$item['id']; ?>"
               data-name="<?php echo $titleText; ?>"
               data-img="<?php echo $imgSrc; ?>"
               data-tag="<?php echo $tagText; ?>"
               data-date="<?php echo $dateText; ?>">
            
            <!-- IMAGE BOX WITH HOVER ZOOM & BADGE -->
            <div class="mbp-img-box">
              <img src="<?php echo $imgSrc; ?>" alt="<?php echo $titleText; ?>" loading="lazy">
              <span class="mbp-badge"><?php echo $badgeText; ?></span>
              <div class="mbp-img-overlay">
                <span class="mbp-view-btn">View Detail ➔</span>
              </div>
            </div>

            <!-- TEXT BOX -->
            <div class="mbp-text-box">
              <div class="mbp-card-meta">
                <span class="mbp-card-tag"><?php echo $tagText; ?></span>
                <span class="mbp-card-date"><?php echo $dateText; ?></span>
              </div>
              <h3 class="mbp-card-title"><?php echo $titleText; ?></h3>
            </div>

          </div>
          <?php endforeach; ?>
        </div>

        <!-- DYNAMIC PAGING AREA -->
        <div class="mbp-paging-area wow fadeInUp" data-wow-duration="0.6s" id="mbpPagingArea">
          <ul class="mbp-pagination" id="mbpPaginationList">
            <!-- Rendered dynamically by JavaScript -->
          </ul>
        </div>

      </div>
    </section>

  </main>

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

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/bottom_conversion.php"; ?>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php"; ?>
</div>

<script>
$(document).ready(function() {
  var PAGE_SIZE = 9;
  var currentPage = 1;

  function renderPortfolio() {
    var activeCat = $('.mbp-cat-link.on').data('cat') || 'all';
    var kw = ($('#mbpSearchInput').val() || '').toLowerCase().trim();
    
    // Find matching items
    var $matchedItems = $('.mbp-card-item').filter(function() {
      var itemCat = $(this).data('cat');
      var itemName = ($(this).data('name') || '').toLowerCase();
      var matchCat = (activeCat === 'all' || itemCat === activeCat);
      var matchKw = (kw === '' || itemName.indexOf(kw) !== -1);
      return matchCat && matchKw;
    });

    var totalItems = $matchedItems.length;
    var totalPages = Math.ceil(totalItems / PAGE_SIZE) || 1;
    if (currentPage > totalPages) currentPage = 1;

    // Hide all items first
    $('.mbp-card-item').hide();

    // Show slice for current page
    var startIndex = (currentPage - 1) * PAGE_SIZE;
    var endIndex = startIndex + PAGE_SIZE;
    $matchedItems.slice(startIndex, endIndex).stop(true, true).fadeIn(200);

    // Update Counter
    $('#mbpTotalNum').text(totalItems);

    // Render Pagination
    var pageHtml = '';
    if (totalPages > 1) {
      pageHtml += '<li><button type="button" class="mbp-page-arrow" data-page="1">«</button></li>';
      pageHtml += '<li><button type="button" class="mbp-page-arrow" data-page="' + Math.max(1, currentPage - 1) + '">‹</button></li>';

      for (var p = 1; p <= totalPages; p++) {
        var activeClass = (p === currentPage) ? 'active' : '';
        pageHtml += '<li><button type="button" class="mbp-page-num ' + activeClass + '" data-page="' + p + '">' + p + '</button></li>';
      }

      pageHtml += '<li><button type="button" class="mbp-page-arrow" data-page="' + Math.min(totalPages, currentPage + 1) + '">›</button></li>';
      pageHtml += '<li><button type="button" class="mbp-page-arrow" data-page="' + totalPages + '">»</button></li>';
      $('#mbpPagingArea').show();
    } else {
      pageHtml = '<li><button type="button" class="mbp-page-num active" data-page="1">1</button></li>';
      $('#mbpPagingArea').show();
    }
    $('#mbpPaginationList').html(pageHtml);
  }

  // Tab Click Event
  $(document).on('click', '.mbp-cat-link', function(e) {
    e.preventDefault();
    $('.mbp-cat-link').removeClass('on');
    $(this).addClass('on');
    $('#mbpCurrentCatLabel').text($(this).text().trim());
    currentPage = 1;
    renderPortfolio();
  });

  // Search Input Event
  $('#mbpSearchInput').on('keyup', function() {
    currentPage = 1;
    renderPortfolio();
  });

  // Pagination Click Event
  $(document).on('click', '.mbp-page-num, .mbp-page-arrow', function(e) {
    e.preventDefault();
    var p = parseInt($(this).data('page'), 10);
    if (p && p !== currentPage) {
      currentPage = p;
      renderPortfolio();
      $('html, body').animate({ scrollTop: $('#mbpGridSec').offset().top - 120 }, 300);
    }
  });

  // Lightbox Modal Click Event
  $(document).on('click', '.mbp-card-item', function() {
    var title = $(this).data('name');
    var img = $(this).data('img');
    var tag = $(this).data('tag');
    var date = $(this).data('date');

    $('#modalTitle').text(title);
    $('#modalImg').attr('src', img);
    $('#modalCat').text(tag + ' · ' + date);
    $('#modalLoc').text('광주 주요 상권 직영 시공 사례');
    $('#modalBackdrop').addClass('open');
  });

  // Modal Close
  $(document).on('click', '#modalClose, .portfolio-modal-backdrop', function(e) {
    if (e.target === this || $(this).attr('id') === 'modalClose') {
      $('#modalBackdrop').removeClass('open');
    }
  });

  $(document).on('keydown', function(e) {
    if (e.key === 'Escape') $('#modalBackdrop').removeClass('open');
  });

  // Initial Run
  renderPortfolio();
});
</script>
</body>
</html>