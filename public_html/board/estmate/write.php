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

    <section class="content contact-page">
      <div class="contact-align-container">

        <!-- 페이지 헤더 (폼 좌측 라인과 칼정렬) -->
        <div class="port-page-head">
          <h1 class="port-page-title wow fadeInUp" data-wow-duration="0.6s">광고 <span>상담신청</span></h1>
          <p class="port-page-desc wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.1s"><strong>광고</strong>전문기업, <strong>가온엔</strong>과 함께해보세요!</p>
        </div>

        <!-- CONSULT SECTION: 폼 -->
        <div class="contact-consult-wrap">
          <div class="contact-consult-section">

            <div class="consult-right">
              <form name="frm" id="contactForm" method="post" action="process_write.php">

                <!-- 01 회사 정보 -->
                <div class="cf-section-head first anim">
                  <span class="cf-num">01</span>
                  <span class="cf-stitle">회사 정보</span>
                </div>
                <div class="cf-row anim">
                  <div class="cf-field">
                    <label>회사명 <span>*</span></label>
                    <input type="text" name="in_company" id="in_company" class="cf-input" placeholder="회사명을 입력하세요" required>
                  </div>
                  <div class="cf-field">
                    <label>담당자명 <span>*</span></label>
                    <input type="text" name="in_name" id="in_name" class="cf-input" placeholder="담당자명을 입력하세요" required>
                  </div>
                </div>
                <div class="cf-field anim">
                  <label>직급</label>
                  <select name="in_position" id="in_position" class="cf-select cf-select-sm">
                    <option value="">선택하세요</option>
                    <option value="사원">사원</option>
                    <option value="대리">대리</option>
                    <option value="과장">과장</option>
                    <option value="차장">차장</option>
                    <option value="부장">부장</option>
                    <option value="이사">이사</option>
                    <option value="대표">대표</option>
                  </select>
                </div>

                <!-- 02 연락처 정보 -->
                <div class="cf-section-head anim">
                  <span class="cf-num">02</span>
                  <span class="cf-stitle">연락처 정보</span>
                </div>
                <div class="cf-row anim">
                  <div class="cf-field">
                    <label>연락처 <span>*</span></label>
                    <input type="text" name="in_tel" id="in_tel" class="cf-input" placeholder="010-0000-0000" maxlength="13" onkeyup="this.value=this.value.replace(/[^0-9-]/g,'')" required>
                  </div>
                  <div class="cf-field">
                    <label>이메일 <span>*</span></label>
                    <input type="email" name="in_email" id="in_email" class="cf-input" placeholder="example@email.com" required>
                  </div>
                </div>

                <!-- 03 광고 문의 -->
                <div class="cf-section-head anim">
                  <span class="cf-num">03</span>
                  <span class="cf-stitle">광고 문의</span>
                </div>
                <div class="cf-field anim">
                  <label>광고 유형 <span>*</span></label>
                  <div class="cf-checks">
                    <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t1" value="버스 광고" checked><label for="t1">버스 광고</label>
                    <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t2" value="택시 광고"><label for="t2">택시 광고</label>
                    <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t3" value="DID 광고"><label for="t3">DID 광고</label>
                    <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t4" value="인쇄물·현수막"><label for="t4">인쇄물·현수막</label>
                    <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t5" value="온라인 마케팅"><label for="t5">온라인 마케팅</label>
                    <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t6" value="홈페이지 제작"><label for="t6">홈페이지 제작</label>
                    <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t7" value="마트 광고"><label for="t7">마트 광고</label>
                    <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t8" value="기타"><label for="t8">기타</label>
                  </div>
                </div>
                <div class="cf-field anim">
                  <label>문의 내용</label>
                  <textarea name="in_memo" id="in_memo" class="cf-textarea" maxlength="500" placeholder="문의 내용을 자유롭게 작성해주세요."></textarea>
                </div>

                <!-- 개인정보 동의 -->
                <div class="cf-agree-wrap anim">
                  <div class="cf-agree-box">
                    수집하는 개인정보 항목: 회사명, 담당자명, 연락처, 이메일<br>
                    수집 목적: 광고 상담 및 견적 안내 &nbsp;/&nbsp; 보유 기간: 상담 완료 후 1년
                  </div>
                  <label class="cf-agree-check">
                    <input type="checkbox" id="agree" name="agree" value="Y" checked required>
                    <span>개인정보 수집 및 이용에 동의합니다.</span>
                  </label>
                </div>

                <!-- 버튼 -->
                <div class="cf-btns anim">
                  <input type="submit" class="cf-btn-submit" id="btn_submit" value="상담 신청하기">
                </div>

              </form>
            </div>

          </div>
        </div>

      </div>
    </section>

  </div><!-- /#container -->

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php"; ?>
</div><!-- /#wrap -->

</body>
</html>
