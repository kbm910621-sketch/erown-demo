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

            <!-- SUBPAGE HEADER -->
      <div class="estimate-page-header wow fadeInUp" data-wow-duration="0.6s">
        <span class="eph-kicker">GAON-N 1:1 CONSULTING &amp; ESTIMATE</span>
        <h1 class="eph-title">1:1 맞춤 <span>견적 상담 신청</span></h1>
        <p class="eph-desc">
          광주 104개 시내버스부터 스마트플레이스, 4K 시네마 영상까지 외주 없는 본사 전문팀이 최적의 미디어 플랜을 제안해 드립니다.
        </p>
      </div>
              <div class="cf-field anim">
                <label>직급</label>
                <select name="in_position" id="in_position" class="cf-select cf-select-sm">
                  <option value="">직급을 선택하세요</option>
                  <option value="대표">대표</option>
                  <option value="원장">원장</option>
                  <option value="이사">이사</option>
                  <option value="부장">부장</option>
                  <option value="팀장">팀장</option>
                  <option value="과장">과장</option>
                  <option value="대리">대리</option>
                  <option value="담당자">담당자</option>
                </select>
              </div>

              <!-- 02 연락처 정보 -->
              <div class="cf-section-head anim">
                <span class="cf-num">02</span>
                <span class="cf-stitle">연락처 및 회신 정보</span>
              </div>
              <div class="cf-row anim">
                <div class="cf-field">
                  <label>연락처 <span>*</span></label>
                  <input type="text" name="in_tel" id="in_tel" class="cf-input" placeholder="010-0000-0000" maxlength="13" onkeyup="this.value=this.value.replace(/[^0-9-]/g,'')" required>
                </div>
                <div class="cf-field">
                  <label>이메일 (견적서 수신) <span>*</span></label>
                  <input type="email" name="in_email" id="in_email" class="cf-input" placeholder="example@naver.com" required>
                </div>
              </div>

              <!-- 03 광고 문의 -->
              <div class="cf-section-head anim">
                <span class="cf-num">03</span>
                <span class="cf-stitle">희망 광고 매체 및 상담 내용 (중복 선택 가능)</span>
              </div>
              <div class="cf-field anim">
                <label>관심 매체 선택 <span>*</span></label>
                <div class="cf-checks">
                  <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t1" value="시내버스 외부 광고" checked><label for="t1">시내버스 외부 광고</label>
                  <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t2" value="시내버스 내부·음성"><label for="t2">시내버스 내부·음성</label>
                  <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t3" value="네이버 스마트플레이스 1위"><label for="t3">스마트플레이스 1위</label>
                  <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t4" value="C-Rank 브랜드 블로그"><label for="t4">C-Rank 블로그</label>
                  <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t5" value="4K 영상제작 · 모바일 릴스"><label for="t5">4K 영상 · 모바일 릴스</label>
                  <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t6" value="택시 · 택배차량 래핑"><label for="t6">택시 · 택배차량 래핑</label>
                  <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t7" value="마트 카트 · DID 전광판"><label for="t7">마트 카트 · DID 전광판</label>
                  <input type="checkbox" class="cf-chk" name="in_ad_type[]" id="t8" value="인쇄물 · 지정게시대 현수막"><label for="t8">인쇄물 · 지정게시대 현수막</label>
                </div>
              </div>

              <div class="cf-row anim">
                <div class="cf-field">
                  <label>희망 집행 시기</label>
                  <select name="in_period" id="in_period" class="cf-select">
                    <option value="즉시 집행 희망">즉시 집행 희망 (1~2주 이내)</option>
                    <option value="1개월 이내">1개월 이내</option>
                    <option value="2~3개월 이내">2~3개월 이내</option>
                    <option value="단가 및 견적 단순 검토">단가 및 견적 단순 검토</option>
                  </select>
                </div>
                <div class="cf-field">
                  <label>예상 월 예산</label>
                  <select name="in_budget" id="in_budget" class="cf-select">
                    <option value="100만원 ~ 300만원">100만원 ~ 300만원</option>
                    <option value="300만원 ~ 500만원">300만원 ~ 500만원</option>
                    <option value="500만원 ~ 1,000만원">500만원 ~ 1,000만원</option>
                    <option value="1,000만원 이상">1,000만원 이상</option>
                    <option value="협의 후 결정">협의 후 결정</option>
                  </select>
                </div>
              </div>

              <div class="cf-field anim">
                <label>문의 및 요청 사항</label>
                <textarea name="in_content" id="in_content" class="cf-textarea" rows="4" placeholder="희망하시는 타깃 지역(상무지구, 수완지구 등), 버스 노선, 또는 홍보 목적을 자유롭게 적어주시면 더욱 정밀한 1:1 맞춤 제안서를 작성해 드립니다."></textarea>
              </div>

              <!-- 개인정보 수집 동의 -->
              <div class="cf-agree anim">
                <input type="checkbox" id="agree" name="agree" class="cf-chk" value="Y" checked required>
                <label for="agree">개인정보 수집 및 이용에 동의합니다. (상담 및 견적 안내 목적)</label>
              </div>

                            <div class="cf-btn-wrap anim">
                <button type="submit" class="cf-luxury-submit-btn" id="btnSubmitEstimate">
                  <span>1:1 맞춤 견적 및 제안서 신청하기</span>
                  <div class="clsb-circle">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                  </div>
                </button>
              </div>

            </form>
          </div>

        </div>
      </div>

    </section>

  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php"; ?>
</div>
</body>
</html>