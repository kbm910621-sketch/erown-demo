/* ==========================================================================
   GAON-N 2026 STRUCTURED PROMOTIONS & LARGE VISUAL JS
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

  /* 03. 104 ALL BUS ROUTES DATABASE IN SEPARATE MODAL */
  var routesData = [{"num":"순환01","cat":"express","district":"seo","path":"상무지구 ↔ 광천터미널 ↔ 전남대 ↔ 조선대 ↔ 백운광장 ↔ 상무지구 (순환)"},{"num":"수완03","cat":"express","district":"gwangsan","path":"송원대 ↔ 상무역 ↔ 유스퀘어 ↔ 첨단2지구 ↔ 수완지구"},{"num":"첨단09","cat":"express","district":"buk","path":"첨단종점 ↔ 전남대 ↔ 법원 ↔ 조선대 ↔ 양림휴먼시아"},{"num":"매월06","cat":"express","district":"seo","path":"매월동 ↔ 풍암지구 ↔ 백운동 ↔ 충장로 ↔ 광주역"},{"num":"진월07","cat":"express","district":"nam","path":"송암공단 ↔ 대성여고 ↔ 백운광장 ↔ 동구청 ↔ 살레시오고"},{"num":"좌석02","cat":"express","district":"gwangsan","path":"무등산국립공원 ↔ 조선대 ↔ 유스퀘어 ↔ 광주송정역 ↔ 나주혁신도시"},{"num":"매월16","cat":"main","district":"seo","path":"매월동 ↔ 풍암지구 ↔ 상무지구 ↔ 광천터미널 ↔ 일곡지구"},{"num":"문흥18","cat":"main","district":"buk","path":"장등동 ↔ 문흥지구 ↔ 전남대 ↔ 광천터미널 ↔ 상무지구"},{"num":"봉선37","cat":"main","district":"nam","path":"송암공단 ↔ 봉선동 학원가 ↔ 조선대 ↔ 산수동 ↔ 살레시오여고"},{"num":"지원15","cat":"main","district":"nam","path":"월남동 ↔ 조선대 ↔ 충장로 ↔ 대인시장 ↔ 광주역 ↔ 효천지구"},{"num":"일곡28","cat":"main","district":"buk","path":"일곡지구 ↔ 양산지구 ↔ 광천터미널 ↔ 조선대 ↔ 매월동"},{"num":"첨단20","cat":"main","district":"gwangsan","path":"첨단종점 ↔ 신창지구 ↔ 광천터미널 ↔ 양동시장 ↔ 조선대"},{"num":"첨단30","cat":"main","district":"gwangsan","path":"첨단산단 ↔ 수완지구 ↔ 운남지구 ↔ 상무지구 ↔ 광천터미널"},{"num":"첨단40","cat":"main","district":"gwangsan","path":"비아동 ↔ 첨단2지구 ↔ 전남대 ↔ 광주역 ↔ 화순전남대병원"},{"num":"송정19","cat":"main","district":"gwangsan","path":"장등동 ↔ 광주역 ↔ 시청 ↔ 광주송정역 ↔ 도산동"},{"num":"송정29","cat":"main","district":"gwangsan","path":"도산동 ↔ 광주송정역 ↔ 우산동 ↔ 광천터미널 ↔ 살레시오여고"},{"num":"풍암16","cat":"main","district":"seo","path":"매월동 ↔ 풍암지구 ↔ 금호지구 ↔ 상무지구 ↔ 광천터미널"},{"num":"풍암26","cat":"main","district":"seo","path":"매월동 ↔ 서구청 ↔ 충장로 ↔ 조선대 ↔ 각화동"},{"num":"금호36","cat":"main","district":"seo","path":"서창동 ↔ 금호지구 ↔ 상무지구 ↔ 광주역 ↔ 장등동"},{"num":"금호46","cat":"main","district":"seo","path":"화순전남대병원 ↔ 소태역 ↔ 풍암지구 ↔ 상무지구"},{"num":"운림51","cat":"main","district":"dong","path":"무등산국립공원 ↔ 조선대 ↔ 충장로 ↔ 유스퀘어 ↔ 첨단산단"},{"num":"운림54","cat":"main","district":"dong","path":"무등산국립공원 ↔ 남광주역 ↔ 광주역 ↔ 양산지구"},{"num":"문흥39","cat":"main","district":"buk","path":"장등동 ↔ 문흥지구 ↔ 전남대 ↔ 광천터미널 ↔ 송암공단"},{"num":"문흥48","cat":"main","district":"buk","path":"장등동 ↔ 문흥지구 ↔ 법원 ↔ 조선대 ↔ 효천지구"},{"num":"지원25","cat":"main","district":"nam","path":"월남동 ↔ 봉선동 ↔ 백운광장 ↔ 양동시장 ↔ 서창동"},{"num":"지원56","cat":"main","district":"nam","path":"월남동 ↔ 소태역 ↔ 조선대 ↔ 충장로 ↔ 광주역"},{"num":"용봉83","cat":"main","district":"buk","path":"용봉동 ↔ 전남대후문 ↔ 산수오거리 ↔ 조선대 ↔ 학운동"},{"num":"대촌70","cat":"main","district":"nam","path":"칠석동 ↔ 대촌 ↔ 백운광장 ↔ 양동시장 ↔ 광천터미널"},{"num":"송암72","cat":"main","district":"nam","path":"송암공단 ↔ 진월지구 ↔ 백운동 ↔ 충장로 ↔ 수완지구"},{"num":"수완12","cat":"main","district":"gwangsan","path":"수완종점 ↔ 신가동 ↔ 운남지구 ↔ 상무지구 ↔ 광천터미널"},{"num":"수완49","cat":"feeder","district":"gwangsan","path":"수완지구 ↔ 신창동 ↔ 첨단병원 ↔ 비아동"},{"num":"첨단92","cat":"feeder","district":"gwangsan","path":"첨단산단 ↔ 비아 ↔ 첨단2지구 ↔ 양산동"},{"num":"첨단94","cat":"feeder","district":"gwangsan","path":"첨단종점 ↔ 과기원 ↔ 첨단병원 ↔ 서남해안고속"},{"num":"첨단95","cat":"feeder","district":"gwangsan","path":"첨단산단 ↔ 수완지구 ↔ 하남산단 ↔ 송정역"},{"num":"송정98","cat":"feeder","district":"gwangsan","path":"도산동 ↔ 송정역 ↔ 하남2지구 ↔ 수완지구 ↔ 첨단"},{"num":"송정100","cat":"feeder","district":"gwangsan","path":"송정역 ↔ 평동산단 ↔ 삼도 ↔ 본량 ↔ 용진"},{"num":"선운101","cat":"feeder","district":"gwangsan","path":"선운지구 ↔ 호남대 ↔ 송정역 ↔ 평동공단"},{"num":"봉선27","cat":"feeder","district":"nam","path":"용산지구 ↔ 봉선동 ↔ 백운광장 ↔ 양동시장"},{"num":"송암47","cat":"feeder","district":"nam","path":"송암공단 ↔ 주월동 ↔ 무등시장 ↔ 농성역 ↔ 시청"},{"num":"송암73","cat":"feeder","district":"nam","path":"송암공단 ↔ 대성여고 ↔ 남광주역 ↔ 조선대 ↔ 동림삼익"},{"num":"송암74","cat":"feeder","district":"nam","path":"송암공단 ↔ 효천역 ↔ 진월동 ↔ 백운광장 ↔ 상무역"},{"num":"대촌270","cat":"feeder","district":"nam","path":"매월유통단지 ↔ 서창 ↔ 대촌동 ↔ 포충사"},{"num":"임곡89","cat":"feeder","district":"gwangsan","path":"덕흥동 ↔ 유스퀘어 ↔ 시청 ↔ 하남 ↔ 임곡역"},{"num":"임곡290","cat":"feeder","district":"gwangsan","path":"광산구청 ↔ 송정역 ↔ 임곡동 ↔ 오룡"},{"num":"동곡73","cat":"feeder","district":"gwangsan","path":"도산동 ↔ 동곡동 ↔ 평동 ↔ 송정시장"},{"num":"평동700","cat":"feeder","district":"gwangsan","path":"평동산단 ↔ 평동역 ↔ 옥동 ↔ 송정역"},{"num":"상무62","cat":"feeder","district":"seo","path":"상무지구 ↔ 서구청 ↔ 양동시장 ↔ 광주역 ↔ 계림동"},{"num":"상무64","cat":"feeder","district":"seo","path":"세하동 ↔ 서창 ↔ 상무역 ↔ 유스퀘어 ↔ 광주역"},{"num":"유덕65","cat":"feeder","district":"seo","path":"유덕동 ↔ 버들마을 ↔ 광천터미널 ↔ 양동시장"},{"num":"518번","cat":"feeder","district":"seo","path":"상무지구 ↔ 5·18기념공원 ↔ 광천터미널 ↔ 전남대 ↔ 국립5·18묘지"},{"num":"용전84","cat":"feeder","district":"buk","path":"용전 ↔ 북구보건소 ↔ 전남대 ↔ 광주역 ↔ 대인시장"},{"num":"용전85","cat":"feeder","district":"buk","path":"용전 ↔ 건국동 ↔ 양산지구 ↔ 전남대 ↔ 충장로"},{"num":"용전86","cat":"feeder","district":"buk","path":"용전 ↔ 일곡지구 ↔ 문흥지구 ↔ 조선대 ↔ 학운동"},{"num":"용전184","cat":"feeder","district":"buk","path":"용전 ↔ 국립박물관 ↔ 비엔날레 ↔ 경신여고 ↔ 양동시장"},{"num":"석곡87","cat":"feeder","district":"buk","path":"망월동 ↔ 문흥지구 ↔ 산수오거리 ↔ 조선대"},{"num":"두암81","cat":"feeder","district":"buk","path":"장등동 ↔ 두암지구 ↔ 동구청 ↔ 남광주역 ↔ 봉선동"},{"num":"충효187","cat":"feeder","district":"dong","path":"장등동 ↔ 산수시장 ↔ 충장사 ↔ 원효사 (무등산)"},{"num":"지원150","cat":"feeder","district":"dong","path":"월남동 ↔ 소태역 ↔ 학동 ↔ 조선대 ↔ 광주역"},{"num":"지원151","cat":"feeder","district":"dong","path":"소태역 ↔ 화순 이양 ↔ 능주 ↔ 남광주시장"},{"num":"지원152","cat":"feeder","district":"dong","path":"소태역 ↔ 남평 ↔ 다도 ↔ 드들강 유원지"}];

  function renderModalBusRoutes(filterCat, searchKeyword) {
    var $grid = $('#modalBusRouteFullGrid');
    $grid.empty();

    var filtered = routesData.filter(function(r) {
      var matchCat = true;
      if (filterCat && filterCat !== 'all') {
        if (filterCat === 'express' || filterCat === 'main' || filterCat === 'feeder') {
          matchCat = (r.cat === filterCat);
        } else if (filterCat === 'seo' || filterCat === 'nam' || filterCat === 'buk' || filterCat === 'gwangsan' || filterCat === 'dong') {
          matchCat = (r.district === filterCat || r.path.indexOf(filterCat === 'seo' ? '상무' : filterCat === 'nam' ? '봉선' : filterCat === 'buk' ? '전남대' : '수완') !== -1);
        }
      }
      var matchSearch = true;
      if (searchKeyword && searchKeyword.trim() !== '') {
        var kw = searchKeyword.trim().toLowerCase();
        matchSearch = (r.num.toLowerCase().indexOf(kw) !== -1 || r.path.toLowerCase().indexOf(kw) !== -1);
      }
      return matchCat && matchSearch;
    });

    if (filtered.length === 0) {
      $grid.html('<div style="grid-column:1/-1; padding:30px; text-align:center; color:#94a3b8; font-size:13.5px;">검색된 시내버스 노선이 없습니다.</div>');
      return;
    }

    filtered.forEach(function(r) {
      var tagClass = r.cat === 'express' ? 'red' : r.cat === 'main' ? 'blue' : 'green';
      var tagLabel = r.cat === 'express' ? '급행' : r.cat === 'main' ? '간선' : '지선';
      var html = '<div class="adg-card">' +
        '<div class="adg-top">' +
          '<span class="adgc-tag ' + tagClass + '">' + tagLabel + '</span>' +
          '<strong>' + r.num + '</strong>' +
        '</div>' +
        '<p>' + r.path + '</p>' +
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
