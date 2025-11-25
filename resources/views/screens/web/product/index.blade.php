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

                    <h5 class="mb-3 text-muted showing-res" id="showing-results-container">
                        {{-- Ye AJAX se update hoga --}}

                    </h5>
                    <div class="row product-list-div">
                        @include('screens.web.product.partials.list')
                    </div>
                    <div class="row pagination-div" style="display: flex; justify-content: center; align-items: center;">

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        @include('screens.web.product.partials.modal')
    </section>
@endsection
@push('scripts')
    @include('includes.web.common.pagination-script')
    @include('includes.web.common.modal-script')
@endpush
