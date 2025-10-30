

(function ($) {
    'use strict';

    // Preloader
    $(window).on('load', function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });


    // Instagram Feed
    //   if (($('#instafeed').length) !== 0) {
    //     var accessToken = $('#instafeed').attr('data-accessToken');
    //     var userFeed = new Instafeed({
    //       get: 'user',
    //       resolution: 'low_resolution',
    //       accessToken: accessToken,
    //       template: '<a href="{{link}}"><img src="{{image}}" alt="instagram-image"></a>'
    //     });
    //     userFeed.run();
    //   }

    //   setTimeout(function () {
    //     $('.instagram-slider').slick({
    //       dots: false,
    //       speed: 300,
    //       // autoplay: true,
    //       arrows: false,
    //       slidesToShow: 6,
    //       slidesToScroll: 1,
    //       responsive: [{
    //           breakpoint: 1024,
    //           settings: {
    //             slidesToShow: 4
    //           }
    //         },
    //         {
    //           breakpoint: 600,
    //           settings: {
    //             slidesToShow: 3
    //           }
    //         },
    //         {
    //           breakpoint: 480,
    //           settings: {
    //             slidesToShow: 2
    //           }
    //         }
    //       ]
    //     });
    //   }, 1500);


    // e-commerce touchspin
    $('input[name=\'product-quantity\']').TouchSpin();


    // Video Lightbox
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });


    // Count Down JS
    $('#simple-timer').syotimer({
        year: 2022,
        month: 5,
        day: 9,
        hour: 20,
        minute: 30
    });

    //Hero Slider
    $('.hero-slider').slick({
        // autoplay: true,
        infinite: true,
        arrows: true,
        prevArrow: '<button type=\'button\' class=\'heroSliderArrow prevArrow tf-ion-chevron-left\'></button>',
        nextArrow: '<button type=\'button\' class=\'heroSliderArrow nextArrow tf-ion-chevron-right\'></button>',
        dots: true,
        autoplaySpeed: 7000,
        pauseOnFocus: false,
        pauseOnHover: false
    });
    $('.hero-slider').slickAnimation();


})(jQuery);


//Start Active menu item highlight karne ka code
document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname.replace(/\/+$/, ''); // remove trailing slash
    const menuLinks = document.querySelectorAll('.navigation .navbar-nav li a');

    menuLinks.forEach(link => {
        const linkPath = new URL(link.href).pathname.replace(/\/+$/, '');

        if (linkPath === currentPath) {
            link.classList.add('active');

            const parentLi = link.closest('li.dropdown');
            if (parentLi) parentLi.querySelector('a.dropdown-toggle')?.classList.add('active');
        }
    });
});
//End Active menu item highlight karne ka code


//Start-> Page load hone par buttons disable karne aur load hone ke baad enable karne ka code
function disableButtons() {
    // sab buttons aur anchors select karo, lekin slick buttons ko ignore karo
    const buttons = document.querySelectorAll('button:not(.slick-arrow):not(.slick-dots button), a:not(.logo-a)');

    buttons.forEach(el => {
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

function enableButtons() {
    const buttons = document.querySelectorAll('button:not(.slick-arrow):not(.slick-dots button), a');

    buttons.forEach(el => {
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

// DOM Ready
document.addEventListener('DOMContentLoaded', function () {
    disableButtons(); // page load pe disable

    window.addEventListener('load', function () {
        enableButtons(); // load complete pe enable
    });
});



// End-> Page load hone par buttons disable karne aur load hone ke baad enable karne ka code
