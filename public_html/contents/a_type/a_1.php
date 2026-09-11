<?php
$page_title = "PORTFOLIO | GAON N";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";

$categories = array(
    'all'     => 'ALL',
    'bus'     => '시내버스 광고',
    'shelter' => '버스 승강장·쉘터',
    'did'     => 'DID·터미널 광고',
    'taxi'    => '택시·택배·특화매체',
    'video'   => '영상제작',
    'mart'    => '대형마트 카트'
);

function normalize_port_img($url) {
    if (empty($url)) return '/images/bs_ad/baro.jpg';
    return str_replace('/admin/bbs/portfolio/uploads/bus/', '/images/port/', $url);
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/admin/bbs/portfolio/portfolio_seed_data.php")) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/bbs/portfolio/portfolio_seed_data.php";
}

if ($conn) {
    @mysqli_query($conn, "ALTER TABLE `portfolio` MODIFY COLUMN `category` VARCHAR(50) NOT NULL DEFAULT 'bus'");
    @mysqli_query($conn, "UPDATE `portfolio` SET `thumb` = REPLACE(`thumb`, '/admin/bbs/portfolio/uploads/bus/', '/images/port/'), `images` = REPLACE(`images`, '/admin/bbs/portfolio/uploads/bus/', '/images/port/')");
    
    $shelterIds = "2,4,5,10,11,12,19,21,26,30,32,34,39,41,42,43,44";
    @mysqli_query($conn, "UPDATE `portfolio` SET `category` = 'shelter' WHERE id IN ($shelterIds) AND (category = '' OR category = 'bus' OR category IS NULL)");
    @mysqli_query($conn, "UPDATE `portfolio` SET `category` = 'did' WHERE id IN (16, 45)");

    // Auto-sync all items from portfolio_seed_data.php
    if (!empty($GAON_PORTFOLIO_ITEMS)) {
        foreach ($GAON_PORTFOLIO_ITEMS as $itm) {
            $nid = (int)$itm['id'];
            $sord = isset($itm['sort_order']) ? (int)$itm['sort_order'] : $nid;
            $cat  = mysqli_real_escape_string($conn, $itm['category']);
            $tit  = mysqli_real_escape_string($conn, $itm['title']);
            $cli  = mysqli_real_escape_string($conn, $itm['client']);
            $loc  = mysqli_real_escape_string($conn, $itm['location']);
            $sca  = mysqli_real_escape_string($conn, $itm['scale']);
            $des  = mysqli_real_escape_string($conn, $itm['description']);
            $thm  = mysqli_real_escape_string($conn, $itm['thumb']);
            $imgs = mysqli_real_escape_string($conn, json_encode($itm['images']));
            @mysqli_query($conn, "INSERT INTO `portfolio` (`id`, `category`, `title`, `client`, `location`, `scale`, `description`, `thumb`, `images`, `is_featured`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES ($nid, '$cat', '$tit', '$cli', '$loc', '$sca', '$des', '$thm', '$imgs', 1, $sord, 'active', NOW(), NOW()) ON DUPLICATE KEY UPDATE `sort_order`=VALUES(`sort_order`), `title`=VALUES(`title`), `client`=VALUES(`client`), `scale`=VALUES(`scale`), `description`=VALUES(`description`), `thumb`=VALUES(`thumb`), `images`=VALUES(`images`), `category`=VALUES(`category`)");
        }
    }


    // Check count and auto-seed if empty
    $chkCount = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `portfolio`");
    $chkRow = $chkCount ? mysqli_fetch_assoc($chkCount) : array('cnt' => 0);
    if ($chkRow['cnt'] == 0 && !empty($GAON_PORTFOLIO_ITEMS)) {
        foreach ($GAON_PORTFOLIO_ITEMS as $itm) {
            $sord = (int)$itm['id'];
            $cat  = mysqli_real_escape_string($conn, $itm['category']);
            $tit  = mysqli_real_escape_string($conn, $itm['title']);
            $cli  = mysqli_real_escape_string($conn, $itm['client']);
            $loc  = mysqli_real_escape_string($conn, $itm['location']);
            $sca  = mysqli_real_escape_string($conn, $itm['scale']);
            $des  = mysqli_real_escape_string($conn, $itm['description']);
            $thm  = mysqli_real_escape_string($conn, normalize_port_img($itm['thumb']));
            $imgs = mysqli_real_escape_string($conn, json_encode(array_map('normalize_port_img', $itm['images'])));
            mysqli_query($conn, "INSERT INTO `portfolio` (`id`, `category`, `title`, `client`, `location`, `scale`, `description`, `thumb`, `images`, `is_featured`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES ($sord, '$cat', '$tit', '$cli', '$loc', '$sca', '$des', '$thm', '$imgs', 1, $sord, 'active', NOW(), NOW())");
        }
    }

    $sql = "SELECT * FROM portfolio WHERE status='active' AND category != 'online' AND category != 'web' ORDER BY sort_order ASC, id DESC";
    $result = mysqli_query($conn, $sql);
    $list = array();
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $row['thumb'] = normalize_port_img($row['thumb']);
            $list[] = $row;
        }
    }
}

// Fallback to verified seed items if empty (excluding online/web)
if (empty($list) && !empty($GAON_PORTFOLIO_ITEMS)) {
    $filteredSeed = array();
    foreach ($GAON_PORTFOLIO_ITEMS as $si) {
        if ($si['category'] !== 'online' && $si['category'] !== 'web') {
            $filteredSeed[] = $si;
        }
    }
    $list = $filteredSeed;
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
            <p class="mbp-sub-desc">시내버스 광고, 버스 승강장 쉘터, 터미널·DID 매체 등 가온엔의 고화질 현장 집행 실적입니다.</p>
          </div>

          <!-- SEARCH PILL -->
          <div class="mbp-search-pill">
            <input type="text" id="mbpSearchInput" placeholder="광고주 또는 프로젝트명을 검색하세요" aria-label="포트폴리오 검색">
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
            
            // Badge & Tag
            $badgeText = !empty($item['badge']) ? htmlspecialchars($item['badge']) : 'GAON·AD';
            $tagText = !empty($item['tag']) ? htmlspecialchars($item['tag']) : (isset($categories[$cat]) ? $categories[$cat] : '옥외광고');
            if (empty($item['badge'])) {
                if ($cat === 'shelter') { $badgeText = 'SHELTER·AD'; $tagText = '버스 승강장·쉘터'; }
                else if ($cat === 'did') { $badgeText = 'TERMINAL·AD'; $tagText = '터미널·DID 광고'; }
                else if ($cat === 'taxi') { $badgeText = 'SPECIAL·AD'; $tagText = '택시·택배·특화매체'; }
                else if ($cat === 'bus') { $badgeText = 'BUS·AD'; $tagText = '시내버스 광고'; }
                else if ($cat === 'mart') { $badgeText = 'MART·CART'; $tagText = '대형마트 카트'; }
            }

            $imgSrc = normalize_port_img(!empty($item['thumb']) ? $item['thumb'] : '');
            $videoSrc = !empty($item['video']) ? htmlspecialchars($item['video']) : '';
            if (empty($videoSrc) && $cat === 'video') {
                $vIdxMap = array(54 => '01', 55 => '02', 56 => '03', 57 => '04', 58 => '05', 63 => '06');
                if (isset($vIdxMap[$item['id']])) {
                    $videoSrc = '/images/port/video/video_clip_' . $vIdxMap[$item['id']] . '.mp4';
                }
            }
            $dateText = !empty($item['date']) ? htmlspecialchars($item['date']) : '2026·09';
            $titleText = htmlspecialchars($item['title']);
            $clientText = !empty($item['client']) ? htmlspecialchars($item['client']) : '';
            $locationText = !empty($item['location']) ? htmlspecialchars($item['location']) : '광주 주요 거점 노선';
            $scaleText = !empty($item['scale']) ? htmlspecialchars($item['scale']) : '';

            // Handle images array
            $imagesArray = array($imgSrc);
            if (!empty($item['images'])) {
                if (is_array($item['images'])) {
                    $imagesArray = $item['images'];
                } else {
                    $decoded = json_decode($item['images'], true);
                    if (is_array($decoded) && count($decoded) > 0) {
                        $imagesArray = $decoded;
                    }
                }
            }
            $imagesArray = array_map('normalize_port_img', $imagesArray);
            $imagesJsonAttr = htmlspecialchars(json_encode($imagesArray), ENT_QUOTES, 'UTF-8');
            $hasMultiple = count($imagesArray) > 1;
          ?>
          <div class="mbp-card-item wow fadeInUp" data-wow-duration="0.7s"
               data-cat="<?php echo $cat; ?>"
               data-id="<?php echo (int)$item['id']; ?>"
               data-name="<?php echo $titleText; ?>"
               data-client="<?php echo $clientText; ?>"
               data-img="<?php echo $imgSrc; ?>"
               data-video="<?php echo $videoSrc; ?>"
               data-images='<?php echo $imagesJsonAttr; ?>'
               data-tag="<?php echo $tagText; ?>"
               data-loc="<?php echo $locationText; ?>"
               data-scale="<?php echo $scaleText; ?>"
               data-date="<?php echo $dateText; ?>">
            
            <!-- IMAGE BOX WITH HOVER ZOOM & BADGE -->
            <div class="mbp-img-box <?php echo $videoSrc ? 'is-video-box' : ''; ?>">
              <img src="<?php echo $imgSrc; ?>" alt="<?php echo $titleText; ?>" loading="lazy">
              <span class="mbp-badge"><?php echo $badgeText; ?></span>
              <?php if ($videoSrc): ?>
              <span class="mbp-video-play-tag"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg> 10초 영상 (스틸컷 캡쳐본)</span>
              <?php elseif ($hasMultiple): ?>
              <span class="mbp-multi-badge" title="다중 사진 등록">📷 <?php echo count($imagesArray); ?>장</span>
              <!-- Card Multi-photo Dots Switcher (카드 위에서 동그라미로 2장 이상 바로 전환) -->
              <div class="mbp-card-photo-dots" onclick="event.stopPropagation();">
                <?php foreach ($imagesArray as $dIdx => $dUrl): ?>
                <button type="button" class="mbp-card-dot-btn <?php echo $dIdx === 0 ? 'active' : ''; ?>" data-img-url="<?php echo htmlspecialchars($dUrl, ENT_QUOTES, 'UTF-8'); ?>" data-idx="<?php echo $dIdx; ?>" title="<?php echo ($dIdx + 1); ?>번 사진 보기" aria-label="<?php echo ($dIdx + 1); ?>번 사진 보기"></button>
                <?php endforeach; ?>
              </div>
              <?php endif; ?>
              <div class="mbp-img-overlay">
                <span class="mbp-view-btn"><?php echo $videoSrc ? '▶ 10초 영상 재생 (캡쳐본)' : 'View Detail ➔'; ?></span>
              </div>
            </div>

            <!-- TEXT BOX -->
            <div class="mbp-text-box">
              <div class="mbp-card-meta">
                <span class="mbp-card-tag"><?php echo $tagText; ?></span>
                <?php if ($scaleText): ?>
                <span class="mbp-card-scale"><?php echo $scaleText; ?></span>
                <?php endif; ?>
              </div>
              <h3 class="mbp-card-title"><?php echo $titleText; ?></h3>
              <?php if ($clientText || $locationText): ?>
              <p class="mbp-card-client"><?php echo $clientText ? $clientText . ' · ' : ''; ?><?php echo $locationText; ?></p>
              <?php endif; ?>
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
        <!-- Multi-photo Sleek Dots Selector (사진을 가리지 않는 하단 미니 도트 인디케이터) -->
        <div class="pm-photo-dots" id="modalPhotoDots" style="display:none;"></div>
      </div>
      <div class="pm-info-wrap">
        <div class="pm-meta-row">
          <span class="pm-cat-badge" id="modalCat">광고사례</span>
          <span class="pm-counter-badge" id="modalCounter">1 / 47</span>
        </div>
        <h3 class="pm-title" id="modalTitle">프로젝트명</h3>
        <p class="pm-loc" id="modalLoc">광주 주요 상권 직영 시공 사례</p>
        <p class="pm-sub-notice" id="modalSubNotice" style="display:none; font-size:12px; color:#38bdf8; margin-top:6px; font-weight:600;">🎬 10초 하이라이트 영상 (대표 화면 스틸컷 캡쳐본)</p>
        <div class="pm-action-row">
          <a href="/board/estmate/write.php" class="pm-cta-btn" id="modalCtaBtn">이 매체 집행 견적 문의 ➔</a>
        </div>
      </div>
    </div>
  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/bottom_conversion.php"; ?>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php"; ?>
</div>

<style>
.mbp-video-play-tag {
  position: absolute;
  top: 14px;
  right: 14px;
  background: rgba(220, 38, 38, 0.9);
  backdrop-filter: blur(6px);
  color: #ffffff;
  font-size: 11px;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 999px;
  border: 1px solid rgba(255, 255, 255, 0.3);
  z-index: 2;
  letter-spacing: 0.5px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
}
.mbp-img-box.is-video-box .mbp-view-btn {
  background: #dc2626;
  border-color: #ef4444;
  color: #ffffff;
}
.mbp-multi-badge {
  position: absolute;
  top: 14px;
  right: 14px;
  background: rgba(10, 25, 47, 0.85);
  backdrop-filter: blur(6px);
  color: #60a5fa;
  font-size: 11px;
  font-weight: 700;
  padding: 4px 9px;
  border-radius: 999px;
  border: 1px solid rgba(96, 165, 250, 0.3);
  z-index: 2;
  letter-spacing: 0.3px;
}
.mbp-card-scale {
  font-size: 12px;
  color: #0284c7;
  font-weight: 600;
  margin-left: 8px;
}
.mbp-card-client {
  font-size: 13px;
  color: #64748b;
  margin-top: 6px;
  line-height: 1.4;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.pm-img-wrap {
  position: relative;
  width: 100%;
  background: #0b1120;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 380px;
}
.pm-img-wrap img {
  width: 100%;
  height: auto;
  max-height: 70vh;
  object-fit: contain;
  display: block;
  transition: opacity 0.25s ease;
}
.pm-img-wrap img.is-fading {
  opacity: 0.3;
}
/* 사진을 가리지 않는 슬림한 플로팅 동그라미 도트 (모달) */
.pm-photo-dots {
  position: absolute;
  bottom: 14px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(15, 23, 42, 0.7);
  padding: 6px 14px;
  border-radius: 9999px;
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255, 255, 255, 0.18);
  z-index: 10;
  box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}
.pm-dot-btn {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.45);
  border: none;
  padding: 0;
  cursor: pointer;
  outline: none;
  transition: all 0.22s cubic-bezier(0.22, 1, 0.36, 1);
}
.pm-dot-btn:hover {
  background: rgba(255, 255, 255, 0.9);
  transform: scale(1.25);
}
.pm-dot-btn.active {
  width: 22px;
  border-radius: 999px;
  background: #2563eb;
  box-shadow: 0 0 8px rgba(37, 99, 235, 0.8);
}

/* 카드 위 다중 사진 동그라미(도트) 인디케이터 */
.mbp-card-photo-dots {
  position: absolute;
  bottom: 12px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  align-items: center;
  gap: 7px;
  background: rgba(15, 23, 42, 0.78);
  padding: 5px 12px;
  border-radius: 9999px;
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255, 255, 255, 0.25);
  z-index: 10;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  transition: all 0.25s ease;
}
.mbp-card-dot-btn {
  width: 9px;
  height: 9px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.45);
  border: none;
  padding: 0;
  cursor: pointer;
  outline: none;
  transition: all 0.22s cubic-bezier(0.22, 1, 0.36, 1);
}
.mbp-card-dot-btn:hover {
  background: rgba(255, 255, 255, 0.95);
  transform: scale(1.3);
}
.mbp-card-dot-btn.active {
  width: 22px;
  border-radius: 999px;
  background: #2563eb;
  box-shadow: 0 0 10px rgba(37, 99, 235, 0.9);
}
.mbp-img-box img {
  transition: opacity 0.2s ease, transform 0.45s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.mbp-img-box img.is-switching {
  opacity: 0.35;
}
</style>

<script>
$(document).ready(function() {
  var PAGE_SIZE = 9;
  var currentPage = 1;
  var currentModalIndex = 0;
  var currentPhotoIndex = 0;
  var currentModalImages = [];
  var matchedCards = [];

  function getMatchedCards() {
    var activeCat = $('.mbp-cat-link.on').data('cat') || 'all';
    var kw = ($('#mbpSearchInput').val() || '').toLowerCase().trim();
    
    return $('.mbp-card-item').filter(function() {
      var itemCat = $(this).data('cat');
      var itemName = ($(this).data('name') || '').toLowerCase();
      var itemClient = ($(this).data('client') || '').toLowerCase();
      var itemLoc = ($(this).data('loc') || '').toLowerCase();
      
      var matchCat = (activeCat === 'all' || itemCat === activeCat);
      var matchKw = (kw === '' || itemName.indexOf(kw) !== -1 || itemClient.indexOf(kw) !== -1 || itemLoc.indexOf(kw) !== -1);
      return matchCat && matchKw;
    });
  }

  function renderPortfolio() {
    var $matched = getMatchedCards();
    matchedCards = $matched.toArray();
    var totalItems = matchedCards.length;
    var totalPages = Math.ceil(totalItems / PAGE_SIZE) || 1;
    if (currentPage > totalPages) currentPage = 1;

    $('.mbp-card-item').hide();

    var startIndex = (currentPage - 1) * PAGE_SIZE;
    var endIndex = startIndex + PAGE_SIZE;
    $matched.slice(startIndex, endIndex).stop(true, true).fadeIn(200);

    $('#mbpTotalNum').text(totalItems);

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
  $('#mbpSearchInput').on('keyup input', function() {
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

  function switchPhoto(pIdx) {
    if (!currentModalImages || currentModalImages.length === 0) return;
    if (pIdx < 0) pIdx = currentModalImages.length - 1;
    if (pIdx >= currentModalImages.length) pIdx = 0;
    currentPhotoIndex = pIdx;

    var targetUrl = currentModalImages[pIdx];
    var $img = $('#modalImg');
    var $vEl = $('#modalVideo');
    if ($vEl.length && $vEl[0]) {
      $vEl[0].pause();
      $vEl.hide().attr('src', '');
    }
    $img.show().addClass('is-fading');
    setTimeout(function() {
      $img.attr('src', targetUrl);
      $img.removeClass('is-fading');
    }, 120);

    $('.pm-dot-btn').removeClass('active');
    $('.pm-dot-btn[data-idx="' + pIdx + '"]').addClass('active');
  }

  function openModal(idx) {
    if (idx < 0) idx = matchedCards.length - 1;
    if (idx >= matchedCards.length) idx = 0;
    currentModalIndex = idx;

    var $card = $(matchedCards[idx]);
    var savedPhotoIdx = parseInt($card.data('selected-photo-idx'), 10) || 0;
    currentPhotoIndex = savedPhotoIdx;

    var title = $card.data('name');
    var tag = $card.data('tag');
    var date = $card.data('date');
    var loc = $card.data('loc') || '';
    var scale = $card.data('scale') || '';
    var client = $card.data('client') || '';
    var videoUrl = $card.data('video') || '';
    var rawImages = $card.data('images');

    if (typeof rawImages === 'string') {
      try { rawImages = JSON.parse(rawImages); } catch(e) { rawImages = [$card.data('img')]; }
    }
    if (!Array.isArray(rawImages) || rawImages.length === 0) {
      rawImages = [$card.data('img')];
    }

    currentModalImages = rawImages.map(function(u) {
      if (!u) return '/images/bs_ad/baro.jpg';
      return u.replace('/admin/bbs/portfolio/uploads/bus/', '/images/port/');
    });

    if (currentPhotoIndex >= currentModalImages.length) currentPhotoIndex = 0;

    $('#modalTitle').text(title);
    $('#modalCat').text(tag + (scale ? ' · ' + scale : ''));
    $('#modalLoc').text((client ? '광고주: ' + client + ' | ' : '') + '집행처: ' + loc);
    $('#modalCounter').text((idx + 1) + ' / ' + matchedCards.length);

    var $vEl = $('#modalVideo');
    var $imgEl = $('#modalImg');

    if (videoUrl) {
      $imgEl.hide();
      $vEl.attr('src', videoUrl).show();
      if ($vEl[0]) {
        $vEl[0].muted = true;
        $vEl[0].currentTime = 0;
        var playPromise = $vEl[0].play();
        if (playPromise !== undefined) {
          playPromise.catch(function(e) { /* Autoplay was prevented */ });
        }
      }
      $('#modalSubNotice').show();
      $('#modalCtaBtn').text('이 영상 제작 견적 문의 ➔');
      $('#modalPhotoDots').hide().empty();
    } else {
      $('#modalSubNotice').hide();
      if ($vEl.length && $vEl[0]) {
        $vEl[0].pause();
        $vEl.attr('src', '').hide();
      }
      $imgEl.show().attr('src', currentModalImages[currentPhotoIndex]);
      $('#modalCtaBtn').text('이 매체 집행 견적 문의 ➔');

      // Render Sleek Dots if multiple photos
      var $dotsWrap = $('#modalPhotoDots');
      if (currentModalImages.length > 1) {
        var dotsHtml = '';
        currentModalImages.forEach(function(imgUrl, pIdx) {
          dotsHtml += '<button type="button" class="pm-dot-btn ' + (pIdx === currentPhotoIndex ? 'active' : '') + '" data-idx="' + pIdx + '" title="사진 ' + (pIdx + 1) + '"></button>';
        });
        $dotsWrap.html(dotsHtml).show();
      } else {
        $dotsWrap.hide().empty();
      }
    }

    $('#modalBackdrop').addClass('open');
  }

  // Card Dot Click Event (카드 목록 위에서 동그라미 클릭 시 사진 즉시 전환)
  $(document).on('click', '.mbp-card-dot-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();

    var $dot = $(this);
    var targetImgUrl = $dot.data('img-url');
    var pIdx = parseInt($dot.data('idx'), 10) || 0;
    var $card = $dot.closest('.mbp-card-item');
    var $img = $card.find('.mbp-img-box img');

    $card.find('.mbp-card-dot-btn').removeClass('active');
    $dot.addClass('active');

    $img.addClass('is-switching');
    setTimeout(function() {
      $img.attr('src', targetImgUrl);
      $img.removeClass('is-switching');
    }, 100);

    $card.data('selected-photo-idx', pIdx);
  });

  function closeModal() {
    var $vEl = $('#modalVideo');
    if ($vEl.length && $vEl[0]) {
      $vEl[0].pause();
      $vEl.attr('src', '').hide();
    }
    $('#modalBackdrop').removeClass('open');
  }

  // Click on Dot Button
  $(document).on('click', '.pm-dot-btn', function(e) {
    e.stopPropagation();
    var pIdx = parseInt($(this).data('idx'), 10);
    switchPhoto(pIdx);
  });

  // Lightbox Modal Click Event
  $(document).on('click', '.mbp-card-item', function() {
    var idx = matchedCards.indexOf(this);
    if (idx !== -1) {
      openModal(idx);
    }
  });

  // Prev / Next Arrows
  $('#modalPrevBtn').on('click', function(e) {
    e.stopPropagation();
    if (currentModalImages.length > 1 && currentPhotoIndex > 0) {
      switchPhoto(currentPhotoIndex - 1);
    } else {
      openModal(currentModalIndex - 1);
    }
  });

  $('#modalNextBtn').on('click', function(e) {
    e.stopPropagation();
    if (currentModalImages.length > 1 && currentPhotoIndex < currentModalImages.length - 1) {
      switchPhoto(currentPhotoIndex + 1);
    } else {
      openModal(currentModalIndex + 1);
    }
  });

  // Modal Close
  $(document).on('click', '#modalClose, .portfolio-modal-backdrop', function(e) {
    if (e.target === this || $(this).attr('id') === 'modalClose') {
      closeModal();
    }
  });

  $(document).on('keydown', function(e) {
    if (!$('#modalBackdrop').hasClass('open')) return;
    if (e.key === 'Escape') closeModal();
    if (e.key === 'ArrowLeft') {
      if (currentModalImages.length > 1 && currentPhotoIndex > 0) {
        switchPhoto(currentPhotoIndex - 1);
      } else {
        openModal(currentModalIndex - 1);
      }
    }
    if (e.key === 'ArrowRight') {
      if (currentModalImages.length > 1 && currentPhotoIndex < currentModalImages.length - 1) {
        switchPhoto(currentPhotoIndex + 1);
      } else {
        openModal(currentModalIndex + 1);
      }
    }
  });

  // Initial Run
  renderPortfolio();
});
</script>
</body>
</html>
