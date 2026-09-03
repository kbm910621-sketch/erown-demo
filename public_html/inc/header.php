<header id="header" class="<?php echo isset($use_depth)?$use_depth:'';?>">
    <div class="inner">
        <h1 class="logo"><a href="/index.php">가온엔</a></h1>
        <div class="mobile_hamburger">
            <button class="gnb_open" id="gnbOpenBtn" type="button" aria-label="메뉴 열기" onclick="openMobileNav();" ontouchstart="openMobileNav();">
                <span class="stic_1"></span><span class="stic_2"></span><span class="stic_3"></span>
            </button>
        </div>
        <nav id="gnb" class="gnb_nav">
            <div class="gnb_drawer_head mobile_only" style="display:flex; justify-content:flex-end; padding:20px 24px;">
                <button type="button" class="gnb_close_btn" id="gnbCloseBtn" aria-label="메뉴 닫기" onclick="closeMobileNav();" ontouchstart="closeMobileNav();">✕</button>
            </div>
            <div class="main_menu">
                <ul class="gnb_nav_list">
                    <li class="depth1"><a href="/index.php#bus" class="gnb_anchor_link" onclick="closeMobileNav();">옥외광고<span class="gnb-sub">OOH Media</span></a></li>
                    <li class="depth1"><a href="/index.php#online" class="gnb_anchor_link" onclick="closeMobileNav();">온라인마케팅<span class="gnb-sub">Digital</span></a></li>
                    <li class="depth1"><a href="/index.php#video" class="gnb_anchor_link" onclick="closeMobileNav();">영상제작<span class="gnb-sub">Cinema</span></a></li>
                    <li class="depth1"><a href="/contents/a_type/a_1.php" onclick="closeMobileNav();">포트폴리오<span class="gnb-sub">Portfolio ➔</span></a></li>
                    <li class="depth1 contact_depth"><a href="/board/estmate/write.php" class="gnb_cta_btn" onclick="closeMobileNav();">상담신청<span class="gnb-sub">Contact ➔</span></a></li>
                </ul>
                <div class="gnb_drawer_footer mobile_only">
                    <div class="gdf_info_row">
                        <div class="gdf_col">
                            <span class="gdf_lbl">CONTACT</span>
                            <a href="tel:062-385-0110" class="gdf_tel">062-385-0110</a>
                        </div>
                        <div class="gdf_col">
                            <span class="gdf_lbl">E-MAIL</span>
                            <span class="gdf_email">gaon-n@naver.com</span>
                        </div>
                    </div>
                    <a href="/board/estmate/write.php" class="gdf_cta_btn">
                        <span>프로젝트 상담신청</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>
        </nav>
        <div class="gnb_dim" id="gnbDim" onclick="closeMobileNav();" ontouchstart="closeMobileNav();"></div>
    </div>
    <div class="gnb_bar"></div>
</header>

<script>
function openMobileNav() {
  var gnb = document.getElementById('gnb');
  var dim = document.getElementById('gnbDim');
  if (gnb) gnb.classList.add('is-mobile-open', 'on');
  if (dim) { dim.style.display = 'block'; dim.style.opacity = '1'; }
  document.body.classList.add('menu-open');
}
function closeMobileNav() {
  var gnb = document.getElementById('gnb');
  var dim = document.getElementById('gnbDim');
  if (gnb) gnb.classList.remove('is-mobile-open', 'on');
  if (dim) { dim.style.display = 'none'; dim.style.opacity = '0'; }
  document.body.classList.remove('menu-open');
}
</script>