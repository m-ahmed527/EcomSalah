/*

Template:  clothing- Responsive Multi-purpose HTML5 Template
Template URI: http://bootexperts.com
Description: This is html5 template
Author: BootExperts
Author URI: http://bootexperts.com
Version: 1.0

*/
/*================================================
[  Table of contents  ]
================================================
    01. jQuery MeanMenu
    02. wow js active
    03. scrollUp jquery active
    04. slick carousel


======================================
[ End table content ]
======================================*/


(function ($) {
    "use strict";

    /*-------------------------------------------
        01. jQuery MeanMenu
    --------------------------------------------- */
    jQuery('nav#dropdown').meanmenu();

    $('.mobile-menu-area').on('click', function (e) {
        if (e.target.className == 'meanmenu-reveal') {
            $('.mean-nav ul').slideUp();
            var meanExp = $('.mean-expand');
            meanExp.removeClass('mean-clicked');
            for (var i = 0; i < meanExp.length; i++) {
                meanExp[i].innerHTML = '+';
            }
        }
    });


    $('.mean-nav li a, .mean-expand').on('click', function (e) {
        var $this = $(this);
        var targetAttr = e.target.getAttribute('href');
        var targetNodeName = e.target.nodeName;
        if (targetAttr === '#' || targetAttr === '' || e.target.classList.contains('mean-expand')) {
            $this.parent().siblings().children('ul').slideUp();
            $this.parent().siblings().children('.mean-expand').removeClass('mean-clicked').text('+');
        }
    })


    /*-------------------------------------------
        02. wow js active
    --------------------------------------------- */
    new WOW().init();


    /*--------------------------
     scrollUp
    ---------------------------- */
    $.scrollUp({
        scrollText: "<i class='zmdi zmdi-arrow-merge'></i>",
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });

    /*-------------------------------------------
    04. slick carousel
    --------------------------------------------- */
    $('.new-arrival-slider-active').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        dots: false,
        arrows: true,
        prevArrow: '<div class="arrow-left"><i class="zmdi zmdi-chevron-left"></i></div>',
        nextArrow: '<div class="arrow-right"><i class="zmdi zmdi-chevron-right"></i></div>',
        responsive: [
            { breakpoint: 1169, settings: { slidesToShow: 4, } },
            { breakpoint: 969, settings: { slidesToShow: 3, } },
            { breakpoint: 767, settings: { slidesToShow: 2, } },
            { breakpoint: 479, settings: { slidesToShow: 1, } },
        ]
    });

    $('.ctg-slider-active').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        dots: false,
        arrows: false,
        prevArrow: '<div class="arrow-left"><i class="zmdi zmdi-chevron-left"></i></div>',
        nextArrow: '<div class="arrow-right"><i class="zmdi zmdi-chevron-right"></i></div>',
        responsive: [
            { breakpoint: 1169, settings: { slidesToShow: 1, } },
            { breakpoint: 969, settings: { slidesToShow: 1, } },
            { breakpoint: 767, settings: { slidesToShow: 1, } },
            { breakpoint: 479, settings: { slidesToShow: 1, } },
        ]
    });
    $('.total-rectnt-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        dots: false,
        arrows: false,
        responsive: [
            { breakpoint: 1169, settings: { slidesToShow: 1, } },
            { breakpoint: 969, settings: { slidesToShow: 1, } },
            { breakpoint: 767, settings: { slidesToShow: 1, } },
            { breakpoint: 479, settings: { slidesToShow: 1, } },
        ]
    });

    $('.active-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        dots: true,
        arrows: false,
        responsive: [
            { breakpoint: 1169, settings: { slidesToShow: 1, } },
            { breakpoint: 969, settings: { slidesToShow: 1, } },
            { breakpoint: 767, settings: { slidesToShow: 1, } },
            { breakpoint: 479, settings: { slidesToShow: 1, } },
        ]
    });

    $('.total-brand').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        dots: false,
        arrows: false,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 6, } },
            { breakpoint: 992, settings: { slidesToShow: 5, } },
            { breakpoint: 768, settings: { slidesToShow: 3, } },
            { breakpoint: 480, settings: { slidesToShow: 2, } },
        ]
    });

    $('.team-carasoul').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        dots: false,
        arrows: false,
        responsive: [
            { breakpoint: 1169, settings: { slidesToShow: 3, } },
            { breakpoint: 969, settings: { slidesToShow: 3, } },
            { breakpoint: 767, settings: { slidesToShow: 2, } },
            { breakpoint: 479, settings: { slidesToShow: 1, } },
        ]
    });

    $('.total-blog').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        dots: false,
        arrows: false,
        responsive: [
            { breakpoint: 1169, settings: { slidesToShow: 3, } },
            { breakpoint: 969, settings: { slidesToShow: 2, } },
            { breakpoint: 767, settings: { slidesToShow: 1, } },
            { breakpoint: 479, settings: { slidesToShow: 1, } },
        ]
    });

    $('.total-blog-2').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        dots: false,
        arrows: false,
        responsive: [
            { breakpoint: 1169, settings: { slidesToShow: 2, } },
            { breakpoint: 969, settings: { slidesToShow: 2, } },
            { breakpoint: 767, settings: { slidesToShow: 1, } },
            { breakpoint: 479, settings: { slidesToShow: 1, } },
        ]
    });
    $('.total-blog-3').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        dots: false,
        arrows: false,
        responsive: [
            { breakpoint: 1169, settings: { slidesToShow: 2, } },
            { breakpoint: 969, settings: { slidesToShow: 1, } },
            { breakpoint: 767, settings: { slidesToShow: 1, } },
            { breakpoint: 479, settings: { slidesToShow: 1, } },
        ]
    });

    /*----------------------------
     fancybox active
    ------------------------------ */
    $(document).ready(function () {
        $('.fancybox').fancybox();
    });


    /*----------------------------
     price-slider active
    ------------------------------ */
    // $("#slider-range").slider({
    //     range: true,
    //     min: 40,
    //     max: 600,
    //     values: [40, 600],
    //     slide: function (event, ui) {
    //         $("#amount").val("RS " + ui.values[0] + " - " + ui.values[1]);
    //     }
    // });
    // $("#amount").val("RS " + $("#slider-range").slider("values", 0) +
    //     " - " + $("#slider-range").slider("values", 1));

    /*----------------------------
    Countdown active
    ------------------------------ */
    $('[data-countdown]').countdown('2023/12/20', function (event) {
        $(this).html(
            event.strftime(
                '<span class="cdown days"><span class="time-count">%-D</span> <p>Days</p></span><span class="cdown hour"><span class="time-count">%-H</span> <p>Hour</p></span><span class="cdown minutes"><span class="time-count">%M</span> <p>Min</p></span> <span class="cdown second"><span class="time-count">%S</span> <p>Sec</p></span>'
            )
        );
    });


    /*----------------------------
     active match height
    ------------------------------ */
    $(function () {
        $('.item').matchHeight();
    });

    /*----------------------------
     treeview active
    ------------------------------ */
    $("#cat-treeview ul").treeview({
        animated: "normal",
        persist: "location",
        collapsed: true,
        unique: true,
    });

    /*----------------------------------------*/
    /* FAQ Accordion
    /*----------------------------------------*/
    $('.card-header a').on('click', function () {
        $('.card').removeClass('actives');
        $(this).parents('.card').addClass('actives');
    });

    /*----------------------------
     cart-plus-minus-button
    ------------------------------ */
    $(".cart-plus-minus")
    $(".qtybutton").on("click", function () {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal);
    });



    $('.acc-toggle').on('click', function () {
        if ($('.acc-toggle input').is(':checked')) {
            $('.create-acc-body').slideDown();
        } else {
            $('.create-acc-body').slideUp();
        }
    });

    $('.ship-toggle').on('click', function () {
        if ($('.ship-toggle input').is(':checked')) {
            $('.ship-acc-body').slideDown();
        } else {
            $('.ship-acc-body').slideUp();
        }
    });




})(jQuery);

$(window).scroll(function () {
    if ($(this).scrollTop() > 1) {
        $('#sticky-header').addClass("sticky");
    }
    else {
        $('#sticky-header').removeClass("sticky");
    }
});


//Start-> Page load hone par buttons disable karne aur load hone ke baad enable karne ka code
function disableButtons(selector = null) {
    // selector pass ho to usko use karo warna sab ko select karo (slick buttons exclude)
    const elements = selector
        ? document.querySelectorAll(selector)
        : document.querySelectorAll('button:not(.slick-arrow):not(.slick-dots button), a');

    elements.forEach(el => {
        if (!el.classList.contains('disabled')) {
            el.classList.add('disabled');
            el.setAttribute('aria-disabled', 'true');

            if (el.tagName.toLowerCase() === 'a') {
                el.dataset.href = el.getAttribute('href');
                el.removeAttribute('href');
            } else {
                el.setAttribute('disabled', 'disabled');
            }

            if (!el.dataset.originalHtml) {
                el.dataset.originalHtml = el.innerHTML;
            }

            el.innerHTML = `<i class="mdi mdi-sync-circle mdi-spin me-1"></i> Loading...`;
        }
    });
}

function enableButtons(selector = null) {
    const elements = selector
        ? document.querySelectorAll(selector)
        : document.querySelectorAll('button:not(.slick-arrow):not(.slick-dots button), a');

    elements.forEach(el => {
        el.classList.remove('disabled');
        el.removeAttribute('aria-disabled');

        if (el.tagName.toLowerCase() === 'a' && el.dataset.href) {
            el.setAttribute('href', el.dataset.href);
            delete el.dataset.href;
        } else {
            el.removeAttribute('disabled');
        }

        if (el.dataset.originalHtml) {
            el.innerHTML = el.dataset.originalHtml;
        }
    });
}

// Example usage:
// disableButtons(); // sab disable
// disableButtons('#submitBtn'); // sirf ek button disable
// disableButtons('.save-btn'); // sirf specific class wale disable


document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.href;

    document.querySelectorAll("#primary-menu a").forEach(link => {
        if (currentUrl === link.href) {
            link.classList.add("active");

            // agar link <li> ke andar hai to <li> ko bhi active karo
            const li = link.closest("li");
            if (li) {
                li.classList.add( "current");
            }
        }
    });
});
