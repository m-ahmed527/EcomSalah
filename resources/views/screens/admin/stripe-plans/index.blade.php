@extends('layouts.admin.app')
@section('title', 'Manage Plans')
@section('page', 'Manage Plans')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-header action-buttons">
                    <h3 class="card-title">Plans</h3>
                    <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#createPlanModal">
                        <i class="fas fa-plus"></i> Create Plan
                    </button>
                    <button class="btn btn-danger btn-sm float-right d-none" data-url="#" id="delete-selected">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                </div>

                <div class="card-body">
                    <table id="plan-table" class="table table-bordered table-striped"></table>
                </div>
            </div>
        </div>
    </section>
    <!-- 🔹 Create Plan Modal -->
    <div class="modal fade" id="createPlanModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Create Stripe Plan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form id="submit-form" action="{{ route('admin.plans.store') }}" method="POST"
                    data-reset="true" data-parsley-validate data-parsley-errors-messages-disabled>
                    @csrf

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-12 d-none" id="edit-message-div">
                                <div class="form-group">
                                    <p style="color:red;" id="edit-message"></p>
                                </div>
                            </div>
                            <!-- Plan Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">Plan Name</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Gold / Premium / Titanium" required>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">Price (USD)</label>
                                    <input type="number" name="amount" class="form-control" placeholder="50" required>
                                </div>
                            </div>

                            <!-- Interval -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">Billing Interval</label>
                                    <select name="interval" class="form-control select2" required>
                                        <option value="day">Daily</option>
                                        <option value="week">Weekly</option>
                                        <option value="month">Monthly</option>
                                        <option value="year">Yearly</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Trial Days -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">Trial Days</label>
                                    <input type="number" name="trial_days" class="form-control" placeholder="7" required>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required">Status</label>
                                    <select name="status" class="form-control select2" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" id="submit-btn" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Plan
                        </button>
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
                data: 'amount',
                name: 'amount',
                title: 'Amount (USD)',
                render: function (data, type, row) {
                    return '$' + data;
                }
            },
            {
                data: 'interval',
                name: 'interval',
                title: 'Interval'
            },
            {
                data: 'trial_days',
                name: 'trial_days',
                title: 'Trial Days'
            },
            {
                data: 'status',
                name: 'status',
                title: 'Status',
                render: function (data, type, row) {
                    return data ? '<span class="badge badge-success">Active</span>' :
                        '<span class="badge badge-danger">Inactive</span>';
                }
            },
            {
                data: null,
                title: 'Action',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    let deleteAble = row.uses > 0 ? false : true;
                    return `
                                <button class="btn btn-sm btn-info editPlan"
                                        data-id="${row.id}"
                                        data-row='${JSON.stringify(row)}'>
                                    <i class="fas fa-edit"></i>
                                </button>
                                    <button class="btn btn-sm btn-danger"
                                        id="delete-btn"
                                        data-url="{{ url('admin/plans/destroy/${row.id}') }}"
                                        data-id="${row.id}"
                                        data-delete="${deleteAble}">
                                    <i class="fas fa-trash"></i>
                                </button>

                                `;
                }
            },
        ];
        $(document).ready(function () {
            // Edit Category
           $(document).on('click', '.editPlan', function () {
                const row = $(this).data('row');
                console.log(row);
                let editAble = row.uses > 0 ? false : true;
                $('#createPlanModal').modal('show');
                $('#createPlanModal .modal-title').text('Edit Plan');
                $('#submit-form').attr('action', `{{ url('admin/plans/update/${row.id}') }}`);
                $('#submit-form input[name="name"]').val(row.name);
                $('#submit-form input[name="amount"]').val(row.amount).prop('disabled', true);
                $('#submit-form select[name="interval"]').val(row.interval).trigger('change').prop('disabled',true);
                $('#submit-form input[name="trial_days"]').val(row.trial_days).prop('readonly', true);
                $('#submit-form select[name="status"]').val(row.status).trigger('change').prop('disabled', true);
                    $('#edit-message-div').removeClass('d-none');
                    $('#edit-message').text('Note: You can only edit the plan name because the plan is already in use.');
            });

            // Delete Category


            // Reset modal on close
            $('#createPlanModal').on('hidden.bs.modal', function () {
                $('#submit-form')[0].reset();
                $('#createPlanModal .modal-title').text('Create Plan');
                $('#submit-form').attr('action', '{{ route('admin.plans.store') }}');
                $('#submit-form input, #submit-form select').prop('disabled', false).prop('readonly', false);
                $('#edit-message-div').addClass('d-none');

            });
        });
    </script>
    @include('includes.admin.datatable.initialize', ['table' => '#plan-table', 'ajaxUrl' => route('admin.plans.get.data')])
    @include('includes.admin.ajax-requests.create', ['redirectUrl' => null])
    @include('includes.admin.ajax-requests.delete');

@endpush