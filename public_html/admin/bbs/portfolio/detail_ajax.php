<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
header('Content-Type: application/json; charset=utf-8');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { echo json_encode(array()); exit; }

$result = mysqli_query($conn, "SELECT * FROM portfolio WHERE id = $id AND status = 'active' LIMIT 1");
$row    = mysqli_fetch_assoc($result);
if (!$row) { echo json_encode(array()); exit; }

$categories = array(
    'bus'    => '버스 광고',
    'taxi'   => '택시 광고',
    'did'    => 'DID 광고',
    'print'  => '인쇄물·현수막',
    'online' => '온라인 마케팅',
    'web'    => '홈페이지제작',
    'mart'   => '마트 광고',
);

$images = json_decode($row['images'] ? $row['images'] : '[]', true);
if (!is_array($images)) $images = array();
if ($row['thumb']) array_unshift($images, $row['thumb']);
$images = array_values(array_unique($images));

// 이미지 HTML (slides만 - 버튼/dots는 HTML에 고정)
ob_start();
if (!empty($images)) {
    echo '<div class="modal-slides">';
    foreach ($images as $i => $img) {
        echo '<div class="modal-slide ' . ($i === 0 ? 'on' : '') . '">';
        echo '<img src="' . htmlspecialchars($img) . '" style="width:100%;height:100%;object-fit:cover">';
        echo '</div>';
    }
    echo '</div>';
    // dots
    echo '<div class="modal-slide-nav" id="modalDots">';
    foreach ($images as $i => $img) {
        echo '<div class="modal-dot ' . ($i === 0 ? 'on' : '') . '" onclick="slideTo(' . $i . ')"></div>';
    }
    echo '</div>';
}
$img_html = ob_get_clean();

// 기간
$period = '';
if ($row['period_start']) {
    $period = substr($row['period_start'], 0, 7);
    if ($row['period_end']) $period .= ' ~ ' . substr($row['period_end'], 0, 7);
}

$cat_label = isset($categories[$row['category']]) ? $categories[$row['category']] : '';

$tags_html = '<span class="modal-tag">' . $cat_label . '</span>';
if ($row['location']) $tags_html .= '<span class="modal-tag">' . htmlspecialchars($row['location']) . '</span>';

echo json_encode(array(
    'img_html'   => $img_html,
    'cat'        => $cat_label,
    'title'      => $row['title'],
    'loc'        => $row['location'] ? $row['location'] : '',
    'type_label' => $cat_label,
    'period'     => $period,
    'scale'      => $row['scale'] ? $row['scale'] : '',
    'tags_html'  => $tags_html,
));