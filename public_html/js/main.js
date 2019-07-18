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

    /* Counter
    ========================================================*/
    $('.counterUp').counterUp({
      delay: 10,
      time: 1000
    });

    /* Search
    ========================================================*/
    $('.search-query .form-control').on('click', function (e) {
      e.stopPropagation();
      $(this).parent().toggleClass('query-focus');
    });
    $('body').on('click', function () {
      if ($('.search-query').hasClass('query-focus')) {
        $('.search-query').removeClass('query-focus');
      }
    });
    $('.search-suggestion').on('click', function (e) {
      e.stopPropagation();
    });

    /* Testimonials Carousel 
    ========================================================*/
    var owl = $("#testimonials");
    owl.owlCarousel({
      navigation: false,
      pagination: true,
      slideSpeed: 1000,
      stopOnHover: true,
      autoPlay: true,
      items: 2,
      itemsDesktop: [1199, 2],
      itemsDesktopSmall: [980, 2],
      itemsTablet: [768, 1],
      itemsTablet: [767, 1],
      itemsTabletSmall: [480, 1],
      itemsMobile: [479, 1],
    });

    /* New Products Owl Carousel
    ========================================================*/
    $("#new-products").owlCarousel({
      navigation: true,
      pagination: false,
      slideSpeed: 1000,
      stopOnHover: true,
      autoPlay: false,
      items: 4,
      itemsDesktop: [1199, 3],
      itemsDesktopSmall: [980, 2],
      itemsTablet: [768, 1],
      itemsTablet: [767, 1],
      itemsTabletSmall: [480, 1],
      itemsMobile: [479, 1],
    });
    
    /* Editor Note Js
      ========================================================*/
    $('#summernote').summernote({
      height: 250,                 // set editor height
      minHeight: null,             // set minimum height of editor
      maxHeight: null,             // set maximum height of editor
      focus: false                  // set focus to editable area after initializing summernote
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