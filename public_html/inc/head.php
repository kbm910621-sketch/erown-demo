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

<!-- ============================================
     GAON-N ADVANCED SEO & GEO (AI SEARCH OPTIMIZATION) SCHEMAS
============================================ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "AdvertisingAgency",
      "@id": "https://gaon-n.com/#organization",
      "name": "주식회사 가온엔 (GAON-N)",
      "alternateName": ["가온엔", "GAON-N", "광주 옥외광고 가온엔", "광주 시내버스광고 가온엔"],
      "url": "https://gaon-n.com",
      "logo": "https://gaon-n.com/images/logo.png",
      "image": "https://gaon-n.com/images/bs_ad/main_sec02_img.jpg",
      "description": "광주 104개 전 노선 시내버스 3면 래핑 광고 공식 직영사, 네이버 스마트플레이스 1위 세팅, C-Rank 브랜드 블로그, 4K UHD 시네마틱 홍보영상 제작 전문 종합 광고대행사",
      "telephone": "062-385-0110",
      "priceRange": "$",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "광주광역시 서구 상무중앙로 78, 4층",
        "addressLocality": "서구",
        "addressRegion": "광주광역시",
        "postalCode": "61964",
        "addressCountry": "KR"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 35.1534,
        "longitude": 126.8521
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
          "opens": "09:00",
          "closes": "18:00"
        }
      ],
      "areaServed": [
        {"@type": "AdministrativeArea", "name": "광주광역시"},
        {"@type": "AdministrativeArea", "name": "광주 서구"},
        {"@type": "AdministrativeArea", "name": "광주 남구"},
        {"@type": "AdministrativeArea", "name": "광주 동구"},
        {"@type": "AdministrativeArea", "name": "광주 북구"},
        {"@type": "AdministrativeArea", "name": "광주 광산구"},
        {"@type": "AdministrativeArea", "name": "전라남도"},
        {"@type": "AdministrativeArea", "name": "나주시"}
      ],
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "가온엔 통합 마케팅 서비스",
        "itemListElement": [
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "광주 시내버스 3면 래핑 옥외광고",
              "description": "광주 104개 노선 1일 18시간 운행 차도면 3.7m + 인도면 3m + 후면 2.4m 직영 시공"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "네이버 스마트플레이스 1위 최적화 세팅",
              "description": "광주 주요 상권 키워드 상위 1~3위 노출 및 영수증 리뷰 유입 최적화"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "C-Rank 브랜드 블로그 마케팅",
              "description": "전문 에디터 1:1 맞춤 칼럼 기획 및 네이버 뷰탭 상단 노출"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "4K UHD 시네마틱 브랜드 영상 및 숏폼 제작",
              "description": "인하우스 프로덕션 직접 기획·촬영·편집 홍보영상 및 인스타그램 릴스"
            }
          }
        ]
      }
    },
    {
      "@type": "WebSite",
      "@id": "https://gaon-n.com/#website",
      "url": "https://gaon-n.com",
      "name": "가온엔 - 광주 옥외광고 & 디지털 통합 마케팅 대행사",
      "publisher": {
        "@id": "https://gaon-n.com/#organization"
      }
    }
  ]
}
</script>

</head>
