<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/gnb_set.php";?>
<?php 
//페이지 타이틀
$sql = "SELECT * FROM title";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);


$pageName = basename($_SERVER['PHP_SELF']); //페이지이름
$dirPage = strtolower(dirname($_SERVER['PHP_SELF'])); //폴더이름

if(strstr($pageName,"index")){
    $page_title = $row['tit_ch1'];
}else if(strstr($dirPage,"a_type")){
    $page_title = $row['tit_ch2'];
}else if(strstr($dirPage,"b_type")){
    $page_title = $row['tit_ch3'];
}else if(strstr($dirPage,"c_type")){
    $page_title = $row['tit_ch4'];
}else if(strstr($dirPage,"d_type")){
    $page_title = $row['tit_ch5'];
}else if(strstr($dirPage,"e_type")){
    $page_title = $row['tit_ch6'];
}else if(strstr($dirPage,"f_type")){
    $page_title = $row['tit_ch7'];
}else if(strstr($dirPage,"g_type")){
    $page_title = $row['tit_ch8'];
}else if(strstr($dirPage,"h_type")){
    $page_title = $row['tit_ch9'];
}else if(strstr($dirPage,"i_type")){
    $page_title = $row['tit_ch10'];
}else if(strstr($dirPage,"j_type")){
    $page_title = $row['tit_ch11'];
}else if(strstr($dirPage,"k_type")){
    $page_title = $row['tit_ch12'];
}else if(strstr($dirPage,"board")){
    $page_title = $row['tit_ch13'];
}else{
    $page_title = $row['tit_ch1'];
}

//페이지 키워드
$sql = "SELECT * FROM keyword";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$key_title = $row['key_ch1'];
$key_url = $row['key_ch2'];
$key_img = $row['key_ch3'];
$key_word = $row['key_ch4'];
$key_desc = $row['key_ch5'];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />
<meta name="format-detection" content="telephone=no" /><!-- 전화번호 자동링크 없애기 -->

<link rel="canonical" href="<?php echo $key_url?>">

<meta name="keywords" content="<?php echo $key_word?>"><!-- 키워드 제공 -->
<meta name="description" content="<?php echo $key_desc?>"><!-- 요약정보 -->
<meta name="robots" content="all"><!-- 검색로봇 -->

<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo $key_title?>">
<meta property="og:description" content="<?php echo $key_desc?>">
<meta property="og:image" content="<?php echo $key_img?>">
<meta property="og:url" content="<?php echo $key_url?>">

<link type="text/css" rel="stylesheet" href="/css/import.css">
<link type="text/css" rel="stylesheet" href="/css/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="/css/animate.css">
<script src="/js/jquery-1.12.4.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/design.js"></script>
<script src="/js/checkform.js"></script>
<script src="/js/wow.min.js"></script>
<script src="/js/jquery.bxslider.js"></script>
<!-- <link rel="shortcut icon" href="/images/ge.ico" type="image/x-icon"> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<title><?php echo $page_title?></title>
</head>
