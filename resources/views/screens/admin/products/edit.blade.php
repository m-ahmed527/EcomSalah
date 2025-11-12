@extends('layouts.admin.app')
@section('title', 'Edit Product')
@section('page', 'Manage Products')

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.products.update', $product->slug) }}" method="POST" enctype="multipart/form-data"
            id="submit-form">
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
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Base Price</label>
                            <input type="text" name="base_price" class="form-control only-numeric"
                                value="{{ $product->base_price }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Stock</label>
                            <input type="text" name="stock" class="form-control only-numeric" value="{{ $product->stock }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" name="sku" class="form-control" readonly value="{{ $product->sku }}">
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

                    {{-- 🔹 Images --}}
                    <h5>Product Images</h5>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Featured Image</label><br>
                            <img id="featuredPreview"
                                src="{{ $product->featured_image ?: asset('assets/web/images/no-image.png') }}"
                                alt="Featured" class="img-thumbnail mb-2"
                                style="width:150px;height:150px;object-fit:cover;">
                            <input type="file" name="featured_image" id="featuredInput" class="form-control-file mt-2"
                                accept="image/*">
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
                                            {{-- <div class="form-group col-md-3">
                                                <label>SKU</label>
                                                <input type="text" name="variants[0][sku]" class="form-control variant-sku"
                                                    required readonly>
                                            </div> --}}

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
                                            {{-- <div class="form-group col-md-3">
                                                <label>SKU</label>
                                                <input type="text" name="variants[0][sku]" class="form-control variant-sku"
                                                    required readonly>
                                            </div> --}}

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
            // $('.summernote').summernote({ height: 150 });
            if ($('#isVariable').is(':checked')) {
                $('#variantSection').slideDown();
            }
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
                // Pehle sirf un previews ko remove karo jinke pas data-id nahi hai
                $('#galleryPreview .position-relative:not([data-id])').remove();

                // Ab naye selected files ka preview add karo
                Array.from(this.files).forEach(file => {
                    const img = $('<div class="position-relative m-1">\
                                    <img src="'+ URL.createObjectURL(file) + '" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">\
                                    <button type="button" class="btn btn-danger btn-sm position-absolute remove-gallery" style="top:2px;right:2px;">&times;</button>\
                                </div>');
                    $('#galleryPreview').append(img);
                });
            });

            // $(document).on('click', '.remove-gallery', function () {
            //     $(this).closest('div').remove();
            // });

            // ✅ Variable product toggle
            // $('#isVariable').on('change', function () {
            //     if ($(this).is(':checked')) {
            //         $('#variantSection').slideDown();
            //     }
            //     else {
            //         $('#variantSection').slideUp();
            //         $('.remove-variant').trigger('click');
            //     }
            // });
            $('#isVariable').on('switchChange.bootstrapSwitch', function (event, state) {
                if (state) {
                    $('#variantSection').slideDown();
                } else {
                    $('#variantSection').slideUp();
                    $('.remove-variant').trigger('click');

                }
            });
            // ✅ Add / remove variant rows
            let variantIndex = {{ $product->variants->count() }};

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
    @include('includes.admin.ajax-requests.delete')
@endpush
