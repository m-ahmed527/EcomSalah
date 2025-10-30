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
                    <table id="category-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Slug</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach (['Men','Women','Kids'] as $key => $cat)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $cat->name }}</td>
                                <td>{{ $cat->parent?->name ?? '—' }}</td>
                                <td>{{ $cat->slug }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info editCategory" data-id="{{ $cat->id }}"
                                        data-name="{{ $cat->name }}" data-parent="{{ $cat->parent_id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger deleteCategory" data-id="{{ $cat->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="categoryForm">
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
                                {{-- @foreach ($parents as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @include('includes.admin.datatable.initialize', ['table' => '#category-table', 'ajaxUrl' => "#", 'columns' => []])
    <script>
        $(document).ready(function () {
            // Edit Category
            $('.editCategory').on('click', function () {
                $('#categoryModal').modal('show');
                $('#catId').val($(this).data('id'));
                $('#catName').val($(this).data('name'));
                $('#parentId').val($(this).data('parent'));
                $('.modal-title').text('Edit Category');
            });

            // Delete Category
            $('.deleteCategory').on('click', function () {
                if (confirm('Are you sure you want to delete this category?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: "{{ url('admin/categories') }}/" + id,
                        method: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (res) {
                            if (res.status) {
                                toastr.success(res.message);
                                setTimeout(() => location.reload(), 800);
                            }
                        }
                    });
                }
            });

            // Reset modal on close
            $('#categoryModal').on('hidden.bs.modal', function () {
                $('#catId').val('');
                $('#catName').val('');
                $('#parentId').val('');
                $('.modal-title').text('Add Category');
            });
        });
    </script>
@endpush
