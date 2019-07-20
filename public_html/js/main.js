(function ($) {

  "use strict";

  $(window).on('load', function () {

    /* Sticky Nav
      ========================================================*/
    $(window).on('scroll', function () {
      if ($(window).scrollTop() > 100) {
        $('.scrolling-navbar').addClass('top-nav-collapse');
      } else {
        $('.scrolling-navbar').removeClass('top-nav-collapse');
      }
    });

    /* slicknav mobile menu active 
      ========================================================*/
    $('.mobile-menu').slicknav({
      prependTo: '.navbar-header',
      parentTag: 'liner',
      allowParentLinks: true,
      duplicate: true,
      label: '',
      closedSymbol: '<i class="lni-chevron-right"></i>',
      openedSymbol: '<i class="lni-chevron-down"></i>',
    });

    /* WOW Scroll Spy
      ========================================================*/
    var wow = new WOW({
      mobile: false
    });
    wow.init();

    /* Nivo Lightbox 
    ========================================================*/
    $('.lightbox').nivoLightbox({
      effect: 'fadeScale',
      keyboardNav: true,
    });

    /* Product Grids active
    ========================================================*/
    var itemList = $('.item-list');
    var gridStyle = $('.grid');
    var listStyle = $('.list');

    $('.list,switchToGrid').on('click', function (e) {
      e.preventDefault();
      itemList.addClass("make-list");
      itemList.removeClass("make-grid");
      itemList.removeClass("make-compact");
      gridStyle.removeClass("active");
      listStyle.addClass("active");
    });

    gridStyle.on('click', function (e) {
      e.preventDefault();
      listStyle.removeClass("active");
      $(this).addClass("active");
      itemList.addClass("make-grid");
      itemList.removeClass("make-list");
      itemList.removeClass("make-compact");
    });

  });

}(jQuery));