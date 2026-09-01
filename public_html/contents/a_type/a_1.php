<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";

$categories = array(
    'bus'    => '버스 광고',
    'taxi'   => '택시 광고',
    'did'    => 'DID 광고',
    'print'  => '인쇄물·현수막',
    'online' => '온라인 마케팅',
    'web'    => '홈페이지제작',
    'video'  => '영상 광고',
    'mart'   => '마트 광고',
);

$result = mysqli_query($conn, "SELECT * FROM portfolio WHERE status='active' ORDER BY sort_order ASC, id DESC");
$list   = array();
while ($row = mysqli_fetch_assoc($result)) {
    $list[] = $row;
}
$total = count($list);
$recent = array_slice($list, 0, 5);
?>
<body class="is-main">
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/blank.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/skip.php"; ?>

<div id="wrap">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php"; ?>

  <div id="container">
    <div class="inner">
      <section class="content port-page">

        <!-- 페이지 헤더 -->
        <div class="port-page-head">
          <h1 class="port-page-title wow fadeInUp" data-wow-duration="0.6s">집행 <span>사례</span></h1>
          <div class="port-page-eyebrow wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.1s">Reference</div>

        </div>

        <!-- 히어로 슬라이더 -->
        <div class="port-hero-swiper-wrap">
          <div class="swiper port-hero-swiper wow fadeInDown" data-wow-duration="0.6s" data-wow-delay="0.3s">
            <div class="swiper-wrapper">
              <?php foreach ($recent as $item): ?>
              <div class="swiper-slide port-hero-slide port-card"
                   data-id="<?php echo (int)$item['id']; ?>"
                   data-name="<?php echo htmlspecialchars($item['title']); ?>">
                <div class="port-hero-slide-thumb">
                  <?php if ($item['thumb']): ?>
                  <img src="<?php echo htmlspecialchars($item['thumb']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                  <?php else: ?>
                  <span>이미지 준비 중</span>
                  <?php endif; ?>
                  <div class="port-hero-slide-overlay"></div>
                </div>
                <div class="port-hero-slide-info">
                  <div class="port-hero-slide-cat"><?php echo isset($categories[$item['category']]) ? $categories[$item['category']] : ''; ?></div>
                  <div class="port-hero-slide-name"><?php echo htmlspecialchars($item['title']); ?></div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>

          </div>
            <div class="swiper-button-prev port-hero-prev"></div>
            <div class="swiper-button-next port-hero-next"></div>
            <div class="swiper-pagination port-hero-pagination"></div>
        </div>

        <!-- 필터 + 검색 -->
        <div class="port-filter-bar">
          <div class="port-filter-left">
            <div class="port-dropdown" id="portDropdown">
              <div class="port-dropdown-trigger">
                <span id="portDropdownLabel">전체</span>
                <span class="port-dropdown-arrow">▾</span>
              </div>
              <ul class="port-dropdown-list">
                <li data-val="all">전체</li>
                <?php foreach ($categories as $k => $v): ?>
                <li data-val="<?php echo $k; ?>"><?php echo $v; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <div class="port-filter-right">
            <div class="port-search-box">
              <input type="text" id="portSearchInput" placeholder="검색어를 입력하세요">
              <button id="portSearchBtn">→</button>
            </div>
          </div>
        </div>

        <!-- 카드 그리드 -->
        <div class="port-grid" id="portGrid">
          <?php foreach ($list as $item): ?>
          <div class="port-card wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.1s"
               data-cat="<?php echo htmlspecialchars($item['category']); ?>"
               data-id="<?php echo (int)$item['id']; ?>"
               data-name="<?php echo htmlspecialchars($item['title']); ?>">
            <div class="port-card-thumb">
              <?php if ($item['thumb']): ?>
              <img src="<?php echo htmlspecialchars($item['thumb']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
              <?php else: ?>
              <span>이미지 준비 중</span>
              <?php endif; ?>
            </div>
            <div class="port-card-info">
              <div class="port-card-cat"><?php echo isset($categories[$item['category']]) ? $categories[$item['category']] : ''; ?></div>
              <div class="port-card-name"><?php echo htmlspecialchars($item['title']); ?></div>

            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- 페이징 -->
        <div class="port-paging" id="portPaging"></div>

      </section>
    </div>
  </div>

  <!-- 모달 -->
  <div class="modal-backdrop" id="modalBackdrop">
    <div class="modal-box" id="modalBox">
      <div class="modal-img-side" id="modalImgSide">
        <span class="modal-img-placeholder" id="modalImgPlaceholder">이미지</span>
        <button class="modal-arr prev" id="modalPrev">←</button>
        <button class="modal-arr next" id="modalNext">→</button>
      </div>
      <div class="modal-info-side" id="modalInfoSide">
        <div>
          <div class="modal-cat" id="modalCat"></div>
          <div class="modal-title" id="modalTitle"></div>
          <div class="modal-loc" id="modalLoc"></div>
          <div class="modal-hr"></div>
          <div class="modal-meta">
            <div class="modal-meta-row"><span class="modal-meta-label">광고 유형</span><span class="modal-meta-val" id="modalType"></span></div>
            <div class="modal-meta-row"><span class="modal-meta-label">집행 기간</span><span class="modal-meta-val" id="modalPeriod"></span></div>
            <div class="modal-meta-row"><span class="modal-meta-label">규모</span><span class="modal-meta-val" id="modalQty"></span></div>
          </div>
          <div class="modal-tags" id="modalTags"></div>
        </div>
        <button class="modal-btn" onclick="location.href='/contact'">이 광고 문의하기 →</button>
      </div>
      <button class="modal-close" id="modalClose">✕</button>
    </div>
  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php"; ?>
</div>
</body>
</html>