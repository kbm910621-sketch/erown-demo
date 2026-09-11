<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";

// 포트폴리오 테이블 자동 생성 및 안전성 보장
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS `portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL DEFAULT 'bus',
  `title` varchar(255) NOT NULL,
  `client` varchar(100) DEFAULT '',
  `location` varchar(100) DEFAULT '',
  `period_start` date DEFAULT NULL,
  `period_end` date DEFAULT NULL,
  `scale` varchar(100) DEFAULT '',
  `description` text,
  `thumb` varchar(255) DEFAULT '',
  `images` text,
  `is_featured` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");

function normalize_port_img($url) {
    if (empty($url)) return '/images/bs_ad/baro.jpg';
    return str_replace('/admin/bbs/portfolio/uploads/bus/', '/images/port/', $url);
}

$categories = array(
    'bus'     => '시내버스 광고',
    'shelter' => '버스 승강장·쉘터',
    'did'     => 'DID·터미널 광고',
    'taxi'    => '택시·택배·특화매체',
    'online'  => '온라인 마케팅',
    'video'   => '영상제작',
    'mart'    => '대형마트 카트',
    'print'   => '인쇄물·현수막',
    'web'     => '홈페이지제작'
);

// 포트폴리오 데이터 자동 동기화 (시드 데이터 파일과 DB 자동 일치화)
if ($conn) {
    @mysqli_query($conn, "ALTER TABLE `portfolio` MODIFY COLUMN `category` VARCHAR(50) NOT NULL DEFAULT 'bus'");
    @mysqli_query($conn, "UPDATE `portfolio` SET `category` = 'shelter' WHERE id IN (2,4,5,10,11,12,19,21,26,30,32,34,39,41,42,43,44) AND (category = '' OR category = 'bus' OR category IS NULL)");
    @mysqli_query($conn, "UPDATE `portfolio` SET `category` = 'did' WHERE id IN (16,45)");

    if (file_exists(__DIR__ . '/portfolio_seed_data.php')) {
        include_once __DIR__ . '/portfolio_seed_data.php';
        if (!empty($GAON_PORTFOLIO_ITEMS)) {
            if (isset($_GET['resync'])) {
                @mysqli_query($conn, "TRUNCATE TABLE `portfolio`");
            }
            foreach ($GAON_PORTFOLIO_ITEMS as $itm) {
                $nid = (int)$itm['id'];
                $sord = $nid;
                $cat  = mysqli_real_escape_string($conn, $itm['category']);
                $tit  = mysqli_real_escape_string($conn, $itm['title']);
                $cli  = mysqli_real_escape_string($conn, $itm['client']);
                $loc  = mysqli_real_escape_string($conn, $itm['location']);
                $sca  = mysqli_real_escape_string($conn, $itm['scale']);
                $des  = mysqli_real_escape_string($conn, $itm['description']);
                $thm  = mysqli_real_escape_string($conn, $itm['thumb']);
                $imgs = mysqli_real_escape_string($conn, json_encode($itm['images']));
                @mysqli_query($conn, "INSERT INTO `portfolio` (`id`, `category`, `title`, `client`, `location`, `scale`, `description`, `thumb`, `images`, `is_featured`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES ($nid, '$cat', '$tit', '$cli', '$loc', '$sca', '$des', '$thm', '$imgs', 1, $sord, 'active', NOW(), NOW()) ON DUPLICATE KEY UPDATE `title`=VALUES(`title`), `client`=VALUES(`client`), `scale`=VALUES(`scale`), `description`=VALUES(`description`), `thumb`=VALUES(`thumb`), `images`=VALUES(`images`), `category`=VALUES(`category`)");
            }
        }
    }

    @mysqli_query($conn, "UPDATE `portfolio` SET `thumb` = REPLACE(`thumb`, '/admin/bbs/portfolio/uploads/bus/', '/images/port/'), `images` = REPLACE(`images`, '/admin/bbs/portfolio/uploads/bus/', '/images/port/')");
    @mysqli_query($conn, "UPDATE `title` SET `tit_ch2` = 'PORTFOLIO | GAON N' WHERE `tit_ch2` = '----' OR `tit_ch2` = '' OR `tit_ch2` IS NULL");
}

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'list';
$msg  = isset($_GET['msg'])  ? $_GET['msg']  : '';
$edit = null;

// ── 수정 데이터 로드 ──
if ($mode === 'modify' && !empty($_GET['id'])) {
    $eid  = (int)$_GET['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM portfolio WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $eid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_col, $category_col, $title_col, $client_col, $location_col, $period_start_col, $period_end_col, $scale_col, $description_col, $thumb_col, $images_col, $is_featured_col, $sort_order_col, $status_col, $created_at_col, $updated_at_col);
    mysqli_stmt_fetch($stmt);
    $edit = array(
        'id'=>$id_col, 'category'=>$category_col, 'title'=>$title_col,
        'client'=>$client_col, 'location'=>$location_col,
        'period_start'=>$period_start_col, 'period_end'=>$period_end_col,
        'scale'=>$scale_col, 'description'=>$description_col,
        'thumb'=>$thumb_col, 'images'=>$images_col,
        'is_featured'=>$is_featured_col, 'sort_order'=>$sort_order_col,
        'status'=>$status_col, 'created_at'=>$created_at_col, 'updated_at'=>$updated_at_col
    );
    mysqli_stmt_close($stmt);
}

// ── 삭제 ──
if (!empty($_GET['del'])) {
    $did    = (int)$_GET['del'];
    $result = mysqli_query($conn, "SELECT thumb, images FROM portfolio WHERE id = $did LIMIT 1");
    $drow   = mysqli_fetch_assoc($result);
    if ($drow) {
        if ($drow['thumb'] && file_exists($_SERVER['DOCUMENT_ROOT'] . $drow['thumb'])) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $drow['thumb']);
        }
        if ($drow['images']) {
            $imgs = json_decode($drow['images'], true);
            if (is_array($imgs)) {
                foreach ($imgs as $img) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $img)) unlink($_SERVER['DOCUMENT_ROOT'] . $img);
                }
            }
        }
        mysqli_query($conn, "DELETE FROM portfolio WHERE id = $did");
    }
    header('Location: admin_portfolio.php?msg=del');
    exit;
}



// ── 저장 (등록/수정) ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id           = (int)(isset($_POST['id'])           ? $_POST['id']           : 0);
    $category     = isset($_POST['category'])           ? $_POST['category']     : '';
    $title        = isset($_POST['title'])              ? trim($_POST['title'])   : '';
    $client       = isset($_POST['client'])             ? trim($_POST['client'])  : '';
    $location     = isset($_POST['location'])           ? trim($_POST['location']): '';
    $period_start = isset($_POST['period_start'])       ? $_POST['period_start'] : '';
    $period_end   = isset($_POST['period_end'])         ? $_POST['period_end']   : '';
    $scale        = isset($_POST['scale'])              ? trim($_POST['scale'])  : '';
    $description  = isset($_POST['description'])        ? trim($_POST['description']) : '';
    $is_featured  = isset($_POST['is_featured'])        ? 1 : 0;
    $sort_order   = (int)(isset($_POST['sort_order'])   ? $_POST['sort_order']   : 0);
    $status       = isset($_POST['status'])             ? $_POST['status']       : 'active';
    $period_start = $period_start ? $period_start : null;
    $period_end   = $period_end   ? $period_end   : null;

    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/admin/bbs/portfolio/uploads/' . $category . '/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    $upload_url = '/admin/bbs/portfolio/uploads/' . $category . '/';

    // 대표 이미지
    $thumb = isset($_POST['thumb_old']) ? $_POST['thumb_old'] : '';
    if (!empty($_FILES['thumb']['name'])) {
        $ext   = strtolower(pathinfo($_FILES['thumb']['name'], PATHINFO_EXTENSION));
        $fname = uniqid('thumb_') . '.' . $ext;
        if (move_uploaded_file($_FILES['thumb']['tmp_name'], $upload_dir . $fname)) {
            if ($thumb && file_exists($_SERVER['DOCUMENT_ROOT'] . $thumb)) unlink($_SERVER['DOCUMENT_ROOT'] . $thumb);
            $thumb = $upload_url . $fname;
        }
    }
    

    // 추가 이미지
    $images = array();
    if (!empty($_POST['images_old'])) {
        $decoded = json_decode($_POST['images_old'], true);
        if (is_array($decoded)) $images = $decoded;
    }
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['name'] as $i => $fname_orig) {
            if (empty($fname_orig)) continue;
            $ext   = strtolower(pathinfo($fname_orig, PATHINFO_EXTENSION));
            $fname = uniqid('img_') . '.' . $ext;
            if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $upload_dir . $fname)) {
                $images[] = $upload_url . $fname;
            }
        }
    }
    if (!empty($_POST['del_images'])) {
        foreach ($_POST['del_images'] as $di) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $di)) unlink($_SERVER['DOCUMENT_ROOT'] . $di);
            $new_images = array();
            foreach ($images as $v) { if ($v !== $di) $new_images[] = $v; }
            $images = $new_images;
        }
    }
    $images_json = json_encode($images);

    if ($id) {
        $stmt = mysqli_prepare($conn, "UPDATE portfolio SET category=?,title=?,client=?,location=?,period_start=?,period_end=?,scale=?,description=?,thumb=?,images=?,is_featured=?,sort_order=?,status=?,updated_at=NOW() WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssssssssssiisi',
            $category,$title,$client,$location,$period_start,$period_end,
            $scale,$description,$thumb,$images_json,$is_featured,$sort_order,$status,$id
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: admin_portfolio.php?cat=' . urlencode($category) . '&msg=modify');
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO portfolio (category,title,client,location,period_start,period_end,scale,description,thumb,images,is_featured,sort_order,status,created_at,updated_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())");
        mysqli_stmt_bind_param($stmt, 'ssssssssssiis',
            $category,$title,$client,$location,$period_start,$period_end,
            $scale,$description,$thumb,$images_json,$is_featured,$sort_order,$status
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: admin_portfolio.php?cat=' . urlencode($category) . '&msg=write');
    }
    exit;
    
}



// ── 목록 조회 & 검색 & 페이징 (가로 4열 x 세로 5행 = 페이지당 20개) ──
$filter_cat = isset($_GET['cat']) ? trim($_GET['cat']) : '';
$frSearch   = isset($_GET['frSearch']) ? trim($_GET['frSearch']) : '';
$page       = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$page_size  = 20; // 5줄 (4개씩 x 5줄 = 20개)

// 카테고리별 건수 집계
$cat_counts = array('all' => 0);
$cnt_all_res = mysqli_query($conn, "SELECT category, COUNT(*) as cnt FROM portfolio GROUP BY category");
if ($cnt_all_res) {
    while ($cr = mysqli_fetch_assoc($cnt_all_res)) {
        $cat_counts[$cr['category']] = (int)$cr['cnt'];
        $cat_counts['all'] += (int)$cr['cnt'];
    }
}

$where_arr = array();
if ($filter_cat !== '') {
    $fc = mysqli_real_escape_string($conn, $filter_cat);
    $where_arr[] = "category = '$fc'";
}
if ($frSearch !== '') {
    $fs = mysqli_real_escape_string($conn, $frSearch);
    $where_arr[] = "(title LIKE '%$fs%' OR client LIKE '%$fs%' OR location LIKE '%$fs%')";
}

$where_sql = !empty($where_arr) ? "WHERE " . implode(' AND ', $where_arr) : "";

$cnt_res = mysqli_query($conn, "SELECT COUNT(*) FROM portfolio $where_sql");
$cnt_row = mysqli_fetch_array($cnt_res);
$totals  = $cnt_row ? (int)$cnt_row[0] : 0;

$total_pages = max(1, (int)ceil($totals / $page_size));
if ($page > $total_pages) $page = $total_pages;
$offset = ($page - 1) * $page_size;

$sql    = "SELECT * FROM portfolio $where_sql ORDER BY sort_order ASC, id DESC LIMIT $offset, $page_size";
$result = mysqli_query($conn, $sql);
$list   = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) { $list[] = $row; }
}
?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php"; ?>
<body class="bg_body">
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php"; ?>

<div id="wrap">
  <div id="container">
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/title.php"; ?>

    <section class="content">

    <?php if ($msg === 'write'): ?>
    <script>alert('등록되었습니다.');</script>
    <?php elseif ($msg === 'modify'): ?>
    <script>alert('수정되었습니다.');</script>
    <?php elseif ($msg === 'del'): ?>
    <script>alert('삭제되었습니다.');</script>
    <?php endif; ?>

      <?php if ($mode === 'write' || $mode === 'modify'): ?>
      <!-- ════════════════ 등록/수정 폼 ════════════════ -->
      <form name="frm" method="post" enctype="multipart/form-data">
        <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">
        <input type="hidden" name="thumb_old" value="<?php echo htmlspecialchars($edit['thumb']); ?>">
        <input type="hidden" name="images_old" value="<?php echo htmlspecialchars($edit['images']); ?>">
        <?php endif; ?>

        <div class="board_A0_W">
          <table summary="포트폴리오 <?php echo $edit ? '수정' : '등록'; ?>">
            <caption>포트폴리오 <?php echo $edit ? '수정' : '등록'; ?></caption>
            <colgroup>
              <col width="150px">
              <col width="*">
            </colgroup>
            <tbody>

              <tr>
                <th scope="row">광고 유형 <span class="req">*</span></th>
                <td>
                  <select name="category" id="category" class="input_type01 w_200">
                    <option value="">선택하세요</option>
                    <?php foreach ($categories as $k => $v): ?>
                    <option value="<?php echo $k; ?>" <?php echo (isset($edit['category']) && $edit['category'] === $k) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                    <?php endforeach; ?>
                  </select>
                </td>
              </tr>

              <tr>
                <th scope="row">광고명 <span class="req">*</span></th>
                <td><input type="text" name="title" id="title" class="input_type01 w_100p" value="<?php echo htmlspecialchars(isset($edit['title']) ? $edit['title'] : ''); ?>" placeholder="예) ○○병원 버스 전면 랩핑"></td>
              </tr>

              <tr>
                <th scope="row">광고주</th>
                <td><input type="text" name="client" id="client" class="input_type01 w_300" value="<?php echo htmlspecialchars(isset($edit['client']) ? $edit['client'] : ''); ?>" placeholder="예) ○○병원"></td>
              </tr>

              <tr>
                <th scope="row">지역</th>
                <td><input type="text" name="location" id="location" class="input_type01 w_300" value="<?php echo htmlspecialchars(isset($edit['location']) ? $edit['location'] : ''); ?>" placeholder="예) 광주광역시 북구"></td>
              </tr>

              <tr>
                <th scope="row">집행 기간</th>
                <td>
                  <div class="date_pick">
                    <input type="text" class="date_cell input_type01 w_100" name="period_start" id="period_start" value="<?php echo isset($edit['period_start']) ? $edit['period_start'] : ''; ?>" maxlength="10">
                    <label class="icon_date" for="period_start">시작일</label>
                  </div>
                  <span class="date_space">~</span>
                  <div class="date_pick">
                    <input type="text" class="date_cell input_type01 w_100" name="period_end" id="period_end" value="<?php echo isset($edit['period_end']) ? $edit['period_end'] : ''; ?>" maxlength="10">
                    <label class="icon_date" for="period_end">종료일</label>
                  </div>
                </td>
              </tr>

              <tr>
                <th scope="row">규모</th>
                <td><input type="text" name="scale" id="scale" class="input_type01 w_100p" value="<?php echo htmlspecialchars(isset($edit['scale']) ? $edit['scale'] : ''); ?>" placeholder="예) 버스 20대 · 3개월 운행"></td>
              </tr>

              <tr>
                <th scope="row">상세 설명</th>
                <td><textarea name="description" id="description" class="input_type01 w_100p" rows="4" style="height:100px;resize:vertical"><?php echo htmlspecialchars(isset($edit['description']) ? $edit['description'] : ''); ?></textarea></td>
              </tr>

              <tr>
                <th scope="row">대표 이미지</th>
                <td>
                  <?php if (!empty($edit['thumb'])): ?>
                  <div style="margin-bottom:8px">
                    <img src="<?php echo htmlspecialchars(normalize_port_img($edit['thumb'])); ?>" style="max-width:200px;max-height:120px;border:1px solid #ddd;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                  </div>
                  <?php endif; ?>
                  <ul class="file_Box">
                    <li><input type="file" class="file_type01" name="thumb" id="thumb" accept="image/*" title="대표 이미지 선택"></li>
                  </ul>
                </td>
              </tr>

              <tr>
                <th scope="row">추가 이미지<br><span style="font-weight:400;font-size:11px;color:#999">(최대 10장)</span></th>
                <td>
                  <?php
                  $edit_imgs = array();
                  if (!empty($edit['images'])) {
                      $decoded = json_decode($edit['images'], true);
                      if (is_array($decoded)) $edit_imgs = $decoded;
                  }
                  if (!empty($edit_imgs)):
                  ?>
                  <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:12px">
                    <?php foreach ($edit_imgs as $img): 
                      $nImg = normalize_port_img($img);
                    ?>
                    <div class="adm-thumb-item" style="position:relative;display:inline-block">
                      <img src="<?php echo htmlspecialchars($nImg); ?>" class="adm-thumb-img" style="width:84px;height:84px;object-fit:cover;border:1px solid #cbd5e1;border-radius:6px;transition:all 0.2s">
                      <label title="클릭 시 삭제 선택" style="position:absolute;top:-6px;right:-6px;width:22px;height:22px;border-radius:50%;background:#ef4444;color:#fff;font-size:12px;font-weight:bold;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 6px rgba(0,0,0,0.25);border:2px solid #fff;">
                        <input type="checkbox" name="del_images[]" value="<?php echo htmlspecialchars($img); ?>" class="adm-del-chk" style="display:none">✕
                      </label>
                      <span class="adm-del-tag" style="display:none;position:absolute;bottom:0;left:0;right:0;background:rgba(239,68,68,0.92);color:#fff;font-size:10px;text-align:center;padding:2px 0;border-radius:0 0 6px 6px;font-weight:bold;">삭제 선택됨</span>
                    </div>
                    <?php endforeach; ?>
                  </div>
                  <p class="exp" style="color:#64748b;font-size:12.5px;margin-bottom:8px">💡 <strong>X 버튼</strong>: 등록된 사진 중 삭제할 사진의 <strong>X</strong>를 누르면 체크되며, 하단 <strong>[수정/저장]</strong> 시 삭제됩니다.</p>
                  <?php endif; ?>
                  <ul class="file_Box">
                    <li><input type="file" class="file_type01" name="images[]" accept="image/*" multiple title="추가 이미지 선택"></li>
                  </ul>
                </td>
              </tr>

              <tr>
                <th scope="row">노출여부</th>
                <td>
                  <ul class="rc_box">
                    <li>
                      <input type="radio" class="chk_type01" name="status" id="status_active" value="active" <?php echo (!isset($edit['status']) || $edit['status'] === 'active') ? 'checked' : ''; ?>>
                      <label for="status_active">공개</label>
                    </li>
                    <li>
                      <input type="radio" class="chk_type01" name="status" id="status_hidden" value="hidden" <?php echo (isset($edit['status']) && $edit['status'] === 'hidden') ? 'checked' : ''; ?>>
                      <label for="status_hidden">비공개</label>
                    </li>
                  </ul>
                </td>
              </tr>

              <tr>
                <th scope="row">메인 노출</th>
                <td>
                  <ul class="rc_box">
                    <li>
                      <input type="checkbox" class="chk_type01" name="is_featured" id="is_featured" value="1" <?php echo (!empty($edit['is_featured'])) ? 'checked' : ''; ?>>
                      <label for="is_featured">메인 페이지 대표 노출</label>
                    </li>
                  </ul>
                </td>
              </tr>

              <tr>
                <th scope="row">정렬 순서</th>
                <td>
                  <input type="text" name="sort_order" id="sort_order" class="input_type01 w_100" value="<?php echo isset($edit['sort_order']) ? $edit['sort_order'] : 0; ?>" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                  <span class="exp_inline">숫자가 낮을수록 먼저 노출</span>
                </td>
              </tr>

            </tbody>
          </table>
        </div>

        <script type="text/javascript">
        $("#period_start").datepicker({
            dateFormat:"yy-mm-dd",
            dayNamesMin:["일","월","화","수","목","금","토"],
            monthNames:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],
            showMonthAfterYear:true, yearSuffix:"년"
        });
        $("#period_end").datepicker({
            dateFormat:"yy-mm-dd",
            dayNamesMin:["일","월","화","수","목","금","토"],
            monthNames:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],
            showMonthAfterYear:true, yearSuffix:"년"
        });
        $(function(){
            $('input').attr('title','내용을 입력하세요');
            $('#btn_submit').click(function(){
                if(!chkForm('category','광고 유형을','select','1')) return;
                if(!chkForm('title','광고명을','input','2')) return;
                if($('#period_start').val() && $('#period_end').val()){
                    if($('#period_start').val() > $('#period_end').val()){
                        alert('종료일이 시작일 이전입니다.');
                        return;
                    }
                }
                document.frm.action="admin_portfolio.php?mode=<?php echo $edit ? 'modify&id='.$edit['id'] : 'write'; ?>";
                document.frm.submit();
            });
        });

        $(document).on('change', 'input[name="del_images[]"]', function() {
    if ($(this).is(':checked')) {
        $(this).closest('div').fadeOut(200, function() { $(this).remove(); });
    }
});
        </script>

      </form>

      <div class="button a_r mat_30">
        <input type="button" class="btn_1 size_n" value="확인" id="btn_submit">
        <input type="button" class="btn_2 size_n" value="목록" onclick="location.href='admin_portfolio.php'">
      </div>

      <?php else: ?>
      <!-- ════════════════ 목록 ════════════════ -->

      <style>
      .port-search-wrap { margin-bottom: 22px; }
      .port-search-wrap fieldset { border: none; padding: 0; margin: 0; }
      .port-search-wrap .single { display: flex; align-items: center; justify-content: flex-end; gap: 8px; }
      .port-search-wrap select.select_type01 {
          height: 42px !important;
          line-height: 42px !important;
          background-color: #ffffff !important;
          color: #0f172a !important;
          border: 1.5px solid #cbd5e1 !important;
          border-radius: 8px !important;
          padding: 0 34px 0 14px !important;
          font-size: 13.5px !important;
          font-weight: 600 !important;
          cursor: pointer;
          outline: none !important;
          appearance: none;
          -webkit-appearance: none;
          background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23475569' stroke-width='1.8' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") !important;
          background-repeat: no-repeat !important;
          background-position: right 12px center !important;
          transition: border-color 0.2s, box-shadow 0.2s;
      }
      .port-search-wrap select.select_type01:focus {
          background-color: #ffffff !important;
          border-color: #0f172a !important;
          box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08) !important;
          outline: none !important;
      }
      .port-search-wrap .search_input_box { position: relative; display: inline-flex; align-items: center; }
      .port-search-wrap input.input_type01 {
          height: 42px !important;
          line-height: 42px !important;
          background: #ffffff !important;
          color: #0f172a !important;
          border: 1.5px solid #cbd5e1 !important;
          border-radius: 8px !important;
          padding: 0 40px 0 14px !important;
          font-size: 13.5px !important;
          width: 320px !important;
          outline: none !important;
          transition: border-color 0.2s, box-shadow 0.2s;
      }
      .port-search-wrap input.input_type01:focus {
          border-color: #0f172a !important;
          box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08) !important;
          background-color: #ffffff !important;
      }
      .port-search-wrap .search_btn_icon {
          position: absolute;
          right: 12px;
          top: 50%;
          transform: translateY(-50%);
          cursor: pointer;
          color: #64748b;
          display: flex;
          align-items: center;
          justify-content: center;
          transition: color 0.15s;
      }
      .port-search-wrap .search_btn_icon:hover { color: #0f172a; }

      .port-tab-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; border: none !important; padding: 0 !important; }
      .port-tabs { display: flex; flex-wrap: wrap; gap: 7px; margin: 0; border: none !important; padding: 0 !important; }
      .port-tab { padding: 8px 18px; font-size: 13px; font-weight: 600; color: #475569; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; text-decoration: none; transition: all 0.15s ease; }
      .port-tab:hover:not(.on) { background: #f1f5f9; color: #0f172a; border-color: #cbd5e1; }
      .port-tab.on { background: #0f172a; color: #ffffff; border-color: #0f172a; font-weight: 700; box-shadow: 0 2px 8px rgba(15,23,42,0.18); }
      
      .port-count-text { font-size: 14px; color: #475569; margin-bottom: 18px; }
      .port-count-text b { color: #0f172a; font-weight: 700; }

      .port-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 22px; margin-bottom: 30px; }
      @media (max-width: 1200px) { .port-grid { grid-template-columns: repeat(3, 1fr); } }
      @media (max-width: 900px) { .port-grid { grid-template-columns: repeat(2, 1fr); } }
      @media (max-width: 600px) { .port-grid { grid-template-columns: 1fr; } }

      .port-item { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.03); transition: transform 0.2s ease, box-shadow 0.2s ease; display: flex; flex-direction: column; }
      .port-item:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.07); border-color: #cbd5e1; }
      .port-thumb { width: 100%; aspect-ratio: 16/10; overflow: hidden; background: #0f172a; display: flex; align-items: center; justify-content: center; position: relative; }
      .port-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.3s ease; }
      .port-item:hover .port-thumb img { transform: scale(1.04); }
      .port-thumb-empty { color: #94a3b8; font-size: 13px; }

      .port-info { padding: 18px 20px; display: flex; flex-direction: column; flex: 1; justify-content: space-between; }
      .port-cat { font-size: 12.5px; font-weight: 700; color: #1855b7; margin-bottom: 6px; letter-spacing: 0.02em; }
      .port-name { font-size: 15.5px; font-weight: 700; color: #0f172a; line-height: 1.45; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
      .port-loc { font-size: 13px; color: #64748b; margin-bottom: 14px; }
      
      .tab-cnt { font-size: 11px; opacity: 0.75; margin-left: 2px; }
      .port-pagination-wrap { display: flex; justify-content: center; align-items: center; margin: 36px 0 20px; }
      .port-pagination { display: inline-flex; align-items: center; gap: 6px; list-style: none; padding: 0; margin: 0; }
      .port-pagination li { margin: 0; padding: 0; }
      .port-pg-num, .port-pg-arrow {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          min-width: 36px;
          height: 36px;
          padding: 0 10px;
          border-radius: 6px;
          background: #ffffff;
          border: 1px solid #e2e8f0;
          color: #334155;
          font-size: 13.5px;
          font-weight: 600;
          text-decoration: none !important;
          transition: all 0.15s ease;
      }
      .port-pg-num:hover, .port-pg-arrow:hover {
          background: #f1f5f9;
          border-color: #cbd5e1;
          color: #0f172a;
      }
      .port-pg-num.active {
          background: #0f172a;
          border-color: #0f172a;
          color: #ffffff !important;
          font-weight: 700;
          box-shadow: 0 2px 6px rgba(15,23,42,0.2);
      }

      .port-admin-bar { display: flex; align-items: center; justify-content: space-between; padding-top: 12px; border-top: 1px solid #f1f5f9; }
      .port-status-badge { font-size: 12.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
      .port-status-active { color: #16a34a; }
      .port-status-hidden { color: #94a3b8; }
      .port-featured-tag { background: #0f172a; color: #ffffff; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 4px; margin-right: 4px; }

      /* HIGH VISIBILITY ACTION BUTTONS */
      .port-btn-edit {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          padding: 5px 12px;
          background: #f1f5f9;
          color: #334155;
          border: 1px solid #cbd5e1;
          border-radius: 6px;
          font-size: 12px;
          font-weight: 600;
          text-decoration: none !important;
          transition: all 0.15s ease;
      }
      .port-btn-edit:hover {
          background: #0f172a;
          color: #ffffff !important;
          border-color: #0f172a;
      }
      .port-btn-del {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          padding: 5px 12px;
          background: #fee2e2;
          color: #dc2626 !important;
          border: 1px solid #fca5a5;
          border-radius: 6px;
          font-size: 12px;
          font-weight: 700;
          text-decoration: none !important;
          transition: all 0.15s ease;
      }
      .port-btn-del:hover {
          background: #dc2626;
          color: #ffffff !important;
          border-color: #dc2626;
      }
      </style>

      <!-- SEARCH BOX -->
      <div class="search_box port-search-wrap" style="border:none; background:transparent; padding:0;">
          <fieldset>
              <legend style="display:none;">게시물검색</legend>
              <div class="single">
                  <select name="cat" id="filterCat" class="select_type01" onchange="filterCategory(this.value)">
                      <option value="">전체 카테고리</option>
                      <?php foreach ($categories as $k => $v): ?>
                      <option value="<?php echo $k; ?>" <?php echo $filter_cat === $k ? 'selected' : ''; ?>><?php echo $v; ?></option>
                      <?php endforeach; ?>
                  </select>
                  <div class="search_input_box">
                      <input type="text" class="input_type01" name="frSearch" id="frSearch" value="<?php echo htmlspecialchars($frSearch); ?>" placeholder="광고명 또는 광고주, 지역 검색" onkeypress="if(event.keyCode==13){ doSearch(); }">
                      <span class="search_btn_icon" onclick="doSearch()" title="검색">
                          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                      </span>
                  </div>
              </div>
          </fieldset>
      </div>

      <!-- TABS & TOP ACTION -->
      <div class="port-tab-header">
          <div class="port-tabs">
              <a href="admin_portfolio.php" class="port-tab <?php echo !$filter_cat ? 'on' : ''; ?>">전체 <span class="tab-cnt">(<?php echo isset($cat_counts['all']) ? $cat_counts['all'] : 0; ?>)</span></a>
              <?php foreach ($categories as $k => $v): 
                  $cNum = isset($cat_counts[$k]) ? $cat_counts[$k] : 0;
              ?>
              <a href="admin_portfolio.php?cat=<?php echo $k; ?><?php echo $frSearch ? '&frSearch='.urlencode($frSearch) : ''; ?>" class="port-tab <?php echo $filter_cat === $k ? 'on' : ''; ?>"><?php echo $v; ?> <span class="tab-cnt">(<?php echo $cNum; ?>)</span></a>
              <?php endforeach; ?>
          </div>
          <input type="button" class="btn_1 size_n" value="+ 신규 등록" onclick="location.href='admin_portfolio.php?mode=write'" style="height:38px; padding:0 22px; font-weight:700; border-radius:6px;">
      </div>

      <p class="port-count-text">
          총 <b><?php echo $totals; ?></b>건의 포트폴리오가 등록되어 있습니다.
      </p>

      <?php if (empty($list)): ?>
      <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:10px; padding:60px 0; text-align:center; margin-bottom:30px;">
          <p style="color:#94a3b8; font-size:15px; margin:0;">등록된 포트폴리오가 없습니다.</p>
      </div>
      <?php else: ?>
      <div class="port-grid">
          <?php foreach ($list as $row): ?>
          <div class="port-item">
              <div class="port-thumb">
                  <?php if ($row['thumb']): ?>
                  <img src="<?php echo htmlspecialchars($row['thumb']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                  <?php else: ?>
                  <span class="port-thumb-empty">이미지 없음</span>
                  <?php endif; ?>
              </div>
              <div class="port-info">
                  <div>
                      <div class="port-cat"><?php echo isset($categories[$row['category']]) ? $categories[$row['category']] : $row['category']; ?></div>
                      <div class="port-name" title="<?php echo htmlspecialchars($row['title']); ?>"><?php echo htmlspecialchars($row['title']); ?></div>
                      <div class="port-loc"><?php echo htmlspecialchars($row['location'] ? $row['location'] : ($row['client'] ? $row['client'] : '가온엔 직영 시공')); ?></div>
                  </div>
                  <div class="port-admin-bar">
                      <div style="display:flex; align-items:center;">
                          <?php if ($row['is_featured']): ?>
                          <span class="port-featured-tag">메인</span>
                          <?php endif; ?>
                          <span class="port-status-badge <?php echo $row['status']==='active' ? 'port-status-active' : 'port-status-hidden'; ?>">
                              <?php echo $row['status']==='active' ? '● 공개' : '● 비공개'; ?>
                          </span>
                      </div>
                      <div style="display:flex; gap:6px;">
                          <a href="admin_portfolio.php?mode=modify&id=<?php echo $row['id']; ?>" class="port-btn-edit">수정</a>
                          <a href="admin_portfolio.php?del=<?php echo $row['id']; ?>" class="port-btn-del" onclick="return confirm('이 포트폴리오를 삭제하시겠습니까?')">삭제</a>
                      </div>
                  </div>
              </div>
          </div>
          <?php endforeach; ?>
      </div>

      <!-- PAGINATION UI (20 ITEMS / 5 ROWS PER PAGE) -->
      <?php if ($total_pages > 1): ?>
      <div class="port-pagination-wrap">
          <ul class="port-pagination">
              <?php
              $url_params = '';
              if ($filter_cat) $url_params .= '&cat=' . urlencode($filter_cat);
              if ($frSearch) $url_params .= '&frSearch=' . urlencode($frSearch);
              ?>
              <?php if ($page > 1): ?>
              <li><a href="admin_portfolio.php?page=1<?php echo $url_params; ?>" class="port-pg-arrow" title="처음 페이지">«</a></li>
              <li><a href="admin_portfolio.php?page=<?php echo max(1, $page - 1); ?><?php echo $url_params; ?>" class="port-pg-arrow" title="이전 페이지">‹</a></li>
              <?php endif; ?>

              <?php
              $start_p = max(1, $page - 4);
              $end_p   = min($total_pages, $start_p + 8);
              if ($end_p - $start_p < 8) {
                  $start_p = max(1, $end_p - 8);
              }
              for ($p = $start_p; $p <= $end_p; $p++):
              ?>
              <li>
                  <a href="admin_portfolio.php?page=<?php echo $p; ?><?php echo $url_params; ?>" class="port-pg-num <?php echo ($p === $page) ? 'active' : ''; ?>">
                      <?php echo $p; ?>
                  </a>
              </li>
              <?php endfor; ?>

              <?php if ($page < $total_pages): ?>
              <li><a href="admin_portfolio.php?page=<?php echo min($total_pages, $page + 1); ?><?php echo $url_params; ?>" class="port-pg-arrow" title="다음 페이지">›</a></li>
              <li><a href="admin_portfolio.php?page=<?php echo $total_pages; ?><?php echo $url_params; ?>" class="port-pg-arrow" title="마지막 페이지">»</a></li>
              <?php endif; ?>
          </ul>
      </div>
      <?php endif; ?>

      <?php endif; ?>

      <div class="button a_r mat_30" style="display:flex; justify-content:flex-end;">
          <input type="button" class="btn_1 size_n" value="+ 신규 포트폴리오 등록" onclick="location.href='admin_portfolio.php?mode=write'" style="padding:10px 24px; font-weight:700;">
      </div>

      <script type="text/javascript">
      function doSearch() {
          var cat = $('#filterCat').val();
          var search = $('#frSearch').val();
          location.href = "admin_portfolio.php?cat=" + encodeURIComponent(cat) + "&frSearch=" + encodeURIComponent(search);
      }
      function filterCategory(cat) {
          var search = $('#frSearch').val();
          location.href = "admin_portfolio.php?cat=" + encodeURIComponent(cat) + (search ? "&frSearch=" + encodeURIComponent(search) : "");
      }
      </script>

      <?php endif; ?>

    </section>
  </div>
</div>

<script>
$(document).on('change', '.adm-del-chk', function() {
  var $box = $(this).closest('.adm-thumb-item');
  if ($(this).is(':checked')) {
    $box.find('.adm-thumb-img').css({ 'opacity': '0.3', 'filter': 'grayscale(100%)' });
    $box.find('.adm-del-tag').show();
  } else {
    $box.find('.adm-thumb-img').css({ 'opacity': '1', 'filter': 'none' });
    $box.find('.adm-del-tag').hide();
  }
});
</script>
</body>
</html>