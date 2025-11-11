@extends('layouts.admin.app')
@section('title', 'Edit Product')
@section('page', 'Manage Products')

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            id="submit-form">
            @csrf

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
                </div>

                <div class="card-body">
                    {{-- ✅ Basic Info --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Product Name</label>
                            <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Base Price</label>
                            <input type="text" name="base_price" value="{{ $product->base_price }}"
                                class="form-control only-numeric" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Stock</label>
                            <input type="text" name="stock" value="{{ $product->stock }}" class="form-control only-numeric"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" name="sku" value="{{ $product->sku }}" class="form-control" readonly>
                    </div>

                    {{-- ✅ Short / Long Description --}}
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea name="short_description"
                            class="form-control summernote">{{ $product->short_description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Long Description</label>
                        <textarea name="long_description"
                            class="form-control summernote">{{ $product->long_description }}</textarea>
                    </div>

                    {{-- ✅ Images --}}
                    <hr>
                    <h5>Images</h5>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Featured Image</label><br>
                            <img id="featuredPreview"
                                src="{{ $product->featured_image ?: asset('assets/web/images/no-image.png') }}"
                                class="img-thumbnail mb-2" style="width:150px;height:150px;object-fit:cover;">
                            <input type="file" name="featured_image" id="featuredInput" class="form-control-file mt-2"
                                accept="image/*">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Gallery Images</label>
                            <input type="file" name="gallery_images[]" id="galleryInput" class="form-control-file" multiple
                                accept="image/*">
                            <div id="galleryPreview" class="d-flex flex-wrap mt-2">
                                @foreach($product->images as $img)
                                    <div class="position-relative m-1">
                                        <img src="{{ $img->image }}" class="img-thumbnail"
                                            style="width:100px;height:100px;object-fit:cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute remove-gallery"
                                            data-id="{{ $img->id }}" style="top:2px;right:2px;">&times;</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- ✅ Variants Section --}}
                    <hr>
                    <h5>Product Variants</h5>
                    <p class="text-muted">Select new attributes to generate more variants if needed.</p>

                    <div class="row">
                        @foreach($attributes as $attr)
                            <div class="form-group col-md-4">
                                <label>{{ $attr->name }}</label>
                                <div class="select2-purple">
                                    <select class="form-control attribute-select select2" data-attribute="{{ $attr->name }}"
                                        multiple>
                                        @foreach($attr->values as $val)
                                            <option value="{{ $val->value }}" {{ in_array($val->value, $usedAttributeValues) ? 'selected' : '' }}>
                                                {{ $val->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- ✅ Variant Table --}}
                    <div id="variantsTable" class="mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Variant</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->variants as $i => $v)
                                    <tr>
                                        <td><input type="hidden" name="variants[{{ $i }}][name]"
                                                value="{{ $v->variant_name }}">{{ $v->variant_name }}</td>
                                        <td><input type="text" name="variants[{{ $i }}][sku]" value="{{ $v->sku }}"
                                                class="form-control" readonly></td>
                                        <td><input type="text" name="variants[{{ $i }}][price]" value="{{ $v->price }}"
                                                class="form-control only-numeric"></td>
                                        <td><input type="text" name="variants[{{ $i }}][stock]" value="{{ $v->stock }}"
                                                class="form-control only-numeric"></td>
                                        <td>
                                            <input type="file" name="variants[{{ $i }}][image]" class="form-control-file"
                                                accept="image/*">
                                            @if($v->image)
                                                <img src="{{ $v->image }}" class="mt-1 rounded"
                                                    style="width:70px;height:70px;object-fit:cover;">
                                            @endif
                                        </td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-variant">&times;</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button class="btn btn-primary" id="submit-btn">Update Product</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {

            // 🔹 Numeric restriction
            $(document).on('input', '.only-numeric', function () {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });

            // 🔹 Featured preview
            $('#featuredInput').on('change', function () {
                const file = this.files[0];
                if (file) $('#featuredPreview').attr('src', URL.createObjectURL(file));
            });

            // 🔹 Gallery preview (new)
            $('#galleryInput').on('change', function () {
                $('#galleryPreview').html('');
                Array.from(this.files).forEach(file => {
                    $('#galleryPreview').append(`
                                                <div class="position-relative m-1">
                                                    <img src="${URL.createObjectURL(file)}" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top:2px;right:2px;">&times;</button>
                                                </div>
                                            `);
                });
            });

            // 🔹 Remove gallery image (existing)
            $(document).on('click', '.remove-gallery', function () {
                const id = $(this).data('id');
                if (confirm('Remove this image?')) {
                    $.ajax({
                        url: "#",
                        method: "POST",
                        data: { id, _token: '{{ csrf_token() }}' },
                        success: res => { if (res.success) $(this).parent().remove(); }
                    });
                }
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



            // 🔹 Generate new variants and merge with existing
            $('.attribute-select').on('change', generateVariants);

            function generateVariants() {
                const attributes = {};
                $('.attribute-select').each(function () {
                    const name = $(this).data('attribute');
                    const values = $(this).val();
                    if (values && values.length > 0) attributes[name] = values;
                });

                const combos = generateCombinations(Object.values(attributes));
                mergeVariantRows(combos);
            }

            function generateCombinations(arrays) {
                if (arrays.length === 0) return [];
                return arrays.reduce((acc, curr) => {
                    let res = [];
                    acc.forEach(a => curr.forEach(c => res.push([].concat(a, c))));
                    return res;
                });
            }

            // 🔹 Merge new variants with existing
            function mergeVariantRows(combos) {
                const productName = $('input[name="name"]').val() || 'PROD';
                const baseSku = productName.trim().substring(0, 3).toUpperCase();

                combos.forEach(c => {
                    const name = Array.isArray(c) ? c.join(' / ') : c;
                    const sku = `${baseSku}-${name.replace(/[\s/]+/g, '-').toUpperCase()}`;

                    // check if already exists
                    if ($(`input[value="${name}"][name*="[name]"]`).length === 0) {
                        $('#variantsTable tbody').append(`
                                                    <tr>
                                                        <td><input type="hidden" name="variants[new_${Date.now()}][name]" value="${name}">${name}</td>
                                                        <td><input type="text" name="variants[new_${Date.now()}][sku]" value="${sku}" class="form-control" readonly></td>
                                                        <td><input type="text" name="variants[new_${Date.now()}][price]" class="form-control only-numeric" value="0"></td>
                                                        <td><input type="text" name="variants[new_${Date.now()}][stock]" class="form-control only-numeric" value="1"></td>
                                                        <td><input type="file" name="variants[new_${Date.now()}][image]" class="form-control-file"></td>
                                                        <td><button type="button" class="btn btn-danger btn-sm remove-variant">&times;</button></td>
                                                    </tr>
                                                `);
                    }
                });
            }

        });
    </script>

    @include('includes.admin.ajax-requests.create', ['redirectUrl' => route('admin.products.index')])
@endpush