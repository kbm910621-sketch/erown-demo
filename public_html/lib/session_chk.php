<?php
//로그인 확인
if($_SESSION['MID']==''){
    echo "
    <script>
    window.alert('로그인 후에 이용하실 수 있습니다.');
    location.href='/admin/login.php'
    </script>
    ";
    exit;
}
?>
