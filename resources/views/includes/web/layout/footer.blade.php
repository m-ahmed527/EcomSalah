<footer class="footer section text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="social-media">
                    <li>
                        <a href="https://www.facebook.com/themefisher">
                            <i class="tf-ion-social-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/themefisher">
                            <i class="tf-ion-social-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.twitter.com/themefisher">
                            <i class="tf-ion-social-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.pinterest.com/themefisher/">
                            <i class="tf-ion-social-pinterest"></i>
                        </a>
                    </li>
                </ul>
                <ul class="footer-menu text-uppercase">
                    <li>
                        <a href="{{ route('web.contact.index') }}">CONTACT</a>
                    </li>
                    <li>
                        <a href="shop.html">SHOP</a>
                    </li>
                    <li>
                        <a href="{{ route('web.about.index') }}">About Us</a>
                    </li>
                    <li>
                        <a href="contact.html">PRIVACY POLICY</a>
                    </li>
                </ul>
                <p class="copyright-text">Copyright &copy;{{ date('Y') }}, Designed &amp; Developed by Salah Wears</p>
            </div>
        </div>
    </div>
</footer>

<!--
    Essential Scripts
    =====================================-->

<!-- Main jQuery -->
<script src="{{asset('assets/web/plugins/jquery/dist/jquery.js')}}"></script>
<script src="{{asset('assets/web/plugins/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.1 -->
<script src="{{asset('assets/web/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- Bootstrap Touchpin -->
<script src="{{asset('assets/web/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
<!-- Instagram Feed Js -->
{{--
<script src="{{asset('assets/web/plugins/instafeed/instafeed.min.js')}}"></script> --}}
<!-- Video Lightbox Plugin -->
<script src="{{asset('assets/web/plugins/ekko-lightbox/dist/ekko-lightbox.min.js')}}"></script>
<!-- Count Down Js -->
<script src="{{asset('assets/web/plugins/syo-timer/build/jquery.syotimer.min.js')}}"></script>

<!-- slick Carousel -->
<script src="{{asset('assets/web/plugins/slick/slick.min.js')}}"></script>
<script src="{{asset('assets/web/plugins/slick/slick-animation.min.js')}}"></script>

<!-- Google Mapl -->
{{--
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
<script type="text/javascript" src="{{asset('assets/web/plugins/google-map/gmap.js')}}"></script> --}}

<!-- Main Js File -->
<script src="{{asset('assets/web/js/script.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    @if (session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            timer: 1500
        })
    @endif
    @if (session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}',
            timer: 1500
        })
    @endif
    $(document).ready(function () {
        $('.view-cart-btn').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('web.cart.index') }}",
                type: "GET",

                success: function (response) {

                    if (response.success === false) {
                        Swal.fire({
                            icon: 'warning',
                            title: response.message,
                        });
                    } else {
                        // If success true OR page returned (HTML)
                        window.location.href = "{{ route('web.cart.index') }}";
                    }
                },

                error: function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: error.responseJSON?.message || 'Failed to load cart.'
                    });
                }
            });
        });

    });


</script>
@include('includes.web.common.add-to-wishlist-script')

@stack('scripts')