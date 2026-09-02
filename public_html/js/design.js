$(function() {

  /* COMMON */
  $windowWid = window.innerWidth;

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
    if (document.querySelector('.main_hero')) {
      lenis.stop();
      window.addEventListener('heroUnlock', function() { lenis.start(); });
      window.addEventListener('heroLock', function() { lenis.stop(); });
    }
  }

  /* GSAP SCROLL STEP HERO INTERACTION */
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
    var currentStep = 1;
    var scrollLocked = true;

    
    /* REFRESH CHECK */
    if (hero.getBoundingClientRect().bottom < 0) {
      currentStep = 3;
      scrollLocked = false;
      window.dispatchEvent(new Event('heroUnlock'));

      gsap.set(wrap, { width: '100%', height: '100vh', top: '0%', left: '50%', xPercent: -50 });
      gsap.set(panel, { borderRadius: 0, y: 0, scale: 1 });
      gsap.set(video, { scale: 1.05 });
      gsap.set(dim, { backgroundColor: 'rgba(0,0,0,0.48)' });
      gsap.set(title, { opacity: 0 });
      gsap.set(keywords, { opacity: 0 });
      gsap.set(overlay, { opacity: 1, y: 0 });
      gsap.set('.mho-text-box', { scale: 1, opacity: 1 });
    } else {
      window.dispatchEvent(new Event('heroLock'));
      gsap.set(wrap, { width: '60%', height: '62vh', top: '36%', left: '50%', xPercent: -50 });
      gsap.set(panel, { borderRadius: '42px', y: 40, scale: 0.9 });
      gsap.set(video, { scale: 1 });
      gsap.set(dim, { backgroundColor: 'rgba(0,0,0,0)' });
      gsap.set(title, { opacity: 1 });
      gsap.set(keywords, { opacity: 1 });
      gsap.set(overlay, { opacity: 0, y: -20 });
      gsap.set('.mho-text-box', { scale: 1.08, opacity: 0 });
    }

        /* DOWN TIMELINE (SYMMETRICAL 1.2S SILKY EXPANSION) */
    var tlDown = gsap.timeline({
      paused: true,
      onStart: function() {
        isAnimating = true;
        scrollLocked = true;
        window.dispatchEvent(new Event('heroLock'));
      },
      onComplete: function() {
        isAnimating = false;
        currentStep = 3;
        setTimeout(function() {
          scrollLocked = false;
          window.dispatchEvent(new Event('heroUnlock'));
        }, 300);
      }
    });

    tlDown
      .to(title, { duration: 0.45, opacity: 0, ease: 'power2.out' })
      .to(keywords, { duration: 0.4, opacity: 0, ease: 'power2.out' }, '<')
      .to(wrap, { duration: 1.2, width: '100%', height: '100vh', top: '0%', ease: 'power3.inOut' }, '-=0.2')
      .to(panel, { duration: 1.2, borderRadius: 0, y: 0, scale: 1, ease: 'power3.inOut' }, '<')
      .to(video, { duration: 1.2, scale: 1.05, ease: 'power3.inOut' }, '<')
      .to(dim, { duration: 0.8, backgroundColor: 'rgba(0,0,0,0.48)', ease: 'power2.out' }, '-=0.6')
      .to(overlay, { duration: 0.8, opacity: 1, y: 0, ease: 'power2.out' }, '<')
      .fromTo('.mho-text-box', { scale: 1.1, opacity: 0 }, { duration: 1.0, scale: 1, opacity: 1, ease: 'power2.out' }, '-=0.7');

    /* UP TIMELINE (SYMMETRICAL 1.2S SILKY CONTRACTION) */
    var tlUp = gsap.timeline({
      paused: true,
      onStart: function() {
        isAnimating = true;
        scrollLocked = true;
        window.dispatchEvent(new Event('heroLock'));
      },
      onComplete: function() {
        isAnimating = false;
        currentStep = 1;
        scrollLocked = false;
        window.dispatchEvent(new Event('heroLock'));
      }
    });

    tlUp
      .to('.mho-text-box', { duration: 0.45, scale: 1.08, opacity: 0, ease: 'power2.inOut' })
      .to(overlay, { duration: 0.45, opacity: 0, y: -15, ease: 'power2.inOut' }, '<')
      .to(dim, { duration: 0.6, backgroundColor: 'rgba(0,0,0,0)', ease: 'power2.out' }, '<')
      .to(wrap, { duration: 1.2, width: '60%', height: '62vh', top: '36%', ease: 'power3.inOut' }, '-=0.3')
      .to(panel, { duration: 1.2, borderRadius: '42px', y: 40, scale: 0.9, ease: 'power3.inOut' }, '<')
      .to(video, { duration: 1.2, scale: 1, ease: 'power3.inOut' }, '<')
      .to(keywords, { duration: 0.6, opacity: 1, ease: 'power2.out' }, '-=0.4')
      .to(title, { duration: 0.6, opacity: 1, ease: 'power2.out' }, '<');


    function stepDown() {
      if (isAnimating || currentStep >= 3) return;
      currentStep = 2;
      tlUp.pause(0);
      tlDown.restart();
    }

    function stepUp() {
      if (isAnimating || currentStep <= 1) return;
      currentStep = 2;
      tlDown.pause(0);
      tlUp.restart();
    }

    /* WHEEL */
    window.addEventListener('wheel', function(e) {
      if (currentStep === 3 && !scrollLocked && e.deltaY > 0) return;

      if (currentStep === 3 && e.deltaY < 0) {
        var videoWrap = hero.querySelector('.main_hero_panel_video_wrap');
        var videoTop = videoWrap.getBoundingClientRect().top;
        if (videoTop >= 0) {
          e.preventDefault();
          stepUp();
          return;
        }
        return;
      }

      if (e.deltaY > 0 && currentStep < 3) {
        e.preventDefault();
        stepDown();
        return;
      }

      if (currentStep === 3 && scrollLocked) {
        e.preventDefault();
      }
    }, { passive: false });

    /* KEYBOARD */
    $(window).on('keydown', function(e) {
      if ((e.keyCode === 40 || e.keyCode === 34 || e.keyCode === 32) && currentStep < 3) {
        e.preventDefault();
        stepDown();
      }
      if ((e.keyCode === 38 || e.keyCode === 33) && currentStep > 1) {
        e.preventDefault();
        stepUp();
      }
    });

    /* TOUCH */
    var touchStartY = 0;
    hero.addEventListener('touchstart', function(e) {
      touchStartY = e.touches[0].clientY;
    }, { passive: true });

    hero.addEventListener('touchend', function(e) {
      var diff = touchStartY - e.changedTouches[0].clientY;
      if (Math.abs(diff) < 30) return;
      if (diff > 0) stepDown();
      else stepUp();
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

  /* 02. BUS BLUEPRINT CONSOLE INTERACTION */
  $(document).on('click', '.bus-spot-btn', function(e) {
    e.preventDefault();
    var $btn = $(this);
    $('.bus-spot-btn').removeClass('on');
    $btn.addClass('on');

    var name = $btn.data('name');
    var size = $btn.data('size');
    var target = $btn.data('target');
    var material = $btn.data('material');
    var benefit = $btn.data('benefit');

    $('#dynBusBadge').text(name);
    $('#dynBusSize').text(size);
    $('#dynBusTarget').text(target);
    $('#dynBusMaterial').text(material);
    $('#dynBusBenefit').text(benefit);

    var markers = {
      '차도면 대형 래핑': { top: '35%', left: '25%' },
      '인도면 표준 래핑': { top: '45%', left: '70%' },
      '후면 번호판 상단 래핑': { top: '55%', left: '88%' },
      '사랑면 (승하차문 측면)': { top: '50%', left: '60%' },
      '내부 중앙창문 포스터': { top: '30%', left: '48%' },
      '정류소 음성 안내 방송': { top: '20%', left: '15%' }
    };
    if (markers[name]) {
      $('#dvsMarker').css(markers[name]);
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

  /* 04. VIDEO PRODUCTION CONSOLE INTERACTION */
  $(document).on('click', '.avc-btn', function() {
    $('.avc-btn').removeClass('on');
    $(this).addClass('on');
    var mode = $(this).data('video-mode');
    if (mode === 'shorts') {
      $('#dynVideoFrame').addClass('shorts-mode');
      $('.avp-card[data-target-mode="shorts"]').first().trigger('click');
    } else {
      $('#dynVideoFrame').removeClass('shorts-mode');
      $('.avp-card[data-target-mode="wide"]').first().trigger('click');
    }
  });

  $(document).on('click', '.avp-card', function() {
    $('.avp-card').removeClass('on');
    $(this).addClass('on');
    var title = $(this).data('vtitle');
    var sub = $(this).data('vsub');
    var mode = $(this).data('target-mode');

    $('#dynVideoTitle').text(title);
    $('#dynVideoSub').text(sub);
    $('#dynVideoTag').text(mode === 'shorts' ? '9:16 SNS SHORTS' : '16:9 4K BRAND FILM');

    if (mode === 'shorts') {
      $('#dynVideoFrame').addClass('shorts-mode');
      $('.avc-btn[data-video-mode="shorts"]').addClass('on').siblings().removeClass('on');
    } else {
      $('#dynVideoFrame').removeClass('shorts-mode');
      $('.avc-btn[data-video-mode="wide"]').addClass('on').siblings().removeClass('on');
    }
  });

  /* 05. SPECIALIZED OOH ACCORDION */
  $(document).on('click', '.aoa-card', function() {
    $('.aoa-card').removeClass('on');
    $(this).addClass('on');
  });

  /* 06. PORTFOLIO FILTER & LIGHTBOX MODAL */
  $(document).on('click', '.afc-btn', function() {
    $('.afc-btn').removeClass('on');
    $(this).addClass('on');
    var filter = $(this).data('filter');
    if (filter === 'all') {
      $('.main-port-card').fadeIn(200);
    } else {
      $('.main-port-card').each(function() {
        if ($(this).data('cat') === filter) {
          $(this).fadeIn(200);
        } else {
          $(this).hide();
        }
      });
    }
  });

  $(document).on('click', '.main-port-card', function() {
    var $img = $(this).find('img');
    var src = $img.attr('src');
    var title = $(this).data('name') || $img.attr('alt') || '프로젝트';
    var cat = $(this).find('.apg-tag').text() || '광고사례';
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

  /* 07. SPECIFICATION GUIDE MODAL */
  function openGuideModal(targetTab) {
    var target = targetTab || 'guideBus';
    $('body').addClass('modal-lock');
    $('#busGuideOverlay').addClass('on').fadeIn(200);
    $('.lmt-tab').removeClass('on');
    $('.lmt-tab[data-target="' + target + '"]').addClass('on');
    $('.bus-guide-page').removeClass('on').hide();
    $('#' + target).addClass('on').show();
  }

  function closeGuideModal() {
    $('#busGuideOverlay').removeClass('on').fadeOut(200);
    $('body').removeClass('modal-lock');
  }

  $(document).on('click', '.bus-guide-open', function(e) {
    e.preventDefault();
    var guide = $(this).data('guide') || 'guideBus';
    openGuideModal(guide);
  });

  $(document).on('click', '#btnCloseBusGuide, #busGuideOverlay', function(e) {
    if (e.target === this || $(e.target).is('#btnCloseBusGuide')) {
      closeGuideModal();
    }
  });

  $(document).on('click', '.lmt-tab', function() {
    var target = $(this).data('target');
    $('.lmt-tab').removeClass('on');
    $(this).addClass('on');
    $('.bus-guide-page').removeClass('on').hide();
    $('#' + target).addClass('on').show();
  });

  /* ESC KEY */
  $(document).on('keydown', function(e) {
    if (e.key === 'Escape') {
      closeRouteModal();
      closeGuideModal();
      $('#modalBackdrop').removeClass('open').fadeOut(200);
      $('body').removeClass('modal-lock');
    }
  });

});


  /* 08. CONSULTATION FORM SUBMISSION VALIDATION */
  $('#btn_submit').on('click', function(e) {
    e.preventDefault();
    var company = $('#in_company').val().trim();
    var name = $('#in_name').val().trim();
    var tel = $('#in_tel').val().trim();
    var email = $('#in_email').val().trim();
    var adTypeCount = $('input[name="in_ad_type[]"]:checked').length;
    var agree = $('#agree').is(':checked');

    if (!company) {
      alert('회사명 또는 병의원명을 입력해주세요.');
      $('#in_company').focus();
      return;
    }
    if (!name) {
      alert('담당자명을 입력해주세요.');
      $('#in_name').focus();
      return;
    }
    if (!tel) {
      alert('연락처를 입력해주세요.');
      $('#in_tel').focus();
      return;
    }
    if (!email) {
      alert('이메일 주소를 입력해주세요.');
      $('#in_email').focus();
      return;
    }
    if (adTypeCount === 0) {
      alert('관심 있는 광고 매체를 최소 1개 이상 선택해주세요.');
      return;
    }
    if (!agree) {
      alert('개인정보 수집 및 이용에 동의해주세요.');
      $('#agree').focus();
      return;
    }

    $('form[name="frm"]').submit();
  });
