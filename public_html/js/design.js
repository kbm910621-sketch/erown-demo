$(function() {

  /* COMMON */
  var $windowWid = window.innerWidth;

  if (typeof WOW !== 'undefined') {
    var wow = new WOW({
      animateClass: 'animated',
      offset: 150
    });
    wow.init();
  }

  /* SMOOTH SCROLL (LENIS) */
  var lenis;
  if (typeof Lenis !== 'undefined') {
    lenis = new Lenis({
      duration: 1.2,
      easing: function(t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); },
      smooth: true
    });

    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
      gsap.ticker.add(function(time) { lenis.raf(time * 1000); });
      gsap.ticker.lagSmoothing(0);
    } else {
      function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
      requestAnimationFrame(raf);
    }

    lenis.on('scroll', function() { if (typeof wow !== 'undefined') wow.sync(); });

    /* HERO SCROLL LOCK / UNLOCK */
    window.addEventListener('heroUnlock', function() { lenis.start(); });
    window.addEventListener('heroLock', function() { lenis.stop(); });
  }

  /* GSAP SINGLE MASTER TIMELINE (100% PERFECT BI-DIRECTIONAL SYMMETRY) */
  var hero = document.querySelector('.main_hero');
  if (hero && typeof gsap !== 'undefined') {
    if (typeof ScrollTrigger !== 'undefined') {
      gsap.registerPlugin(ScrollTrigger);
    }

    var panel = hero.querySelector('.main_hero_panel');
    var wrap = hero.querySelector('.main_hero_panel_wrap');
    var video = hero.querySelector('.main_hero_panel_video');
    var dim = hero.querySelector('.main_hero_panel_dim');
    var title = hero.querySelector('.main_hero_text');
    var overlay = hero.querySelector('.main_hero_panel_overlay_text');
    var keywords = hero.querySelector('.main_hero_keywords');

    var isAnimating = false;
    var currentStep = 1; // 1: small hero, 2: animating, 3: full screen
    var scrollLocked = false;

    /* MASTER TIMELINE DEFINITION (EXACT CHOREOGRAPHY)
       - 커질 때: 글자 없어지고 -> 화면 커지고 -> 오버레이 자막 등장
       - 작아질 때: 오버레이 자막 사라지고 -> 화면 작아지고 -> 원래 글자 생성!
    */
    var tlHero = gsap.timeline({
      paused: true,
      defaults: { ease: 'power3.inOut' },
      onStart: function() {
        isAnimating = true;
        scrollLocked = true;
        if (lenis) lenis.stop();
      },
      onComplete: function() {
        isAnimating = false;
        currentStep = 3;
        scrollLocked = false;
        if (lenis) lenis.start();
      },
      onReverseComplete: function() {
        isAnimating = false;
        currentStep = 1;
        scrollLocked = true;
        if (lenis) lenis.stop();
      }
    });

    // Step 1 -> Step 3 (Forward Progression)
    tlHero
      // 1. 글자 없어짐
      .to(title, { duration: 0.4, opacity: 0, y: -25, ease: 'power2.out' }, 0)
      .to(keywords, { duration: 0.35, opacity: 0, y: -15, ease: 'power2.out' }, 0)
      // 2. 화면이 전체화면으로 커짐
      .to(wrap, { duration: 1.2, width: '100%', height: '100vh', top: '0%', ease: 'power3.inOut' }, 0.1)
      .to(panel, { duration: 1.2, borderRadius: 0, y: 0, scale: 1, ease: 'power3.inOut' }, 0.1)
      .to(video, { duration: 1.2, scale: 1.05, ease: 'power3.inOut' }, 0.1)
      // 3. 딤 및 오버레이 글자 등장
      .to(dim, { duration: 0.8, backgroundColor: 'rgba(0,0,0,0.48)', ease: 'power2.out' }, 0.45)
      .to(overlay, { duration: 0.8, opacity: 1, y: 0, ease: 'power2.out' }, 0.45)
      .fromTo('.mho-text-box', { scale: 1.08, opacity: 0 }, { duration: 0.8, scale: 1, opacity: 1, ease: 'power2.out' }, 0.5);

    /* REFRESH (F5) CHECK: If user is down the page, immediately set to completed full state */
    var initialScrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
    if (initialScrollY > 50) {
      tlHero.progress(1);
      currentStep = 3;
      scrollLocked = false;
      if (lenis) lenis.start();
    } else {
      tlHero.progress(0);
      currentStep = 1;
      scrollLocked = true;
      if (lenis) lenis.stop();
    }

    /* WHEEL EVENT LISTENER (BULLETPROOF) */
    window.addEventListener('wheel', function(e) {
      var scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;

      // 1. While animating, block wheel
      if (isAnimating) {
        e.preventDefault();
        return;
      }

      // 2. When at Step 1 (top of hero) and scrolling DOWN -> Play Expansion
      if (currentStep === 1 && e.deltaY > 0) {
        e.preventDefault();
        tlHero.play();
        return;
      }

      // 3. When at Step 3 (expanded) and scrolling UP -> Only Reverse when at the very top of page!
      if (currentStep === 3 && e.deltaY < 0 && scrollY <= 5) {
        e.preventDefault();
        tlHero.reverse();
        return;
      }
    }, { passive: false });

    /* KEYBOARD LISTENER */
    $(window).on('keydown', function(e) {
      var scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
      if (isAnimating) { e.preventDefault(); return; }
      if ((e.keyCode === 40 || e.keyCode === 34 || e.keyCode === 32) && currentStep === 1) {
        e.preventDefault();
        tlHero.play();
      }
      if ((e.keyCode === 38 || e.keyCode === 33) && currentStep === 3 && scrollY <= 5) {
        e.preventDefault();
        tlHero.reverse();
      }
    });

    /* TOUCH LISTENER */
    var touchStartY = 0;
    hero.addEventListener('touchstart', function(e) {
      touchStartY = e.touches[0].clientY;
    }, { passive: true });

    hero.addEventListener('touchend', function(e) {
      var scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
      if (isAnimating) return;
      var diff = touchStartY - e.changedTouches[0].clientY;
      if (Math.abs(diff) < 30) return;
      if (diff > 0 && currentStep === 1) tlHero.play();
      else if (diff < 0 && currentStep === 3 && scrollY <= 5) tlHero.reverse();
    }, { passive: true });
  }

  /* 01. COUNTER ANIMATION */
  var counted = false;
  function startCounters() {
    if (counted) return;
    var $counters = $('.counter');
    if (!$counters.length) return;
    var winTop = $(window).scrollTop();
    var winHeight = $(window).height();
    var secTop = $('.am-about-stats-sec').offset() ? $('.am-about-stats-sec').offset().top : 0;

    if (winTop + winHeight > secTop + 100) {
      counted = true;
      $counters.each(function() {
        var $this = $(this);
        var target = parseInt($this.attr('data-target'), 10) || 0;
        $({ count: 0 }).animate({ count: target }, {
          duration: 1800,
          easing: 'swing',
          step: function() { $this.text(Math.floor(this.count)); },
          complete: function() { $this.text(this.count); }
        });
      });
    }
  }
  $(window).on('scroll', startCounters);
  startCounters();

      /* 02. NATURAL BUS STAGE INTERACTION */
  $(document).on('click', '.abh-tab-btn', function(e) {
    e.preventDefault();
    var $btn = $(this);
    $('.abh-tab-btn').removeClass('on');
    $btn.addClass('on');

    var name = $btn.data('name');
    var size = $btn.data('size');
    var img = $btn.data('img');
    var title = $btn.data('title');
    var desc = $btn.data('desc');
    var target = $btn.data('target');
    var material = $btn.data('material');

    $('#dynBusTitle').text(title);
    $('#dynBusDesc').text(desc);
    $('#dynBusSize').text(size);
    $('#dynBusTarget').text(target);
    $('#dynBusMaterial').text(material);
    $('#dynBusPhotoTag').text(name + ' (' + size + ')');

    if (img) {
      $('#dynBusPhoto').fadeOut(120, function() {
        $(this).attr('src', img).fadeIn(180);
      });
    }
  });

  /* 03. 104 BUS ROUTES SEARCH & DIRECTORY MODAL */
  var allRoutes = [
    { num: '순환01', cat: 'express', district: 'seo', desc: '상무지구 ↔ 광천터미널 ↔ 전남대 ↔ 조선대 ↔ 백운광장 (도심 순환)', fleet: '32대 운행', interval: '10~12분', target: '광주 전역 직장인·대학생' },
    { num: '수완03', cat: 'express', district: 'gwangsan', desc: '송원대 ↔ 상무역 ↔ 유스퀘어 ↔ 첨단2지구 ↔ 수완지구', fleet: '28대 운행', interval: '8~10분', target: '수완·첨단 주거지 ↔ 상무 상권' },
    { num: '첨단09', cat: 'express', district: 'buk', desc: '첨단종점 ↔ 전남대 ↔ 법원 ↔ 조선대 ↔ 양림휴먼시아', fleet: '26대 운행', interval: '10~13분', target: '첨단산단 ↔ 대학가 ↔ 법원' },
    { num: '매월06', cat: 'express', district: 'seo', desc: '매월동 ↔ 풍암지구 ↔ 백운동 ↔ 충장로 ↔ 광주역', fleet: '20대 운행', interval: '12~15분', target: '풍암·백운 주거지 ↔ 구도심' },
    { num: '진월07', cat: 'express', district: 'nam', desc: '송암공단 ↔ 대성여고 ↔ 백운광장 ↔ 동구청 ↔ 살레시오고', fleet: '18대 운행', interval: '12~15분', target: '남구 학군 밀집지 ↔ 동구' },
    { num: '좌석02', cat: 'express', district: 'gwangsan', desc: '무등산국립공원 ↔ 조선대 ↔ 유스퀘어 ↔ 송정역 ↔ 나주혁신도시', fleet: '24대 운행', interval: '15~18분', target: '광주 ↔ 나주혁신도시 통근' },
    { num: '매월16', cat: 'main', district: 'seo', desc: '매월동 ↔ 풍암지구 ↔ 상무지구 ↔ 광천터미널 ↔ 일곡지구', fleet: '24대 운행', interval: '10~13분', target: '풍암·상무·일곡 핵심 축' },
    { num: '문흥18', cat: 'main', district: 'buk', desc: '장등동 ↔ 문흥지구 ↔ 전남대 ↔ 광천터미널 ↔ 상무지구', fleet: '22대 운행', interval: '11~14분', target: '문흥 아파트단지 ↔ 상무지구' },
    { num: '봉선37', cat: 'main', district: 'nam', desc: '송암공단 ↔ 봉선동 학원가 ↔ 조선대 ↔ 산수동 ↔ 살레시오여고', fleet: '22대 운행', interval: '10~12분', target: '봉선동 학원가/학부모 독점' },
    { num: '지원15', cat: 'main', district: 'nam', desc: '월남동 ↔ 조선대 ↔ 충장로 ↔ 대인시장 ↔ 광주역 ↔ 효천지구', fleet: '20대 운행', interval: '12~15분', target: '효천·월남 ↔ 충장로' },
    { num: '일곡28', cat: 'main', district: 'buk', desc: '일곡지구 ↔ 양산지구 ↔ 광천터미널 ↔ 조선대 ↔ 매월동', fleet: '21대 운행', interval: '11~13분', target: '양산·일곡 북구 배후세대' },
    { num: '첨단20', cat: 'main', district: 'gwangsan', desc: '첨단종점 ↔ 신창지구 ↔ 광천터미널 ↔ 양동시장 ↔ 조선대', fleet: '19대 운행', interval: '13~16분', target: '신창·첨단 ↔ 터미널' },
    { num: '첨단30', cat: 'main', district: 'gwangsan', desc: '첨단산단 ↔ 수완지구 ↔ 운남지구 ↔ 상무지구 ↔ 광천터미널', fleet: '23대 운행', interval: '10~12분', target: '수완·운남·첨단 직통' },
    { num: '첨단40', cat: 'main', district: 'gwangsan', desc: '비아동 ↔ 첨단2지구 ↔ 전남대 ↔ 광주역 ↔ 화순전남대병원', fleet: '18대 운행', interval: '14~17분', target: '대학병원 및 전남대' },
    { num: '송정19', cat: 'main', district: 'gwangsan', desc: '장등동 ↔ 광주역 ↔ 시청 ↔ 광주송정역 ↔ 도산동', fleet: '20대 운행', interval: '12~15분', target: 'KTX 송정역 & 시청' },
    { num: '송정29', cat: 'main', district: 'gwangsan', desc: '도산동 ↔ 광주송정역 ↔ 우산동 ↔ 광천터미널 ↔ 살레시오여고', fleet: '19대 운행', interval: '13~16분', target: '송정역 ↔ 광천터미널' },
    { num: '풍암16', cat: 'main', district: 'seo', desc: '매월동 ↔ 풍암지구 ↔ 금호지구 ↔ 상무지구 ↔ 광천터미널', fleet: '20대 운행', interval: '11~14분', target: '금호·풍암 아파트 주민' },
    { num: '풍암26', cat: 'main', district: 'seo', desc: '매월동 ↔ 서구청 ↔ 충장로 ↔ 조선대 ↔ 각화동', fleet: '18대 운행', interval: '13~16분', target: '서구청·조선대 상권' },
    { num: '금호36', cat: 'main', district: 'seo', desc: '서창동 ↔ 금호지구 ↔ 상무지구 ↔ 광주역 ↔ 장등동', fleet: '19대 운행', interval: '12~15분', target: '금호지구 및 상무역' },
    { num: '금호46', cat: 'main', district: 'seo', desc: '화순전남대병원 ↔ 소태역 ↔ 풍암지구 ↔ 상무지구', fleet: '17대 운행', interval: '14~18분', target: '상무지구 ↔ 화순병원' },
    { num: '운림51', cat: 'main', district: 'dong', desc: '무등산국립공원 ↔ 조선대 ↔ 충장로 ↔ 유스퀘어 ↔ 첨단산단', fleet: '21대 운행', interval: '11~14분', target: '문화전당 ↔ 터미널 ↔ 첨단' },
    { num: '운림54', cat: 'main', district: 'dong', desc: '무등산국립공원 ↔ 남광주역 ↔ 광주역 ↔ 양산지구', fleet: '16대 운행', interval: '15~18분', target: '남광주시장 & 양산동' },
    { num: '문흥39', cat: 'main', district: 'buk', desc: '장등동 ↔ 문흥지구 ↔ 전남대 ↔ 광천터미널 ↔ 송암공단', fleet: '18대 운행', interval: '13~16분', target: '문흥지구 ↔ 송암공단' },
    { num: '문흥48', cat: 'main', district: 'buk', desc: '장등동 ↔ 문흥지구 ↔ 법원 ↔ 조선대 ↔ 효천지구', fleet: '17대 운행', interval: '14~17분', target: '효천지구 ↔ 법원 행정타운' },
    { num: '지원25', cat: 'main', district: 'nam', desc: '월남동 ↔ 봉선동 ↔ 백운광장 ↔ 양동시장 ↔ 서창동', fleet: '16대 운행', interval: '15~18분', target: '봉선동·백운광장 로컬' },
    { num: '지원56', cat: 'main', district: 'nam', desc: '월남동 ↔ 소태역 ↔ 조선대 ↔ 충장로 ↔ 광주역', fleet: '15대 운행', interval: '16~20분', target: '동남부 주거지 ↔ 충장로' },
    { num: '용봉83', cat: 'main', district: 'buk', desc: '용봉동 ↔ 전남대후문 ↔ 산수오거리 ↔ 조선대 ↔ 학운동', fleet: '18대 운행', interval: '12~15분', target: '전남대·조선대 학생' },
    { num: '대촌70', cat: 'main', district: 'nam', desc: '칠석동 ↔ 대촌 ↔ 백운광장 ↔ 양동시장 ↔ 광천터미널', fleet: '14대 운행', interval: '18~22분', target: '에너지밸리 ↔ 도심' },
    { num: '송암72', cat: 'main', district: 'nam', desc: '송암공단 ↔ 진월지구 ↔ 백운동 ↔ 충장로 ↔ 수완지구', fleet: '20대 운행', interval: '12~15분', target: '진월·백운 ↔ 수완' },
    { num: '수완12', cat: 'main', district: 'gwangsan', desc: '수완종점 ↔ 신가동 ↔ 운남지구 ↔ 상무지구 ↔ 광천터미널', fleet: '22대 운행', interval: '10~13분', target: '수완지구 10만 배후세대' }
  ];

  function renderModalRoutes(keyword, catFilter) {
    var $grid = $('#modalBusRouteFullGrid');
    $grid.empty();
    var kw = (keyword || '').toLowerCase().trim();
    var cat = catFilter || 'all';

    var filtered = allRoutes.filter(function(item) {
      var matchKw = !kw || item.num.toLowerCase().indexOf(kw) !== -1 || item.desc.toLowerCase().indexOf(kw) !== -1 || item.target.toLowerCase().indexOf(kw) !== -1;
      var matchCat = (cat === 'all') || (item.cat === cat) || (item.district === cat);
      return matchKw && matchCat;
    });

    if (!filtered.length) {
      $grid.html('<div class="rsm-empty">일치하는 노선이 없습니다. 검색어를 다시 확인해 주세요.</div>');
      return;
    }

    filtered.forEach(function(r) {
      var badgeClass = r.cat === 'express' ? 'red' : (r.cat === 'main' ? 'blue' : 'green');
      var html = '<div class="rsm-item-card">' +
                   '<div class="ric-head">' +
                     '<span class="ric-num ' + badgeClass + '">' + r.num + '</span>' +
                     '<span class="ric-fleet">' + r.fleet + ' (' + r.interval + ')</span>' +
                   '</div>' +
                   '<div class="ric-desc">' + r.desc + '</div>' +
                   '<div class="ric-target"><strong>핵심 타깃:</strong> ' + r.target + '</div>' +
                 '</div>';
      $grid.append(html);
    });
  }

  function openRouteModal() {
    $('body').addClass('modal-lock');
    $('#routeSearchModal').fadeIn(200).css('display', 'flex');
    renderModalRoutes('', 'all');
  }

  function closeRouteModal() {
    $('#routeSearchModal').fadeOut(200);
    $('body').removeClass('modal-lock');
  }

  $(document).on('click', '#btnOpenRouteSearchModal, #btnHeadRouteSearch', function(e) {
    e.preventDefault();
    openRouteModal();
  });

  $(document).on('click', '#btnCloseRouteSearch', function(e) {
    e.preventDefault();
    closeRouteModal();
  });

  $(document).on('click', '#routeSearchModal', function(e) {
    if (e.target === this) closeRouteModal();
  });

  $(document).on('keyup', '#modalBusRouteSearchInput', function() {
    var kw = $(this).val();
    var cat = $('.rsm-tab.on').data('filter-cat') || 'all';
    renderModalRoutes(kw, cat);
  });

  $(document).on('click', '.rsm-tab', function() {
    $('.rsm-tab').removeClass('on');
    $(this).addClass('on');
    var cat = $(this).data('filter-cat');
    var kw = $('#modalBusRouteSearchInput').val();
    renderModalRoutes(kw, cat);
  });

  /* 04. VIDEO PRODUCTION CINEMA & SMARTPHONE MOCKUP INTERACTION */
  $(document).on('click', '.avh-mode-btn', function() {
    $('.avh-mode-btn').removeClass('on');
    $(this).addClass('on');
    var mode = $(this).data('video-mode');
    if (mode === 'shorts') {
      $('#cinemaFrame').removeClass('on');
      $('#phoneMockup').addClass('on');
      $('.avs-item-card[data-target-mode="shorts"]').first().addClass('on').siblings().removeClass('on');
    } else {
      $('#phoneMockup').removeClass('on');
      $('#cinemaFrame').addClass('on');
      $('.avs-item-card[data-target-mode="wide"]').first().addClass('on').siblings().removeClass('on');
    }
  });

  $(document).on('click', '.avs-item-card', function() {
    $('.avs-item-card').removeClass('on');
    $(this).addClass('on');
    var title = $(this).data('title');
    var sub = $(this).data('sub');
    var mode = $(this).data('target-mode');

    $('#dynCinemaTitle').text(title);
    $('#dynCinemaSub').text(sub);

    if (mode === 'shorts') {
      $('#cinemaFrame').removeClass('on');
      $('#phoneMockup').addClass('on');
      $('.avh-mode-btn[data-video-mode="shorts"]').addClass('on').siblings().removeClass('on');
    } else {
      $('#phoneMockup').removeClass('on');
      $('#cinemaFrame').addClass('on');
      $('.avh-mode-btn[data-video-mode="wide"]').addClass('on').siblings().removeClass('on');
    }
  });

  /* 05. SPECIALIZED OOH ACCORDION */
  $(document).on('click', '.aoa-card', function() {
    $('.aoa-card').removeClass('on');
    $(this).addClass('on');
  });

    /* 06. SPLIT INTERACTIVE CASE STUDY PREVIEW */
  $(document).on('mouseenter click', '.ais-project-item', function() {
    var $this = $(this);
    $('.ais-project-item').removeClass('on');
    $this.addClass('on');

    var img = $this.data('img');
    var title = $this.data('name');
    var catLabel = $this.data('cat-label');
    var id = $this.data('id');
    var cat = $this.data('cat');

    $('#dynSplitImg').attr('src', img);
    $('#dynSplitTitle').text(title);
    $('#dynSplitCat').text(catLabel);

    $('#splitPreviewCard').data('id', id).data('name', title).data('cat', cat);
  });

  $(document).on('click', '.afc-btn', function() {
    $('.afc-btn').removeClass('on');
    $(this).addClass('on');
    var filter = $(this).data('filter');
    if (filter === 'all') {
      $('.ais-project-item').fadeIn(200);
      $('.ais-project-item:visible').first().trigger('click');
    } else {
      $('.ais-project-item').each(function() {
        if ($(this).data('cat') === filter) {
          $(this).fadeIn(200);
        } else {
          $(this).hide();
        }
      });
      $('.ais-project-item:visible').first().trigger('click');
    }
  });

  $(document).on('click', '.main-port-card', function() {
    var $img = $(this).find('img');
    var src = $img.attr('src');
    var title = $(this).data('name') || $img.attr('alt') || '프로젝트';
    var cat = $(this).find('.apg-tag, .asps-badge').first().text() || '광고사례';
    var id = $(this).data('id') || '01';

    $('#modalImg').attr('src', src);
    $('#modalTitle').text(title);
    $('#modalCat').text(cat);
    $('#modalId').text('#' + id);

    $('#modalBackdrop').addClass('open').fadeIn(200);
    $('body').addClass('modal-lock');
  });

  $(document).on('click', '#modalClose, #modalBackdrop', function(e) {
    if (e.target === this || $(e.target).is('#modalClose')) {
      $('#modalBackdrop').removeClass('open').fadeOut(200);
      $('body').removeClass('modal-lock');
    }
  });

  /* 07. MASTER SPECIFICATION MODAL TABS */
  $(document).on('click', '.bus-guide-open', function(e) {
    e.preventDefault();
    var guideTarget = $(this).data('guide') || 'guideBus';
    $('#busGuideOverlay').fadeIn(200).css('display', 'block');
    $('body').addClass('modal-lock');
    $('.lmt-tab[data-target="' + guideTarget + '"]').trigger('click');
  });

  $(document).on('click', '#btnCloseBusGuide', function() {
    $('#busGuideOverlay').fadeOut(200);
    $('body').removeClass('modal-lock');
  });

  $(document).on('click', '#busGuideOverlay', function(e) {
    if (e.target === this) {
      $('#busGuideOverlay').fadeOut(200);
      $('body').removeClass('modal-lock');
    }
  });

  $(document).on('click', '.lmt-tab', function() {
    $('.lmt-tab').removeClass('on');
    $(this).addClass('on');
    var target = $(this).data('target');
    $('.bus-guide-page').removeClass('on');
    $('#' + target).addClass('on');
  });

});


  /* 07. PROPOSAL CENTER MODAL */
  $(document).on('click', '#btnOpenProposalCenter, .btn-open-proposal-center', function(e) {
    e.preventDefault();
    $('#modalProposalCenter').fadeIn(200);
    $('body').css('overflow', 'hidden');
  });

  $(document).on('click', '#btnCloseProposalModal', function() {
    $('#modalProposalCenter').fadeOut(200);
    $('body').css('overflow', '');
  });