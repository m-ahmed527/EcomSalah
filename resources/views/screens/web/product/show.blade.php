@extends('layouts.web.app')

@section('title', 'Details of a Product of Salah Wears')
@section('page', 'Products')
@section('content')
    {{-- @dd($product) --}}
    <section class="single-product">
        <div class="container">

            <div class="row mt-20">
                <div class="col-md-5">
                    <div class="single-product-slider">
                        <div id='carousel-custom' class='carousel slide' data-ride='carousel'>
                            <div class='carousel-outer'>
                                <!-- me art lab slider -->
                                <div class='carousel-inner '>
                                    <div class='item active'>
                                        <img src='{{$product->featured_image ?? asset('assets/web/images/no-image.png')}}'
                                            alt=''
                                            data-zoom-image="{{$product->featured_image ?? asset('assets/web/images/no-image.png')}}" />
                                    </div>
                                    @forelse ($product->images as $image)
                                        <div class='item'>
                                            <img src='{{$image->image ?? asset('assets/web/images/no-image.png')}}' alt=''
                                                data-zoom-image="{{$image->image ?? asset('assets/web/images/no-image.png')}}" />
                                        </div>
                                    @empty
                                        <div class='item'>
                                            <img src='{{ asset('assets/web/images/no-image.png')}}' alt=''
                                                data-zoom-image="{{ asset('assets/web/images/no-image.png')}}" />
                                        </div>
                                    @endforelse


                                </div>

                                <!-- sag sol -->
                                <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
                                    <i class="tf-ion-ios-arrow-left"></i>
                                </a>
                                <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
                                    <i class="tf-ion-ios-arrow-right"></i>
                                </a>
                            </div>

                            <!-- thumb -->
                            <ol class='carousel-indicators mCustomScrollbar meartlab'>
                                <li data-target='#carousel-custom' data-slide-to='0' class='active'>
                                    <img src='{{$product->featured_image ?? asset('assets/web/images/no-image.png')}}'
                                        alt='' />
                                </li>
                                @forelse ($product->images as $key => $image)
                                    <li data-target='#carousel-custom' data-slide-to='{{ $key + 1 }}'>
                                        <img src='{{$image->image ?? asset('assets/web/images/no-image.png')}}' alt='' />
                                    </li>
                                @empty
                                    <li data-target='#carousel-custom' data-slide-to='1'>
                                        <img src='{{ asset('assets/web/images/no-image.png')}}' alt='' />
                                    </li>
                                @endforelse

                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-details">
                        <h2>{{ $product->name }}</h2>
                        <p class="product-price">PKR {{ $product->priceRange() }}</p>

                        <p class="product-description mt-20">
                            {!! $product->short_description !!}
                        </p>
                        {{-- @dd($attributes) --}}
                        <form action="">
                            <div class="row" id="variant-selectors">
                                @foreach ($attributes as $attribute)

                                    <div class="mb-3">
                                        <label class="form-label d-block fw-bold">{{ $attribute->name }}:</label>
                                        <div style="display: flex; gap:10px; margin:5px">
                                            @foreach ($attribute->values as $value)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input variant-radio" type="radio"
                                                        name="attribute_{{ $attribute->id }}"
                                                        data-attribute-id="{{ $attribute->id }}" value="{{ $value->id }}">
                                                    <label class="form-check-label">{{ $value->value }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- Reset Button --}}
                                        <button type="button" class="btn btn-sm btn-outline-secondary ms-2 reset-attribute"
                                            data-attribute-id="{{ $attribute->id }}">
                                            Reset {{ $attribute->name }}
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </form>
                        <div class="mt-4">
                            <h5>Additional price: <span id="variant-price">-</span></h5>
                            <h5>Stock of variant: <span id="variant-stock">-</span></h5>
                        </div>
                        <div class="product-category">
                            <span>Categories:</span>
                            <ul>
                                @forelse ($product->categories as $category)
                                    <li><a href="#!">{{ $category->name }}</a></li>
                                @empty
                                    <li><a href="#!">Uncategorized</a></li>
                                @endforelse

                            </ul>
                        </div>
                        <form id="cart-form">
                            <input type="hidden" name="variant_id" id="selected-variant-id">
                            <div class="product-quantity">
                                <span>Quantity:</span>
                                <div class="product-quantity-slider">
                                    <input id="quantity" type="text" value="0" name="product-quantity">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main mt-20">Add To Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="tabCommon mt-20">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#details" aria-expanded="true">Details</a></li>
                            {{-- <li class=""><a data-toggle="tab" href="#reviews" aria-expanded="false">Reviews (3)</a>
                            </li> --}}
                        </ul>
                        <div class="tab-content patternbg">
                            <div id="details" class="tab-pane fade active in">
                                <h4>Product Description</h4>
                                <p>{!! $product->long_description !!}</p>
                            </div>
                            {{-- <div id="reviews" class="tab-pane fade">
                                <div class="post-comments">
                                    <ul class="media-list comments-list m-bot-50 clearlist">
                                        <!-- Comment Item start-->
                                        <li class="media">

                                            <a class="pull-left" href="#!">
                                                <img class="media-object comment-avatar"
                                                    src="{{ asset('assets/web/images/blog/avater-1.jpg') }}" alt=""
                                                    width="50" height="50" />
                                            </a>

                                            <div class="media-body">
                                                <div class="comment-info">
                                                    <h4 class="comment-author">
                                                        <a href="#!">Jonathon Andrew</a>

                                                    </h4>
                                                    <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                                    <a class="comment-button" href="#!"><i
                                                            class="tf-ion-chatbubbles"></i>Reply</a>
                                                </div>

                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at
                                                    magna ut ante eleifend eleifend.Lorem ipsum dolor sit amet, consectetur
                                                    adipisicing elit. Quod laborum minima, reprehenderit laboriosam officiis
                                                    praesentium? Impedit minus provident assumenda quae.
                                                </p>
                                            </div>

                                        </li>
                                        <!-- End Comment Item -->

                                        <!-- Comment Item start-->
                                        <li class="media">

                                            <a class="pull-left" href="#!">
                                                <img class="media-object comment-avatar"
                                                    src="{{asset('assets/web/images/blog/avater-4.jpg')}}" alt="" width="50"
                                                    height="50" />
                                            </a>

                                            <div class="media-body">

                                                <div class="comment-info">
                                                    <div class="comment-author">
                                                        <a href="#!">Jonathon Andrew</a>
                                                    </div>
                                                    <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                                    <a class="comment-button" href="#!"><i
                                                            class="tf-ion-chatbubbles"></i>Reply</a>
                                                </div>

                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at
                                                    magna ut ante eleifend eleifend. Lorem ipsum dolor sit amet, consectetur
                                                    adipisicing elit. Magni natus, nostrum iste non delectus atque ab a
                                                    accusantium optio, dolor!
                                                </p>

                                            </div>

                                        </li>
                                        <!-- End Comment Item -->

                                        <!-- Comment Item start-->
                                        <li class="media">

                                            <a class="pull-left" href="#!">
                                                <img class="media-object comment-avatar"
                                                    src="{{asset('assets/web/images/blog/avater-1.jpg')}}" alt="" width="50"
                                                    height="50">
                                            </a>

                                            <div class="media-body">

                                                <div class="comment-info">
                                                    <div class="comment-author">
                                                        <a href="#!">Jonathon Andrew</a>
                                                    </div>
                                                    <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                                    <a class="comment-button" href="#!"><i
                                                            class="tf-ion-chatbubbles"></i>Reply</a>
                                                </div>

                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at
                                                    magna ut ante eleifend eleifend.
                                                </p>

                                            </div>

                                        </li>
                                    </ul>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="products related-products section">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2>Related Products</h2>
                </div>
            </div>
            <div class="row">
                @forelse ($relatedProducts as $relProduct)
                    <div class="col-md-3">
                        <div class="product-item">

                            <div class="product-thumb">
                                <span class="bage">Sale</span>
                                <a href="{{ route('web.product.show', $relProduct->slug) }}" class="product-a">
                                    <img class="img-responsive"
                                        src="{{ $relProduct->featured_image ?? asset('assets/web/images/no-image.png') }}"
                                        alt="product-img" />
                                </a>
                                <div class="preview-meta">
                                    <ul>
                                        <li>
                                            <span class="modalProductShow"
                                                data-url="{{ route('web.product.details', $relProduct->slug) }}">
                                                <i class="tf-ion-ios-eye" style="font-size:22px;"></i>
                                            </span>
                                        </li>
                                        <li>
                                            <span><i class="tf-ion-ios-heart"></i></span>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                            <div class="product-content">
                                <h4 class="mb-1">{{ $relProduct->name }}</h4>
                                <p class="price">PKR {{ $relProduct->priceRange() }}</p>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <h5 class="text-center text-muted">No related products found.</h5>
                    </div>
                @endforelse

            </div>
        </div>
    </section>



    <!-- Modal -->
    @include('screens.web.product.partials.modal')
@endsection
@push('scripts')
    @include('includes.web.common.modal-script')

    <script>
        const variantMap = @json($variantMap);
        const priceDisplay = $('#variant-price');
        const stockDisplay = $('#variant-stock');
        let currentVariantId = null;

        function getSelectedAttributes() {
            const selected = {};
            $('.variant-radio:checked').each(function () {
                const attrId = $(this).data('attribute-id');
                selected[attrId] = parseInt($(this).val());
            });

            return selected;
        }

        function filterRadios(changedInput = null) {
            const selected = getSelectedAttributes();

            $('.variant-radio').prop('disabled', false); // reset all first

            if (changedInput && !$(changedInput).is(':checked')) {
                // If radio was unchecked (user clicked same again), stop here
                priceDisplay.text('-');
                stockDisplay.text('-');
                $('#selected-variant-id').val('');
                currentVariantId = null;
                return;
            }

            // Loop through all attribute radios
            $('.variant-radio').each(function () {
                const currentAttr = $(this).data('attribute-id');
                const currentVal = parseInt($(this).val());


                const otherSelected = {
                    ...selected
                };

                delete otherSelected[currentAttr]; // remove self from filtering

                const isValid = variantMap.some(function (combo) {
                    let match = true;
                    for (const key in otherSelected) {
                        if (combo[key] !== otherSelected[key]) {
                            match = false;
                            break;
                        }
                    }
                    return match && combo[currentAttr] === currentVal;
                });

                if (!isValid) {
                    $(this).prop('disabled', true);
                    // Uncheck if already selected and invalid now
                    if ($(this).is(':checked')) {
                        $(this).prop('checked', false);
                    }
                }
            });

            // Check if full selection done
            if (Object.keys(selected).length === {{ $attributes->count() }}) {
                $.ajax({
                    url: "{{ route('web.product.get.variant') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        product_id: {{ $product->id }},
                        attribute_value_ids: Object.values(selected)
                    }),
                    success: function (response) {
                        if (response.success) {
                            // Update UI with variant data
                            if (response.data.price) {
                                priceDisplay.text(`PKR ${response.data.price}`);
                                stockDisplay.text(response.data.stock);
                            } else {
                                priceDisplay.text('-');
                                stockDisplay.text('-');
                            }

                            if (response.data.variant_id) {
                                $('#selected-variant-id').val(response.data.variant_id);
                                currentVariantId = response.data.variant_id;
                            }
                        } else {
                            Swal.fire('Not available', response.message, 'info');
                        }
                    },
                    error: function (error) {
                        Swal.fire('Error', error.responseJSON.message, 'error');
                    }
                });
            } else {
                priceDisplay.text('-');
                stockDisplay.text('-');
                $('#selected-variant-id').val('');
                currentVariantId = null;
            }
        }

        // 🔄 On radio change
        $('.variant-radio').on('change', function () {
            filterRadios(this);
        });
        $('.reset-attribute').on('click', function () {
            const attrId = $(this).data('attribute-id');

            // Uncheck selected radio of this attribute
            $(`.variant-radio[data-attribute-id="${attrId}"]`).prop('checked', false);

            // Trigger filtering logic to update UI
            filterRadios();
        });
        // 🛒 Cart submission
        $('#cart-form').on('submit', function (e) {
            e.preventDefault();
            const isVariantRequired = {{ $attributes->isEmpty() ? 'false' : 'true' }};
            const variantId = $('#selected-variant-id').val();
            const quantity = $('#quantity').val();

            if (isVariantRequired && !variantId) {
                Swal.fire('Select Variant', 'Please select a valid product variant before adding to cart.', 'warning');
                return;
            }

            $.ajax({
                url: "#",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    variant_id: variantId,
                    quantity: quantity
                },
                success: function (response) {
                    $('#cart-message').text(response.message);
                }
            });
        });
    </script>
@endpush
