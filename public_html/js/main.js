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
    var $bg;
    $('.mobile-menu').slicknav({
      prependTo: '.navbar-header',
      parentTag: 'liner',
      allowParentLinks: true,
      duplicate: true,
      label: '',
      closedSymbol: '<i class="lni-chevron-right"></i>',
      openedSymbol: '<i class="lni-chevron-down"></i>',
      init: function () {
        $bg = $('.slicknav_menu');
      },
      afterOpen: function () {
        $bg.css({ 'background': 'rgba(25,118,210,.95)' });
      },
      afterClose: function () {
        $bg.css({ 'background': 'transparent' });
      }
    });

    //Like button behavior
    //like or dislike ad, animate it.
    $('.like').on('click', function (rsp) {
      $.get(api_server + "v1/ad_hit_like/" + $(this).data("ad_id") + "?api_token=" + user_token, function (data) {
        $('.like > i').toggleClass('lni-thumbs-down');
        $('.like > i').toggleClass('lni-thumbs-up');
      });
    });

    /* WOW Scroll Spy
      ========================================================*/
    var wow = new WOW({
      mobile: false
    });
    wow.init();
  });

}(jQuery));