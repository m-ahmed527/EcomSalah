@extends('layouts.admin.app')
@section('title', 'Manage Attributes')
@section('page', 'Manage Attributes')
@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header action-buttons">
                <h3 class="card-title">Attributes</h3>
                <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#attributeModal">
                    <i class="fas fa-plus"></i> Add Attribute
                </button>
                <button class="btn btn-danger btn-sm float-right d-none"
                    data-url="{{ route('admin.attributes.destroy.selected') }}" id="delete-selected">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped" id="attribute-table"></table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="attributeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="submit-form" action="{{route('admin.attributes.store')}}" method="POST" data-reset="true"
                    data-parsley-validate data-parsley-errors-messages-disabled>
                    @csrf
                    <input type="hidden" id="attrId" name="id">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Attribute</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Attribute Name</label>
                            <input type="text" id="attrName" name="name" class="form-control" required>
                        </div>

                        <div id="valueFields">
                            <label>Values</label>
                            <div class="input-group mb-2">
                                <input type="text" name="values[0]" class="form-control" placeholder="Enter value" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success addValue">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a type="button" id="submit-btn" class="btn btn-primary">Save</a>
                        <a type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {

            // Add dynamic value field
            $(document).on('click', '.addValue', function () {
                // determine next numeric index for name="values[<index>]"
                let nextIndex = 0;
                const inputs = $('#valueFields').find('input[name^="values"]');

                inputs.each(function () {
                    const name = $(this).attr('name') || '';
                    const m = name.match(/values\[(\d+)\]/);
                    if (m) nextIndex = Math.max(nextIndex, parseInt(m[1], 10) + 1);
                });

                // if no indexed names found (e.g. names are "values[]"), fall back to count
                if (nextIndex === 0) nextIndex = inputs.length;

                $('#valueFields').append(`
                                            <div class="input-group mb-2">
                                                <input type="text" name="values[${nextIndex}]" class="form-control" placeholder="Enter value" required>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger removeValue">-</button>
                                                </div>
                                            </div>
                                        `);
            });

            // Remove value field and reset indexes
            $(document).on('click', '.removeValue', function () {
                const $group = $(this).closest('.input-group');
                // remove only the error span immediately following this group (if any)
                $group.next('span.error-message').remove();
                $group.remove();

                // reindex remaining inputs to values[0], values[1], ...
                $('#valueFields').find('input[name^="values"]').each(function (i) {
                    $(this).attr('name', 'values[' + i + ']');
                });
            });

            // Reset modal
            $('#attributeModal').on('hidden.bs.modal', function () {
                $('#attrId').val('');
                $('#attrName').val('');
                $('#valueFields').find('.input-group:gt(0)').remove();
                $('#valueFields input').val('');
                $('.modal-title').text('Add Attribute');
            });

            // Edit
            $(document).on('click', '.editAttr', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                // safe JSON decode
                let raw = $(this).attr('data-values') || '[]';
                let values;
                try {
                    values = JSON.parse(raw);
                    if (typeof values === 'string') values = JSON.parse(values);
                } catch {
                    values = [];
                }

                console.log(typeof (values)); // ✅ Pure array e.g. ["Dolorem sequi eaque", "Cum in id dolore cup"]
                $('#attrId').val(id);
                $('#attrName').val(name);
                $('.modal-title').text('Edit Attribute');
                $('#valueFields').html('');

                values.forEach((v, i) => {
                    const btn = i === 0
                        ? '<button type="button" class="btn btn-success addValue">+</button>'
                        : '<button type="button" class="btn btn-danger removeValue">-</button>';

                    $('#valueFields').append(`
                                                                            <div class="input-group mb-2">
                                                                                <input type="text" name="values[]" value="${v}" class="form-control">
                                                                                <div class="input-group-append">
                                                                                    ${btn}
                                                                                </div>
                                                                            </div>
                                                                        `);
                });

                $('#attributeModal').modal('show');
            });


        });
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
                data: 'name',
                name: 'name',
                title: 'Name'
            },
            {
                data: 'values',
                name: 'values.value',
                title: 'Values',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    let values = [];
                    try {
                        values = JSON.parse(row.values || '[]');
                    } catch {
                        values = [];
                    }
                    if (!Array.isArray(values)) values = [values];
                    return '<ol class="mb-0">' + values.map(v => `<li>${v}</li>`).join('') + '</ol>';
                }
            },

            {
                data: null,
                title: 'Action',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    const values = JSON.stringify(row.values); // safe convert to JSON string
                    return `
                                                                            <button class="btn btn-sm btn-info editAttr"
                                                                                    data-id="${row.id}"
                                                                                    data-name="${row.name}"
                                                                                    data-values='${values}'>
                                                                                <i class="fas fa-edit"></i>
                                                                            </button>
                                                                            <button class="btn btn-sm btn-danger"
                                                                                id="delete-btn"
                                                                                data-url="{{ url('admin/attributes/destroy/${row.id}') }}"
                                                                                data-id="${row.id}">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>

                                                                        `;
                }
            },
        ];
    </script>
    @include('includes.admin.datatable.initialize', ['table' => '#attribute-table', 'ajaxUrl' => route('admin.attributes.get.data')])
    @include('includes.admin.ajax-requests.create', ['redirectUrl' => null])
    @include('includes.admin.ajax-requests.delete');
    @include('includes.admin.ajax-requests.delete-selected');
@endpush
