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
                <form action="{{route('category.update',$category->category_id)}}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="col-sm-6">
                        <div class="form-group my-4">
                            <label class="form-label" for="default-01">Category Name</label>
                            <div class="form-control-wrap">
                                <input name="category_name" type="text" class="form-control" id="default-01" placeholder="Category Name" value="{{$category->category_name}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Select Type</label>
                            <div class="form-control-wrap">
                                <select class="form-select js-select2" name="type" required>
                                    <option value="Asset" @if($category->type == 'Asset') selected @endif>Asset</option>
                                    <option value="Liability" @if($category->type == 'Liability') selected @endif>Liability</option>
                                    <option value="Equity" @if($category->type == 'Equity') selected @endif>Equity</option>
                                    <option value="Income" @if($category->type == 'Income') selected @endif>Income</option>
                                    <option value="Expense" @if($category->type == 'Expense') selected @endif>Expense</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Select Status</label>
                            <div class="form-control-wrap">
                                <select class="form-select js-select2" name="status" required>
                                    <option @if($category->status == 'active') selected @endif value="active">Active</option>
                                    <option @if($category->status == 'inactive') selected @endif value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group my-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
