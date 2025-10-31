@extends('layouts.admin.app')
@section('title', 'Manage Categories')
@section('page', 'Manage Categories')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                    <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#categoryModal">
                        <i class="fas fa-plus"></i> Add Category
                    </button>
                </div>

                <div class="card-body">
                    <table id="category-table" class="table table-bordered table-striped"></table>
                </div>
            </div>
        </div>
    </section>
    <!-- Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="submit-form" action="{{ route('admin.categories.store') }}" method="POST" data-reset="true">
                    @csrf
                    <input type="hidden" name="id" id="catId">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="name" id="catName" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Parent Category</label>
                            <select name="parent_id" id="parentId" class="form-control">
                                <option value="">None</option>
                                @foreach ($parents as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
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
        let columns = [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                title: '#', orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name',
                title: 'Name'
            },
            {
                data: 'parent_name',
                name: 'parent.name',
                title: 'Parent'
            },

            {
                data: null,
                title: 'Action',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `

                                    <button class="btn btn-sm btn-info editCategory"
                                            data-id="${row.id}"
                                            data-name="${row.name}"
                                            data-parent="${row.parent_id}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                        <button class="btn btn-sm btn-danger"
                                            id="delete-btn"
                                            data-url="{{ url('admin/categories/destroy/${row.id}') }}"
                                            data-id="${row.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    `;
                }
            },
        ];
        $(document).ready(function () {
            // Edit Category
            $(document).on('click', '.editCategory', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const parent = $(this).data('parent');

                console.log('Editing:', id);

                $('#categoryModal').modal('show');
                $('#catId').val(id);
                $('#catName').val(name);
                $('#parentId').val(parent);
                $('.modal-title').text('Edit Category');
            });

            // Delete Category


            // Reset modal on close
            $('#categoryModal').on('hidden.bs.modal', function () {
                $('#catId').val('');
                $('#catName').val('');
                $('#parentId').val('');
                $('.modal-title').text('Add Category');
            });
        });
    </script>
    @include('includes.admin.datatable.initialize', ['table' => '#category-table', 'ajaxUrl' => route('admin.categories.get.data')])
    @include('includes.admin.ajax-requests.create', ['redirectUrl' => null])
    @include('includes.admin.ajax-requests.delete');
@endpush