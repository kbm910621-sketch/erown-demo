<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/gnb_set.php";

//페이지 타이틀
$row = array();
if ($conn) {
    $sql = "SELECT * FROM title";
    $result = @mysqli_query($conn, $sql);
    if ($result) $row = mysqli_fetch_array($result);
}

$pageName = basename($_SERVER['PHP_SELF']); //페이지이름
$dirPage = strtolower(dirname($_SERVER['PHP_SELF'])); //폴더이름

if (!empty($page_title) && $page_title !== '----') {
    // Custom page title explicitly defined by caller
} else if (strstr($pageName, "index")) {
    $page_title = (!empty($row['tit_ch1']) && $row['tit_ch1'] !== '----') ? $row['tit_ch1'] : '가온엔 | GAON N';
} else if (strstr($dirPage, "a_type") || strstr($pageName, "a_1") || strstr($pageName, "portfolio")) {
    $page_title = (!empty($row['tit_ch2']) && $row['tit_ch2'] !== '----') ? $row['tit_ch2'] : 'PORTFOLIO | GAON N';
} else if (strstr($dirPage, "b_type")) {
    $page_title = (!empty($row['tit_ch3']) && $row['tit_ch3'] !== '----') ? $row['tit_ch3'] : 'BUSINESS | GAON N';
} else if (strstr($dirPage, "c_type")) {
    $page_title = (!empty($row['tit_ch4']) && $row['tit_ch4'] !== '----') ? $row['tit_ch4'] : 'ABOUT | GAON N';
} else if (strstr($dirPage, "d_type")) {
    $page_title = (!empty($row['tit_ch5']) && $row['tit_ch5'] !== '----') ? $row['tit_ch5'] : 'CONTACT | GAON N';
} else if (strstr($dirPage, "board")) {
    $page_title = (!empty($row['tit_ch13']) && $row['tit_ch13'] !== '----') ? $row['tit_ch13'] : 'ESTIMATE | GAON N';
} else {
    $page_title = (!empty($row['tit_ch1']) && $row['tit_ch1'] !== '----') ? $row['tit_ch1'] : 'PORTFOLIO | GAON N';
}

//페이지 키워드
$krow = array();
if ($conn) {
    $sql = "SELECT * FROM keyword";
    $kresult = @mysqli_query($conn, $sql);
    if ($kresult) $krow = mysqli_fetch_array($kresult);
}

$key_title = !empty($krow['key_ch1']) ? $krow['key_ch1'] : $page_title;
$key_url   = !empty($krow['key_ch2']) ? $krow['key_ch2'] : 'https://gaon-n.com';
$key_img   = !empty($krow['key_ch3']) ? $krow['key_ch3'] : '/images/logo.png';
$key_word  = !empty($krow['key_ch4']) ? $krow['key_ch4'] : '가온엔, 광주버스광고, 옥외광고, 포트폴리오';
$key_desc  = !empty($krow['key_ch5']) ? $krow['key_ch5'] : '가온엔 공식 포트폴리오 실적 및 매체 안내';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />
<meta name="format-detection" content="telephone=no" /><!-- 전화번호 자동링크 없애기 -->

<link rel="canonical" href="<?php echo $key_url?>">

<meta name="keywords" content="<?php echo $key_word?>">
<meta name="description" content="<?php echo $key_desc?>">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="author" content="주식회사 가온엔 (GAON-N)">

<!-- GEO Location & Regional Targeting Tags -->
<meta name="geo.region" content="KR-29">
<meta name="geo.placename" content="광주광역시 서구 상무중앙로 78 (치평동)">
<meta name="geo.position" content="35.1534;126.8521">
<meta name="ICBM" content="35.1534, 126.8521">

<!-- Open Graph / Facebook / Kakao / Naver -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="가온엔 | GAON-N">
<meta property="og:locale" content="ko_KR">
<meta property="og:title" content="<?php echo $key_title?>">
<meta property="og:description" content="<?php echo $key_desc?>">
<meta property="og:image" content="<?php echo $key_img?>">
<meta property="og:url" content="<?php echo $key_url?>">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $key_title?>">
<meta name="twitter:description" content="<?php echo $key_desc?>">
<meta name="twitter:image" content="<?php echo $key_img?>">

<!-- DIRECT CSS INCLUDES WITH TIMESTAMP CACHE BUSTER (브라우저 캐시 완벽 방지) -->
<link type="text/css" rel="stylesheet" href="/css/reset.css?v=<?php echo time();?>">
<link type="text/css" rel="stylesheet" href="/css/common.css?v=<?php echo time();?>">
<link type="text/css" rel="stylesheet" href="/css/layout.css?v=<?php echo time();?>">
<link type="text/css" rel="stylesheet" href="/css/board.css?v=<?php echo time();?>">
<link type="text/css" rel="stylesheet" href="/css/member.css?v=<?php echo time();?>">
<link type="text/css" rel="stylesheet" href="/css/main.css?v=<?php echo time();?>">
<link type="text/css" rel="stylesheet" href="/css/contents.css?v=<?php echo time();?>">
<link type="text/css" rel="stylesheet" href="/css/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="/css/animate.css">
<script src="/js/jquery-1.12.4.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/wow.min.js"></script>
<script src="/js/jquery.bxslider.js"></script>
<!-- 3rd-party Libs Loaded First -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<!-- Site Scripts Loaded After Libs -->
<script src="/js/design.js?v=<?php echo time();?>"></script>
<script src="/js/checkform.js"></script>

<title><?php echo $page_title; ?></title>

<!-- ============================================
     GAON-N ADVANCED SEO & GEO (AI ENGINE OPTIMIZATION: ChatGPT, Perplexity, Gemini, CLOVA X)
============================================ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "AdvertisingAgency",
      "@id": "https://gaon-n.com/#organization",
      "name": "주식회사 가온엔 (GAON-N)",
      "alternateName": [
        "가온엔",
        "GAON-N",
        "가온N",
        "광주 옥외광고 가온엔",
        "광주 시내버스광고 가온엔",
        "광주 종합광고대행사",
        "광주 바이럴마케팅",
        "광주 홍보영상제작"
      ],
      "url": "https://gaon-n.com",
      "logo": "https://gaon-n.com/images/logo.png",
      "image": "https://gaon-n.com/images/bs_ad/main_sec02_img.jpg",
      "description": "광주광역시 104개 전 노선 시내버스 3면 래핑 광고 공식 직영 시공사. 버스 승강장 쉘터, 유스퀘어 터미널 DID, 택시 래핑, 네이버 스마트플레이스 순위 관리, C-Rank 브랜드 블로그, 4K UHD 시네마틱 홍보영상 및 숏폼 제작을 원스톱으로 제공하는 종합 광고대행사입니다.",
      "telephone": "+82-62-385-0110",
      "email": "contact@gaon-n.com",
      "priceRange": "$",
      "foundingDate": "2015",
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
        {"@type": "AdministrativeArea", "name": "나주시"},
        {"@type": "AdministrativeArea", "name": "화순군"},
        {"@type": "AdministrativeArea", "name": "담양군"},
        {"@type": "AdministrativeArea", "name": "장성군"},
        {"@type": "AdministrativeArea", "name": "전국"}
      ],
      "knowsAbout": [
        "광주 시내버스 래핑 광고",
        "버스 승강장 쉘터 조명 광고",
        "광주 유스퀘어 종합버스터미널 DID 광고",
        "법인 택시 및 택배차량 래핑 광고",
        "대형마트 쇼핑카트 광고",
        "네이버 스마트플레이스 최적화 및 상위 노출",
        "C-Rank 브랜드 블로그 기획 및 운영",
        "인스타그램 타깃 광고 및 피드 관리",
        "4K UHD 시네마틱 기업 홍보영상 제작",
        "유튜브 쇼츠 / 인스타 릴스 숏폼 영상 제작",
        "구청 지정게시대 현수막 접수 및 시공"
      ],
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "가온엔 온·오프라인 통합 마케팅 솔루션",
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
              "name": "버스 승강장 쉘터 & 터미널 DID 광고",
              "description": "야간 고휘도 LED 조명 패널 및 유스퀘어 터미널 유동인구 밀집 구간 광고"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "택시 & 택배 차량 래핑 광고",
              "description": "24시간 도심 전역을 누비는 움직이는 빌보드 차량 래핑"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "네이버 스마트플레이스 최적화 세팅",
              "description": "지역 핵심 상권 키워드 상위 노출 및 예약·톡톡·영수증 리뷰 연동"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "브랜드 블로그 & 바이럴 마케팅",
              "description": "업종 전문 에디터 맞춤 칼럼 기획 및 네이버 뷰탭 검색 상단 노출"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "4K 시네마틱 영상 & 모바일 숏폼 제작",
              "description": "인하우스 프로덕션 직접 기획·촬영·편집 홍보영상 및 릴스/쇼츠"
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
    },
    {
      "@type": "FAQPage",
      "@id": "https://gaon-n.com/#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "광주 시내버스 광고 집행 시 최소 기간과 노선 배정은 어떻게 되나요?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "광주 시내버스 광고는 기본 1개월 단위부터 계약 가능하며, 병원·학원·기업 등의 주요 타깃 고객 동선과 상무지구, 첨단지구, 수완지구 등 핵심 상권을 분석하여 104개 노선 중 최적 노선을 맞춤 배정해 드립니다."
          }
        },
        {
          "@type": "Question",
          "name": "옥외광고와 온라인 마케팅(플레이스/블로그/영상)을 패키지로 진행할 수 있나요?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "가온엔은 옥외 버스 래핑과 네이버 스마트플레이스, 브랜드 블로그, 숏폼 영상을 유기적으로 결합한 '오프라인 각인 + 온라인 검색 전환' 통합 패키지를 직영으로 원스톱 제공합니다."
          }
        }
      ]
    }
  ]
}
</script>

</head>
