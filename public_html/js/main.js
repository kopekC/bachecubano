(function ($) {

  "use strict";

  $(window).on('load', function () {

    /* Sticky Nav
      ========================================================*/
    $(window).on('scroll', function () {
      if ($(window).scrollTop() > 100) {
        $('.scrolling-navbar').addClass('top-nav-collapse');
        $('.navbar-brand > img').attr('src', logo);
      } else {
        $('.scrolling-navbar').removeClass('top-nav-collapse');
        $('.navbar-brand > img').attr('src', logo_w);
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
      openedSymbol: '<i class="lni-chevron-down"></i>'
    });

    /* WOW Scroll Spy
      ========================================================*/
    var wow = new WOW({
      mobile: false
    });
    wow.init();
  });

}(jQuery));