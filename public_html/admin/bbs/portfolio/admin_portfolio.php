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

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'list';
$msg  = isset($_GET['msg'])  ? $_GET['msg']  : '';
$edit = null;

// ── 수정 데이터 로드 ──
if ($mode === 'modify' && !empty($_GET['id'])) {
    $eid  = (int)$_GET['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM portfolio WHERE id = ?");
    if ($stmt) {
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
}

// ── 삭제 ──
if (!empty($_GET['del'])) {
    $did    = (int)$_GET['del'];
    $result = mysqli_query($conn, "SELECT thumb, images FROM portfolio WHERE id = $did LIMIT 1");
    if ($result) {
        $drow = mysqli_fetch_assoc($result);
        if ($drow) {
            if ($drow['thumb'] && file_exists($_SERVER['DOCUMENT_ROOT'] . $drow['thumb'])) {
                @unlink($_SERVER['DOCUMENT_ROOT'] . $drow['thumb']);
            }
            if ($drow['images']) {
                $imgs = json_decode($drow['images'], true);
                if (is_array($imgs)) {
                    foreach ($imgs as $img) {
                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $img)) @unlink($_SERVER['DOCUMENT_ROOT'] . $img);
                    }
                }
            }
            mysqli_query($conn, "DELETE FROM portfolio WHERE id = $did");
        }
    }
    $ret_view = isset($_GET['view']) ? '&view=' . urlencode($_GET['view']) : '';
    header('Location: admin_portfolio.php?msg=del' . $ret_view);
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
            if ($thumb && file_exists($_SERVER['DOCUMENT_ROOT'] . $thumb)) @unlink($_SERVER['DOCUMENT_ROOT'] . $thumb);
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
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $di)) @unlink($_SERVER['DOCUMENT_ROOT'] . $di);
            $new_images = array();
            foreach ($images as $v) { if ($v !== $di) $new_images[] = $v; }
            $images = $new_images;
        }
    }
    $images_json = json_encode(array_values($images));

    if ($id > 0) {
        $stmt = mysqli_prepare($conn, "
            UPDATE portfolio SET
                category=?, title=?, client=?, location=?,
                period_start=?, period_end=?, scale=?, description=?,
                thumb=?, images=?, is_featured=?, sort_order=?, status=?,
                updated_at=NOW()
            WHERE id=?
        ");
        mysqli_stmt_bind_param($stmt, 'sssssssssiisi',
            $category, $title, $client, $location,
            $period_start, $period_end, $scale, $description,
            $thumb, $images_json, $is_featured, $sort_order, $status,
            $id
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: admin_portfolio.php?cat=' . urlencode($category) . '&msg=modify');
    } else {
        $stmt = mysqli_prepare($conn, "
            INSERT INTO portfolio
                (category, title, client, location, period_start, period_end, scale, description, thumb, images, is_featured, sort_order, status, created_at, updated_at)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        mysqli_stmt_bind_param($stmt, 'sssssssssiiss',
            $category, $title, $client, $location,
            $period_start, $period_end, $scale, $description,
            $thumb, $images_json, $is_featured, $sort_order, $status
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: admin_portfolio.php?cat=' . urlencode($category) . '&msg=write');
    }
    exit;
}

// ── 보기 모드 (table: 목록형 / gallery: 카드형) ──
$view_mode = isset($_GET['view']) ? $_GET['view'] : (isset($_COOKIE['admin_port_view']) ? $_COOKIE['admin_port_view'] : 'table');
if (!in_array($view_mode, array('table', 'gallery'))) $view_mode = 'table';
if (isset($_GET['view'])) {
    @setcookie('admin_port_view', $view_mode, time() + 3600 * 24 * 365, '/');
}

// ── 목록 조회 & 검색 & 페이징 ──
$filter_cat = isset($_GET['cat']) ? trim($_GET['cat']) : '';
$frSearch   = isset($_GET['frSearch']) ? trim($_GET['frSearch']) : '';

$_page      = isset($_GET['_page']) ? (int)$_GET['_page'] : (isset($_GET['page']) ? (int)$_GET['page'] : 1);
if (!$_page) $_page = 1;
$view_limit = ($view_mode === 'gallery') ? 12 : 10; // 게시글 노출 수
$page       = ($_page - 1) * $view_limit;

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
$totals = 0;
if ($cnt_res) {
    $cnt_row = mysqli_fetch_array($cnt_res);
    if ($cnt_row) $totals = (int)$cnt_row[0];
}

$sql    = "SELECT * FROM portfolio $where_sql ORDER BY sort_order ASC, id DESC LIMIT $page, $view_limit";
$result = mysqli_query($conn, $sql);
$list   = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) { $list[] = $row; }
}
?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php"; ?>
<body class="bg_body">

<!--header-->
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php"; ?>
<!--//header-->

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
      <!-- ════════════════ 등록/수정 폼 (board_A0_W) ════════════════ -->
      <style>
      .board_A0_W table th { width: 140px; }
      .port-form-textarea {
          width: 100% !important;
          max-width: 850px !important;
          min-height: 150px !important;
          box-sizing: border-box !important;
          padding: 12px 14px !important;
          font-size: 13.5px !important;
          line-height: 1.7 !important;
          border: 1px solid #d5d5d5 !important;
          border-radius: 4px !important;
          background: #fff !important;
          color: #111 !important;
          resize: vertical !important;
          font-family: inherit !important;
      }
      .port-form-textarea:focus { border-color: #111 !important; outline: none; }
      .w_max850 { width: 100% !important; max-width: 850px !important; box-sizing: border-box !important; }
      </style>

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
                  <select name="category" id="category" class="select_type01" style="width:200px;">
                    <option value="">선택하세요</option>
                    <?php foreach ($categories as $k => $v): ?>
                    <option value="<?php echo $k; ?>" <?php echo (isset($edit['category']) && $edit['category'] === $k) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                    <?php endforeach; ?>
                  </select>
                </td>
              </tr>

              <tr>
                <th scope="row">광고명 <span class="req">*</span></th>
                <td><input type="text" name="title" id="title" class="input_type01 w_max850" value="<?php echo htmlspecialchars(isset($edit['title']) ? $edit['title'] : ''); ?>" placeholder="예) ○○병원 버스 전면 랩핑"></td>
              </tr>

              <tr>
                <th scope="row">광고주</th>
                <td><input type="text" name="client" id="client" class="input_type01 w_max850" value="<?php echo htmlspecialchars(isset($edit['client']) ? $edit['client'] : ''); ?>" placeholder="예) ○○병원"></td>
              </tr>

              <tr>
                <th scope="row">지역</th>
                <td><input type="text" name="location" id="location" class="input_type01 w_max850" value="<?php echo htmlspecialchars(isset($edit['location']) ? $edit['location'] : ''); ?>" placeholder="예) 광주광역시 북구"></td>
              </tr>

              <tr>
                <th scope="row">집행 기간</th>
                <td>
                  <input type="text" name="period_start" id="period_start" class="input_type01 w_150" value="<?php echo isset($edit['period_start']) ? $edit['period_start'] : ''; ?>" placeholder="YYYY-MM-DD" readonly>
                  ~
                  <input type="text" name="period_end" id="period_end" class="input_type01 w_150" value="<?php echo isset($edit['period_end']) ? $edit['period_end'] : ''; ?>" placeholder="YYYY-MM-DD" readonly>
                </td>
              </tr>

              <tr>
                <th scope="row">집행 규모</th>
                <td><input type="text" name="scale" id="scale" class="input_type01 w_max850" value="<?php echo htmlspecialchars(isset($edit['scale']) ? $edit['scale'] : ''); ?>" placeholder="예) 버스 10대 / 3개월"></td>
              </tr>

              <tr>
                <th scope="row">상세 설명</th>
                <td><textarea name="description" id="description" class="port-form-textarea" placeholder="포트폴리오에 대한 상세 설명 및 광고 기획 의도를 입력하세요."><?php echo htmlspecialchars(isset($edit['description']) ? $edit['description'] : ''); ?></textarea></td>
              </tr>

              <tr>
                <th scope="row">대표 썸네일</th>
                <td>
                  <?php if (!empty($edit['thumb'])): ?>
                  <div style="margin-bottom:8px">
                    <img src="<?php echo normalize_port_img($edit['thumb']); ?>" style="max-height:90px;border:1px solid #e2e8f0;border-radius:4px;vertical-align:middle;cursor:pointer;" onclick="openImgModal('<?php echo normalize_port_img($edit['thumb']); ?>', '<?php echo htmlspecialchars(addslashes($edit['title'])); ?>', '');">
                  </div>
                  <?php endif; ?>
                  <ul class="file_Box">
                    <li><input type="file" class="file_type01" name="thumb" accept="image/*" title="대표 이미지 선택"></li>
                  </ul>
                </td>
              </tr>

              <tr>
                <th scope="row">추가 사진</th>
                <td>
                  <?php
                  $imgs_arr = !empty($edit['images']) ? json_decode($edit['images'], true) : array();
                  if (!empty($imgs_arr) && is_array($imgs_arr)):
                  ?>
                  <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:8px">
                    <?php foreach ($imgs_arr as $img_path): ?>
                    <div style="position:relative;display:inline-block">
                      <img src="<?php echo normalize_port_img($img_path); ?>" style="width:75px;height:75px;object-fit:cover;border:1px solid #e2e8f0;border-radius:4px;cursor:pointer;" onclick="openImgModal('<?php echo normalize_port_img($img_path); ?>', '추가 사진 미리보기', '');">
                      <label style="position:absolute;top:2px;right:2px;background:rgba(220,38,38,0.9);color:#fff;border-radius:3px;padding:1px 5px;font-size:11px;font-weight:bold;cursor:pointer" title="삭제 체크">
                        <input type="checkbox" name="del_images[]" value="<?php echo htmlspecialchars($img_path); ?>" style="display:none"> ✕
                      </label>
                    </div>
                    <?php endforeach; ?>
                  </div>
                  <p class="exp" style="color:#64748b;font-size:12.5px;margin-bottom:8px">💡 ✕ 버튼을 누르면 체크되며 저장 시 해당 사진이 삭제됩니다. (사진 클릭 시 확대)</p>
                  <?php endif; ?>
                  <ul class="file_Box">
                    <li><input type="file" class="file_type01" name="images[]" accept="image/*" multiple title="추가 이미지 선택"></li>
                  </ul>
                </td>
              </tr>

              <tr>
                <th scope="row">노출 여부</th>
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
      <!-- ════════════════ 목록 (board_A0_L) ════════════════ -->

      <style>
      /* Table Layout & Single Line Ellipsis */
      .port-table-wrap table { table-layout: fixed !important; width: 100% !important; border-top: 1px solid #111; }
      .port-table-wrap th { text-align: center; border-bottom: 1px solid #d5d5d5; padding: 14px 6px; font-weight: 600; background: #fafafa; font-size: 13.5px; }
      .port-table-wrap td { text-align: center; border-bottom: 1px solid #e5e5e5; padding: 11px 6px; font-size: 13px; vertical-align: middle; }
      .port-table-wrap td.subject { text-align: left; }
      
      /* Pure 1-Line Ellipsis Text */
      .port-ellipsis {
          display: block;
          width: 100%;
          white-space: nowrap !important;
          overflow: hidden !important;
          text-overflow: ellipsis !important;
          word-break: break-all;
      }
      .port-table-wrap td.subject a {
          display: block;
          width: 100%;
          white-space: nowrap !important;
          overflow: hidden !important;
          text-overflow: ellipsis !important;
          color: #111;
          font-weight: 700;
      }
      .port-table-wrap td.subject a:hover {
          color: #2563eb;
          text-decoration: underline;
      }
      .port-thumb-img {
          width: 72px;
          height: 48px;
          object-fit: cover;
          border: 1px solid #cbd5e1;
          border-radius: 4px;
          vertical-align: middle;
          display: block;
          margin: 0 auto;
          cursor: zoom-in;
          transition: transform 0.2s, box-shadow 0.2s;
      }
      .port-thumb-img:hover {
          transform: scale(1.08);
          box-shadow: 0 4px 10px rgba(0,0,0,0.15);
      }

      /* Bold Action Buttons */
      .port-btn-edit {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          padding: 5px 12px;
          background: #f1f5f9;
          color: #1e293b !important;
          border: 1.5px solid #cbd5e1;
          border-radius: 4px;
          font-size: 12.5px;
          font-weight: 800 !important;
          text-decoration: none !important;
          transition: all 0.15s ease;
          letter-spacing: 0.3px;
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
          border: 1.5px solid #fca5a5;
          border-radius: 4px;
          font-size: 12.5px;
          font-weight: 800 !important;
          text-decoration: none !important;
          transition: all 0.15s ease;
          margin-left: 4px;
          letter-spacing: 0.3px;
      }
      .port-btn-del:hover {
          background: #dc2626;
          color: #ffffff !important;
          border-color: #dc2626;
      }

      /* Top Header & Pictogram Switcher */
      .port-list-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin: 22px 0 16px 0;
          padding-bottom: 6px;
      }
      .port-list-header .count { margin-bottom: 0; }
      .view-switch-box {
          display: inline-flex;
          background: #f1f5f9;
          padding: 4px;
          border-radius: 8px;
          border: 1px solid #cbd5e1;
          gap: 4px;
      }
      .view-switch-btn {
          display: inline-flex;
          align-items: center;
          gap: 6px;
          padding: 6px 14px;
          font-size: 12.5px;
          font-weight: 700;
          color: #64748b;
          text-decoration: none !important;
          border-radius: 5px;
          transition: all 0.15s;
      }
      .view-switch-btn svg { width: 14px; height: 14px; }
      .view-switch-btn:hover { color: #0f172a; background: rgba(255,255,255,0.7); }
      .view-switch-btn.active { color: #0f172a; background: #ffffff; box-shadow: 0 1px 4px rgba(0,0,0,0.12); font-weight: 800; }

      /* Gallery Card View */
      .port-card-grid {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 20px;
          margin-top: 15px;
          margin-bottom: 30px;
      }
      @media (max-width: 1200px) { .port-card-grid { grid-template-columns: repeat(3, 1fr); } }
      @media (max-width: 850px) { .port-card-grid { grid-template-columns: repeat(2, 1fr); } }
      @media (max-width: 550px) { .port-card-grid { grid-template-columns: 1fr; } }

      .port-card {
          background: #ffffff;
          border: 1px solid #e2e8f0;
          border-radius: 8px;
          overflow: hidden;
          transition: all 0.2s ease;
          display: flex;
          flex-direction: column;
      }
      .port-card:hover {
          transform: translateY(-3px);
          box-shadow: 0 8px 20px rgba(0,0,0,0.08);
          border-color: #cbd5e1;
      }
      .port-card-thumb-wrap {
          position: relative;
          width: 100%;
          aspect-ratio: 16/10;
          overflow: hidden;
          background: #0f172a;
          cursor: zoom-in;
          display: block;
      }
      .port-card-thumb-wrap img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          display: block;
          transition: transform 0.3s;
      }
      .port-card:hover .port-card-thumb-wrap img { transform: scale(1.05); }
      .port-card-cat-tag {
          position: absolute;
          top: 10px;
          left: 10px;
          background: rgba(15, 23, 42, 0.85);
          color: #fff;
          font-size: 11px;
          font-weight: 700;
          padding: 3px 8px;
          border-radius: 4px;
          backdrop-filter: blur(4px);
      }
      .port-zoom-badge {
          position: absolute;
          bottom: 10px;
          right: 10px;
          background: rgba(0,0,0,0.7);
          color: #fff;
          font-size: 11px;
          font-weight: 600;
          padding: 3px 8px;
          border-radius: 4px;
          opacity: 0;
          transition: opacity 0.2s;
      }
      .port-card:hover .port-zoom-badge { opacity: 1; }

      .port-card-body {
          padding: 14px 16px;
          flex: 1;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
      }
      .port-card-title {
          font-size: 14px;
          font-weight: 700;
          color: #0f172a;
          margin: 0 0 6px;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
      }
      .port-card-meta {
          font-size: 12px;
          color: #64748b;
          margin-bottom: 12px;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
      }
      .port-card-foot {
          display: flex;
          justify-content: space-between;
          align-items: center;
          border-top: 1px solid #f1f5f9;
          padding-top: 10px;
      }
      </style>

      <script type="text/javascript">
      $(function(){
          $('#btnSearch').click(function(){
              searchList();
          });
      });

      var searchList = function(){
          var frCat = $('#filterCat').val();
          var frSearch = $('#frSearch').val();
          var view = '<?=$view_mode?>';
          location.href="admin_portfolio.php?cat="+encodeURI(frCat)+"&frSearch="+encodeURI(frSearch)+"&view="+view;
      }

      var EnterKey = function(){
          if(event.keyCode == 13){ searchList(); }
      }

      function delPort(id) {
          if (confirm('선택한 포트폴리오를 삭제하시겠습니까?')) {
              var view = '<?=$view_mode?>';
              location.href = 'admin_portfolio.php?del=' + id + '&view=' + view;
          }
      }
      </script>

      <!--search-->
      <div class="search_box">
          <fieldset>
              <legend>게시물검색</legend>
              <div class="single">
                  <select name="cat" id="filterCat" class="select_type01" title="광고유형 선택">
                      <option value="">전체 광고유형</option>
                      <?php foreach ($categories as $k => $v): ?>
                      <option value="<?=$k?>" <?if($filter_cat==$k){?>selected<?}?>><?=$v?></option>
                      <?php endforeach; ?>
                  </select>
                  <input type="text" class="input_type01 w_400" name="frSearch" id="frSearch" value="<?=htmlspecialchars($frSearch)?>" placeholder="광고명, 광고주, 지역 검색" onkeypress="EnterKey();">
                  <span class="search_btn" id="btnSearch">검색</span>
              </div>
          </fieldset>
      </div>
      <!--//search-->

      <!--board_A0_list-->
      <div class="board_A0_L port-table-wrap">
          <div class="port-list-header">
              <p class="count">총 <b><?=$totals?></b>건의 내용이 있습니다</p>
              
              <!-- 픽토그램 뷰 스위처 (위/아래 여유 공간) -->
              <div class="view-switch-box">
                  <a href="admin_portfolio.php?view=table&cat=<?=urlencode($filter_cat)?>&frSearch=<?=urlencode($frSearch)?>" class="view-switch-btn <?=$view_mode==='table'?'active':''?>" title="목록형으로 보기">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                      <span>목록형</span>
                  </a>
                  <a href="admin_portfolio.php?view=gallery&cat=<?=urlencode($filter_cat)?>&frSearch=<?=urlencode($frSearch)?>" class="view-switch-btn <?=$view_mode==='gallery'?'active':''?>" title="카드형으로 보기">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                      <span>카드형</span>
                  </a>
              </div>
          </div>

          <?php if ($view_mode === 'table'): ?>
          <!-- ─── 1. 깔끔한 한 줄 말줄임(...) 목록형 테이블 ─── -->
          <table summary="포트폴리오 관리 목록이며 번호, 썸네일, 광고유형, 광고명, 광고주, 지역, 노출여부, 메인노출, 정렬, 관리를 제공합니다.">
              <caption>포트폴리오 관리 목록</caption>
              <colgroup>
                  <col width="55" />
                  <col width="85" />
                  <col width="130" />
                  <col width="*" />
                  <col width="140" />
                  <col width="130" />
                  <col width="75" />
                  <col width="75" />
                  <col width="65" />
                  <col width="125" />
              </colgroup>
              <thead>
                  <tr>
                      <th scope="col" class="resp">번호</th>
                      <th scope="col">썸네일</th>
                      <th scope="col">광고유형</th>
                      <th scope="col">광고명</th>
                      <th scope="col">광고주</th>
                      <th scope="col">지역</th>
                      <th scope="col">노출</th>
                      <th scope="col">메인</th>
                      <th scope="col">정렬</th>
                      <th scope="col">관리</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  if($totals > 0){
                      $cnt = $page + 1;
                      foreach ($list as $row){
                          $cat_title = isset($categories[$row['category']]) ? $categories[$row['category']] : $row['category'];
                          $thumb_src = !empty($row['thumb']) ? normalize_port_img($row['thumb']) : '/images/bs_ad/baro.jpg';
                          $status_txt = ($row['status'] === 'active') ? '<span style="color:#16a34a; font-weight:700;">공개</span>' : '<span style="color:#94a3b8;">비공개</span>';
                          $featured_txt = (!empty($row['is_featured'])) ? '<span style="color:#2563eb; font-weight:800;">노출</span>' : '-';
                          $client_txt = $row['client'] ? htmlspecialchars($row['client']) : '-';
                          $loc_txt = $row['location'] ? htmlspecialchars($row['location']) : '-';
                          $title_txt = htmlspecialchars($row['title']);
                          $title_safe = htmlspecialchars(addslashes($row['title']));
                  ?>
                  <tr>
                      <td class="resp"><?=$cnt?></td>
                      <td>
                          <a href="javascript:void(0);" onclick="openImgModal('<?=$thumb_src?>', '<?=$title_safe?>', '<?=$cat_title?>');" title="사진 크게보기 (클릭)">
                              <img src="<?=$thumb_src?>" alt="" class="port-thumb-img">
                          </a>
                      </td>
                      <td><span class="port-ellipsis" title="<?=$cat_title?>"><?=$cat_title?></span></td>
                      <td class="subject">
                          <a href="admin_portfolio.php?mode=modify&id=<?=$row['id']?>" title="<?=$title_txt?>"><?=$title_txt?></a>
                      </td>
                      <td><span class="port-ellipsis" title="<?=$client_txt?>"><?=$client_txt?></span></td>
                      <td><span class="port-ellipsis" title="<?=$loc_txt?>"><?=$loc_txt?></span></td>
                      <td><?=$status_txt?></td>
                      <td><?=$featured_txt?></td>
                      <td><?=$row['sort_order']?></td>
                      <td>
                          <a href="admin_portfolio.php?mode=modify&id=<?=$row['id']?>" class="port-btn-edit">수정</a>
                          <a href="javascript:delPort(<?=$row['id']?>);" class="port-btn-del">삭제</a>
                      </td>
                  </tr>
                  <?php $cnt++; }} ?>
                  <?php if($totals <= 0){ ?>
                  <tr>
                      <td colspan="10" class="no_text">등록된 포트폴리오가 없습니다.</td>
                  </tr>
                  <?php } ?>
              </tbody>
          </table>

          <?php else: ?>
          <!-- ─── 2. 비주얼 카드/갤러리형 ─── -->
          <div class="port-card-grid">
              <?php
              if($totals > 0){
                  foreach ($list as $row){
                      $cat_title = isset($categories[$row['category']]) ? $categories[$row['category']] : $row['category'];
                      $thumb_src = !empty($row['thumb']) ? normalize_port_img($row['thumb']) : '/images/bs_ad/baro.jpg';
                      $status_txt = ($row['status'] === 'active') ? '<span style="color:#16a34a; font-weight:700; font-size:12px;">● 공개</span>' : '<span style="color:#94a3b8; font-size:12px;">● 비공개</span>';
                      $featured_txt = (!empty($row['is_featured'])) ? '<span style="background:#2563eb; color:#fff; font-size:10px; font-weight:800; padding:2px 6px; border-radius:3px; margin-left:4px;">메인</span>' : '';
                      $client_txt = $row['client'] ? htmlspecialchars($row['client']) : '가온엔 광고';
                      $title_txt = htmlspecialchars($row['title']);
                      $title_safe = htmlspecialchars(addslashes($row['title']));
              ?>
              <div class="port-card">
                  <a href="javascript:void(0);" onclick="openImgModal('<?=$thumb_src?>', '<?=$title_safe?>', '<?=$cat_title?>');" class="port-card-thumb-wrap" title="사진 크게보기 (클릭)">
                      <img src="<?=$thumb_src?>" alt="<?=$title_txt?>">
                      <span class="port-card-cat-tag"><?=$cat_title?></span>
                      <span class="port-zoom-badge">🔍 사진확대</span>
                  </a>
                  <div class="port-card-body">
                      <div>
                          <h4 class="port-card-title" title="<?=$title_txt?>"><a href="admin_portfolio.php?mode=modify&id=<?=$row['id']?>" style="color:#0f172a;"><?=$title_txt?></a></h4>
                          <p class="port-card-meta"><?=$client_txt?> <?=($row['location'] ? '· '.htmlspecialchars($row['location']) : '')?></p>
                      </div>
                      <div class="port-card-foot">
                          <div><?=$status_txt?><?=$featured_txt?></div>
                          <div>
                              <a href="admin_portfolio.php?mode=modify&id=<?=$row['id']?>" class="port-btn-edit">수정</a>
                              <a href="javascript:delPort(<?=$row['id']?>);" class="port-btn-del">삭제</a>
                          </div>
                      </div>
                  </div>
              </div>
              <?php }} ?>
              <?php if($totals <= 0){ ?>
              <div style="grid-column: 1 / -1; text-align: center; padding: 50px 0; color: #94a3b8;">등록된 포트폴리오가 없습니다.</div>
              <?php } ?>
          </div>
          <?php endif; ?>

      </div>
      <!--//board_A0_list-->

      <!--button-->
      <div class="button a_r mat_30">
          <a href="admin_portfolio.php?mode=write" class="btn_1 size_n">등록</a>
      </div>
      <!--//button-->

      <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/paging.php"; ?>

      <?php endif; ?>

    </section>
  </div>
</div>

<!-- Image Preview Modal Lightbox (사진 확대 보기) -->
<div id="imgPreviewModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.75); z-index:99999; justify-content:center; align-items:center; backdrop-filter:blur(3px);">
  <div style="position:relative; max-width:90%; max-height:90%; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 20px 40px rgba(0,0,0,0.3); display:flex; flex-direction:column;">
    <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 20px; background:#0f172a; color:#fff;">
      <div style="font-size:15px; font-weight:700;" id="modalImgTitle">포트폴리오 사진 확대</div>
      <button type="button" onclick="closeImgModal()" style="background:none; border:none; color:#fff; font-size:24px; line-height:1; cursor:pointer; padding:0 4px;" title="닫기">&times;</button>
    </div>
    <div style="padding:15px; background:#1e293b; display:flex; justify-content:center; align-items:center; overflow:auto; max-height:calc(90vh - 120px);">
      <img id="modalImgTag" src="" alt="" style="max-width:100%; max-height:calc(85vh - 140px); object-fit:contain; border-radius:6px; box-shadow:0 4px 15px rgba(0,0,0,0.5);">
    </div>
    <div style="padding:12px 20px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center;">
      <span id="modalImgCat" style="font-size:13px; font-weight:700; color:#2563eb;"></span>
      <button type="button" onclick="closeImgModal()" class="btn_2 size_s" style="padding:6px 18px; font-size:13px; font-weight:700; cursor:pointer;">닫기</button>
    </div>
  </div>
</div>

<script>
function openImgModal(src, title, cat) {
    if (!src) return;
    $('#modalImgTag').attr('src', src);
    $('#modalImgTitle').text(title || '포트폴리오 사진 확대');
    $('#modalImgCat').text(cat || '');
    $('#imgPreviewModal').css('display', 'flex').hide().fadeIn(150);
}
function closeImgModal() {
    $('#imgPreviewModal').fadeOut(150);
}
$(document).on('click', '#imgPreviewModal', function(e) {
    if (e.target === this) closeImgModal();
});
$(document).keydown(function(e) {
    if (e.keyCode === 27) closeImgModal();
});
</script>

</body>
</html>
