@extends('layouts.web.app')
@section('title', 'Products of Salah Wears')
@section('page', 'Products')
@section('content')



    <section class="products section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="widget">
                        <h4 class="widget-title">Short By</h4>
                        <form method="post" action="#">
                            <select class="form-control">
                                <option>Man</option>
                                <option>Women</option>
                                <option>Accessories</option>
                                <option>Shoes</option>
                            </select>
                        </form>
                    </div>
                    <div class="widget product-category">
                        <h4 class="widget-title">Categories</h4>
                        <div class="panel-group commonAccordion" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            Shoes
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                    aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <ul>
                                            <li><a href="#!">Brand & Twist</a></li>
                                            <li><a href="#!">Shoe Color</a></li>
                                            <li><a href="#!">Shoe Color</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Duty Wear
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <ul>
                                            <li><a href="#!">Brand & Twist</a></li>
                                            <li><a href="#!">Shoe Color</a></li>
                                            <li><a href="#!">Shoe Color</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            WorkOut Shoes
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <ul>
                                            <li><a href="#!">Brand & Twist</a></li>
                                            <li><a href="#!">Shoe Color</a></li>
                                            <li><a href="#!">Gladian Shoes</a></li>
                                            <li><a href="#!">Swis Shoes</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">

                        @for ($item = 1; $item <= 9; $item++)
                            <div class="col-md-4">
                                <div class="product-item" style="cursor:pointer;">
                                    <div class="product-thumb">
                                        <span class="bage">Sale</span>
                                        <a href="{{ route('web.product.show') }}">
                                            <img class="img-responsive"
                                                src="{{ asset('assets/web/images/shop/products/product-' . $item . '.jpg') }}"
                                                alt="product-img" />
                                        </a>
                                        <div class="preview-meta">
                                            <ul>
                                                <li>
                                                    <span data-toggle="modal" data-target="#product-modal">
                                                        <i class="tf-ion-ios-search-strong"></i>
                                                    </span>
                                                </li>
                                                <li>
                                                    <span><i class="tf-ion-ios-heart"></i></span>
                                                </li>
                                                <li>
                                                    <span><i class="tf-ion-android-cart"></i></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h4 class="mb-1">Rainbow Shoes</h4>
                                        <p class="price">$200</p>
                                    </div>
                                </div>
                            </div>
                        @endfor

                        <!-- Modal -->
                        <div class="modal product-modal fade" id="product-modal">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="tf-ion-close"></i>
                            </button>
                            <div class="modal-dialog " role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <div class="modal-image">
                                                    <img class="img-responsive"
                                                        src="{{ asset('assets/web/images/shop/products/modal-product.jpg') }}"
                                                        alt="product-img" />
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="product-short-details">
                                                    <h2 class="product-title">GM Pendant, Basalt Grey</h2>
                                                    <p class="product-price">$200</p>
                                                    <p class="product-short-description">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem iusto
                                                        nihil cum. Illo laborum numquam rem aut officia dicta cumque.
                                                    </p>
                                                    <a href="cart.html" class="btn btn-main">Add To Cart</a>
                                                    <a href="product-single.html" class="btn btn-transparent">View Product
                                                        Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
