 <form method="post" action="#">
                                            <div class="table-responsive mb-20">
                                                <table class="shop_table-2 cart table">
                                                    <thead>
                                                        <tr>
                                                            <th class="product-thumbnail ">Image</th>
                                                            <th class="product-name ">Product Name</th>
                                                            <th class="product-price ">Variant</th>
                                                            <th class="product-price ">Unit Price</th>
                                                            <th class="product-quantity">Quantity</th>
                                                            <th class="product-subtotal ">Total</th>
                                                            <th class="product-remove">Remove</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse (session('cart.items', []) as $key => $item)
                                                            <tr class="cart_item">
                                                                <td class="item-img">
                                                                    <a href="{{route('web.product.show', $item['product']['slug'])}}"><img src="{{$item['product']['featured_image'] ?? asset('assets/web/images/product/no-image.png')}}" alt="">
                                                                    </a>
                                                                </td>
                                                                <td class="item-title"> <a href="{{route('web.product.show', $item['product']['slug'])}}">{{ $item['product']['name'] }} </a></td>
                                                                <td class="item-title"> {{ $item['variant']['variant_name'] ?? 'Simple Product' }}</td>
                                                                <td class="item-price"> PKR {{ number_format($item['product']['base_price'] + ($item['variant']['price'] ?? 0), 2) }} </td>
                                                                <td class="item-qty">
                                                                    <div class="cart-quantity">

                                                                        <div class="product-qty">
                                                                            <div class="cart-quantity">
                                                                                <div class="cart-plus-minus">
                                                                                    <div class="dec qtybutton">-</div>
                                                                                    <input type="text" value="{{ $item['quantity'] }}"
                                                                                        name="quantity"
                                                                                        class="cart-plus-minus-box"
                                                                                        id="quantity"
                                                                                        data-id="{{$key}}">
                                                                                    <div class="inc qtybutton">+</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </td>
                                                                <td class="total-price"><strong>PKR {{ number_format($item['total_price'],2) }}</strong>
                                                                </td>
                                                                <td class="remove-item"><a href="javascript:void(0);" data-id="{{$key}}" id="remove-from-cart-{{$key}}"><i
                                                                            class="fa fa-trash-o"></i></a></td>
                                                            </tr>
                                                        @empty



                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>


                                            <div class="cart-bottom-area">
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-7">
                                                        <div class="update-coupne-area">
                                                            <div class="update-continue-btn text-end pb-20">
                                                                <a href="#" class="btn-def btn2">Update Cart</a>
                                                                <a href="#" class="btn-def btn2">Continue
                                                                    Shopping</a>
                                                            </div>
                                                            <div class="coupn-area">
                                                                <div class="catagory-title cat-tit-5 mb-20">
                                                                    <h3>Coupon</h3>
                                                                    <p>Enter your coupon code if you have one.
                                                                    </p>
                                                                </div>
                                                                <div class="input-box input-box-2 mb-20">
                                                                    <input type="text" placeholder="Coupn" class="info"
                                                                        name="subject">
                                                                </div>
                                                                <a href="#" class="btn-def btn2">Apply Coupn</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-5">
                                                        <div class="cart-total-area">
                                                            <div class="catagory-title cat-tit-5 mb-20 text-end">
                                                                <h3>Cart Totals</h3>
                                                            </div>
                                                            <div class="sub-shipping">
                                                                <p>Subtotal <span>PKR {{ number_format(session('cart.total_amount', 0),2) }}</span></p>
                                                                <p>Shipping <span>$3.00</span></p>
                                                            </div>
                                                            <div class="shipping-method text-end">
                                                                <div class="shipp">
                                                                    <input type="radio" name="ship" id="pay-toggle1">
                                                                    <label for="pay-toggle1">Flat Rate</label>
                                                                </div>
                                                                <div class="shipp">
                                                                    <input type="radio" name="ship" id="pay-toggle3">
                                                                    <label for="pay-toggle3">Direct Bank
                                                                        Transfer</label>
                                                                </div>
                                                                <p><a href="#">Calculate Shipping</a></p>
                                                            </div>
                                                            <div class="process-cart-total">
                                                                <p>Total <span>PKR {{ number_format(session('cart.total_amount', 0),2) }}</span></p>
                                                            </div>
                                                            <div class="process-checkout-btn text-end">
                                                                <a class="btn-def btn2" href="#">Process To
                                                                    Checkout</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>