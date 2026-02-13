@extends('layouts.theme')
@section('title','Category Edit')
@section('content')
    {{--page title and optional buttons--}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Edit Category</h3>
            </div>
        </div>
    </div>

    {{--main page content--}}
    <div class="nk-block">
        <div class="row g-gs">
            <div class="card card-preview">
                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Required for Update --}}

                    <div class="row g-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" name="date" value="{{ $transaction->date }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Amount (৳)</label>
                                <input type="number" step="0.01" class="form-control" name="amount" value="{{ $transaction->amount }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-danger">Debit Account</label>
                                <select name="debit_category_id" class="form-select js-select2">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}"
                                            @selected($transaction->debit_category_id == $category->category_id)>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-success">Credit Account</label>
                                <select name="credit_category_id" class="form-select js-select2">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}"
                                            @selected($transaction->credit_category_id == $category->category_id)>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description">{{ $transaction->description }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Transaction</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
