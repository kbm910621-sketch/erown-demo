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

$reqCat = isset($_GET['category']) ? trim($_GET['category']) : 'all';
if (!array_key_exists($reqCat, $categories)) {
    $reqCat = 'all';
}

$sql = "SELECT * FROM portfolio WHERE status='active' ";
if ($reqCat !== 'all') {
    $safeCat = mysqli_real_escape_string($conn, $reqCat);
    $sql .= " AND category='{$safeCat}' ";
}
$sql .= " ORDER BY sort_order ASC, id DESC";

$result = mysqli_query($conn, $sql);
$list = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $list[] = $row;
    }
}

// Rich fallback items if DB empty
if (empty($list)) {
    $allFallback = array(
        array('id'=>1, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'상무지구 대형 메디컬센터 시내버스 3면 풀래핑 광고', 'tag'=>'광주 시내버스', 'date'=>'2026·09', 'thumb'=>'/images/bs_ad/baro.jpg'),
        array('id'=>9, 'category'=>'online', 'badge'=>'PLACE SEO', 'title'=>'봉선동 대표 입시학원 네이버 스마트플레이스 1위 세팅', 'tag'=>'네이버 플레이스', 'date'=>'2026·09', 'thumb'=>'/images/bs_ad/baro_13.jpg'),
        array('id'=>13, 'category'=>'video', 'badge'=>'CINEMA 4K', 'title'=>'광주 대표 종합병원 4K UHD 시네마틱 브랜드 필름', 'tag'=>'시네마틱 영상', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/visual01.jpg'),
        array('id'=>18, 'category'=>'taxi', 'badge'=>'OOH WRAP', 'title'=>'광주 5개 구 아파트 단지 택배 탑차 3면 와이드 래핑', 'tag'=>'특화 래핑', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/baro_18.jpg'),
        array('id'=>10, 'category'=>'online', 'badge'=>'C-RANK BLOG', 'title'=>'상무지구 피부과 C-Rank 브랜드 블로그 전문 칼럼 발행', 'tag'=>'브랜드 블로그', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/baro_14.jpg'),
        array('id'=>2, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'광주 주요 간선도로 시내버스 인도면 표준 래핑 광고', 'tag'=>'광주 시내버스', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/baro_3.jpg'),
        array('id'=>15, 'category'=>'video', 'badge'=>'SNS REELS', 'title'=>'인스타그램 릴스 & 유튜브 숏폼 모바일 9:16 바이럴', 'tag'=>'숏폼 바이럴', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/visual03.jpg'),
        array('id'=>3, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'교차로 신호 대기 차량 타깃 시내버스 후면 래핑 광고', 'tag'=>'광주 시내버스', 'date'=>'2026·08', 'thumb'=>'/images/bs_ad/baro_9.jpg'),
        array('id'=>11, 'category'=>'online', 'badge'=>'VIRAL', 'title'=>'수완지구 외식 브랜드 광주 맘카페 & 당근마켓 바이럴', 'tag'=>'맘카페 바이럴', 'date'=>'2026·07', 'thumb'=>'/images/bs_ad/baro_15.jpg'),
        array('id'=>19, 'category'=>'did', 'badge'=>'SIGNAGE', 'title'=>'유스퀘어 광주버스터미널 4K UHD 디지털 사이니지 송출', 'tag'=>'터미널 전광판', 'date'=>'2026·07', 'thumb'=>'/images/bs_ad/did_01.jpg'),
        array('id'=>4, 'category'=>'bus', 'badge'=>'BUS·AD', 'title'=>'광주 시내버스 내부 중앙창문 & 전문 성우 음성안내 방송', 'tag'=>'버스 내부광고', 'date'=>'2026·07', 'thumb'=>'/images/bs_ad/port_in03.jpg'),
        array('id'=>12, 'category'=>'online', 'badge'=>'META ADS', 'title'=>'광주 로컬 핫플레이스 인스타그램 릴스 스폰서 광고', 'tag'=>'메타 광고', 'date'=>'2026·07', 'thumb'=>'/images/bs_ad/baro_16.jpg')
    );

    if ($reqCat === 'all') {
        $list = $allFallback;
    } else {
        $list = array();
    foreach ($allFallback as $it) {
        if (isset($it['category']) && $it['category'] === $reqCat) {
            $list[] = $it;
        }
    }
    }
}

$totalCount = count($list);
?>
<body class="is-sub sub-body portfolio-body">
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/blank.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/skip.php"; ?>

<div id="wrap">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php"; ?>

  <main id="container" class="mbp-main-wrap">
    
    <!-- 1. SUBPAGE TOP HEADER & SEARCH PILL (masstige.biz 1:1) -->
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
          <span class="mbp-bc-current"><?php echo $categories[$reqCat]; ?></span>
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
            <button type="button" id="mbpSearchBtn" class="mbp-search-btn">
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
              $isActive = ($k === $reqCat) ? 'on' : '';
            ?>
            <li class="mbp-cat-item">
              <a href="?category=<?php echo $k; ?>" class="mbp-cat-link <?php echo $isActive; ?>" data-cat="<?php echo $k; ?>">
                <h2><?php echo $v; ?></h2>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>

        </div>

      </div>
    </section>

    <!-- 3. PORTFOLIO CARDS GRID (masstige.biz 3~4열 포트폴리오 리스트) -->
    <section class="mbp-grid-sec">
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
               data-name="<?php echo $titleText; ?>">
            
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

        <!-- PAGING AREA -->
        <div class="mbp-paging-area wow fadeInUp" data-wow-duration="0.6s">
          <ul class="mbp-pagination">
            <li><a href="?category=<?php echo $reqCat; ?>&page=1" class="mbp-page-arrow prev-first"><span>«</span></a></li>
            <li><a href="?category=<?php echo $reqCat; ?>&page=1" class="mbp-page-arrow prev"><span>‹</span></a></li>
            <li><a href="?category=<?php echo $reqCat; ?>&page=1" class="mbp-page-num active">1</a></li>
            <li><a href="?category=<?php echo $reqCat; ?>&page=2" class="mbp-page-num">2</a></li>
            <li><a href="?category=<?php echo $reqCat; ?>&page=3" class="mbp-page-num">3</a></li>
            <li><a href="?category=<?php echo $reqCat; ?>&page=2" class="mbp-page-arrow next"><span>›</span></a></li>
            <li><a href="?category=<?php echo $reqCat; ?>&page=3" class="mbp-page-arrow next-last"><span>»</span></a></li>
          </ul>
        </div>

      </div>
    </section>

  </main>

  <!-- LIGHTBOX MODAL -->
    <!-- PORTFOLIO LIGHTBOX MODAL (오른쪽 위 안쪽 닫기 버튼 탑재) -->
  <div class="portfolio-modal-backdrop" id="modalBackdrop">
    <div class="pm-modal-box">
      <button type="button" class="pm-close-btn" id="modalClose" aria-label="팝업 닫기">✕</button>
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
$(document).ready(function() {
  // Real-time client search filter
  $('#mbpSearchInput').on('keyup', function() {
    var kw = $(this).val().toLowerCase().trim();
    var visibleCount = 0;

    $('.mbp-card-item').each(function() {
      var name = ($(this).data('name') || '').toLowerCase();
      if (kw === '' || name.indexOf(kw) !== -1) {
        $(this).stop(true, true).fadeIn(200);
        visibleCount++;
      } else {
        $(this).stop(true, true).hide();
      }
    });

    $('#mbpTotalNum').text(visibleCount);
  });
});
</script>
</body>
</html>