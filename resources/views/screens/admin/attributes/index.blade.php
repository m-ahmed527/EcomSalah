@extends('layouts.admin.app')
@section('title', 'Manage Attributes')
@section('page', 'Manage Attributes')
@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Attributes</h3>
                <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#attributeModal">
                    <i class="fas fa-plus"></i> Add Attribute
                </button>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped" id="attributeTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Values</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach ($attributes as $key => $attr)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $attr->name }}</td>
                            <td>
                                @foreach ($attr->values as $val)
                                <span class="badge badge-info">{{ $val->value }}</span>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info editAttr" data-id="{{ $attr->id }}"
                                    data-name="{{ $attr->name }}"
                                    data-values="{{ json_encode($attr->values->pluck('value')) }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger deleteAttr" data-id="{{ $attr->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="attributeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="submit-form" action="{{route('admin.attributes.store')}}" method="POST" data-reset="true">
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
                                <input type="text" name="values[]" class="form-control" placeholder="Enter value">
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
                $('#valueFields').append(`
                    <div class="input-group mb-2">
                        <input type="text" name="values[]" class="form-control" placeholder="Enter value">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger removeValue">-</button>
                        </div>
                    </div>
                `);
            });

            // Remove value field
            $(document).on('click', '.removeValue', function () {
                $(this).closest('.input-group').remove();
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
                const values = $(this).data('values');

                $('#attrId').val(id);
                $('#attrName').val(name);
                $('.modal-title').text('Edit Attribute');
                $('#valueFields').html('');

                JSON.parse(values).forEach(v => {
                    $('#valueFields').append(`
                        <div class="input-group mb-2">
                            <input type="text" name="values[]" value="${v}" class="form-control">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger removeValue">-</button>
                            </div>
                        </div>
                    `);
                });

                $('#attributeModal').modal('show');
            });

            // Save (Add/Update)
            // $('#attrForm').on('submit', function (e) {
            //     e.preventDefault();

            //     let id = $('#attrId').val();
            //     

            //     $.ajax({
            //         url: url,
            //         method: 'POST',
            //         data: $(this).serialize(),
            //         success: function (res) {
            //             if (res.success) {
            //                 toastr.success(res.message);
            //                 setTimeout(() => location.reload(), 1000);
            //             }
            //         },
            //         error: function (err) {
            //             toastr.error('Something went wrong');
            //         }
            //     });
            // });

            // // Delete
            // $(document).on('click', '.deleteAttr', function () {
            //     if (confirm('Are you sure you want to delete this attribute?')) {
            //         const id = $(this).data('id');
            //         $.ajax({
            //             url: `/admin/attributes/${id}`,
            //             type: 'DELETE',
            //             data: { _token: '{{ csrf_token() }}' },
            //             success: function (res) {
            //                 if (res.success) {
            //                     toastr.success(res.message);
            //                     setTimeout(() => location.reload(), 800);
            //                 }
            //             }
            //         });
            //     }
            // });
        });
    </script>
    @include('includes.admin.ajax-requests.create', ['redirectUrl' => null])
    @include('includes.admin.ajax-requests.delete');
@endpush