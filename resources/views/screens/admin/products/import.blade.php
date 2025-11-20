@extends('layouts.admin.app')
@section('title', 'Import Products')
@section('page', 'Import Products')

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header action-buttons">
                <h3 class="card-title">Import Products (CSV)</h3>
                {{-- <div> --}}
                    <a href="{{ route('admin.imports.products.sample') }}" class="btn btn-sm btn-info float-right">
                        <i class="fas fa-download"></i> Download Sample CSV
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary float-right">Back to
                        Products</a>
                    {{--
                </div> --}}
            </div>

            <div class="card-body">
                <div id="message"></div>
                <form id="importForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Select CSV file</label>
                        <input type="file" name="file" id="importFile" class="form-control" accept=".csv,text/csv">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="uploadBtn" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload & Queue Import
                        </button>
                    </div>
                </form>

                <div id="importStatus" class="mt-3" style="display:none;">
                    <h5>Import Status</h5>

                    <div id="statusInfo"></div>
                    <div id="errorLink" class="mt-2"></div>
                </div>
            </div>

        </div>
        <div class="card card-outline card-primary">
            <div class="card-header action-buttons">
                <h3 class="card-title">Product Imports List</h3>
                <button class="btn btn-danger btn-sm float-right d-none"
                    data-url="{{ route('admin.imports.products.destroy.selected') }}" id="delete-selected">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>

            <div class="card-body">
                <table id="import-table" class="table table-bordered table-striped"></table>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function () {

            $('#importForm').on('submit', function (e) {
                e.preventDefault();

                let file = $('#importFile')[0].files[0];
                if (!file) {
                    Swal.fire('No file selected', 'Please choose a CSV file to upload', 'warning');
                    return;
                }

                let formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                $('#uploadBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Queued');

                $.ajax({
                    url: "{{ route('admin.imports.products.store') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        $('#uploadBtn').prop('disabled', false).html('<i class="fas fa-upload"></i> Upload & Queue Import');

                        if (res.success) {
                            $('#importStatus').show();
                            $('#statusInfo').html('<div class="alert alert-info">Import queued. Import ID: <strong>' + res.import_id + '</strong></div>');
                            $('#message').html('<div class="alert alert-danger">Do not Close or Refresh this page. </div>');
                            pollStatus(res.import_id);

                        } else {
                            Swal.fire('Error', res.message || 'Upload failed', 'error');
                        }
                        $('#importForm')[0].reset();
                    },
                    error: function (xhr) {
                        $('#uploadBtn').prop('disabled', false).html('<i class="fas fa-upload"></i> Upload & Queue Import');
                        let msg = 'Upload failed';
                        if (xhr.responseJSON && xhr.responseJSON.errors) msg = Object.values(xhr.responseJSON.errors).join('<br>');
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });

            function pollStatus(importId) {
                $('#statusInfo').append('<div id="pollingMsg" class="text-muted">Checking status...</div>');
                let interval = setInterval(() => {
                    $.ajax({
                        url: "{{ url('admin/imports/products/status') }}/" + importId,
                        method: 'GET',
                        dataType: 'json',
                        success: function (res) {
                            if (!res.success) return;

                            let d = res.data;
                            $('#statusInfo').html(`
                                                        <p><strong>Status:</strong> ${d.status}</p>
                                                        <p><strong>Processed:</strong> ${d.processed}</p>
                                                        <p><strong>Failed:</strong> ${d.failed}</p>
                                                    `);

                            if (d.status === 'done' || d.status === 'failed') {
                                clearInterval(interval);

                                if (d.errors_file) {
                                    $('#errorLink').html('<a href="{{ url('storage') }}/' + d.errors_file.replace('imports/', '') + '" class="btn btn-sm btn-danger" target="_blank"><i class="fas fa-file-csv"></i> Download Errors CSV</a>');
                                    // better to use named route:
                                    $('#errorLink').html('<a href="{{ route("admin.imports.products.errors", ["import" => "REPLACE_ID"]) }}" id="errorDownload" class="btn btn-sm btn-danger" target="_blank"><i class="fas fa-file-csv"></i> Download Errors CSV</a>');
                                    // replace REPLACE_ID
                                    $('#errorDownload').attr('href', '{{ url("admin/imports/products/errors") }}/' + importId);
                                }
                                $('#message').html('');
                                Swal.fire('Import Finished', 'Import completed. Rows processed: ' + d.processed + ', failed: ' + d.failed, 'success');
                                // 🔥 Reload datatable
                                if ($.fn.DataTable.isDataTable('.dataTable')) {
                                    $('.dataTable').DataTable().ajax.reload(null, false);
                                }
                            }
                        },
                        error: function () {
                            // ignore polling errors silently
                        }
                    });
                }, 2500);
            }

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
                data: 'filename',
                name: 'filename',
                title: 'File Name'
            },
            {
                data: 'processed',
                name: 'processed',
                title: 'Processed Lines'
            },
            {
                data: 'failed',
                name: 'failde',
                title: 'Failed Lines'
            },
            {
                data: 'notes',
                name: 'notes',
                title: 'Note'
            },

            {
                data: null,
                title: 'Product File',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `

                                <a href="{{ url('admin/imports/products/file') }}/${row.id}" class="btn btn-sm btn-primary errorFile">
                                    <i class="fas fa-file-csv"></i> Product File
                                </a>
                                `;
                }
            },
            {
                data: null,
                title: 'Error File',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `

                                        <a href="{{ url('admin/imports/products/errors') }}/${row.id}" class="btn btn-sm btn-danger errorFile">
                                            <i class="fas fa-file-csv"></i> Error File
                                        </a>
                                        `;
                }
            },
        ];
    </script>
    @include('includes.admin.datatable.initialize', ['table' => '#import-table', 'ajaxUrl' => route('admin.imports.products.get.data')])
    @include('includes.admin.ajax-requests.delete-selected');
@endpush
