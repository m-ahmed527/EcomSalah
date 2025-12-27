<script>
    console.log({{ $minPrice }}, {{ $maxPrice }});
    $("#slider-range").slider({
        range: true,
        min: {{ $minPrice }},
        max: {{ $maxPrice }},
        values: [{{ $minPrice }}, {{ $maxPrice }}],
        slide: function (event, ui) {
            $("#amount").text("RS " + ui.values[0] + " - " + ui.values[1]);
            $('#min_price').val(Math.floor($("#slider-range").slider("values", 0)));
            $('#max_price').val(Math.ceil($("#slider-range").slider("values", 1)));
        },
        change: function (event, ui) {
            $("#amount").text("RS " + ui.values[0] + " - " + ui.values[1]);
            $('#min_price').val(Math.floor($("#slider-range").slider("values", 0)));
            $('#max_price').val(Math.ceil($("#slider-range").slider("values", 1)));
        }
    });
    $("#amount").text("RS " + $("#slider-range").slider("values", 0) +
        " - " + $("#slider-range").slider("values", 1));


    // Sorting
    $("#price-range-btn").click(function () {
        loadProducts();
    });
    $("#input-sort").change(function () {
        loadProducts();
    });
    $("#input-perPage").change(function () {
        loadProducts();
    });

    // AJAX Pagination
    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();

        let page = $(this).attr('href').split('page=')[1];
        loadProducts(page);
    });
    $(document).on('change', 'input[name="category[]"]', function (e) {
        loadProducts();
    });
    function loadProducts(page = 1, categories = []) {

        let data = {
            page: page,
            perPage: $("#input-perPage").val(),
            sort: $("#input-sort").val(),
            category_id: $('input[name="category[]"]:checked').val() ?? null,
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
