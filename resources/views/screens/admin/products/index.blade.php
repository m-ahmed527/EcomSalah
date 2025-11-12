@extends('layouts.admin.app')
@section('title', 'Manage Products')
@section('page', 'Manage Products')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Products</h3>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                </div>

                <div class="card-body">
                    <table id="product-table" class="table table-bordered table-striped"></table>
                </div>
            </div>
        </div>
    </section>

    <!-- 🔹 Product Detail Modal -->
    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="productDetailLabel">Product Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- 🔹 Left: Images -->
                        <div class="col-md-5 text-center">
                            <img id="modalFeaturedImage" src="{{ asset('assets/web/images/no-image.png') }}"
                                class="img-fluid rounded shadow mb-3" style="max-height: 300px; object-fit: cover;">

                            <div id="modalGallery" class="d-flex flex-wrap justify-content-center"></div>
                        </div>

                        <!-- 🔹 Right: Product Info -->
                        <div class="col-md-7">
                            <h4 id="modalProductName" class="fw-bold"></h4>
                            <p><strong>SKU:</strong> <span id="modalProductSku"></span></p>
                            <p><strong>Price:</strong> $<span id="modalProductPrice"></span></p>
                            <p><strong>Stock:</strong> <span id="modalProductStock"></span></p>
                            <hr>
                            <h6>Short Description</h6>
                            <div id="modalShortDescription" class="border rounded p-2 mb-2 bg-light"></div>
                            <h6>Long Description</h6>
                            <div id="modalLongDescription" class="border rounded p-2 bg-light"></div>
                        </div>
                    </div>


                    <!-- 🔹 Variants -->
                    <div id="modalVariantsSection" style="display:none;">
                    <hr>

                        <h5>Product Variants</h5>
                        <table class="table table-bordered mt-2">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Variant</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody id="modalVariantTable"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let columns = [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                title: '#', orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name',
                title: 'Name'
            },
            {
                data: 'base_price',
                name: 'base_price',
                title: 'Base Price'
            },

            {
                data: null,
                title: 'Action',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <!-- 👁 View Button -->
                    <button class="btn btn-sm btn-primary viewProduct"
                            data-url='{{ url('admin/products/show/${row.slug}') }}'
                            title="View Product">
                        <i class="fas fa-eye"></i>
                    </button>

                    <a href="{{ url('admin/products/edit/${row.slug}') }}" class="btn btn-sm btn-info editProduct">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button class="btn btn-sm btn-danger"
                        id="delete-btn"
                        data-url="{{ url('admin/products/destroy/${row.slug}') }}"
                        data-id="${row.slug}">
                    <i class="fas fa-trash"></i>
                    </button>

                    `;
                }
            },
        ];
        // Example: When clicking "View" button in your product list
        $(document).on('click', '.viewProduct', function () {
            // const product = $(this).data('product'); // Pass full product JSON from your blade
            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function () {
                    $('#modalProductName').text('');
                    $('#modalProductSku').text('');
                    $('#modalProductPrice').text('');
                    $('#modalProductStock').text('');
                    $('#modalFeaturedImage').attr('src', "{{ asset('assets/web/images/no-image.png') }}");
                    $('#modalShortDescription').html('');
                    $('#modalLongDescription').html('');
                    $('#modalGallery').html('');
                    $('#modalVariantTable').html('');
                    $('.modal-body').LoadingOverlay('show');
                },
                success: function (response) {
                    $('.modal-body').LoadingOverlay('hide');
                    product = response.data;
                    console.log(product);
                    $('#modalProductName').text(product.name);
                    $('#modalProductSku').text(product.sku);
                    $('#modalProductPrice').text(product.base_price || '-');
                    $('#modalProductStock').text(product.stock || '-');
                    $('#modalFeaturedImage').attr('src', product.featured_image || '{{ asset("assets/web/images/no-image.png") }}');
                    $('#modalShortDescription').html(product.short_description || '');
                    $('#modalLongDescription').html(product.long_description || '');

                    // Gallery
                    $('#modalGallery').html('');
                    if (product.images && product.images.length) {
                        product.images.forEach(img => {
                            $('#modalGallery').append(`<img src="${img.image}" class="img-thumbnail m-1" style="width:70px;height:70px;object-fit:cover;">`);
                        });
                    }


                    // Variants
                    if (product.variants && product.variants.length) {
                        $('#modalVariantTable').html('');

                        product.variants.forEach(v => {
                            // 🔹 Construct attribute-value string in multiple lines
                            let attrHTML = '';
                            if (v.values && v.values.length) {
                                attrHTML = v.values.map(val => {
                                    const attrName = val.attribute ? val.attribute.name : '';
                                    return `<div><strong>${attrName}:</strong> ${val.value}</div>`;
                                }).join('');
                            }

                            // 🔹 Decide display name
                            const displayName = v.variant_name
                                ? `<div><strong>${v.variant_name}</strong></div>` + (attrHTML || '')
                                : (attrHTML || '-');

                            $('#modalVariantTable').append(`
                                                    <tr>
                                                        <td>${displayName}</td>
                                                        <td>${v.sku || '-'}</td>
                                                        <td>${v.price}</td>
                                                        <td>${v.stock}</td>
                                                        <td>${v.image ? `<img src="${v.image}" width="50" height="50" style="object-fit:cover;">` : '-'}</td>
                                                    </tr>
                                                `);
                        });

                        $('#modalVariantsSection').show();
                    } else {
                        $('#modalVariantsSection').hide();
                    }


                }, error: function (xhr) {
                    $('.modal-body').LoadingOverlay('hide');
                    $('.modal-body').html('<p class="text-danger text-center">Failed to load content.</p>');
                }
            })
            $('#productDetailModal').modal('show');

        });

    </script>
    @include('includes.admin.datatable.initialize', ['table' => '#product-table', 'ajaxUrl' => route('admin.products.get.data')])
    @include('includes.admin.ajax-requests.delete');
@endpush
