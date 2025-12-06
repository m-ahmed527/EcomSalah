<script>
    console.log({{ $products->min('effective_price') }}, {{ $products->max('effective_price') }});


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
                $(".product-list").LoadingOverlay('show');
            },
            success: function (response) {
                $(".product-list").LoadingOverlay('hide');
                $(".product-list").html(response.data.html);
                $(".pagination-div").html(response.data.pagination);
                $("#showing-results-container").html(response.data.showing_results);
            }
        });
    }


</script>