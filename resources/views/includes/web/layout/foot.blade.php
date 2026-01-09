<!-- Placed js at the end of the document so the pages load faster -->

<!-- jquery latest version -->
<script src="{{asset('assets/web/js/vendor/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/web/js/vendor/jquery-migrate-3.3.2.min.js')}}"></script>
<!-- Bootstrap framework js -->
<script src="{{asset('assets/web/js/bootstrap.bundle.min.js')}}"></script>
<!-- Slider js -->
<script src="{{asset('assets/web/js/slider/jquery.nivo.slider.pack.js')}}"></script>
<script src="{{asset('assets/web/js/slider/nivo-active.js')}}"></script>
<!-- counterUp-->
<script src="{{asset('assets/web/js/jquery.countdown.min.js')}}"></script>
<!-- All js plugins included in this file. -->
<script src="{{asset('assets/web/js/plugins.js')}}"></script>
<!-- Main js file that contents all jQuery plugins activation. -->
<script src="{{asset('assets/web/js/main.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-IIoucJ-70FQg6xZsORjQCUPHCVj9GV4"></script>

<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>
{{--
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script src="{{ asset('assets/web/js/sweetalert2.js') }}"></script>

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

        const $searchInput = $('#header-search-input');
        const $searchDropdown = $('#search-dropdown-ul');

        function toggleDropdown() {
            let keyword = $searchInput.val().trim();

            if (keyword.length > 0) {
                $searchDropdown.show();

                // 🔹 AJAX request on input
                $.ajax({
                    url: "{{ route('web.product.header.search') }}",   // apna backend route
                    type: 'GET',
                    data: {
                        q: keyword
                    },
                    beforeSend: function () {
                        $searchDropdown.html('<li>Loading...</li>');
                    },
                    success: function (response) {
                        console.log(response);
                        $searchDropdown.html(response.data.html);
                    },
                    error: function () {
                        $searchDropdown.html('<li>Error loading results</li>');
                    }
                });

            } else {
                $searchDropdown.hide();
            }
        }

        // focus event
        $searchInput.on('focus', toggleDropdown);

        // input event
        $searchInput.on('keyup', toggleDropdown);

        // click outside hide dropdown
        $(document).on('click', function (e) {
            if (!$searchInput.is(e.target) &&
                !$searchDropdown.is(e.target) &&
                $searchDropdown.has(e.target).length === 0) {

                $searchDropdown.hide();
            }
        });

    });

</script>
@include('includes.web.common.cart.cart-wishlist-index-script')
@include('includes.web.common.wishlist.add-to-wishlist-script')
@stack('scripts')