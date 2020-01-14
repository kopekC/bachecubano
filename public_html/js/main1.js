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
      var like_btn = $(this);
      //Show spinner
      like_btn.children("div").toggleClass('d-none');
      //Hide i element
      like_btn.children("i").toggleClass('d-none');
      $.get(api_server + "v1/ad_hit_like/" + $(this).data("ad_id") + "?api_token="+user_token, function (data) {
        //Toggle Thumbs
        like_btn.children("i").toggleClass('lni-thumbs-down');
        like_btn.children("i").toggleClass('lni-thumbs-up');
        //Hide spinner
        like_btn.children("div").toggleClass('d-none');
        //Show i element
        like_btn.children("i").toggleClass('d-none');
      });
    });

    //Delete Ad behavior
    $('.delete-ad').on('click', function (rsp) {

      //Initialize variables
      var delete_btn = $(this);
      var delete_url = $(this).data("href");

      $.ajax({
        url: delete_url + "?api_token="+user_token,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        cache: false,
        type: 'DELETE',
        beforeSend: function () {
          return confirm("¿Está seguro? Esta operación es irreversible.");
        },
        success: function (result) {
          // Do something with the result
          //Redirect this self page
          window.location.replace(current_url);
        }
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