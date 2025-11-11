@extends('layouts.admin.app')
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
                    <div class="form-row">
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
@endpush