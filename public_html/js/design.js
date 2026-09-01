/* ==========================================================================
   GAON-N 2026 HARMONIZED INTERACTION JS
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

  /* 03. BUS DISTRICT ROUTE FILTER TABS */
  $(document).on('click', '.adb-tab', function(e) {
    e.preventDefault();
    var district = $(this).attr('data-district');

    $('.adb-tab').removeClass('on');
    $(this).addClass('on');

    if (district === 'all') {
      $('#districtRouteGrid .adg-card').fadeIn(200);
    } else {
      $('#districtRouteGrid .adg-card').each(function() {
        if ($(this).attr('data-district') === district) {
          $(this).fadeIn(200);
        } else {
          $(this).hide();
        }
      });
    }
  });

  /* 04. SEO KEYWORD COCKPIT INTERACTION */
  $(document).on('click', '.akb-btn', function(e) {
    e.preventDefault();
    var $btn = $(this);
    var kw = $btn.attr('data-kw');
    var rank = $btn.attr('data-rank');
    var review = $btn.attr('data-review');
    var calls = $btn.attr('data-calls');
    var strategy = $btn.attr('data-strategy');

    $('.akb-btn').removeClass('on');
    $btn.addClass('on');

    $('#dynKwText').text(kw);
    $('#dynRankBadge').text('#' + rank + ' 네이버 스마트플레이스 1위');
    $('#dynReviewCount').text('(방문자 영수증 리뷰 ' + review + ')');
    $('#dynCallCount').text('네이버 예약 (월 ' + calls + '건)');
    if (strategy) {
      $('#dynStrategyDesc').text(strategy);
    }
  });

  $(document).on('click', '.ast-card', function(e) {
    e.preventDefault();
    $('.ast-card').removeClass('on');
    $(this).addClass('on');
    var desc = $(this).attr('data-strat-desc');
    if (desc) {
      $('#dynStrategyDesc').text(desc);
    }
  });

  /* 05. VIDEO FORMAT SWITCHER & PRODUCT CLICK */
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

  /* 06. OOH ACCORDION HOVER/CLICK */
  $(document).on('mouseenter click', '.aoa-card', function() {
    $('.aoa-card').removeClass('on');
    $(this).addClass('on');
  });

  /* 07. ALL-IN-ONE MASTER PORTFOLIO FILTER */
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

  /* 08. GUIDE MODAL HANDLERS (5 TABS) */
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
    if (!$('#modalBackdrop').is(':visible')) {
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

  /* 09. PORTFOLIO LIGHTBOX MODAL HANDLER */
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
    if (!$('#busGuideOverlay').is(':visible')) {
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
    }
  });
});
