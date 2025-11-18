@extends('layouts.admin.app')
@section('title', 'Create Product')
@section('page', 'Manage Products')

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="submit-form"
            data-reset="true">
            @csrf
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create Product</h3>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                <div class="card-body">
                    {{-- 🔹 Basic Info --}}
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Base Price</label>
                            <input type="text" name="base_price" class="form-control only-numeric">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Stock</label>
                            <input type="text" name="stock" class="form-control only-numeric">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control select2" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" name="sku" class="form-control" readonly>
                    </div>

                    {{-- 🔹 Descriptions --}}
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea name="short_description" class="form-control summernote"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Long Description</label>
                        <textarea name="long_description" class="form-control summernote"></textarea>
                    </div>

                    <hr>

                    {{-- 🔹 Images --}}
                    <h5>Product Images</h5>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Featured Image</label><br>
                            <img id="featuredPreview" src="{{ asset('assets/web/images/no-image.png') }}" alt="Featured"
                                class="img-thumbnail mb-2" style="width:150px;height:150px;object-fit:cover;">
                            <input type="file" name="featured_image" id="featuredInput" class="form-control-file mt-2"
                                accept="image/*">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Gallery Images</label>
                            <input type="file" name="gallery_images[]" id="galleryInput" class="form-control-file" multiple
                                accept="image/*">
                            <div id="galleryPreview" class="d-flex flex-wrap mt-2"></div>
                        </div>
                    </div>

                    <hr>

                    {{-- 🔹 Variable Product --}}
                    <div class="form-group mb-4">
                        <label class="form-label fw-bold d-block mb-2">Product Type</label>

                        <input type="checkbox" name="is_variable" id="isVariable" data-bootstrap-switch
                            data-off-color="danger" data-on-color="success" data-on-text="Variable" data-off-text="Simple">

                        <small class="form-text text-muted mt-2">
                            Turn <strong>ON</strong> if this product has multiple variants (like sizes, colors, etc).
                            Keep it <strong>OFF</strong> for a single standard product.
                        </small>
                    </div>


                    {{-- 🔹 Variants Section --}}
                    <div id="variantSection" style="display: none;">
                        <h5>Product Variants</h5>

                        <div id="variant-wrapper">
                            <div class="card mb-3 variant-group position-relative border border-secondary">
                                <button type="button" class="btn btn-danger btn-sm position-absolute remove-variant"
                                    style="top: 5px; right: 5px; display: none;">
                                    <i class="fas fa-times"></i>
                                </button>

                                <div class="card-body">
                                    <div class="row">
                                        {{-- <div class="form-group col-md-3">
                                            <label>SKU</label>
                                            <input type="text" name="variants[0][sku]" class="form-control variant-sku"
                                                required readonly>
                                        </div> --}}

                                        <div class="form-group col-md-6">
                                            <label>Price</label>
                                            <input type="text" name="variants[0][price]" class="form-control only-numeric"
                                                value="0">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Stock</label>
                                            <input type="text" name="variants[0][stock]" class="form-control only-numeric"
                                                value="1">
                                        </div>

                                        {{-- <div class="form-group col-md-3">
                                            <label>Image</label>
                                            <input type="file" name="variants[0][image]" class="form-control-file"
                                                accept="image/*">
                                        </div> --}}
                                    </div>

                                    <div class="row">
                                        @foreach ($attributes as $attribute)
                                            @php
                                                $attrCount = count($attributes);
                                                if ($attrCount == 2 || $attrCount == 4)
                                                    $col = "col-md-6";
                                                elseif ($attrCount == 3)
                                                    $col = "col-md-4";
                                                else
                                                    $col = "col-md-3";
                                            @endphp
                                            <div class="{{ $col }}">
                                                <div class="form-group">
                                                    <label>{{ $attribute->name }}</label>
                                                    <select name="variants[0][attribute_value_ids][]"
                                                        class="form-control select2 variant-attr" style="width: 100%;">
                                                        <option value="">Select {{ $attribute->name }}</option>
                                                        @foreach ($attribute->values as $value)
                                                            <option value="{{ $value->id }}">{{ $value->value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mb-3">
                            <button type="button" id="add-variant" class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Add More
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button class="btn btn-primary" id="submit-btn">Save Product</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            // $('.summernote').summernote({ height: 150 });

            // ✅ Only numeric fields
            $(document).on('input', '.only-numeric', function () {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });

            // ✅ SKU auto from product name
            $('input[name="name"]').on('input', function () {
                const base = $(this).val().trim().substring(0, 3).toUpperCase();
                $('input[name="sku"]').val(base);
            });

            // ✅ Featured image preview
            $('#featuredInput').on('change', function () {
                const file = this.files[0];
                if (file) $('#featuredPreview').attr('src', URL.createObjectURL(file));
            });

            // ✅ Gallery image preview
            $('#galleryInput').on('change', function () {
                $('#galleryPreview').html('');
                Array.from(this.files).forEach(file => {
                    const img = $('<div class="position-relative m-1">\
                                    <img src="'+ URL.createObjectURL(file) + '" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">\
                                    <button type="button" class="btn btn-danger btn-sm position-absolute remove-gallery" style="top:2px;right:2px;">&times;</button>\
                                </div>');
                    $('#galleryPreview').append(img);
                });
            });

            $(document).on('click', '.remove-gallery', function () {
                $(this).closest('div').remove();
            });


            $('#isVariable').on('switchChange.bootstrapSwitch', function (event, state) {
                if (state) {
                    $('#variantSection').slideDown();
                } else {
                    $('#variantSection').slideUp();
                    $('.remove-variant').trigger('click');
                    $('#variant-wrapper').find('input,select').each(function () {
                        const name = $(this).attr('name');
                        if (name) $(this).attr('name', name.replace(/\[\d+\]/, '[0]')).val('');
                    });
                }
            });
            // ✅ Add / remove variant rows
            let variantIndex = 1;
            $('#add-variant').on('click', function () {
                const wrapper = $('#variant-wrapper');
                wrapper.find('.remove-variant').show();
                const firstGroup = wrapper.find('.variant-group').first();

                // Destroy all select2 before cloning
                firstGroup.find('.select2').each(function () {
                    if ($(this).data('select2')) {
                        $(this).select2('destroy');
                    }
                });

                const newGroup = firstGroup.clone();

                newGroup.find('input, select').each(function () {
                    const name = $(this).attr('name');
                    if (name) $(this).attr('name', name.replace(/\[\d+\]/, `[${variantIndex}]`)).val('');
                });

                newGroup.find('.remove-variant').show();

                // Remove any leftover select2 containers
                newGroup.find('.select2-container').remove();

                wrapper.append(newGroup);

                // Reinitialize select2 cleanly
                newGroup.find('.select2').select2({ width: '100%' });

                // Reinitialize select2 on original firstGroup
                firstGroup.find('.select2').select2({ width: '100%' });

                variantIndex++;
            });

            $(document).on('click', '.remove-variant', function () {
                if ($('.variant-group').length > 1) {
                    $(this).closest('.variant-group').remove();
                }
            });

            // Initialize select2 initially
            if ($.fn.select2) $('.select2').select2({ width: '100%' });
        });
    </script>

    @include('includes.admin.ajax-requests.create', ['redirectUrl' => null])
@endpush






{{-- @extends('layouts.admin.app')
@section('title', 'Create Product')
@section('page', 'Manage Products')
@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="submit-form">
        @csrf
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Product</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Product Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Base Price</label>
                        <input type="text" name="base_price" class="form-control only-numeric" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Stock</label>
                        <input type="text" name="stock" class="form-control only-numeric" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" name="sku" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Short Description</label>
                    <textarea name="short_description" class="form-control summernote"></textarea>
                </div>

                <div class="form-group">
                    <label>Long Description</label>
                    <textarea name="long_description" class="form-control summernote"></textarea>
                </div>

                <hr>
                <h5>Images</h5>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Featured Image</label><br>
                        <img id="featuredPreview" src="{{ asset('assets/web/images/no-image.png') }}" alt="Featured"
                            class="img-thumbnail mb-2" style="width:150px;height:150px;object-fit:cover;">
                        <input type="file" name="featured_image" id="featuredInput" class="form-control-file mt-2"
                            accept="image/*">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Gallery Images</label>
                        <input type="file" name="gallery_images[]" id="galleryInput" class="form-control-file" multiple
                            accept="image/*">
                        <div id="galleryPreview" class="d-flex flex-wrap mt-2"></div>
                    </div>
                </div>

                <hr>
                <h5>Product Variants (Optional)</h5>
                <p class="text-muted">Select attributes to generate variant combinations.</p>

                <div class="row">
                    @foreach($attributes as $attr)
                    <div class="form-group col-md-4">
                        <label>{{ $attr->name }}</label>
                        <div class="select2-purple">
                            <select class="form-control attribute-select select2" data-attribute="{{ $attr->name }}"
                                multiple="multiple">
                                @foreach($attr->values as $val)
                                <option value="{{ $val->value }}">{{ $val->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div id="variantsTable" class="mt-4"></div>
            </div>

            <div class="card-footer text-right">
                <button class="btn btn-primary" id="submit-btn">Save Product</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        // Allow only numeric input
        $(document).on('input', '.only-numeric', function () {
            this.value = this.value.replace(/[^0-9.]/g, '');
        });

        // 🔹 Featured image preview
        $('#featuredInput').on('change', function () {
            const file = this.files[0];
            if (file) {
                $('#featuredPreview').attr('src', URL.createObjectURL(file));
            }
        });

        // 🔹 Gallery image preview
        $('#galleryInput').on('change', function () {
            $('#galleryPreview').html('');
            Array.from(this.files).forEach(file => {
                const img = $('<div class="position-relative m-1">\
                                    <img src="'+ URL.createObjectURL(file) + '" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">\
                                    <button type="button" class="btn btn-danger btn-sm position-absolute remove-gallery" style="top:2px;right:2px;">&times;</button>\
                                </div>');
                $('#galleryPreview').append(img);
            });
        });

        // 🔹 Remove gallery image preview
        $(document).on('click', '.remove-gallery', function () {
            $(this).closest('div').remove();
        });

        // 🔹 Generate variants
        $('.attribute-select').on('change', generateVariants);

        function generateVariants() {
            const attributes = {};
            $('.attribute-select').each(function () {
                const name = $(this).data('attribute');
                const values = $(this).val();
                if (values && values.length > 0) {
                    attributes[name] = values;
                }
            });

            const combinations = generateCombinations(Object.values(attributes));
            renderVariantTable(combinations);
        }

        function generateCombinations(arrays) {
            if (arrays.length === 0) return [];
            return arrays.reduce((acc, curr) => {
                let res = [];
                acc.forEach(a => {
                    curr.forEach(c => res.push([].concat(a, c)));
                });
                return res;
            });
        }
        $('input[name="name"]').on('input', function () {
            const productName = $('input[name="name"]').val() || 'PROD';
            const baseSku = productName.trim().substring(0, 3).toUpperCase();
            $('input[name="sku"]').val(baseSku);
        });
        // 🔹 Remove variant row + unselect attribute values only if unused
        $(document).on('click', '.remove-variant', function () {
            const $row = $(this).closest('tr');

            // Get variant name (e.g., "S / Blue")
            const variantName = $row.find('input[name*="[name]"]').val();
            const parts = variantName.split(' / ').map(v => v.trim());

            // Remove the row first
            $row.remove();

            // Check each value if still used in other variants
            parts.forEach(value => {
                let stillUsed = false;

                // Loop through remaining variants
                $('input[name*="[name]"]').each(function () {
                    const otherName = $(this).val();
                    if (otherName && otherName.includes(value)) {
                        stillUsed = true; // found same value in another variant
                    }
                });

                // ✅ Only unselect if no other variant uses this value
                if (!stillUsed) {
                    $('.attribute-select').each(function () {
                        const $select = $(this);
                        const selectedValues = $select.val() || [];

                        if (selectedValues.includes(value)) {
                            const newValues = selectedValues.filter(v => v !== value);
                            $select.val(newValues).trigger('change.select2');
                        }
                    });
                }
            });
        });
        function renderVariantTable(combos) {
            if (combos.length === 0) {
                $('#variantsTable').html('');
                return;
            }
            const productName = $('input[name="name"]').val() || 'PROD';
            const baseSku = productName.trim().substring(0, 3).toUpperCase();

            let html = `
                                <table class="table table-bordered">
                                    <thead>
                                        <tr><th>Variant</th><th>SKU</th><th>Price</th><th>Stock</th><th>Image</th><th>Action</th></tr>
                                    </thead>
                                    <tbody>
                            `;

            combos.forEach((c, i) => {
                const name = Array.isArray(c) ? c.join(' / ') : c;
                const variantSku = `${baseSku}-${name.replace(/[\s/]+/g, '-').toUpperCase()}`;

                html += `
                                    <tr>
                                        <td><input type="hidden" name="variants[${i}][name]" value="${name}">${name}</td>
                                        <td><input type="text" name="variants[${i}][sku]" class="form-control" value="${variantSku}" readonly></td>
                                        <td><input type="text" name="variants[${i}][price]" class="form-control only-numeric" value="0" required></td>
                                        <td><input type="text" name="variants[${i}][stock]" class="form-control only-numeric" value="1" required></td>
                                        <td><input type="file" name="variants[${i}][image]" class="form-control-file" accept="image/*"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-variant">&times;</button></td>
                                    </tr>
                                `;
            });

            html += '</tbody></table>';
            $('#variantsTable').html(html);
        }
    });
</script>

@include('includes.admin.ajax-requests.create', ['redirectUrl' => null])
@endpush --}}
