@extends('layouts.theme')
@section('title','Transactions')
@section('content')
    {{--page title and optional buttons--}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Transactions List</h3>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <button type="button" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="modal" data-bs-target="#modalForm">
                                    <em class="icon ni ni-plus"></em><span>
                                        <span class="d-md-none">Add</span>
                                        <span class="d-none d-md-block">Add New Transaction</span>
                                    </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--modal content--}}
    <div class="modal fade" id="modalForm">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Category Info</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('transactions.store') }}" method="POST" class="form-validate">
                        @csrf
                        <div class="row g-gs">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Transaction Date</label>
                                    <div class="form-control-wrap">
                                        <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Amount</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <span style="font-style: normal; font-weight: bold; font-size: 1.1rem;">৳</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control" name="amount" placeholder="0.00" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label text-danger">Debit Account</label>
                                    <div class="form-control-wrap">
                                        <select name="debit_category_id" class="form-select js-select2" data-search="on" required>
                                            <option value="">Select Account</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->category_id }}">{{ $category->category_name }} ({{ $category->type }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label text-success">Credit Account</label>
                                    <div class="form-control-wrap">
                                        <select name="credit_category_id" class="form-select js-select2" data-search="on" required>
                                            <option value="">Select Account</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->category_id }}">{{ $category->category_name }} ({{ $category->type }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Description / Memo</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control no-resize" name="description" placeholder="Enter transaction details..." required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Post Transaction</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--main page content--}}
    <div class="nk-block">
        @if (session('success'))
            <div class="example-alert my-4">
                <div class="alert alert-success alert-icon alert-dismissible">
                    <em class="icon ni ni-check-circle"></em>
                    <strong>Success</strong>! {{ session('success') }}
                    <button class="close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        <div class="row g-gs">
            <div class="nk-block nk-block-lg">
                <div class="card card-preview">
                    <table class="table table-tranx">
                        <thead>
                        <tr class="tb-tnx-head">
                            <th>Date</th>
                            <th>Description</th>
                            <th>Debit (From)</th>
                            <th>Credit (To)</th>
                            <th>Amount</th>
                            <th>Posted By</th>
                            <th class="tb-tnx-action">
                                <span>Action</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $tnx)
                            <tr class="tb-tnx-item">
                                <td>{{ \Carbon\Carbon::parse($tnx->date)->format('d M, Y') }}</td>
                                <td>{{ $tnx->description }}</td>
                                <td>
                <span class="badge badge-dim bg-outline-danger">
                    {{ $tnx->debitCategory->category_name }}
                </span>
                                </td>
                                <td>
                <span class="badge badge-dim bg-outline-success">
                    {{ $tnx->creditCategory->category_name }}
                </span>
                                </td>
                                <td><strong>{{ number_format($tnx->amount, 2) }}</strong></td>
                                <td><span class="dot dot-primary"></span> {{ $tnx->user->name }}</td>
                                <td class="tb-tnx-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                            <ul class="link-list-plain">
                                                <li>
                                                    <a href="{{ route('transactions.edit', $tnx->id) }}">
                                                        <em class="icon ni ni-edit"></em><span>Edit</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="text-danger"
                                                       onclick="genericDelete('{{ $tnx->id }}', 'Transaction #{{ $tnx->id }}', 'transaction')">
                                                        <em class="icon ni ni-trash"></em><span>Delete</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--delete modal--}}
    <div class="modal fade" tabindex="-1" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                        <h4 class="nk-modal-title" id="modalTitle">Are you sure?</h4>
                        <div class="nk-modal-text">
                            <p class="lead">You are about to delete <strong id="itemName"></strong>. This action cannot be undone and may affect associated data.</p>
                        </div>
                        <div class="nk-modal-action mt-5">
                            <form id="deleteModalForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Return</a>
                                <button type="submit" class="btn btn-lg btn-mw btn-danger">Confirm Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function genericDelete(id, name, type) {
            // 1. Update the Display Name
            document.getElementById('itemName').innerText = name;

            // 2. Set the Title based on what we are deleting
            document.getElementById('modalTitle').innerText = 'Delete ' + type.charAt(0).toUpperCase() + type.slice(1);

            // 3. Construct the Route URL
            // This assumes your routes are standard: transactions.destroy, users.destroy, etc.
            let url = "{{ url('/') }}/" + type + "s/" + id;

            // 4. Update the form action
            document.getElementById('deleteModalForm').setAttribute('action', url);

            // 5. Show the modal
            let myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            myModal.show();
        }

        $(document).ready(function() {
            $('form').on('submit', function(e) {
                let debit = $('select[name="debit_category_id"]').val();
                let credit = $('select[name="credit_category_id"]').val();

                if (debit === credit) {
                    e.preventDefault();
                    Swal.fire('Error', 'Debit and Credit accounts cannot be the same!', 'error');
                }
            });
        });
    </script>
@endsection
