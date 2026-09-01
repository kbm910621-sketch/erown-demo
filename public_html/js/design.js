/* ==========================================================================
   GAON-N GRAND PRIX AWARD-WINNING INTERACTION JS
   ========================================================================== */
$(function () {
  'use strict';

  if (typeof WOW !== 'undefined') {
    new WOW().init();
  }

  /* 01. BUS SERVICE TAB SWITCHER */
  $(document).on('click', '.bus-service-tab', function(e) {
    e.preventDefault();
    var $tab = $(this);
    var index = $tab.attr('data-index');
    var title = $tab.attr('data-title');
    var desc = $tab.attr('data-desc');
    var img = $tab.attr('data-image');

    $('.bus-service-tab').removeClass('on');
    $tab.addClass('on');

    $('#busStageIndex').text(index);
    $('#busStageTitle').text(title);
    $('#busStageDesc').text(desc);

    if (img && img.trim() !== '') {
      $('#busStageImg').attr('src', img).show();
      $('.gpsv-placeholder').hide();
    }
  });

  /* 02. ONLINE SERVICE TAB SWITCHER */
  $(document).on('click', '.online-service-tab', function(e) {
    e.preventDefault();
    var $tab = $(this);
    var tag = $tab.attr('data-tag');
    var title = $tab.attr('data-title');
    var desc = $tab.attr('data-desc');

    $('.online-service-tab').removeClass('on');
    $tab.addClass('on');

    $('#onlineStageTag').text(tag);
    $('#onlineStageTitle').text(title);
    $('#onlineStageDesc').text(desc);
  });

  /* 03. VIDEO SERVICE TAB SWITCHER */
  $(document).on('click', '.video-service-tab', function(e) {
    e.preventDefault();
    var $tab = $(this);
    var tag = $tab.attr('data-tag');
    var title = $tab.attr('data-title');
    var desc = $tab.attr('data-desc');

    $('.video-service-tab').removeClass('on');
    $tab.addClass('on');

    $('#videoStageTag').text(tag);
    $('#videoStageTitle').text(title);
    $('#videoStageDesc').text(desc);
  });

  /* 04. OTHER MEDIA PORTFOLIO FILTER */
  $(document).on('click', '.other-port-filter-btn', function(e) {
    e.preventDefault();
    var filter = $(this).attr('data-filter');

    $('.other-port-filter-btn').removeClass('on');
    $(this).addClass('on');

    if (filter === 'all') {
      $('#otherPortGrid .other-port-item').fadeIn(200);
    } else {
      $('#otherPortGrid .other-port-item').each(function() {
        var cat = $(this).attr('data-cat');
        if (cat === filter) {
          $(this).fadeIn(200);
        } else {
          $(this).hide();
        }
      });
    }
  });

  /* 05. GUIDE MODAL HANDLERS (5 TABS) */
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

  /* 06. PORTFOLIO LIGHTBOX MODAL HANDLER */
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

  $(document).on('click', '.main-port-card, .gp-card', function(e) {
    e.preventDefault();
    var name = $(this).attr('data-name') || $(this).find('.gpc-title').text();
    var cat = $(this).attr('data-cat') || $(this).find('.gpc-cat').text();
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
