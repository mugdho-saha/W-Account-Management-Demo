@extends('layouts.theme')
@section('title','User Edit')
@section('content')
    {{--page title and optional buttons--}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Edit User</h3>
            </div>
        </div>
    </div>

    {{--main page content--}}
    <div class="nk-block">
        <div class="row g-gs">
            <div class="card card-preview">
                <form action="{{ route('users.update', $user->id) }}" class="form-validate is-alter py-3" method="post">
                    @csrf
                    @method('PUT') {{-- Don't forget this for updates! --}}

                    <div class="form-group">
                        <label class="form-label" for="full-name">User Name</label>
                        <div class="form-control-wrap"><input name="name" type="text" class="form-control" id="full-name" value="{{$user->name}}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">User Email</label>
                        <div class="form-control-wrap"><input autocomplete="off" name="email" type="email" class="form-control" id="full-name" value="{{$user->email}}" required></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">User Password (Leave blank to keep current)</label>
                        <div class="form-control-wrap"><input autocomplete="off" name="password" type="password" class="form-control" id="password"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="role">Select User Role</label>
                        <div class="form-control-wrap">
                            <select class="form-control" id="role" name="role">
                                @foreach($roles as $role)
                                    {{-- Check if the user has this role --}}
                                    <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="categories">Select Assigned Categories</label>
                        <div class="form-control-wrap">
                            <select name="categories[]" class="form-select" id="categories" multiple>
                                @foreach($categories as $category)
                                    {{-- Check if this category ID is in the user's categories collection --}}
                                    <option value="{{$category->category_id}}"
                                        @selected($user->categories->contains('category_id', $category->category_id))>
                                        {{$category->category_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group"><button type="submit" class="btn btn-lg btn-primary">Update User</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection
