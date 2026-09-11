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

// ── 목록 조회 & 검색 & 페이징 ──
$filter_cat = isset($_GET['cat']) ? trim($_GET['cat']) : '';
$frSearch   = isset($_GET['frSearch']) ? trim($_GET['frSearch']) : '';

$_page      = isset($_GET['_page']) ? (int)$_GET['_page'] : (isset($_GET['page']) ? (int)$_GET['page'] : 1);
if (!$_page) $_page = 1;
$view_limit = 10; // 게시글 노출 수
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
                  <input type="text" name="period_start" id="period_start" class="input_type01 w_150" value="<?php echo isset($edit['period_start']) ? $edit['period_start'] : ''; ?>" placeholder="YYYY-MM-DD" readonly>
                  ~
                  <input type="text" name="period_end" id="period_end" class="input_type01 w_150" value="<?php echo isset($edit['period_end']) ? $edit['period_end'] : ''; ?>" placeholder="YYYY-MM-DD" readonly>
                </td>
              </tr>

              <tr>
                <th scope="row">집행 규모</th>
                <td><input type="text" name="scale" id="scale" class="input_type01 w_300" value="<?php echo htmlspecialchars(isset($edit['scale']) ? $edit['scale'] : ''); ?>" placeholder="예) 버스 10대 / 3개월"></td>
              </tr>

              <tr>
                <th scope="row">상세 설명</th>
                <td><textarea name="description" id="description" class="textarea_type01" style="height:120px;"><?php echo htmlspecialchars(isset($edit['description']) ? $edit['description'] : ''); ?></textarea></td>
              </tr>

              <tr>
                <th scope="row">대표 썸네일</th>
                <td>
                  <?php if (!empty($edit['thumb'])): ?>
                  <div style="margin-bottom:8px">
                    <img src="<?php echo normalize_port_img($edit['thumb']); ?>" style="max-height:80px;border:1px solid #e2e8f0;border-radius:4px;vertical-align:middle;">
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
                      <img src="<?php echo normalize_port_img($img_path); ?>" style="width:70px;height:70px;object-fit:cover;border:1px solid #e2e8f0;border-radius:4px;">
                      <label style="position:absolute;top:2px;right:2px;background:rgba(220,38,38,0.9);color:#fff;border-radius:3px;padding:1px 4px;font-size:11px;cursor:pointer">
                        <input type="checkbox" name="del_images[]" value="<?php echo htmlspecialchars($img_path); ?>" style="display:none"> ✕
                      </label>
                    </div>
                    <?php endforeach; ?>
                  </div>
                  <p class="exp" style="color:#64748b;font-size:12px;margin-bottom:8px">💡 ✕ 버튼을 누르면 체크되며 저장 시 해당 사진이 삭제됩니다.</p>
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
      <!-- ════════════════ 목록 (board_A0_L - 팝업과 동일한 포맷) ════════════════ -->

      <script type="text/javascript">
      $(function(){
          $('#btnSearch').click(function(){
              searchList();
          });
      });

      var searchList = function(){
          var frCat = $('#filterCat').val();
          var frSearch = $('#frSearch').val();
          location.href="admin_portfolio.php?cat="+encodeURI(frCat)+"&frSearch="+encodeURI(frSearch);
      }

      var EnterKey = function(){
          if(event.keyCode == 13){ searchList(); }
      }

      function delPort(id) {
          if (confirm('선택한 포트폴리오를 삭제하시겠습니까?')) {
              location.href = 'admin_portfolio.php?del=' + id;
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
      <div class="board_A0_L">
          <p class="count">총 <b><?=$totals?></b>건의 내용이 있습니다</p>
          <table summary="포트폴리오 관리 목록이며 번호, 썸네일, 광고유형, 광고명, 광고주, 지역, 노출여부, 메인노출, 정렬, 관리를 제공합니다.">
              <caption>포트폴리오 관리 목록</caption>
              <colgroup>
                  <col width="60" />
                  <col width="90" />
                  <col width="140" />
                  <col width="*" />
                  <col width="130" />
                  <col width="120" />
                  <col width="80" />
                  <col width="80" />
                  <col width="70" />
                  <col width="120" />
              </colgroup>
              <thead>
                  <tr>
                      <th scope="col" class="resp">번호</th>
                      <th scope="col">썸네일</th>
                      <th scope="col">광고유형</th>
                      <th scope="col">광고명</th>
                      <th scope="col">광고주</th>
                      <th scope="col">지역</th>
                      <th scope="col">노출여부</th>
                      <th scope="col">메인노출</th>
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
                          $status_txt = ($row['status'] === 'active') ? '<span style="color:#16a34a; font-weight:600;">공개</span>' : '<span style="color:#94a3b8;">비공개</span>';
                          $featured_txt = (!empty($row['is_featured'])) ? '<span style="color:#2563eb; font-weight:700;">노출</span>' : '-';
                  ?>
                  <tr>
                      <td class="resp"><?=$cnt?></td>
                      <td>
                          <a href="admin_portfolio.php?mode=modify&id=<?=$row['id']?>">
                              <img src="<?=$thumb_src?>" alt="" style="width:70px; height:46px; object-fit:cover; border:1px solid #e2e8f0; border-radius:3px; vertical-align:middle;">
                          </a>
                      </td>
                      <td><?=$cat_title?></td>
                      <td class="subject">
                          <a href="admin_portfolio.php?mode=modify&id=<?=$row['id']?>"><b><?=htmlspecialchars($row['title'])?></b></a>
                      </td>
                      <td><?=htmlspecialchars($row['client'] ? $row['client'] : '-')?></td>
                      <td><?=htmlspecialchars($row['location'] ? $row['location'] : '-')?></td>
                      <td><?=$status_txt?></td>
                      <td><?=$featured_txt?></td>
                      <td><?=$row['sort_order']?></td>
                      <td>
                          <a href="admin_portfolio.php?mode=modify&id=<?=$row['id']?>" class="btn_4 size_t rad_3">수정</a>
                          <a href="javascript:delPort(<?=$row['id']?>);" class="btn_3 size_t rad_3">삭제</a>
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

</body>
</html>