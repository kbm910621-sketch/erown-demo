<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";
?>
<body>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/blank.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/skip.php"; ?>

<div id="wrap">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php"; ?>

  <div id="container">
    <section class="content email-policy-page">
      
            <!-- DEDICATED CLEAN SUBPAGE HEADER -->
      <div class="email-page-header wow fadeInUp" data-wow-duration="0.6s">
        <span class="eph-kicker">GAON-N POLICY &amp; LEGAL</span>
        <h1 class="eph-title">이메일 <span>무단수집 거부</span></h1>
        <p class="eph-desc">
          (주)가온엔은 정보주체의 개인정보와 권익을 보호하고 무단 수집 및 불법 스팸 전송을 엄격히 금지합니다.
        </p>
      </div>

      <!-- MAIN LEGAL CONTENT CONTAINER -->
      <div class="email-policy-wrap wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
        
        <!-- 01 CORE NOTICE CALLOUT -->
        <div class="epc-notice-card">
          <div class="epc-shield-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#1855b7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <div class="epc-notice-text">
            <strong class="epc-notice-title">이메일 무단 수집 거부 기본 방침</strong>
            <p class="epc-notice-desc">
              본 웹사이트에 게시된 이메일 주소가 <strong>전자우편 수집 프로그램이나 그 밖의 기술적 장치</strong>를 이용하여 무단으로 수집되는 것을 거부하며, 이를 위반 시 <strong>「정보통신망 이용촉진 및 정보보호 등에 관한 법률」</strong>에 의해 형사처벌됨을 유념하시기 바랍니다.
            </p>
          </div>
        </div>

        <!-- 02 LAW CLAUSES (3 CARDS) -->
        <div class="epc-section-block">
          <div class="epc-sec-head">
            <span class="epc-num-badge">01</span>
            <h2 class="epc-sec-title">정보통신망법 관련 조항 안내</h2>
          </div>
          
          <div class="epc-clauses-grid">
            <div class="epc-clause-card">
              <span class="ecc-tag">제50조의2 ①항</span>
              <strong class="ecc-title">전자우편주소 무단 수집 금지</strong>
              <p class="ecc-desc">
                누구든지 전자우편주소의 수집을 거부하는 의사가 명시된 인터넷 홈페이지에서 자동으로 전자우편주소를 수집하는 프로그램이나 그 밖의 기술적 장치를 이용하여 전자우편주소를 수집하여서는 아니 된다.
              </p>
            </div>

            <div class="epc-clause-card">
              <span class="ecc-tag">제50조의2 ②항</span>
              <strong class="ecc-title">수집 주소의 판매·유통 금지</strong>
              <p class="ecc-desc">
                누구든지 제1항의 규정을 위반하여 수집된 전자우편주소를 영리 목적으로 판매하거나 제3자에게 유통하여서는 아니 된다.
              </p>
            </div>

            <div class="epc-clause-card">
              <span class="ecc-tag">제50조의2 ③항</span>
              <strong class="ecc-title">불법 주소 이용 정보 전송 금지</strong>
              <p class="ecc-desc">
                누구든지 제1항 및 제2항의 규정에 의하여 수집·판매 및 유통이 금지된 전자우편주소임을 알고 이를 광고성 정보 전송에 이용하여서는 아니 된다.
              </p>
            </div>
          </div>
        </div>

        <!-- 03 PENALTIES & PUNISHMENT -->
        <div class="epc-section-block">
          <div class="epc-sec-head">
            <span class="epc-num-badge">02</span>
            <h2 class="epc-sec-title">위반 시 처벌 규정 안내</h2>
          </div>

          <div class="epc-penalty-card">
            <div class="ep-law-ref">정보통신망 이용촉진 및 정보보호 등에 관한 법률 제74조 (벌칙)</div>
            <p class="ep-penalty-txt">
              위의 제50조의2 규정을 위반하여 <strong>전자우편주소를 수집·판매·유통하거나 이를 정보 전송에 이용한 자</strong>는 
              <span class="ep-highlight">1년 이하의 징역 또는 1천만 원 이하의 벌금</span>에 처해집니다.
            </p>
            <div class="ep-date-info">
              <span>※ 게시일자 : 2026년 3월 1일 (최초 시행 : 2003년 1월 1일)</span>
            </div>
          </div>
        </div>

        <!-- 04 INQUIRY & COMPLAINT REPORT -->
        <div class="epc-section-block">
          <div class="epc-sec-head">
            <span class="epc-num-badge">03</span>
            <h2 class="epc-sec-title">침해 사실 신고 및 고객 문의</h2>
          </div>

          <div class="epc-contact-grid">
            <div class="ep-contact-box">
              <strong class="ecb-title">(주)가온엔 공식 담당처</strong>
              <div class="ecb-list">
                <span><em>대표전화</em> 062-385-0110</span>
                <span><em>직통문의</em> 062-381-1350</span>
                <span><em>대표이메일</em> lgmo123@naver.com</span>
                <span><em>상담시간</em> 평일 09:30 – 18:30 (주말·공휴일 휴무)</span>
              </div>
            </div>

            <div class="ep-contact-box">
              <strong class="ecb-title">불법 스팸 및 침해 전문 신고기관</strong>
              <div class="ecb-list">
                <span><em>KISA 불법스팸대응센터</em> 국번없이 118 (<a href="https://spam.kisa.or.kr" target="_blank" rel="noopener">spam.kisa.or.kr</a>)</span>
                <span><em>개인정보침해신고센터</em> 국번없이 118 (<a href="https://privacy.kisa.or.kr" target="_blank" rel="noopener">privacy.kisa.or.kr</a>)</span>
                <span><em>경찰청 사이버수사국</em> 국번없이 182 (<a href="https://ecrm.police.go.kr" target="_blank" rel="noopener">ecrm.police.go.kr</a>)</span>
              </div>
            </div>
          </div>
        </div>

        <!-- BOTTOM ACTION -->
        <div class="epc-bottom-cta">
          <a href="/board/estmate/write.php" class="epc-cta-btn">
            <span>1:1 광고 견적 및 문의 바로가기</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
        </div>

      </div>

    </section>
  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/bottom_conversion.php"; ?>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php"; ?>
</div>
</body>
</html>
