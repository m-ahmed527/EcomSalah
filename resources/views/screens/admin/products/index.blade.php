@extends('layouts.admin.app')
@section('title', 'Manage Products')
@section('page', 'Manage Products')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">

                <div class="card-header action-buttons">
                    <h3 class="card-title">Products</h3>

                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                    <a href="{{ route('admin.imports.products.index') }}" class="btn btn-outline-info btn-sm float-right">
                        <i class="fas fa-plus"></i> Bulk Upload
                    </a>

                    <button class="btn btn-danger btn-sm float-right d-none"
                        data-url="{{ route('admin.products.destroy.selected') }}" id="delete-selected">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
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
                    <h5 class="modal-title" id="productDetailLabel">Product Details <span id="modalProductType"
                            class="badge badge-success"></span></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- 🔹 Left: Images -->
                        <div class="col-md-5 text-center">
                            <img id="modalFeaturedImage" src="{{ asset('assets/web/images/no-image.png') }}"
                                class="img-fluid rounded shadow mb-3 image-preview"
                                style="max-height: 300px; object-fit: cover;">

                            <div id="modalGallery" class="d-flex flex-wrap justify-content-center"></div>
                        </div>

                        <!-- 🔹 Right: Product Info -->
                        <div class="col-md-7">
                            <h4 id="modalProductName" class="fw-bold"></h4>
                            <p><strong>SKU:</strong> <span id="modalProductSku"></span></p>
                            <p><strong>Price:</strong> PKR <span id="modalProductPrice"></span></p>
                            <p><strong>Stock:</strong> <span id="modalProductStock"></span></p>
                            <p><strong>Category:</strong> <span id="modalProductCategory"></span></p>
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
                                    {{-- <th>Image</th> --}}
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
                data: 'id',
                title: `<input type="checkbox" id="select-all"> <span class="ml-1">Select All</span>`,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<input type="checkbox" class="row-checkbox" value="${row.id}">`;
                }
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                title: 'Sr.No.',
                orderable: false,
                searchable: false
            },
            {
                data: 'featured_image',
                name: 'featured_image',
                title: 'Image',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<img src="${row.featured_image}" class="img-thumbnail m-1 image-preview" style="width:70px;height:70px;object-fit:cover;">`;
                }
            },
            {
                data: 'name',
                name: 'name',
                title: 'Name'
            },
            {
                data: 'sku',
                name: 'sku',
                title: 'SKU',
            },
            {
                data: 'base_price',
                name: 'base_price',
                title: 'Base Price',
                render: function (data, type, row) {
                    return 'PKR ' + data;
                }
            },
            {
                data: 'stock',
                name: 'stock',
                title: 'Stock',
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
                    $('#modalProductType').text('');
                    $('#modalProductName').text('');
                    $('#modalProductSku').text('');
                    $('#modalProductPrice').text('');
                    $('#modalProductStock').text('');
                    $('#modalProductCategory').text('');
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
                    $('#modalProductType').text(product.has_variants ? '(Variable)' : '(Simple)');
                    $('#modalProductName').text(product.name);
                    $('#modalProductSku').text(product.sku);
                    $('#modalProductPrice').text(product.base_price || '-');
                    $('#modalProductStock').text(product.stock || '-');
                    if (product.categories && product.categories.length) {
                        product.categories.forEach(cat => {
                            $('#modalProductCategory').append(`<span class="badge badge-primary">${cat.name}</span> `);
                        })
                    } else {
                        console.log(product.categories);
                        $('#modalProductCategory').html('<span class="badge badge-danger">Uncategorized</span>');
                    }
                    $('#modalFeaturedImage').attr('src', product.featured_image || '{{ asset("assets/web/images/no-image.png") }}');
                    $('#modalShortDescription').html(product.short_description || '<span class="text-muted">No Description</span>');
                    $('#modalLongDescription').html(product.long_description || '<span class="text-muted">No Description</span>');

                    // Gallery
                    $('#modalGallery').html('');
                    if (product.images && product.images.length) {
                        product.images.forEach(img => {
                            $('#modalGallery').append(`<img src="${img.image}" class="img-thumbnail m-1 image-preview" style="width:70px;height:70px;object-fit:cover;">`);
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
    @include('includes.admin.ajax-requests.delete-selected');
@endpush
{{-- <td>${v.image ? `<img src="${v.image}" width="50" height="50" style="object-fit:cover;">` : '-'}</td> --}}
