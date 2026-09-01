<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";


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
        header('Location: admin_portfolio.php?msg=modify');
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO portfolio (category,title,client,location,period_start,period_end,scale,description,thumb,images,is_featured,sort_order,status,created_at,updated_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())");
        mysqli_stmt_bind_param($stmt, 'ssssssssssiis',
            $category,$title,$client,$location,$period_start,$period_end,
            $scale,$description,$thumb,$images_json,$is_featured,$sort_order,$status
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: admin_portfolio.php?msg=write');
    }
    exit;
    
}



// ── 목록 조회 ──
$filter_cat = isset($_GET['cat']) ? $_GET['cat'] : '';
if ($filter_cat) {
    $fc     = mysqli_real_escape_string($conn, $filter_cat);
    $sql    = "SELECT * FROM portfolio WHERE category='$fc' ORDER BY sort_order ASC, id DESC";
} else {
    $sql    = "SELECT * FROM portfolio ORDER BY sort_order ASC, id DESC";
}
$result = mysqli_query($conn, $sql);
$list   = array();
while ($row = mysqli_fetch_assoc($result)) { $list[] = $row; }
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
                    <img src="<?php echo htmlspecialchars($edit['thumb']); ?>" style="max-width:200px;max-height:120px;border:1px solid #ddd;border-radius:4px">
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
                  <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px">
                    <?php foreach ($edit_imgs as $img): ?>
                    <div style="position:relative">
                      <img src="<?php echo htmlspecialchars($img); ?>" style="width:72px;height:72px;object-fit:cover;border:1px solid #ddd;border-radius:4px">
                      <label style="position:absolute;top:-6px;right:-6px;width:18px;height:18px;border-radius:50%;background:#e53e3e;color:#fff;font-size:11px;display:flex;align-items:center;justify-content:center;cursor:pointer">
                        <input type="checkbox" name="del_images[]" value="<?php echo htmlspecialchars($img); ?>" style="display:none">✕
                      </label>
                    </div>
                    <?php endforeach; ?>
                  </div>
                  <p class="exp">✕ 클릭 체크 후 저장하면 삭제됩니다</p>
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

        <div class="port-tabs" style="margin-bottom:24px">
        <a href="admin_portfolio.php" class="port-tab <?php echo !$filter_cat ? 'on' : ''; ?>">전체</a>
        <?php foreach ($categories as $k => $v): ?>
        <a href="admin_portfolio.php?cat=<?php echo $k; ?>" class="port-tab <?php echo $filter_cat === $k ? 'on' : ''; ?>"><?php echo $v; ?></a>
        <?php endforeach; ?>
        </div>

        <?php if (empty($list)): ?>
<p style="color:#999;font-size:14px;padding:40px 0;text-align:center">등록된 포트폴리오가 없습니다.</p>
<?php else: ?>
<div class="port-grid">
    <?php foreach ($list as $row): ?>
    <div class="port-item show">
        <div class="port-thumb">
        <?php if ($row['thumb']): ?>
        <img src="<?php echo htmlspecialchars($row['thumb']); ?>" style="width:100%;height:100%;object-fit:cover">
        <?php else: ?>
        <span>이미지 없음</span>
        <?php endif; ?>
        </div>
        <div class="port-info">
        <div class="port-cat"><?php echo isset($categories[$row['category']]) ? $categories[$row['category']] : $row['category']; ?></div>
        <div class="port-name"><?php echo htmlspecialchars($row['title']); ?></div>
        <div class="port-loc"><?php echo htmlspecialchars($row['location'] ? $row['location'] : '-'); ?></div>
        <div class="port-admin-bar">
            <div style="display:flex;align-items:center;gap:6px">
            <?php if ($row['is_featured']): ?>
            <span style="background:#0D2347;color:#fff;font-size:10px;padding:2px 7px;border-radius:3px">메인</span>
            <?php endif; ?>
            <span style="font-size:11px;color:<?php echo $row['status']==='active' ? '#2E7D32' : '#999'; ?>">
                <?php echo $row['status']==='active' ? '● 공개' : '● 비공개'; ?>
            </span>
            </div>
            <div style="display:flex;gap:4px">
            <a href="admin_portfolio.php?mode=modify&id=<?php echo $row['id']; ?>" class="btn_2 size_s">수정</a>
            <a href="admin_portfolio.php?del=<?php echo $row['id']; ?>" class="btn_2 size_s" onclick="return confirm('삭제하시겠습니까?')">삭제</a>
            </div>
        </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<!-- ✅ foreach 밖으로 이동 -->
<div id="portPaging" style="display:flex;justify-content:center;gap:6px;margin-top:24px"></div>
<?php endif; ?>

        <div class="button a_r mat_30">
          <input type="button" class="btn_1 size_n" value="등록" onclick="location.href='admin_portfolio.php?mode=write'">
        </div>

      <?php endif; ?>

    </section>
  </div>
</div>

</body>
</html>