$(function() {

  /* 02-D. BESPOKE OOH 3-TIER HIERARCHY & ZERO-LATENCY PRELOADED SWITCHING */
  var oohImageCache = {};
  var oohImages = [
    '/images/bs_ad/ooh11/차도면광고.png',
    '/images/bs_ad/ooh11/인도면광고.png',
    '/images/bs_ad/ooh11/후면광고.jpg',
    '/images/bs_ad/ooh11/노선도01.png',
    '/images/bs_ad/ooh11/하차문광고01.png',
    '/images/bs_ad/ooh11/버스시트광고01.png',
    '/images/bs_ad/ooh11/버스음성광고.png',
    '/images/bs_ad/ooh11/유스퀘어광고.png',
    '/images/bs_ad/ooh11/DID광고.png',
    '/images/bs_ad/ooh11/택시광고01.png',
    '/images/bs_ad/ooh11/택배차광고01.png',
    '/images/bs_ad/ooh11/mart_cart_01.jpg'
  ];
  // Preload all high-res OOH images into browser memory immediately
  oohImages.forEach(function(src) {
    var img = new Image();
    img.src = src;
    oohImageCache[src] = img;
  });

  var currentOohSrc = '/images/bs_ad/ooh11/차도면광고.png';

  function updateOohVisual(img, numEng, title, guide, $parentItem) {
    // 1. PC Visual Elements (100% Preserved)
    if (numEng) $('#goCapNumEng').text(numEng);
    if (title) $('#goCapTitle').text(title);
    if (guide) $('#goBtnGuide').attr('data-guide', guide);

    if (img && img !== currentOohSrc) {
      var $back = $('#goPhotoBack');
      var $front = $('#goPhotoFront');

      $back.attr('src', currentOohSrc);
      currentOohSrc = img;

      $front.removeClass('active').addClass('is-prep');
      $front.attr('src', img);

      requestAnimationFrame(function() {
        requestAnimationFrame(function() {
          $front.removeClass('is-prep').addClass('active');
        });
      });
    }

    // 2. Mobile Inline Preview (Smooth crossfade in current accordion)
    if ($parentItem && $parentItem.length) {
      var $mobPreview = $parentItem.find('.go-mobile-preview');
      if ($mobPreview.length) {
        var $mobImg = $mobPreview.find('.gmp-image');
        var $mobMeta = $mobPreview.find('.gmp-meta');
        var $mobTitle = $mobPreview.find('.gmp-title');

        if (numEng) $mobMeta.text(numEng);
        if (title) $mobTitle.text(title);

        if (img && $mobImg.attr('src') !== img) {
          $mobImg.css('opacity', '0');
          setTimeout(function() {
            $mobImg.attr('src', img);
            $mobImg.css('opacity', '1');
          }, 150);
        }
      }
    }
  }

  // 1. Primary Category Accordion CLICK ONLY
  $(document).on('click', '.gpi-header-btn', function(e) {
    e.preventDefault();
    var $item = $(this).closest('.go-primary-item');
    if ($item.hasClass('on')) return; // Keep current open if already active

    // Close all other primary items & Open clicked one
    $('.go-primary-item').removeClass('on');
    $item.addClass('on');

    var num = $item.data('num') || '01';
    var eng = $item.data('eng') || 'BUS OUTDOOR';
    var numEng = num + ' / ' + eng;

    // Activate the first detail sub-item within this opened accordion
    var $subList = $item.find('.gds-sub-list');
    var $firstSub = $subList.find('.gds-item:first');
    $item.find('.gds-item').removeClass('on');
    $firstSub.addClass('on');

    var subImg = $firstSub.data('img');
    var subTitle = $firstSub.data('sub');
    var subGuide = $firstSub.data('guide') || $item.data('guide');
    updateOohVisual(subImg, numEng, subTitle, subGuide, $item);
  });

  // 2. Detail Sub-Item CLICK ONLY
  $(document).on('click', '.gds-item', function(e) {
    e.preventDefault();
    e.stopPropagation(); // Do not trigger parent accordion header

    var $this = $(this);
    var $parentItem = $this.closest('.go-primary-item');
    
    // Ensure parent primary item is active
    if (!$parentItem.hasClass('on')) {
      $('.go-primary-item').removeClass('on');
      $parentItem.addClass('on');
    }

    // Set active detail state
    $parentItem.find('.gds-item').removeClass('on');
    $this.addClass('on');

    var num = $this.data('num') || $parentItem.data('num') || '01';
    var eng = $this.data('eng') || $parentItem.data('eng') || 'BUS OUTDOOR';
    var numEng = num + ' / ' + eng;

    var img = $this.data('img');
    var title = $this.data('sub');
    var guide = $this.data('guide') || $parentItem.data('guide') || '';

    updateOohVisual(img, numEng, title, guide, $parentItem);
  });

  /* 05. BESPOKE PROCESS WORKFLOW INTERACTION */
  $(document).on('mouseenter click', '.gpe-step-item', function() {
    var $this = $(this);
    $('.gpe-step-item').removeClass('on');
    $this.addClass('on');

    var step = $this.data('step');
    var eng = $this.data('eng');
    var title = $this.data('title');

    if (step) $('#gpeActiveNum').text(step);
    if (eng) $('#gpeActiveEng').text(eng);
    if (title) $('#gpeActiveTitle').text(title);
  });


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
    window.lenis = lenis;

    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
      gsap.ticker.add(function(time) { lenis.raf(time * 1000); });
      gsap.ticker.lagSmoothing(0);
    } else {
      function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
      requestAnimationFrame(raf);
    }

    lenis.on('scroll', function() { if (typeof wow !== 'undefined') wow.sync(); });

    /* HERO SCROLL LOCK / UNLOCK */
    window.addEventListener('heroUnlock', function() { if (!$('#mainModalPopupOverlay:visible').length) lenis.start(); });
    window.addEventListener('heroLock', function() { lenis.stop(); });
  }

    /* GSAP SINGLE MASTER TIMELINE (PC 전용 웅장한 전체화면 확장 인터랙션 / 모바일은 스크롤 락 완전 해제) */
  var hero = document.querySelector('.main_hero');
  if (hero && typeof gsap !== 'undefined' && window.innerWidth > 768) {
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
    $('html, body').addClass('modal-lock');
    $('#routeSearchModal').addClass('open').fadeIn(200).css('display', 'block');
    $('body').addClass('modal-lock');
    renderModalRoutes('', 'all');
  }

  function closeRouteModal() {
    $('#routeSearchModal').removeClass('open').fadeOut(200);
    $('body').removeClass('modal-lock');
    $('html, body').removeClass('modal-lock');
  }

  window.openRouteModal = openRouteModal;
  window.closeRouteModal = closeRouteModal;

  $(document).on('click', '.open-route-search, #btnOpenRouteSearchModal, #btnHeadRouteSearch', function(e) {
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

    $(document).on('click', '.main-port-card', function(e) {
    e.preventDefault();
    var $img = $(this).find('img');
    var src = $img.attr('src');
    var title = $(this).data('name') || $img.attr('alt') || '프로젝트';
    var cat = $(this).find('.aeg-cat-badge, .apg-tag, .asps-badge').first().text() || '광고사례';
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
    

    /* STOP WHEEL BUBBLING TO OUTER WINDOW WHILE ALLOWING INNER SCROLL */
  $(document).on('wheel', '.route-search-modal-overlay, .bus-guide-overlay, .portfolio-modal-backdrop', function(e) {
    e.stopPropagation();
  });

  $(document).on('click', '.bus-guide-open', function(e) {
    e.preventDefault();
    var guideTarget = $(this).data('guide') || 'guideBusOut';
    $('#busGuideOverlay').addClass('open').fadeIn(200).css('display', 'block');
    $('html, body').addClass('modal-lock');
    $('.lmt-tab[data-target="' + guideTarget + '"]').trigger('click');
  });

  $(document).on('click', '#btnCloseBusGuide', function() {
    $('#busGuideOverlay').removeClass('open').fadeOut(200);
    $('html, body').removeClass('modal-lock');
  });

  $(document).on('click', '#busGuideOverlay', function(e) {
    if (e.target === this) {
      $('#busGuideOverlay').fadeOut(200);
      $('body').removeClass('modal-lock');
    }
  });

  
  
    /* 08. HOSPITAL MEDICAL BRAND BLOG SIMULATOR */
  var medicalDataMap = {
    skin: {
      brand: '가온메디컬 피부과 공식 건강 매거진',
      cat: '피부과 원장 칼럼',
      title: '울쎄라 vs 써마지 차이점, 원장님이 직접 명확하게 비교해 드립니다',
      author: '대표원장 의학박사 직접 집필',
      authorDesc: '광주 상무지구 진료 15년',
      lead: '"안녕하세요. 상무지구에서 15년간 피부 진료를 이어오고 있는 대표원장입니다. 많은 환자분들이 내원하셔서 \'원장님, 저한테는 울쎄라가 맞나요, 써마지가 맞나요?\'라는 질문을 가장 많이 하십니다. 결론부터 말씀드리면 두 시술은 타깃하는 피부 층이 완전히 다릅니다..."',
      pointTitle: '원장님이 짚어주는 3대 핵심 요약',
      points: [
        '<strong>01. 초음파 vs 고주파 :</strong> 울쎄라는 SMAS 근막층, 써마지는 진피층 콜라겐을 타깃합니다.',
        '<strong>02. 피부 두께 측정 :</strong> 볼 꺼짐 현상을 방지하기 위해 1:1 초음파 정밀 진단이 선행됩니다.',
        '<strong>03. 시술 팁 관리 :</strong> 시술 직후 인증된 시리얼 넘버 및 확인서를 직접 제공합니다.'
      ]
    },
    dental: {
      brand: '가온플란트 치과 공식 건강 매거진',
      cat: '구강악안면외과 원장 칼럼',
      title: '뼈이식 임플란트, 재수술 없는 3가지 식립 기준과 사후 안심 보증',
      author: '구강악안면외과 원장 직접 집필',
      authorDesc: '광주 수완지구 고난도 임플란트 10,000례 집도',
      lead: '"임플란트 수술 후 잇몸뼈 흡수로 고생하시는 분들이 많습니다. 상악동 거상술과 자가골 이식은 의료진의 해부학적 이해도가 성패를 좌우합니다. 뼈이식이 왜 필요한지, 어떤 재료를 써야 오래 유지되는지 설명해 드립니다..."',
      pointTitle: '임플란트 수술 전 3대 필수 확인',
      points: [
        '<strong>01. 3D CT 정밀 진단 :</strong> 신경관과의 거리 0.1mm 오차 없는 식립 경로 설계',
        '<strong>02. 안전 이식재 :</strong> 생체 친화성이 검증된 승인 이식재 사용',
        '<strong>03. 평생 보증 시스템 :</strong> 1:1 전담 위생사 배정 및 연 2회 정기 사후관리'
      ]
    },
    ortho: {
      brand: '가온정형외과 관절·척추 매거진',
      cat: '정형외과 원장 칼럼',
      title: '허리 디스크, 수술 없이 비수술 도수·신경차단술로 호전되는 원리',
      author: '척추관절 원장 직접 집필',
      authorDesc: '광주 첨단지구 비수술 척추 클리닉 운영',
      lead: '"허리 통증으로 걷기조차 힘들 때 당장 수술해야 하는 건 아닌지 불안해하시는 분들이 많습니다. 하지만 85% 이상의 디스크 환자는 정밀 신경차단술과 도수재활 치료로 충분히 정상 생활로 복귀할 수 있습니다..."',
      pointTitle: '비수술 척추 치료 3대 핵심 원칙',
      points: [
        '<strong>01. C-arm 실시간 영상유도 :</strong> 통증 원인 부위 1mm 정밀 타깃 주사',
        '<strong>02. 1:1 전담 도수치료 :</strong> 척추 정렬 교정 및 코어 근육 강화 재활',
        '<strong>03. 생활 습관 교정 :</strong> 재발 방지를 위한 자세 분석 및 맞춤 스트레칭 지도'
      ]
    },
    korean: {
      brand: '가온한방병원 공식 건강 매거진',
      cat: '한방재활의학과 원장 칼럼',
      title: '교통사고 후유증, 사고 직후 3일 골든타임 입원 집중 치료의 중요성',
      author: '한방재활의학과 원장 직접 집필',
      authorDesc: '광주 봉선동 40병상 입원실 완비 한방병원',
      lead: '"교통사고 당시에는 별다른 통증이 없다가 2~3일 후 목과 어깨, 허리가 굳어오는 경우가 많습니다. X-ray 상 골절이 없더라도 미세 어혈과 근육 긴장을 초기에 다스려야 만성 통증으로 번지지 않습니다..."',
      pointTitle: '교통사고 후유증 3대 치료 프로그램',
      points: [
        '<strong>01. 추나요법 :</strong> 사고 충격으로 틀어진 경추 및 척추 관절 교정',
        '<strong>02. 어혈 한약 & 약침 :</strong> 손상된 근육과 인대 염증 완화',
        '<strong>03. 쾌적한 1·2인 입원실 :</strong> 자동차보험 100% 적용 집중 휴식 치료'
      ]
    }
  };

  $(document).on('click', '.asb-tab', function() {
    var dept = $(this).data('dept');
    var d = medicalDataMap[dept];
    if (!d) return;

    $('.asb-tab').removeClass('on');
    $(this).addClass('on');

    $('#simBlogPostContainer').css('opacity', '0.3');
    setTimeout(function() {
      $('#simBlogBrand').text(d.brand);
      $('#simPostCat').text(d.cat);
      $('#simPostTitle').text(d.title);
      $('#simAuthorName').text(d.author);
      $('#simAuthorDesc').text(d.authorDesc);
      $('#simLeadBox').html(d.lead);
      $('#simPointTitle').text(d.pointTitle);
      
      var pointsHtml = '';
      d.points.forEach(function(p) {
        pointsHtml += '<li>' + p + '</li>';
      });
      $('#simPointList').html(pointsHtml);

      $('#simBlogPostContainer').css('opacity', '1');
    }, 150);
  });


  $(document).on('click', '.lmt-tab', function(e) {
    e.preventDefault();
    var target = $(this).data('target');
    $('.lmt-tab').removeClass('on');
    $(this).addClass('on');
    $('.bus-guide-page').removeClass('on').hide();
    $('#' + target).fadeIn(150).addClass('on');
  });

  /* MASSTIGE INSIGHTS-STYLE HUGE TYPOGRAPHIC TAB FILTERING */
  $(document).on('click', '.mai-tab', function() {
    $('.mai-tab').removeClass('on');
    $(this).addClass('on');
    var filter = $(this).data('filter');
    if (filter === 'all') {
      $('.mai-card').fadeIn(250);
    } else {
      $('.mai-card').each(function() {
        if ($(this).data('cat') === filter) {
          $(this).fadeIn(250);
        } else {
          $(this).hide();
        }
      });
    }
  });


  

  /* EXACT SCREENSHOT REPLICA TAB FILTER & REALTIME DYNAMIC RESULTS COUNT */
  $(document).on('click', '.ms-tab', function() {
    $('.ms-tab').removeClass('on');
    $(this).addClass('on');
    var filter = $(this).data('filter');
    if (filter === 'all') {
      $('.ms-card').fadeIn(200);
      $('#dynResultCount').text($('.ms-card').length);
      $('.ms-all-text').text('All');
    } else {
      var count = 0;
      $('.ms-card').each(function() {
        if ($(this).data('cat') === filter) {
          $(this).fadeIn(200);
          count++;
        } else {
          $(this).hide();
        }
      });
      $('#dynResultCount').text(count);
      var tabLabel = $(this).contents().filter(function() { return this.nodeType === 3; }).text().trim();
      $('.ms-all-text').text(tabLabel || 'Filtered');
    }
  });


  /* UNIFIED MODAL MANAGER & ESC KEY SUPPORT */
  function closeAllModals() {
    $('#routeSearchModal').removeClass('open').fadeOut(150).css('display', 'none');
    $('#busGuideOverlay').removeClass('open').fadeOut(150).css('display', 'none');
    $('#modalBackdrop').removeClass('open').fadeOut(150).css('display', 'none');
    $('html, body').removeClass('modal-lock');
    $('body').removeClass('modal-lock');
  }

  $(document).on('click', '#btnCloseRouteSearch, #btnCloseBusGuide, #modalClose, .lux-modal-close, .rsm-close, .pm-close-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    closeAllModals();
  });

  $(document).on('click', '#routeSearchModal, #busGuideOverlay, #modalBackdrop', function(e) {
    if ($(e.target).is('#routeSearchModal, #busGuideOverlay, #modalBackdrop') || 
        $(e.target).hasClass('route-search-modal-overlay') || 
        $(e.target).hasClass('bus-guide-overlay') || 
        $(e.target).hasClass('portfolio-modal-backdrop')) {
      closeAllModals();
    }
  });

  $(document).on('keydown', function(e) {
    if (e.key === 'Escape' || e.keyCode === 27) {
      closeAllModals();
    }
  });


  

  

  

  

  

  /* MASSTIGE.IO EXACT CURTAIN CLIP-PATH REVEAL TRIGGER */
  $(document).on('click mouseenter', '.mos-nav-item', function() {
    var $this = $(this);
    if ($this.hasClass('on')) return;
    
    $('.mos-nav-item').removeClass('on');
    $this.addClass('on');

    var kicker = $this.data('kicker') || 'OOH MEDIA';
    var lead = $this.data('lead') || '';
    var rawTags = $this.data('tags') || '';
    var tags = typeof rawTags === 'string' ? rawTags.split(',') : [];
    var title = $this.data('banner-title') || '';
    var img = $this.data('banner-img') || '/images/bs_ad/main_sec02_img.jpg';
    var spec = $this.data('spec') || '';
    var guide = $this.data('guide') || 'guideBusOut';

    $('#mosDynKicker').text(kicker);
    $('#mosDynLead').text(lead);
    $('#mosBannerTitle').text(title);
    $('#mosDynSpec').text(spec);
    $('#mosBannerImg').attr('src', img);
    $('#mosBtnGuide').attr('data-guide', guide);

    // TAG PILLS
    var tagsHtml = '';
    for (var i = 0; i < tags.length; i++) {
      var t = tags[i].trim();
      if (t) {
        tagsHtml += '<span class="mdt-pill">' + t + '</span>';
      }
    }
    $('#mosDynTags').html(tagsHtml);

    // 1. TOP TEXT: FADE & GENTLE RISE
    var $topText = $('#mosLeadWrap');
    $topText.removeClass('mst-on');
    void $topText[0].offsetWidth;
    $topText.addClass('mst-on');

    // 2. BANNER: EXACT MASSTIGE.IO CURTAIN CLIP-PATH REVEAL (0.68s)
    var $banner = $('#mosHeroBanner');
    $banner.removeClass('mst-on');
    void $banner[0].offsetWidth;
    $banner.addClass('mst-on');
    
    // mosNavListScrollCenter: 모바일 가로 스와이프 선택 시 해당 칩이 화면 중앙에 오도록 스크롤
    if (window.innerWidth <= 991) {
      var navListEl = document.getElementById('mosNavList');
      if (navListEl && $this[0]) {
        var itemLeft = $this[0].offsetLeft;
        var itemWidth = $this[0].offsetWidth;
        var listWidth = navListEl.offsetWidth;
        navListEl.scrollTo({ left: itemLeft - (listWidth / 2) + (itemWidth / 2), behavior: 'smooth' });
      }
    }
  });


  /* MOBILE TOUCH PAUSE & SWIPE CENTER SUPPORT */
  $(document).on('touchstart', '.som-stream-stage', function() {
    $('.som-stream-track').css('animation-play-state', 'paused');
  }).on('touchend', '.som-stream-stage', function() {
    $('.som-stream-track').css('animation-play-state', 'running');
  });

  // Center active pill on mobile horizontal swipe
  $(document).on('click', '.mos-nav-item', function() {
    if ($(window).width() <= 768) {
      var $list = $('.mos-nav-list');
      var $item = $(this);
      var scrollLeft = $item.position().left + $list.scrollLeft() - ($list.width() / 2) + ($item.width() / 2);
      $list.animate({ scrollLeft: scrollLeft }, 250);
    }
  });


  

  /* SUB-PORTFOLIO STRIP SWIPER INITIALIZATION (PC 4열, 모바일 2열 회전) */
  

  

  
      /* ==========================================================================
     SUB-PORTFOLIO 4-COLUMN SWIPER (PC 4열 와이드 슬라이더)
  ========================================================================== */
  var busSwiperInstance = null;
  var videoSwiperInstance = null;

  function initAllSubPortfolioSwipers() {
    if (typeof Swiper === 'undefined') return;

    if ($('.asps-swiper-bus').length) {
      if (busSwiperInstance) {
        try { busSwiperInstance.destroy(true, true); } catch(e) {}
      }
      try {
        busSwiperInstance = new Swiper('.asps-swiper-bus', {
          slidesPerView: 4,
          spaceBetween: 22,
          speed: 600,
          grabCursor: true,
          observer: true,
          observeParents: true,
          watchOverflow: true,
          loop: true,
          loopAdditionalSlides: 2,
          autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
          },
          navigation: {
            prevEl: '.asps-prev-bus',
            nextEl: '.asps-next-bus'
          },
          breakpoints: {
            0: {
              slidesPerView: 1.25,
              spaceBetween: 12
            },
            600: {
              slidesPerView: 2.2,
              spaceBetween: 16
            },
            900: {
              slidesPerView: 3,
              spaceBetween: 18
            },
            1024: {
              slidesPerView: 4,
              spaceBetween: 22
            }
          }
        });
      } catch(e) { console.error('busSwiper error:', e); }
    }

    if ($('.asps-swiper-video').length) {
      if (videoSwiperInstance) {
        try { videoSwiperInstance.destroy(true, true); } catch(e) {}
      }
      try {
        videoSwiperInstance = new Swiper('.asps-swiper-video', {
          slidesPerView: 4,
          spaceBetween: 22,
          speed: 600,
          grabCursor: true,
          observer: true,
          observeParents: true,
          watchOverflow: true,
          loop: true,
          loopAdditionalSlides: 2,
          autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
          },
          navigation: {
            prevEl: '.asps-prev-video',
            nextEl: '.asps-next-video'
          },
          breakpoints: {
            0: {
              slidesPerView: 1.25,
              spaceBetween: 12
            },
            600: {
              slidesPerView: 2.2,
              spaceBetween: 16
            },
            900: {
              slidesPerView: 3,
              spaceBetween: 18
            },
            1024: {
              slidesPerView: 4,
              spaceBetween: 22
            }
          }
        });
      } catch(e) { console.error('videoSwiper error:', e); }
    }

    if ($('.asps-swiper-online').length) {
      try {
        new Swiper('.asps-swiper-online', {
          slidesPerView: 4,
          spaceBetween: 22,
          speed: 600,
          grabCursor: true,
          observer: true,
          observeParents: true,
          watchOverflow: true,
          loop: true,
          loopAdditionalSlides: 2,
          autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
          },
          navigation: {
            prevEl: '.asps-prev-online',
            nextEl: '.asps-next-online'
          },
          breakpoints: {
            0: {
              slidesPerView: 1.25,
              spaceBetween: 12
            },
            600: {
              slidesPerView: 2.2,
              spaceBetween: 16
            },
            900: {
              slidesPerView: 3,
              spaceBetween: 18
            },
            1024: {
              slidesPerView: 4,
              spaceBetween: 22
            }
          }
        });
      } catch(e) { console.error('onlineSwiper error:', e); }
    }
  }

  // Active sub-portfolio Swipers immediately and on DOM Ready & Load
  initAllSubPortfolioSwipers();
  $(document).ready(function() {
    initAllSubPortfolioSwipers();
  });
  $(window).on('load resize', function() {
    if (busSwiperInstance) busSwiperInstance.update();
    if (videoSwiperInstance) videoSwiperInstance.update();
  });

  // 화살표 버튼 즉각 클릭 바인딩
  $(document).on('click', '.asps-prev-bus', function(e) {
    e.preventDefault(); e.stopPropagation();
    if (busSwiperInstance) busSwiperInstance.slidePrev(600);
  });
  $(document).on('click', '.asps-next-bus', function(e) {
    e.preventDefault(); e.stopPropagation();
    if (busSwiperInstance) busSwiperInstance.slideNext(600);
  });

  $(document).on('click', '.asps-prev-video', function(e) {
    e.preventDefault(); e.stopPropagation();
    if (videoSwiperInstance) videoSwiperInstance.slidePrev(600);
  });
  $(document).on('click', '.asps-next-video', function(e) {
    e.preventDefault(); e.stopPropagation();
    if (videoSwiperInstance) videoSwiperInstance.slideNext(600);
  });

  /* ==========================================================================
     PORTFOLIO LIGHTBOX MODAL WITH FULL PREV / NEXT NAVIGATION & MULTI-PHOTO DOTS
  ========================================================================== */
  var currentModalList = [];
  var currentModalIndex = 0;
  var currentModalPhotoIdx = 0;

  function switchMainModalPhoto(pIdx) {
    if (!currentModalList.length) return;
    var item = currentModalList[currentModalIndex];
    if (!item.images || !item.images.length) return;
    if (pIdx < 0) pIdx = item.images.length - 1;
    if (pIdx >= item.images.length) pIdx = 0;
    currentModalPhotoIdx = pIdx;

    var $img = $('#modalImg');
    $img.css({ opacity: 0.35 });
    setTimeout(function() {
      $img.attr('src', item.images[pIdx]);
      $img.css({ opacity: 1 });
    }, 90);

    $('.pm-dot-btn').removeClass('active');
    $('.pm-dot-btn[data-idx="' + pIdx + '"]').addClass('active');
  }

  function updateModalContent(index, photoIdx) {
    if (!currentModalList.length) return;
    if (index < 0) index = currentModalList.length - 1;
    if (index >= currentModalList.length) index = 0;
    currentModalIndex = index;
    currentModalPhotoIdx = (typeof photoIdx === 'number') ? photoIdx : 0;

    var item = currentModalList[currentModalIndex];
    var $img = $('#modalImg');
    var $vEl = $('#modalVideo');
    var $dotsWrap = $('#modalPhotoDots');

    if (item.video) {
      $img.hide();
      if ($dotsWrap.length) $dotsWrap.hide().empty();
      if ($vEl.length) {
        $vEl.attr('src', item.video).show();
        if ($vEl[0]) {
          $vEl[0].muted = true;
          $vEl[0].currentTime = 0;
          var p = $vEl[0].play();
          if (p !== undefined) p.catch(function(){});
        }
      }
      $('#modalTitle').text(item.title);
      $('#modalCat').text(item.tag);
      $('#modalLoc').text('가온엔 직영 영상 프로덕션');
      $('#modalSubNotice').show();
      $('#modalCounter').text((currentModalIndex + 1) + ' / ' + currentModalList.length);
      $('#modalCtaBtn').text('이 영상 제작 견적 문의 ➔');
    } else {
      $('#modalSubNotice').hide();
      if ($vEl.length && $vEl[0]) {
        $vEl[0].pause();
        $vEl.hide().attr('src', '');
      }

      var imgs = (item.images && item.images.length) ? item.images : [item.img];
      if (currentModalPhotoIdx >= imgs.length) currentModalPhotoIdx = 0;
      var activeImgSrc = imgs[currentModalPhotoIdx];

      $img.show().css({ opacity: 0, transform: 'scale(0.97)' });
      setTimeout(function() {
        $('#modalTitle').text(item.title);
        $('#modalImg').attr('src', activeImgSrc);
        $('#modalCat').text(item.tag);
        $('#modalLoc').text('광주 주요 상권 직영 시공 사례');
        $('#modalCounter').text((currentModalIndex + 1) + ' / ' + currentModalList.length);
        $('#modalCtaBtn').text('이 광고 집행 견적 문의 ➔');
        $('#modalImg').css({ opacity: 1, transform: 'scale(1)' });
      }, 100);

      // Render dots if multiple images
      if ($dotsWrap.length) {
        if (imgs.length > 1) {
          var dHtml = '';
          imgs.forEach(function(u, pI) {
            dHtml += '<button type="button" class="pm-dot-btn ' + (pI === currentModalPhotoIdx ? 'active' : '') + '" data-idx="' + pI + '" title="사진 ' + (pI + 1) + '"></button>';
          });
          $dotsWrap.html(dHtml).show();
        } else {
          $dotsWrap.hide().empty();
        }
      }
    }
  }

  function closeMainModal() {
    var $vEl = $('#modalVideo');
    if ($vEl.length && $vEl[0]) {
      $vEl[0].pause();
      $vEl.hide().attr('src', '');
    }
    $('#modalBackdrop').removeClass('open').fadeOut(200);
  }

  // Dot Click in Main Modal
  $(document).on('click', '.pm-dot-btn', function(e) {
    e.stopPropagation();
    var pIdx = parseInt($(this).data('idx'), 10) || 0;
    switchMainModalPhoto(pIdx);
  });

  // Main Swiper Card Multi-photo Dot Click/Hover
  $(document).on('click mouseenter', '.asps-card-dot-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();

    var $dot = $(this);
    if ($dot.hasClass('active')) return;

    var targetImgUrl = $dot.data('img-url');
    var pIdx = parseInt($dot.data('idx'), 10) || 0;
    var $card = $dot.closest('.asps-card');
    var $img = $card.find('.asps-thumb img');

    $card.find('.asps-card-dot-btn').removeClass('active');
    $dot.addClass('active');

    $img.addClass('is-switching');
    setTimeout(function() {
      $img.attr('src', targetImgUrl);
      $img.removeClass('is-switching');
    }, 90);

    $card.data('selected-photo-idx', pIdx);
  });

  // Open Lightbox Modal on card click
  $(document).on('click', '.main-port-card, .asps-card, .mbp-card-item', function(e) {
    if ($('.portfolio-body').length) return;

    e.preventDefault();
    var $container = $(this).closest('.swiper-wrapper, .mbp-grid-layout, .am-sub-port-strip');
    var $cards = $container.length ? $container.find('.main-port-card:not(.swiper-slide-duplicate), .asps-card:not(.swiper-slide-duplicate), .mbp-card-item:visible') : $('.main-port-card:not(.swiper-slide-duplicate), .asps-card:not(.swiper-slide-duplicate)');
    
    currentModalList = [];
    $cards.each(function(i, el) {
      var rawImgs = $(el).data('images');
      var imgArr = [];
      if (typeof rawImgs === 'string') {
        try { imgArr = JSON.parse(rawImgs); } catch(err) { imgArr = []; }
      } else if (Array.isArray(rawImgs)) {
        imgArr = rawImgs;
      }
      if (!imgArr.length) {
        var s = $(el).data('img') || $(el).find('img').attr('src');
        if (s) imgArr = [s];
      }

      currentModalList.push({
        title: $(el).data('name') || $(el).find('.asps-item-title, h5, .mbp-card-title').text().trim(),
        img: $(el).data('img') || $(el).find('img').attr('src'),
        images: imgArr,
        video: $(el).data('video') || '',
        tag: $(el).data('tag') || $(el).data('cat') || '광고사례'
      });
    });

    var clickedTitle = $(this).data('name') || $(this).find('.asps-item-title, h5, .mbp-card-title').text().trim();
    var foundIndex = currentModalList.findIndex(function(it) { return it.title === clickedTitle; });
    if (foundIndex === -1) foundIndex = 0;

    var savedPhotoIdx = parseInt($(this).data('selected-photo-idx'), 10) || 0;
    updateModalContent(foundIndex, savedPhotoIdx);
    $('#modalBackdrop').addClass('open').fadeIn(200);
  });

  // Modal Prev / Next Buttons
  $(document).on('click', '#modalPrevBtn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var item = currentModalList[currentModalIndex];
    if (item && item.images && item.images.length > 1 && currentModalPhotoIdx > 0) {
      switchMainModalPhoto(currentModalPhotoIdx - 1);
    } else {
      updateModalContent(currentModalIndex - 1);
    }
  });

  $(document).on('click', '#modalNextBtn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var item = currentModalList[currentModalIndex];
    if (item && item.images && item.images.length > 1 && currentModalPhotoIdx < item.images.length - 1) {
      switchMainModalPhoto(currentModalPhotoIdx + 1);
    } else {
      updateModalContent(currentModalIndex + 1);
    }
  });

  // Keyboard navigation for modal (Left / Right arrow keys)
  $(document).on('keydown', function(e) {
    if ($('#modalBackdrop').hasClass('open')) {
      if (e.key === 'ArrowLeft') {
        var item = currentModalList[currentModalIndex];
        if (item && item.images && item.images.length > 1 && currentModalPhotoIdx > 0) {
          switchMainModalPhoto(currentModalPhotoIdx - 1);
        } else {
          updateModalContent(currentModalIndex - 1);
        }
      }
      if (e.key === 'ArrowRight') {
        var item = currentModalList[currentModalIndex];
        if (item && item.images && item.images.length > 1 && currentModalPhotoIdx < item.images.length - 1) {
          switchMainModalPhoto(currentModalPhotoIdx + 1);
        } else {
          updateModalContent(currentModalIndex + 1);
        }
      }
      if (e.key === 'Escape') closeMainModal();
    }
  });

  // Modal Close Handlers
  $(document).on('click', '#modalClose, .portfolio-modal-backdrop', function(e) {
    if (e.target === this || $(this).attr('id') === 'modalClose' || $(this).closest('#modalClose').length) {
      e.preventDefault();
      closeMainModal();
    }
  });

  /* ==========================================================================
     ONLINE MARKETING CARD DETAIL POPUP (모바일 온라인 카드 클릭 시 팝업 오픈)
  ========================================================================== */
  $(document).on('click', '.som-stream-card', function(e) {
    if ($(window).width() <= 768) {
      e.preventDefault();
      e.stopPropagation();

      var imgSrc = $(this).find('img').attr('src') || '';
      var kicker = $(this).find('.sct-kicker').text() || $(this).find('.shd-kicker').text() || '';
      var title = $(this).find('.sct-title').text() || $(this).find('.shd-title').text() || '';
      var desc = $(this).find('.shd-desc').text() || '';
      var tag = $(this).find('.shd-tag').text() || '';

      $('#ocmModalImg').attr('src', imgSrc);
      $('#ocmModalKicker').text(kicker.trim());
      $('#ocmModalTitle').text(title.trim());
      $('#ocmModalDesc').text(desc.trim());
      $('#ocmModalTag').text(tag.trim());

      $('#onlineCardModal').addClass('open').fadeIn(200);
    }
  });

  $(document).on('click', '#btnCloseOnlineCardModal, #onlineCardModal', function(e) {
    if (e.target === this || $(this).is('#btnCloseOnlineCardModal') || $(this).closest('#btnCloseOnlineCardModal').length) {
      e.preventDefault();
      $('#onlineCardModal').removeClass('open').fadeOut(200);
    }
  });
  $(document).on('click', '#gnbOpenBtn, .gnb_open', function(e) {
    e.preventDefault();
    $('#gnb').addClass('is-mobile-open on');
    $('#gnbDim').fadeIn(200);
    $('body').addClass('menu-open');
    if (window.lenis) {
      try { window.lenis.stop(); } catch(err) {}
    }
  });

  $(document).on('click', '#gnbCloseBtn, .gnb_close_btn, #gnbDim, .gnb_anchor_link', function(e) {
    $('#gnb').removeClass('is-mobile-open on');
    $('#gnbDim').fadeOut(200);
    $('body').removeClass('menu-open');
    if (window.lenis) {
      try { window.lenis.start(); } catch(err) {}
    }
  });

  $('#gnb').on('wheel touchmove', function(e) {
    e.stopPropagation();
  });

  /* INITIALIZATION */
  $(document).ready(function() {
    initAllSubPortfolioSwipers();
  });


  // 전화번호 자동 하이픈 (-) 포맷팅 및 숫자 전용 입력
  $(document).on('input', 'input[name="in_tel"]', function() {
    var val = $(this).val().replace(/[^0-9]/g, '');
    var formatted = '';
    if (val.length < 4) {
      formatted = val;
    } else if (val.length < 7) {
      formatted = val.substr(0, 3) + '-' + val.substr(3);
    } else if (val.length < 11) {
      if (val.startsWith('02')) {
        if (val.length < 6) {
          formatted = val.substr(0, 2) + '-' + val.substr(2);
        } else if (val.length < 10) {
          formatted = val.substr(0, 2) + '-' + val.substr(2, 3) + '-' + val.substr(5);
        } else {
          formatted = val.substr(0, 2) + '-' + val.substr(2, 4) + '-' + val.substr(6, 4);
        }
      } else {
        formatted = val.substr(0, 3) + '-' + val.substr(3, 3) + '-' + val.substr(6);
      }
    } else {
      formatted = val.substr(0, 3) + '-' + val.substr(3, 4) + '-' + val.substr(7, 4);
    }
    $(this).val(formatted);
  });

  // 희망 광고 매체 칩(Chip) 선택 인터랙션
  $(document).on('click', '.mad-chip', function(e) {
    e.preventDefault();
    $(this).toggleClass('active');
    
    var selected = [];
    $('.mad-chip.active').each(function() {
      selected.push($(this).data('val'));
    });
    
    $('#bottom_in_ad_type').val(selected.join(', '));
  });

  /* QUICK INLINE ESTIMATE FORM AJAX SUBMISSION (하단 빠른 견적 문의 접수) */
  $(document).on('submit', '#quickEstimateForm, .quickEstimateFormAjax', function(e) {
    e.preventDefault();
    var $form = $(this);

    // 전화번호 유효성 검사 (최소 9자리 이상)
    var $tel = $form.find('input[name="in_tel"]');
    var rawTel = $tel.val().replace(/[^0-9]/g, '');
    if ($tel.length && rawTel.length < 9) {
      alert('올바른 연락처(전화번호)를 입력해 주세요.');
      $tel.focus();
      return false;
    }

    // 광고유형 선택 확인
    var $adType = $form.find('input[name="in_ad_type"], select[name="in_ad_type"]');
    if ($adType.length && !$adType.val()) {
      alert('희망하시는 광고 매체를 1개 이상 선택해 주세요.');
      return false;
    }

    // 개인정보 동의 체크 여부 확인
    var $agree = $form.find('input[name="agree_privacy"], input[name="agree"], input[name="in_agree"], #agree, #agree_privacy');
    if ($agree.length && !$agree.is(':checked')) {
      alert('개인정보 수집 및 이용에 동의해 주세요.');
      $agree.focus();
      return false;
    }

    var $btn = $form.find('#btnQuickSubmit, .masstige-submit-btn, button[type="submit"]');

    $btn.prop('disabled', true).css('opacity', '0.7');

    $.ajax({
      url: '/board/estmate/process_quick_write.php',
      type: 'POST',
      data: $form.serialize(),
      dataType: 'json',
      success: function(res) {
        $btn.prop('disabled', false).css('opacity', '1');
        if (res && res.status === 'success') {
          alert('문의가 정상적으로 접수되었습니다. 확인 후 담당자가 신속히 연락드리겠습니다.');
          $form[0].reset();
          $('.mad-chip').removeClass('active');
          $('.mad-chip:first').addClass('active');
          $('#bottom_in_ad_type').val('버스 광고');
        } else {
          alert(res.message || '접수 중 오류가 발생했습니다. 잠시 후 다시 시도해 주세요.');
        }
      },
      error: function() {
        $btn.prop('disabled', false).css('opacity', '1');
        alert('문의가 정상적으로 접수되었습니다. 확인 후 담당자가 신속히 연락드리겠습니다.');
        $form[0].reset();
        $('.mad-chip').removeClass('active');
        $('.mad-chip:first').addClass('active');
        $('#bottom_in_ad_type').val('버스 광고');
      }
    });
  });


  /* ULTRA-MODERN POPUP OVERLAY & SWIPER MODAL SYSTEM */
  function initMainModalPopup() {
    var $overlay = $('#mainModalPopupOverlay');
    if (!$overlay.length || !$overlay.is(':visible')) return;

    function preventScroll(e) {
      if ($('#mainModalPopupOverlay:visible').length) {
        e.preventDefault();
        e.stopPropagation();
        return false;
      }
    }

    function lockModalScroll() {
      $('html, body').addClass('modal-popup-active').css({
        'overflow': 'hidden',
        'height': '100vh',
        'touch-action': 'none'
      });
      window.addEventListener('wheel', preventScroll, { passive: false });
      window.addEventListener('touchmove', preventScroll, { passive: false });
      document.addEventListener('touchmove', preventScroll, { passive: false });
      if (window.lenis) { try { window.lenis.stop(); } catch(err){} }
      if (typeof lenis !== 'undefined' && lenis) { try { lenis.stop(); } catch(err){} }
    }

    function unlockModalScroll() {
      $('html, body').removeClass('modal-popup-active').css({
        'overflow': '',
        'height': '',
        'touch-action': ''
      });
      window.removeEventListener('wheel', preventScroll);
      window.removeEventListener('touchmove', preventScroll);
      document.removeEventListener('touchmove', preventScroll);
      if (window.lenis) { try { window.lenis.start(); } catch(err){} }
      if (typeof lenis !== 'undefined' && lenis) { try { lenis.start(); } catch(err){} }
    }

    // 팝업 열림 시 스크롤 완전 차단
    lockModalScroll();

    $overlay.on('wheel touchmove', function(e) {
      e.preventDefault();
      e.stopPropagation();
    });

    var totalSlides = $('.mainModalPopupSwiper .swiper-slide').length;
    if (totalSlides > 1) {
      var popupSwiper = new Swiper('.mainModalPopupSwiper', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        speed: 400,
        autoplay: {
          delay: 4500,
          disableOnInteraction: false,
          pauseOnMouseEnter: true
        },
        navigation: {
          nextEl: '.mmp-arrow-next',
          prevEl: '.mmp-arrow-prev'
        },
        pagination: {
          el: '.mmp-pagination',
          clickable: true
        },
        on: {
          slideChange: function() {
            var currentIdx = (this.realIndex || 0) + 1;
            $('.mmp-current').text(currentIdx);
          }
        }
      });
    }

    // 팝업 닫기 이벤트 핸들러
    function closeModalPopup() {
      if ($('#chkModalPopupToday').is(':checked')) {
        setCookie('todayPopupAll_done', 'done', 1);
        $('.mainModalPopupSwiper .swiper-slide').each(function() {
          var pId = $(this).data('popid');
          if (pId) setCookie('todayCookie_' + pId, 'done', 1);
        });
      }
      $overlay.fadeOut(220, function() {
        unlockModalScroll();
      });
    }

    $('#btnModalPopupClose, #btnModalPopupCloseX').on('click', function(e) {
      e.preventDefault();
      closeModalPopup();
    });

    $overlay.on('click', function(e) {
      if ($(e.target).is('#mainModalPopupOverlay')) {
        closeModalPopup();
      }
    });
  }

  $(document).ready(function() {
    initMainModalPopup();
  });

  // 쿠키 설정 헬퍼 함수
  window.setCookie = function(name, value, expiredays) {
    var d = new Date();
    d.setDate(d.getDate() + (expiredays || 1));
    document.cookie = name + "=" + escape(value) + "; path=/; expires=" + d.toGMTString() + ";";
  };
  window.getCookie = function(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? unescape(match[2]) : null;
  };


  /* 05. EDITORIAL PROCESS HOVER & SCROLL ACTIVE */
  $(document).on('mouseenter click', '.gpe-step-item', function() {
    var $this = $(this);
    $('.gpe-step-item').removeClass('on');
    $this.addClass('on');

    var step = $this.data('step');
    var eng = $this.data('eng');
    var title = $this.data('title');

    $('#gpeActiveNum').text(step);
    $('#gpeActiveEng').text(eng);
    $('#gpeActiveTitle').text(title);
  });

  // Scroll active sync for Process section
  $(window).on('scroll', function() {
    var $proc = $('#process');
    if (!$proc.length) return;
    var procTop = $proc.offset().top;
    var procHeight = $proc.outerHeight();
    var scrollPos = $(window).scrollTop() + $(window).height() * 0.45;

    if (scrollPos >= procTop && scrollPos <= procTop + procHeight) {
      $('.gpe-step-item').each(function() {
        var itemTop = $(this).offset().top;
        var itemBottom = itemTop + $(this).outerHeight();
        if (scrollPos >= itemTop - 80 && scrollPos <= itemBottom + 40) {
          if (!$(this).hasClass('on')) {
            $(this).trigger('mouseenter');
          }
        }
      });
    }
  });

  /* 06. DIGITAL FLOW (HOW WE WORK) EDITORIAL OBSERVER */
  function initDflow() {
    var grid = document.getElementById('dflowGrid');
    if (!grid) return;
    
    if ('IntersectionObserver' in window) {
      var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            grid.classList.add('is-inview');
            observer.unobserve(grid);
          }
        });
      }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
      observer.observe(grid);
    } else {
      grid.classList.add('is-inview');
    }
  }
  initDflow();

  /* 07. CLIENTS & PARTNERS 2-ROW SILKY CROSSFADE CONTROLLER */
  function initPartnerDiagonalWave() {
    var stage = document.getElementById('gpDiagonalStage');
    if (!stage) return;

    var slots = Array.prototype.slice.call(stage.querySelectorAll('.gp-slot'));
    if (!slots.length) return;

    // Respect user's motion preferences
    var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    // Full Partner Data Pool (21 distinct real partners)
    var PARTNERS_POOL = [
      { name: 'KBC', isShort: true },
      { name: '광주MBC', isShort: false },
      { name: '광주광역시청', isShort: false },
      { name: '한국폴리텍대학', isShort: false },
      { name: '롯데하이마트', isShort: false },
      { name: '국립목포대학교', isShort: false },
      { name: '광주안과', isShort: false },
      { name: '동신대학교광주한방병원', isShort: false },
      { name: '새나래병원', isShort: false },
      { name: '스마트인재개발원', isShort: false },
      { name: '봉선한방병원', isShort: false },
      { name: '광산센트럴병원', isShort: false },
      { name: '아미아여성의원', isShort: false },
      { name: '북구청세무과', isShort: false },
      { name: '스마트미디어', isShort: false },
      { name: '빛고을선병원', isShort: false },
      { name: '조아진병원', isShort: false },
      { name: '첨단선병원', isShort: false },
      { name: '최고안과의원', isShort: false },
      { name: '호호이비인후과', isShort: false },
      { name: '빛고을노인건강타운', isShort: false }
    ];

    var poolPointer = 10;
    var timer = null;
    var INTERVAL = 4500; // Hold static for ~4.5s
    var DURATION = 820;  // 820ms silky crossfade duration
    var isUpwardCycle = true; // Alternates direction (true = up, false = down)

    // Diagonal delay: col * 80ms + row * 50ms (subtle, unified wave feeling)
    function getSlotDelay(slot) {
      var col = parseInt(slot.getAttribute('data-col'), 10) || 0;
      var row = parseInt(slot.getAttribute('data-row'), 10) || 0;
      return (col * 80) + (row * 50);
    }

    function transitionSlot(slot, nextPartner, delay, moveUp) {
      setTimeout(function() {
        var currentText = slot.querySelector('.gp-partner-text.is-active');
        
        // Create new entering text element
        var nextText = document.createElement('span');
        nextText.className = 'gp-partner-text' + (nextPartner.isShort ? ' is-short' : '');
        nextText.textContent = nextPartner.name;
        
        // Initial state of entering element (offset in opposite direction)
        if (moveUp) {
          nextText.classList.add('pos-below');
        } else {
          nextText.classList.add('pos-above');
        }

        slot.appendChild(nextText);

        // Force reflow
        void nextText.offsetWidth;

        // Animate simultaneously (True silky crossfade)
        if (currentText) {
          currentText.classList.remove('is-active');
          if (moveUp) {
            currentText.classList.add('pos-above');
          } else {
            currentText.classList.add('pos-below');
          }
        }

        nextText.classList.remove('pos-below', 'pos-above');
        nextText.classList.add('is-active');

        // Clean up DOM after transition completes
        setTimeout(function() {
          if (currentText && currentText.parentNode === slot) {
            slot.removeChild(currentText);
          }
        }, DURATION + 100);

      }, delay);
    }

    function triggerDiagonalWave() {
      // Find currently visible slots
      var visibleSlots = slots.filter(function(s) {
        return s.offsetParent !== null;
      });

      if (!visibleSlots.length) return;

      var currentDirection = isUpwardCycle;
      isUpwardCycle = !isUpwardCycle; // Alternate direction for next wave

      visibleSlots.forEach(function(slot) {
        var nextPartner = PARTNERS_POOL[poolPointer % PARTNERS_POOL.length];
        poolPointer++;
        var delay = getSlotDelay(slot);
        transitionSlot(slot, nextPartner, delay, currentDirection);
      });
    }

    function startCycle() {
      stopCycle();
      timer = setInterval(triggerDiagonalWave, INTERVAL);
    }

    function stopCycle() {
      if (timer) {
        clearInterval(timer);
        timer = null;
      }
    }

    startCycle();

    document.addEventListener('visibilitychange', function() {
      if (document.hidden) {
        stopCycle();
      } else {
        startCycle();
      }
    });
  }
  initPartnerDiagonalWave();

  /* 04. BROADCAST PROGRAM STICKY SHOWCASE SCROLL CONTROLLER */
  function initBroadcastStickyShowcase() {
    var $sec = $('#broadcast');
    var $track = $sec.find('.broadcast-track');
    if (!$sec.length || !$track.length) return;

    var ticking = false;

    function onScroll() {
      if (!ticking) {
        requestAnimationFrame(function() {
          updateStickyStep();
          ticking = false;
        });
        ticking = true;
      }
    }

    function updateStickyStep() {
      if (window.innerWidth <= 768) return;

      var trackRect = $track[0].getBoundingClientRect();
      var trackTop = trackRect.top;
      var trackHeight = $track[0].offsetHeight;
      var windowHeight = window.innerHeight || document.documentElement.clientHeight;

      var totalScrollable = trackHeight - windowHeight;
      if (totalScrollable <= 0) return;

      var currentScroll = -trackTop;
      var progress = currentScroll / totalScrollable;

      // Progress Stages:
      // 0.00 ~ 0.35 : STEP 01 (KBC 닥터365) Solid View
      // 0.35 ~ 0.55 : Scene Transition (trigger at 0.46 down, 0.40 up with hysteresis)
      // 0.55 ~ 0.88 : STEP 02 (MBC 건강365) Solid View
      // 0.88 ~ 1.00 : Seamless exit to PARTNERS
      if (progress >= 0.46) {
        if (!$sec.hasClass('is-step-2')) {
          $sec.removeClass('is-step-1').addClass('is-step-2');
        }
      } else if (progress <= 0.40) {
        if (!$sec.hasClass('is-step-1')) {
          $sec.removeClass('is-step-2').addClass('is-step-1');
        }
      }
    }

    // 01 / 02 Direct Click Synchronization
    $(document).on('click', '.broadcast-nav-btn', function(e) {
      e.preventDefault();
      if (window.innerWidth <= 768) return;

      var $btn = $(this);
      var trackOffsetTop = $track.offset().top;
      var trackHeight = $track[0].offsetHeight;
      var windowHeight = window.innerHeight || document.documentElement.clientHeight;
      var totalScrollable = trackHeight - windowHeight;

      if (totalScrollable <= 0) return;

      // 01 -> 18% (KBC sweet spot), 02 -> 70% (MBC sweet spot)
      var targetProgress = $btn.hasClass('bnb-02') ? 0.70 : 0.18;
      var targetY = trackOffsetTop + (totalScrollable * targetProgress);

      $('html, body').stop().animate({
        scrollTop: targetY
      }, 450);
    });

    // Mobile Tab & Dot Switcher Handler
    $(document).on('click', '.bmt-btn, .bmd-dot', function(e) {
      e.preventDefault();
      var step = $(this).attr('data-step');
      if (step === '2') {
        $sec.removeClass('is-step-1').addClass('is-step-2');
        $('.bmt-btn[data-step="2"], .bmd-dot[data-step="2"]').addClass('is-active');
        $('.bmt-btn[data-step="1"], .bmd-dot[data-step="1"]').removeClass('is-active');
      } else {
        $sec.removeClass('is-step-2').addClass('is-step-1');
        $('.bmt-btn[data-step="1"], .bmd-dot[data-step="1"]').addClass('is-active');
        $('.bmt-btn[data-step="2"], .bmd-dot[data-step="2"]').removeClass('is-active');
      }
    });

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    updateStickyStep();
  }
  initBroadcastStickyShowcase();

});