<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$est_uid_arr = $_POST['est_uid'];

if (is_array($est_uid_arr)) {
    // 복수 삭제 (리스트 체크박스)
    foreach ($est_uid_arr as $uid) {
        $uid = mysqli_real_escape_string($conn, $uid);
        mysqli_query($conn, "DELETE FROM estmate WHERE est_uid = '$uid'");
    }
    echo "<script type='text/javascript'>alert('삭제했습니다.'); location.href='list.php';</script>";
} else {
    // 단일 삭제 (뷰에서 삭제 버튼)
    $uid = mysqli_real_escape_string($conn, $est_uid_arr);
    $result = mysqli_query($conn, "DELETE FROM estmate WHERE est_uid = '$uid'");
    if ($result === false) {
        echo '저장하는 과정에서 문제가 생겼습니다.';
        error_log(mysqli_error($conn));
    } else {
        echo "<script type='text/javascript'>alert('글을 삭제했습니다'); location.href='list.php';</script>";
    }
}
?>