/* ==========================================================================
   GAON-N 2026 ELITE BRANDED STYLING & GOTHIC TYPOGRAPHY JS
   ========================================================================== */
$(function () {
  'use strict';

  if (typeof WOW !== 'undefined') {
    new WOW().init();
  }

  /* 01. ANIMATED LIVE COUNTERS */
  $('.counter').each(function() {
    var $this = $(this);
    var target = parseInt($this.attr('data-target'), 10) || 0;
    $({ countNum: 0 }).animate({ countNum: target }, {
      duration: 1800,
      easing: 'swing',
      step: function() {
        $this.text(Math.floor(this.countNum));
      },
      complete: function() {
        $this.text(this.countNum);
      }
    });
  });

  /* 02. BUS BLUEPRINT CHIP SWITCHER */
  $(document).on('click', '.bus-spot-btn', function(e) {
    e.preventDefault();
    var $btn = $(this);
    var name = $btn.attr('data-name');
    var size = $btn.attr('data-size');
    var target = $btn.attr('data-target');
    var material = $btn.attr('data-material');
    var benefit = $btn.attr('data-benefit');

    $('.bus-spot-btn').removeClass('on');
    $btn.addClass('on');

    $('#dynBusBadge').text(name);
    $('#dynBusSize').text(size);
    $('#dynBusTarget').text(target);
    if (material) {
      $('#dynBusMaterial').text(material);
    }
    $('#dynBusBenefit').text(benefit);

    var markerPos = [
      { top: '35%', left: '25%' },
      { top: '55%', left: '60%' },
      { top: '35%', left: '85%' },
      { top: '48%', left: '72%' },
      { top: '25%', left: '50%' },
      { top: '40%', left: '15%' }
    ];
    var idx = $btn.index() % markerPos.length;
    $('#dvsMarker').css(markerPos[idx]);
  });

  /* 03. 104 ALL BUS ROUTES DATABASE IN LUXURY DIRECTORY LIST */
  var routesData = [{"num":"순환01","cat":"express","district":"seo","desc":"상무지구 ↔ 광천터미널 ↔ 전남대 ↔ 조선대 ↔ 백운광장 (도심 순환)","fleet":"32대 운행","interval":"10~12분","target":"광주 전역 직장인·대학생"},{"num":"수완03","cat":"express","district":"gwangsan","desc":"송원대 ↔ 상무역 ↔ 유스퀘어 ↔ 첨단2지구 ↔ 수완지구","fleet":"28대 운행","interval":"8~10분","target":"수완·첨단 주거지 ↔ 상무 상권"},{"num":"첨단09","cat":"express","district":"buk","desc":"첨단종점 ↔ 전남대 ↔ 법원 ↔ 조선대 ↔ 양림휴먼시아","fleet":"26대 운행","interval":"10~13분","target":"첨단산단 ↔ 대학가 ↔ 법원"},{"num":"매월06","cat":"express","district":"seo","desc":"매월동 ↔ 풍암지구 ↔ 백운동 ↔ 충장로 ↔ 광주역","fleet":"20대 운행","interval":"12~15분","target":"풍암·백운 주거지 ↔ 구도심"},{"num":"진월07","cat":"express","district":"nam","desc":"송암공단 ↔ 대성여고 ↔ 백운광장 ↔ 동구청 ↔ 살레시오고","fleet":"18대 운행","interval":"12~15분","target":"남구 학군 밀집지 ↔ 동구"},{"num":"좌석02","cat":"express","district":"gwangsan","desc":"무등산국립공원 ↔ 조선대 ↔ 유스퀘어 ↔ 송정역 ↔ 나주혁신도시","fleet":"24대 운행","interval":"15~18분","target":"광주 ↔ 나주혁신도시 통근"},{"num":"매월16","cat":"main","district":"seo","desc":"매월동 ↔ 풍암지구 ↔ 상무지구 ↔ 광천터미널 ↔ 일곡지구","fleet":"24대 운행","interval":"10~13분","target":"풍암·상무·일곡 핵심 축"},{"num":"문흥18","cat":"main","district":"buk","desc":"장등동 ↔ 문흥지구 ↔ 전남대 ↔ 광천터미널 ↔ 상무지구","fleet":"22대 운행","interval":"11~14분","target":"문흥 아파트단지 ↔ 상무지구"},{"num":"봉선37","cat":"main","district":"nam","desc":"송암공단 ↔ 봉선동 학원가 ↔ 조선대 ↔ 산수동 ↔ 살레시오여고","fleet":"22대 운행","interval":"10~12분","target":"봉선동 학원가/학부모 독점"},{"num":"지원15","cat":"main","district":"nam","desc":"월남동 ↔ 조선대 ↔ 충장로 ↔ 대인시장 ↔ 광주역 ↔ 효천지구","fleet":"20대 운행","interval":"12~15분","target":"효천·월남 ↔ 충장로"},{"num":"일곡28","cat":"main","district":"buk","desc":"일곡지구 ↔ 양산지구 ↔ 광천터미널 ↔ 조선대 ↔ 매월동","fleet":"21대 운행","interval":"11~13분","target":"양산·일곡 북구 배후세대"},{"num":"첨단20","cat":"main","district":"gwangsan","desc":"첨단종점 ↔ 신창지구 ↔ 광천터미널 ↔ 양동시장 ↔ 조선대","fleet":"19대 운행","interval":"13~16분","target":"신창·첨단 ↔ 터미널"},{"num":"첨단30","cat":"main","district":"gwangsan","desc":"첨단산단 ↔ 수완지구 ↔ 운남지구 ↔ 상무지구 ↔ 광천터미널","fleet":"23대 운행","interval":"10~12분","target":"수완·운남·첨단 직통"},{"num":"첨단40","cat":"main","district":"gwangsan","desc":"비아동 ↔ 첨단2지구 ↔ 전남대 ↔ 광주역 ↔ 화순전남대병원","fleet":"18대 운행","interval":"14~17분","target":"대학병원 및 전남대"},{"num":"송정19","cat":"main","district":"gwangsan","desc":"장등동 ↔ 광주역 ↔ 시청 ↔ 광주송정역 ↔ 도산동","fleet":"20대 운행","interval":"12~15분","target":"KTX 송정역 & 시청"},{"num":"송정29","cat":"main","district":"gwangsan","desc":"도산동 ↔ 광주송정역 ↔ 우산동 ↔ 광천터미널 ↔ 살레시오여고","fleet":"19대 운행","interval":"13~16분","target":"송정역 ↔ 광천터미널"},{"num":"풍암16","cat":"main","district":"seo","desc":"매월동 ↔ 풍암지구 ↔ 금호지구 ↔ 상무지구 ↔ 광천터미널","fleet":"20대 운행","interval":"11~14분","target":"금호·풍암 아파트 주민"},{"num":"풍암26","cat":"main","district":"seo","desc":"매월동 ↔ 서구청 ↔ 충장로 ↔ 조선대 ↔ 각화동","fleet":"18대 운행","interval":"13~16분","target":"서구청·조선대 상권"},{"num":"금호36","cat":"main","district":"seo","desc":"서창동 ↔ 금호지구 ↔ 상무지구 ↔ 광주역 ↔ 장등동","fleet":"19대 운행","interval":"12~15분","target":"금호지구 및 상무역"},{"num":"금호46","cat":"main","district":"seo","desc":"화순전남대병원 ↔ 소태역 ↔ 풍암지구 ↔ 상무지구","fleet":"17대 운행","interval":"14~18분","target":"상무지구 ↔ 화순병원"},{"num":"운림51","cat":"main","district":"dong","desc":"무등산국립공원 ↔ 조선대 ↔ 충장로 ↔ 유스퀘어 ↔ 첨단산단","fleet":"21대 운행","interval":"11~14분","target":"문화전당 ↔ 터미널 ↔ 첨단"},{"num":"운림54","cat":"main","district":"dong","desc":"무등산국립공원 ↔ 남광주역 ↔ 광주역 ↔ 양산지구","fleet":"16대 운행","interval":"15~18분","target":"남광주시장 & 양산동"},{"num":"문흥39","cat":"main","district":"buk","desc":"장등동 ↔ 문흥지구 ↔ 전남대 ↔ 광천터미널 ↔ 송암공단","fleet":"18대 운행","interval":"13~16분","target":"문흥지구 ↔ 송암공단"},{"num":"문흥48","cat":"main","district":"buk","desc":"장등동 ↔ 문흥지구 ↔ 법원 ↔ 조선대 ↔ 효천지구","fleet":"17대 운행","interval":"14~17분","target":"효천지구 ↔ 법원 행정타운"},{"num":"지원25","cat":"main","district":"nam","desc":"월남동 ↔ 봉선동 ↔ 백운광장 ↔ 양동시장 ↔ 서창동","fleet":"16대 운행","interval":"15~18분","target":"봉선동·백운광장 로컬"},{"num":"지원56","cat":"main","district":"nam","desc":"월남동 ↔ 소태역 ↔ 조선대 ↔ 충장로 ↔ 광주역","fleet":"15대 운행","interval":"16~20분","target":"동남부 주거지 ↔ 충장로"},{"num":"용봉83","cat":"main","district":"buk","desc":"용봉동 ↔ 전남대후문 ↔ 산수오거리 ↔ 조선대 ↔ 학운동","fleet":"18대 운행","interval":"12~15분","target":"전남대·조선대 학생"},{"num":"대촌70","cat":"main","district":"nam","desc":"칠석동 ↔ 대촌 ↔ 백운광장 ↔ 양동시장 ↔ 광천터미널","fleet":"14대 운행","interval":"18~22분","target":"에너지밸리 ↔ 도심"},{"num":"송암72","cat":"main","district":"nam","desc":"송암공단 ↔ 진월지구 ↔ 백운동 ↔ 충장로 ↔ 수완지구","fleet":"20대 운행","interval":"12~15분","target":"진월·백운 ↔ 수완"},{"num":"수완12","cat":"main","district":"gwangsan","desc":"수완종점 ↔ 신가동 ↔ 운남지구 ↔ 상무지구 ↔ 광천터미널","fleet":"22대 운행","interval":"10~13분","target":"수완지구 10만 배후세대"}];

  function renderModalBusRoutes(filterCat, searchKeyword) {
    var $grid = $('#modalBusRouteFullGrid');
    $grid.empty();

    var filtered = routesData.filter(function(r) {
      var matchCat = true;
      if (filterCat && filterCat !== 'all') {
        if (filterCat === 'express' || filterCat === 'main' || filterCat === 'feeder') {
          matchCat = (r.cat === filterCat);
        } else if (filterCat === 'seo' || filterCat === 'nam' || filterCat === 'buk' || filterCat === 'gwangsan' || filterCat === 'dong') {
          matchCat = (r.district === filterCat || r.desc.indexOf(filterCat === 'seo' ? '상무' : filterCat === 'nam' ? '봉선' : filterCat === 'buk' ? '전남대' : '수완') !== -1);
        }
      }
      var matchSearch = true;
      if (searchKeyword && searchKeyword.trim() !== '') {
        var kw = searchKeyword.trim().toLowerCase();
        matchSearch = (r.num.toLowerCase().indexOf(kw) !== -1 || r.desc.toLowerCase().indexOf(kw) !== -1 || r.target.toLowerCase().indexOf(kw) !== -1);
      }
      return matchCat && matchSearch;
    });

    if (filtered.length === 0) {
      $grid.html('<div style="padding:40px; text-align:center; color:#94a3b8; font-size:14px; background:#f8fafc; border-radius:12px;">검색된 시내버스 노선이 없습니다. 다른 검색어를 입력해 보세요.</div>');
      return;
    }

    filtered.forEach(function(r) {
      var tagClass = r.cat === 'express' ? 'red' : r.cat === 'main' ? 'blue' : 'green';
      var tagLabel = r.cat === 'express' ? '급행' : r.cat === 'main' ? '간선' : '지선';
      var html = '<div class="rsd-row">' +
        '<div class="rsd-badge-col">' +
          '<span class="rsd-tag ' + tagClass + '">' + tagLabel + '</span>' +
          '<strong class="rsd-num">' + r.num + '</strong>' +
        '</div>' +
        '<div class="rsd-desc-col">' +
          '<span class="rsd-path">' + r.desc + '</span>' +
          '<span class="rsd-target">타깃: ' + r.target + '</span>' +
        '</div>' +
        '<div class="rsd-fleet-col">' +
          '<span><strong>' + r.fleet + '</strong></span>' +
          '<span>' + r.interval + '</span>' +
        '</div>' +
        '<div class="rsd-action-col">' +
          '<a href="/board/estmate/write.php" class="rsd-btn">이 노선 견적조회 →</a>' +
        '</div>' +
      '</div>';
      $grid.append(html);
    });
  }

  // Open Route Search Modal
  $(document).on('click', '#btnOpenRouteSearchModal', function(e) {
    e.preventDefault();
    renderModalBusRoutes('all', '');
    $('html, body').addClass('modal-open');
    $('#routeSearchModal').fadeIn(200);
  });

  $(document).on('click', '#btnCloseRouteSearch', function(e) {
    e.preventDefault();
    $('#routeSearchModal').fadeOut(200);
    if (!$('#busGuideOverlay').is(':visible') && !$('#modalBackdrop').is(':visible')) {
      $('html, body').removeClass('modal-open');
    }
  });

  $(document).on('click', '#routeSearchModal', function(e) {
    if (e.target === this) {
      $('#routeSearchModal').fadeOut(200);
      if (!$('#busGuideOverlay').is(':visible') && !$('#modalBackdrop').is(':visible')) {
        $('html, body').removeClass('modal-open');
      }
    }
  });

  $(document).on('click', '.rsm-tab', function(e) {
    e.preventDefault();
    $('.rsm-tab').removeClass('on');
    $(this).addClass('on');
    var cat = $(this).attr('data-filter-cat');
    var kw = $('#modalBusRouteSearchInput').val();
    renderModalBusRoutes(cat, kw);
  });

  $(document).on('input', '#modalBusRouteSearchInput', function() {
    var kw = $(this).val();
    var cat = $('.rsm-tab.on').attr('data-filter-cat') || 'all';
    renderModalBusRoutes(cat, kw);
  });

  /* 04. VIDEO FORMAT SWITCHER & PRODUCT CLICK */
  $(document).on('click', '.avc-btn', function(e) {
    e.preventDefault();
    var mode = $(this).attr('data-video-mode');

    $('.avc-btn').removeClass('on');
    $(this).addClass('on');

    if (mode === 'shorts') {
      $('#dynVideoFrame').css({ 'aspect-ratio': '9/16', 'max-width': '340px', 'margin': '0 auto' });
      $('#dynVideoTag').text('9:16 SNS 릴스 & 쇼츠');
      $('#dynVideoTitle').text('모바일 최적화 세로형 숏폼 바이럴 영상');
      $('#dynVideoSub').text('첫 3초 만에 시선을 사로잡는 빠른 템포의 SNS 영상');
    } else {
      $('#dynVideoFrame').css({ 'aspect-ratio': '16/9', 'max-width': '100%', 'margin': '0' });
      $('#dynVideoTag').text('16:9 4K BRAND FILM');
      $('#dynVideoTitle').text('기업 · 상급병원 4K 시네마틱 브랜드 필름');
      $('#dynVideoSub').text('Sony FX Cinema 풀프레임 + 4K 드론 항공촬영 + 전문 성우 더빙');
    }
  });

  $(document).on('click', '.avp-card', function(e) {
    e.preventDefault();
    $('.avp-card').removeClass('on');
    $(this).addClass('on');
    var targetMode = $(this).attr('data-target-mode');
    var vtitle = $(this).attr('data-vtitle');
    var vsub = $(this).attr('data-vsub');

    $('.avc-btn[data-video-mode="' + targetMode + '"]').trigger('click');
    if (vtitle) $('#dynVideoTitle').text(vtitle);
    if (vsub) $('#dynVideoSub').text(vsub);
  });

  /* 05. OOH ACCORDION HOVER/CLICK */
  $(document).on('mouseenter click', '.aoa-card', function() {
    $('.aoa-card').removeClass('on');
    $(this).addClass('on');
  });

  /* 06. ALL-IN-ONE MASTER PORTFOLIO FILTER */
  $(document).on('click', '.afc-btn', function(e) {
    e.preventDefault();
    var filter = $(this).attr('data-filter');

    $('.afc-btn').removeClass('on');
    $(this).addClass('on');

    if (filter === 'all') {
      $('#masterPortGrid .apg-card').fadeIn(200);
    } else {
      $('#masterPortGrid .apg-card').each(function() {
        var cat = $(this).attr('data-cat');
        if (cat === filter) {
          $(this).fadeIn(200);
        } else {
          $(this).hide();
        }
      });
    }
  });

  /* 07. GUIDE MODAL HANDLERS (5 TABS) */
  function openGuideModal(targetTab) {
    var target = targetTab || 'guideBus';
    $('html, body').addClass('modal-open');
    $('#busGuideOverlay').fadeIn(200);
    $('.lmt-tab').removeClass('on');
    $('.lmt-tab[data-target="' + target + '"]').addClass('on');
    $('.bus-guide-page').removeClass('on').hide();
    $('#' + target).addClass('on').show();
    $('#busGuideOverlay .lux-modal-panel').scrollTop(0);
  }

  function closeGuideModal() {
    $('#busGuideOverlay').fadeOut(200);
    if (!$('#modalBackdrop').is(':visible') && !$('#routeSearchModal').is(':visible')) {
      $('html, body').removeClass('modal-open');
    }
  }

  $(document).on('click', '.bus-guide-open', function(e) {
    e.preventDefault();
    var target = $(this).attr('data-guide') || 'guideBus';
    openGuideModal(target);
  });

  $(document).on('click', '.lux-modal-close, #btnCloseBusGuide', function(e) {
    e.preventDefault();
    closeGuideModal();
  });

  $(document).on('click', '#busGuideOverlay', function(e) {
    if (e.target === this) {
      closeGuideModal();
    }
  });

  $(document).on('click', '.lmt-tab', function(e) {
    e.preventDefault();
    var target = $(this).attr('data-target') || 'guideBus';
    $('.lmt-tab').removeClass('on');
    $(this).addClass('on');
    $('.bus-guide-page').removeClass('on').hide();
    $('#' + target).addClass('on').show();
  });

  /* 08. PORTFOLIO LIGHTBOX MODAL HANDLER */
  function openPortfolioModal(name, cat, img, id) {
    $('#modalTitle').text(name || '광고 프로젝트');
    $('#modalCat').text(cat || '광고 집행 사례');
    $('#modalId').text('#' + (id || '01'));
    if (img && img.trim() !== '') {
      $('#modalImg').attr('src', img).show();
    } else {
      $('#modalImg').hide();
    }
    $('html, body').addClass('modal-open');
    $('#modalBackdrop').fadeIn(200);
    $('#modalBackdrop .portfolio-modal-box').scrollTop(0);
  }

  function closePortfolioModal() {
    $('#modalBackdrop').fadeOut(200);
    if (!$('#busGuideOverlay').is(':visible') && !$('#routeSearchModal').is(':visible')) {
      $('html, body').removeClass('modal-open');
    }
  }

  $(document).on('click', '.main-port-card, .apg-card', function(e) {
    e.preventDefault();
    var name = $(this).attr('data-name') || $(this).find('.apg-title').text();
    var cat = $(this).attr('data-cat') || $(this).find('.apg-cat').text();
    var id = $(this).attr('data-id') || '01';
    var img = $(this).find('img').attr('src');
    if (!img) {
      img = $(this).attr('data-image');
    }
    openPortfolioModal(name, cat, img, id);
  });

  $(document).on('click', '.portfolio-modal-close, #modalClose', function(e) {
    e.preventDefault();
    closePortfolioModal();
  });

  $(document).on('click', '#modalBackdrop', function(e) {
    if (e.target === this) {
      closePortfolioModal();
    }
  });

  /* ESC KEY */
  $(document).on('keydown', function(e) {
    if (e.key === 'Escape' || e.keyCode === 27) {
      closeGuideModal();
      closePortfolioModal();
      $('#routeSearchModal').fadeOut(200);
      $('html, body').removeClass('modal-open');
    }
  });
});

  /* 09. SCROLL INTERACTIVE HERO VIDEO SCALING */
  var $heroVidFrame = $('#heroScrollVideoFrame');
  if ($heroVidFrame.length) {
    $(window).on('scroll', function() {
      var st = $(window).scrollTop();
      if (st < 400) {
        var scale = 1 + (1 - (st / 400)) * 0.06;
        var maxW = 1200 + (1 - (st / 400)) * 160;
        var radius = 32 - (1 - (st / 400)) * 12;
        $heroVidFrame.css({
          'max-width': maxW + 'px',
          'border-radius': radius + 'px'
        });
      } else {
        $heroVidFrame.css({
          'max-width': '1200px',
          'border-radius': '32px'
        });
      }
    });
  }

  /* 09. DISTINCT SCROLL-DRIVEN HERO VIDEO SCALING */
  var $heroVidFrame = $('#heroScrollVideoFrame');
  if ($heroVidFrame.length) {
    function updateHeroScrollScale() {
      var st = $(window).scrollTop();
      var maxScroll = 450;
      var progress = Math.min(Math.max(st / maxScroll, 0), 1);
      
      // Interpolate from wide expansive (1500px / 12px radius) to centered compact (1180px / 36px radius)
      var maxW = 1500 - (progress * 320);
      var radius = 16 + (progress * 20);
      var scale = 1.04 - (progress * 0.04);
      var shadow = progress > 0.3 ? '0 30px 90px rgba(0,0,0,0.18)' : '0 10px 40px rgba(0,0,0,0.06)';

      $heroVidFrame.css({
        'max-width': maxW + 'px',
        'border-radius': radius + 'px',
        'transform': 'scale(' + scale + ')',
        'box-shadow': shadow
      });
    }

    $(window).on('scroll resize', updateHeroScrollScale);
    updateHeroScrollScale();
  }
