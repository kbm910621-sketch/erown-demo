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
    <section class="content email-page">
      <div class="email-wrap">
        <h1 class="email-title">이메일 무단수집 거부</h1>
        <div class="email-body">
          <p>
            본 웹사이트에 게시된 이메일 주소가 전자우편 수집 프로그램이나<br>
            그 밖의 기술적 장치를 이용하여 무단으로 수집되는 것을 거부하며,<br>
            이를 위반시 <strong>정보통신망법</strong>에 의해 형사처벌됨을 유념하시기 바랍니다.
          </p>
          <div class="email-law">
            <strong>정보통신망 이용촉진 및 정보보호 등에 관한 법률</strong><br><br>
            제 50조의 2 (전자우편주소의 무단 수집행위 등 금지)<br><br>
            ① 누구든지 전자우편주소의 수집을 거부하는 의사가 명시된 인터넷 홈페이지에서 자동으로
            전자우편주소를 수집하는 프로그램 그 밖의 기술적 장치를 이용하여 전자우편주소를
            수집하여서는 아니된다.<br><br>
            ② 누구든지 제1항의 규정을 위반하여 수집된 전자우편주소를 판매·유통하여서는 아니된다.<br><br>
            ③ 누구든지 제1항 및 제2항의 규정에 의하여 수집·판매 및 유통이 금지된 전자우편주소임을
            알고 이를 정보 전송에 이용하여서는 아니된다.<br><br>
            [시행일자 : 2003년 1월 1일]
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php"; ?>
</div>
</body>
</html>
