<script>
    console.log({{ $products->min('effective_price') }}, {{ $products->max('effective_price') }});

    var slider = document.getElementById('price-slider');

    noUiSlider.create(slider, {
        start: [{{ $minPrice }}, {{ $maxPrice }}],
        connect: true,
        range: {
            'min': {{ $minPrice }},
            'max': {{ $maxPrice }}
    }
    });
    slider.noUiSlider.on('update', function (values) {
        $('#min_price').val(values[0]);
        $('#max_price').val(values[1]);

        loadProducts(); // AJAX reload
    });


    // Sorting
    $("#sort-select").change(function () {
        loadProducts();
    });

    // AJAX Pagination
    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();

        let page = $(this).attr('href').split('page=')[1];
        loadProducts(page);
    });

    function loadProducts(page = 1) {

        let data = {
            page: page,
            sort: $("#sort-select").val(),
            // category_id: $("#category-select").val(),
            // brand_id: $("#brand-select").val(),
            price_min: $("#min_price").val(),
            price_max: $("#max_price").val(),
            // attributes: {}
        };

        // collect attributes filters e.g. color[1,2], size[3,4]
        // $(".attribute-filter").each(function () {
        //     let attrId = $(this).data("attribute-id");
        //     let selectedValues = [];

        //     $(this).find("input[type=checkbox]:checked").each(function () {
        //         selectedValues.push($(this).val());
        //     });

        //     if (selectedValues.length > 0) {
        //         data.attributes[attrId] = selectedValues;
        //     }
        // });
        console.log(data);
        $.ajax({
            url: "{{ route('web.product.index') }}",
            data: data,
            beforeSend: function () {
                $(".product-list-div").append(`<div class="loader-overlay"><i class="fa fa-spinner fa-spin fa-2x"></i></div>`);
            },
            success: function (response) {
                $(".loader-overlay").remove();
                $(".product-list-div").html(response.data.html);
                $(".pagination-div").html(response.data.pagination);
                $("#showing-results-container").html(response.data.showing_results);
            }
        });
    }


</script>
