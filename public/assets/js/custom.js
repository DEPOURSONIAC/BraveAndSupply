(function ($) {

    "use strict";


    /* ----- Carousels ----- */

    $('.owl-men-item').owlCarousel({
        items: 3,
        loop: false,
        dots: true,
        nav: true,
        margin: 30,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });


    $('.owl-women-item').owlCarousel({
        items: 3,
        loop: false,
        dots: true,
        nav: true,
        margin: 30,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });


    $('.owl-kid-item').owlCarousel({
        items: 3,
        loop: false,
        dots: true,
        nav: true,
        margin: 30,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });



    /* ----- Header scroll ----- */

    $(window).scroll(function () {

        var scroll = $(window).scrollTop();
        var box = $('#top').height();
        var header = $('header').height();


        if (scroll >= box - header) {
            $("header").addClass("background-header");
        } else {
            $("header").removeClass("background-header");
        }

    });


    mobileNav();


    $('.menu-trigger').on('click', function () {

        $(this).toggleClass('active');

        $('.header-area .nav').slideToggle(200);

    });


    if (typeof scrollReveal !== "undefined") {

        window.sr = new scrollReveal();

    }



    /* ----- Scroll ----- */

    $('.scroll-to-section a[href^="#"]').on('click', function (e) {

        e.preventDefault();

        var target = $(this.hash);


        if (target.length) {

            $('html, body').animate({

                scrollTop: target.offset().top - 80

            }, 700);

        }

    });



    $(document).ready(function () {

        $(document).on("scroll", onScroll);

    });



    function onScroll(event) {


        var scrollPos = $(document).scrollTop();


        $('.nav a').each(function () {


            var currLink = $(this);

            var href = currLink.attr("href");


            if (!href || href.charAt(0) !== "#") {

                return;

            }


            var refElement = $(href);


            if (refElement.length) {


                if (
                    refElement.position().top <= scrollPos &&
                    refElement.position().top + refElement.height() > scrollPos
                ) {

                    $('.nav ul li a').removeClass("active");

                    currLink.addClass("active");


                } else {

                    currLink.removeClass("active");

                }

            }


        });

    }





    /* ----- Preloader ----- */

    $(window).on('load', function () {


        if ($('.cover').length) {


            $('.cover').parallax({

                imageSrc: $('.cover').data('image'),

                zIndex: '1'

            });


        }


        $("#preloader").animate({
            opacity: '0'
        }, 600, function () {

            setTimeout(function () {

                $("#preloader").css("visibility", "hidden").fadeOut();

            }, 300);


        });


    });





    /* ----- Resize mobile menu ----- */

    $(window).on('resize', function () {

        mobileNav();

    });



    function mobileNav() {
        var width = $(window).width();

        $('.submenu').off('click').on('click', function () {


            if (width < 767) {
                $('.submenu ul').removeClass('active');

                $(this).find('ul').toggleClass('active');
            }

        });

    }

})(window.jQuery);