<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$est_uid_input = isset($_POST['est_uid']) ? $_POST['est_uid'] : null;

if (!empty($est_uid_input)) {
    $ids = array();
    if (is_array($est_uid_input)) {
        foreach ($est_uid_input as $uid) {
            $n = (int)$uid;
            if ($n > 0) $ids[] = $n;
        }
    } else {
        $n = (int)$est_uid_input;
        if ($n > 0) $ids[] = $n;
    }

    if (!empty($ids)) {
        $id_str = implode(',', $ids);
        $result = mysqli_query($conn, "DELETE FROM estmate WHERE est_uid IN ($id_str)");
        if ($result === false) {
            echo "<script type='text/javascript'>alert('삭제 처리 중 오류가 발생했습니다.'); history.back();</script>";
            error_log(mysqli_error($conn));
            exit;
        }
        $count = count($ids);
        echo "<script type='text/javascript'>alert('{$count}건의 항목을 삭제했습니다.'); location.href='list.php';</script>";
        exit;
    }
}

echo "<script type='text/javascript'>alert('삭제할 항목이 선택되지 않았습니다.'); location.href='list.php';</script>";
?>