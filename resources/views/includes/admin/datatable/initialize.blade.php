<script>
    $(document).ready(function () {
        // let buttons_dict = {
        //     'copy':{
        //         extend: 'copy',
        //         exportOptions: {
        //             columns: ':not(:last-child)' // Exclude last column (Action)
        //         }
        //     },
        //     'csv' :{
        //         extend: 'csv',
        //         exportOptions: {
        //             columns: ':not(:last-child)' // Exclude last column (Action)
        //         }
        //     },
        //     'excel' :{
        //         extend: 'excel',
        //         exportOptions: {
        //             columns: ':not(:last-child)' // Exclude last column (Action)
        //         }
        //     },
        //     'pdf' :{
        //         extend: 'pdf',
        //         exportOptions: {
        //             columns: ':not(:last-child)' // Exclude last column (Action)
        //         }
        //     },
        //     'print' :{
        //         extend: 'print',
        //         exportOptions: {
        //             columns: ':not(:last-child)' // Exclude last column (Action)
        //         }
        //     }
        // };


        // let buttons_to_display = [];
        // for(let button of display_buttons){
        //     let chosen = buttons_dict[button];
        //     if(!chosen){
        //         continue;
        //     }

        //     buttons_to_display.push(chosen);
        // }
        let tableName = @json($table);
        let ajaxUrl = @json($ajaxUrl);
        let columnsArray = columns || [];
       let dataTable = $(tableName).DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: true,
            searchDelay: 1000, //delay on search key input, but doesn't work for first search
            pageLength: 10,
            ajax: ajaxUrl,
            columns: columnsArray,
            order: [],
            // dom: 'lBfrtip', // Define position of buttons
            // buttons: buttons_to_display
        });

    });
</script>

{{-- $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        }); --}}
