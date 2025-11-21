@extends('layouts.admin.app')
@section('title', 'Edit Product')
@section('page', 'Manage Products')
@php
    use App\Models\Product;
    $productCount = substr($product->sku, 4);
    $productCount = $productCount ?: str_pad($product->id, 4, '0', STR_PAD_LEFT);
    // dd($productCount);
@endphp
@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.products.update', $product->slug) }}" method="POST" enctype="multipart/form-data"
            id="submit-form" data-parsley-validate data-parsley-errors-messages-disabled>
            @csrf
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                <div class="card-body">
                    {{-- 🔹 Basic Info --}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="required">Product Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="required">Base Price</label>
                            <input type="text" name="base_price" class="form-control only-numeric"
                                value="{{ $product->base_price }}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="required">Stock</label>
                            <input type="text" name="stock" class="form-control only-numeric" value="{{ $product->stock }}"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="required">Category</label>
                        <select name="category_id" class="form-control select2" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if ($product->categories->contains($category)) selected
                                @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="required">SKU</label>
                        <input type="text" name="sku" class="form-control" readonly value="{{ $product->sku }}">
                    </div>

                    <hr>

                    {{-- 🔹 Images --}}
                    <h5>Product Images</h5>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="required">Featured Image</label><br>
                            <img id="featuredPreview"
                                src="{{ $product->featured_image ?: asset('assets/web/images/no-image.png') }}"
                                alt="Featured" class="img-thumbnail mb-2"
                                style="width:150px;height:150px;object-fit:cover;">
                            <input type="file" name="featured_image" id="featuredInput" class="form-control-file mt-2"
                                accept="image/*" {{ $product->featured_image ? '' : 'required'  }}>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Gallery Images</label>
                            <input type="file" name="gallery_images[]" id="galleryInput" class="form-control-file" multiple
                                accept="image/*">
                            <div id="galleryPreview" class="d-flex flex-wrap mt-2">

                                @foreach($product->images as $img)
                                    <div class="position-relative m-1" data-id="{{ $img->id }}">
                                        <img src="{{ $img->image }}" class="img-thumbnail"
                                            style="width:100px;height:100px;object-fit:cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute remove-gallery"
                                            data-id="{{ $img->id }}"
                                            data-url="{{ route('admin.products.image.destroy', $img->id) }}"
                                            style="top:2px;right:2px;">&times;</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- 🔹 Descriptions --}}
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



                    <hr>

                    {{-- 🔹 Variable Product --}}

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold d-block mb-2">Product Type</label>

                        <input type="checkbox" name="is_variable" id="isVariable" {{ $product->has_variants ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success" data-on-text="Variable"
                            data-off-text="Simple">

                        <small class="form-text text-muted mt-2">
                            Turn <strong>ON</strong> if this product has multiple variants (like sizes, colors, etc).
                            Keep it <strong>OFF</strong> for a single standard product.
                        </small>
                    </div>
                    {{-- 🔹 Variants Section --}}
                    <div id="variantSection" style="display: none;">
                        <h5>Product Variants</h5>

                        <div id="variant-wrapper">

                            @forelse ($product->variants as $index => $variant)
                                <div class="card mb-3 variant-group position-relative border border-secondary">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute remove-variant"
                                        style="top: 5px; right: 5px; display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                    <div class="card-body">
                                        <div class="row">


                                            <div class="form-group col-md-6">
                                                <label>Price</label>
                                                <input type="text" name="variants[{{ $index }}][price]"
                                                    class="form-control only-numeric" value="{{ $variant->price }}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Stock</label>
                                                <input type="text" name="variants[{{ $index }}][stock]"
                                                    class="form-control only-numeric" value="{{ $variant->stock }}">
                                            </div>

                                            {{-- <div class="form-group col-md-3">
                                                <label>Image</label>
                                                <input type="file" name="variants[0][image]" class="form-control-file"
                                                    accept="image/*">
                                            </div> --}}
                                        </div>

                                        <div class="row">

                                            @foreach ($attributes as $attribute)
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ $attribute->name }}</label>
                                                        <select name="variants[{{ $index }}][attribute_value_ids][]"
                                                            class="form-select select2 variant-attr" style="width: 100%;">
                                                            @foreach ($attribute->values as $value)
                                                                <option value="{{ $value->id }}" @if ($variant->values->contains($value)) selected @endif>
                                                                    {{ $value->value }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>SKU</label>
                                            <input type="text" name="variants[{{ $index }}][sku]"
                                                class="form-control variant-sku" value="{{ $variant->sku }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="card mb-3 variant-group position-relative border border-secondary">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute remove-variant"
                                        style="top: 5px; right: 5px; display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="card-body">
                                        <div class="row">


                                            <div class="form-group col-md-6">
                                                <label>Price</label>
                                                <input type="text" name="variants[0][price]" class="form-control only-numeric">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Stock</label>
                                                <input type="text" name="variants[0][stock]" class="form-control only-numeric">
                                            </div>

                                            {{-- <div class="form-group col-md-3">
                                                <label>Image</label>
                                                <input type="file" name="variants[0][image]" class="form-control-file"
                                                    accept="image/*">
                                            </div> --}}
                                        </div>

                                        <div class="row">

                                            @foreach ($attributes as $attribute)
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ $attribute->name }}</label>
                                                        <select name="variants[0][attribute_value_ids][]"
                                                            class="form-select select2 variant-attr" style="width: 100%;">
                                                            <option value="">Select {{ $attribute->name }}</option>
                                                            @foreach ($attribute->values as $value)
                                                                <option value="{{ $value->id }}">
                                                                    {{ $value->value }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>SKU</label>
                                            <input type="text" name="variants[0][sku]" class="form-control variant-sku"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                            @endforelse
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

            if ($('#isVariable').is(':checked')) {
                $('#variantSection').slideDown();
            }

            // -------------------------
            //  ONLY NUMERIC FIELDS
            // -------------------------
            $(document).on('input', '.only-numeric', function () {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });

            // -------------------------
            //  BASE SKU GENERATION
            // -------------------------
            let baseSku = "";

            $('input[name="name"]').on('input', function () {
                const base = $(this).val().trim().substring(0, 3).toUpperCase();

                let count = "{{ $productCount }}";
                count = count.toString().padStart(4, '0');

                baseSku = base ? base + '-' + count : null;

                $('input[name="sku"]').val(baseSku);

                $(".variant-group").each(function () {
                    generateVariantSKU($(this));
                });
            });


            // -------------------------
            //  GENERATE VARIANT SKU
            // -------------------------
            function generateVariantSKU(group) {
                let sku = baseSku ? baseSku : $('input[name="sku"]').val();

                group.find('.variant-attr').each(function () {
                    if (!$(this).val()) return;
                    const text = $(this).find("option:selected").text().trim();
                    if (text) sku += "-" + text.replace(/\s+/g, '').toUpperCase();
                });

                group.find('.variant-sku').val(sku);
            }



            // -------------------------
            //  GET COMBINATION STRING
            // -------------------------
            function getVariantCombination(group) {
                let combo = [];

                group.find('.variant-attr').each(function () {
                    const txt = $(this).find("option:selected").text().trim();
                    if (txt) combo.push(txt);
                });

                return combo.join("|").toUpperCase();  // ex: "RED|M"
            }

            // -------------------------
            //  DUPLICATE CHECK
            // -------------------------
            function isDuplicateVariant(currentGroup) {
                const currentCombo = getVariantCombination(currentGroup);
                if (!currentCombo) return false;

                let found = false;

                $('.variant-group').not(currentGroup).each(function () {
                    const otherCombo = getVariantCombination($(this));
                    if (otherCombo === currentCombo && otherCombo !== "") {
                        found = true;
                    }
                });

                return found;
            }



            // -------------------------
            //  ON ATTRIBUTE CHANGE
            // -------------------------
            $(document).on("change", ".variant-attr", function () {

                const group = $(this).closest(".variant-group");

                if (isDuplicateVariant(group)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Variant',
                        text: 'Yeh variant combination already exist karta hai!',
                    });

                    $(this).val("").trigger("change");
                    return;
                }

                generateVariantSKU(group);
            });




            // -------------------------
            //  ADD VARIANT (CLONE)
            // -------------------------
            let variantIndex = {{ $product->variants->count() }};

            $('#add-variant').on('click', function () {
                const wrapper = $('#variant-wrapper');
                wrapper.find('.remove-variant').show();
                const firstGroup = wrapper.find('.variant-group').first();

                firstGroup.find('.select2').each(function () {
                    if ($(this).data('select2')) $(this).select2('destroy');
                });

                const newGroup = firstGroup.clone();

                newGroup.find('input, select').each(function () {
                    const name = $(this).attr('name');
                    if (name) $(this).attr('name', name.replace(/\[\d+\]/, `[${variantIndex}]`)).val('');
                });

                newGroup.find('.remove-variant').show();
                generateVariantSKU(newGroup);

                newGroup.find('.select2-container').remove();
                wrapper.append(newGroup);

                newGroup.find('.select2').select2({ width: '100%' });
                firstGroup.find('.select2').select2({ width: '100%' });


                // duplicate check for cloned row
                if (isDuplicateVariant(newGroup)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Variant',
                        text: 'Yeh combination already exist karta hai!',
                    });

                    newGroup.remove();
                    return;
                }

                variantIndex++;
            });



            // -------------------------
            //  REMOVE VARIANT
            // -------------------------
            $(document).on('click', '.remove-variant', function () {
                if ($('.variant-group').length > 1) {
                    $(this).closest('.variant-group').remove();
                }
            });


            // -------------------------
            //  INIT SELECT2
            // -------------------------
            if ($.fn.select2) $('.select2').select2({ width: '100%' });



            // -------------------------
            //  FEATURED IMAGE PREVIEW
            // -------------------------
            $('#featuredInput').on('change', function () {
                const file = this.files[0];
                if (file) $('#featuredPreview').attr('src', URL.createObjectURL(file));
            });


            // -------------------------
            //  GALLERY PREVIEW
            // -------------------------
            $('#galleryInput').on('change', function () {
                // Purani uploaded images ko mat hatao (jin par data-id hai)
                $('#galleryPreview .position-relative:not([data-id])').remove();

                const files = Array.from(this.files);

                files.forEach((file, index) => {
                    const wrapper = $(`
                            <div class="position-relative m-1" data-index="${index}">
                                <img src="${URL.createObjectURL(file)}" class="img-thumbnail"
                                     style="width:100px;height:100px;object-fit:cover;">
                                <button type="button"
                                        class="btn btn-danger btn-sm position-absolute remove-gallery"
                                        style="top:2px;right:2px;">&times;</button>
                            </div>
                                `);

                    $('#galleryPreview').append(wrapper);
                });
            });


            // // -------------------------
            // //  GALLERY PREVIEW
            // // -------------------------
            // $('#galleryInput').on('change', function () {
            //     $('#galleryPreview .position-relative:not([data-id])').remove();

            //     Array.from(this.files).forEach(file => {
            //         const img = $('<div class="position-relative m-1">\
            //                             <img src="' + URL.createObjectURL(file) + '" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">\
            //                             <button type="button" class="btn btn-danger btn-sm position-absolute remove-gallery" style="top:2px;right:2px;">&times;</button>\
            //                         </div>');
            //         $('#galleryPreview').append(img);
            //     });
            // });


        });

    </script>

    @include('includes.admin.ajax-requests.create', ['redirectUrl' => route('admin.products.index')])
    @include('includes.admin.ajax-requests.delete')
@endpush


{{-- Chalta hua hai ye bas combo check nahi hai --}}
