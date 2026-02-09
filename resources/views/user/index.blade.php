@extends('layouts.theme')
@section('title','Users')
@section('content')
    {{--page title and optional buttons--}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Users List</h3>
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
                                        <span class="d-none d-md-block">Add User</span>
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
                    <h5 class="modal-title">User Info</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                </div>
                <div class="modal-body">
                    <form action="{{route('users.store')}}" class="form-validate is-alter" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="full-name">User Name</label>
                            <div class="form-control-wrap"><input name="name" type="text" class="form-control" id="full-name" required></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="full-name">User Email</label>
                            <div class="form-control-wrap"><input autocomplete="off" name="email" type="email" class="form-control" id="full-name" required></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="full-name">User Password</label>
                            <div class="form-control-wrap"><input autocomplete="off" name="password" type="password" class="form-control" id="full-name" required></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="full-name">Select User Role</label>
                            <div class="form-control-wrap">
                                <select class="form-control" id="default-06" name="role">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="full-name">Select Assigned Categories</label>
                            <div class="form-control-wrap">
                                <select name="categories[]" class="form-select" id="default-07" multiple="" aria-label="multiple select example">
                                    @foreach($categories as $category)
                                        <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group"><button type="submit" class="btn btn-lg btn-primary">Save User</button></div>
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
                            <th>SL</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Assigned Categories</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="tb-tnx-item">
                                <td class="tb-tnx-id">{{ $loop->iteration }}</td>
                                <td class="tb-tnx-info">
                                    <div class="tb-tnx-desc">
                                        <span class="title">{{ $user->name }}</span>
                                    </div>
                                    <div class="tb-tnx-date">
                                        <span class="date">{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($user->status == 1)
                                        <span class="badge badge-dot bg-success">Active</span>
                                    @else
                                        <span class="badge badge-dot bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @forelse($user->roles as $role)
                                        <li>
                                        {{ ucfirst($role->name) }}
                                        </li>
                                    @empty
                                        <li>No role assigned.</li>
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($user->categories as $category)
                                        <span class="badge badge-dim bg-info">
                        {{ $category->category_name }}
                    </span>
                                    @empty
                                        <span class="text-soft font-italic">No categories assigned</span>
                                    @endforelse
                                </td>
                                <td class="tb-tnx-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                            <ul class="link-list-plain">
                                                <li><a href="{{route('users.edit',$user->id)}}"><em class="icon ni ni-edit"></em>Edit</a></li>
                                                <li>
                                                    <a href="javascript:void(0)"
                                                       onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')">
                                                        <em class="icon ni ni-trash"></em>
                                                        <span>Delete</span>
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
                        <h4 class="nk-modal-title">Are you sure?</h4>
                        <div class="nk-modal-text">
                            <p class="lead">You are about to delete <strong id="deleteCategoryName"></strong>. This action cannot be undone and may affect associated transactions.</p>
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
        function confirmDelete(userId, name) {
            // 1. Set the name in the modal text
            document.getElementById('deleteCategoryName').innerText = name;

            // 2. Update the form action URL
            let url = "{{ route('users.destroy', ':userId') }}";
            url = url.replace(':userId', userId);
            document.getElementById('deleteModalForm').setAttribute('action', url);

            // 3. Show the modal using Bootstrap's JS (DashLite uses Bootstrap 5)
            let myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            myModal.show();
        }
    </script>
@endsection
