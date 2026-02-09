@extends('layouts.theme')
@section('title','Category')
@section('content')
    {{--page title and optional buttons--}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Category List</h3>
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
                                        <span class="d-none d-md-block">Add Category</span>
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
                    <form action="{{route('category.store')}}" class="form-validate is-alter" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="full-name">Category Name</label>
                            <div class="form-control-wrap"><input name="category_name" type="text" class="form-control" id="full-name" required></div>
                        </div>
                        <div class="form-group"><button type="submit" class="btn btn-lg btn-primary">Save Category</button></div>
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
                        <thead class="bg-light bg-opacity-75">
                        <tr class="tb-tnx-head">
                            <th class="tb-tnx-id"><span class="">#</span></th>
                            <th class="tb-tnx-amount is-alt"><span class="tb-tnx-total">Category Name</span></th>
                            <th><span class="tb-tnx-status d-none d-md-inline-block">Status</span></th>
                            <th class="tb-tnx-action"><span>&nbsp;</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $category)
                            <tr class="tb-tnx-item">
                                <td class="tb-tnx-id"><a href="#"><span>{{$loop->iteration}}</span></a></td>
                                <td class="tb-tnx-id"><a href="#"><span>{{$category->category_name}}</span></a></td>
                                <td class="tb-tnx-id">
                                    @if($category->status == 'active')
                                        <span><span class="badge badge-dot bg-success">Active</span></span>
                                    @else
                                        <span><span class="badge badge-dot bg-danger">Inactive</span></span>
                                    @endif
                                </td>
                                <td class="tb-tnx-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                            <ul class="link-list-plain">
                                                <li><a href="{{route('category.edit',$category->category_id)}}">Edit</a></li>
                                                <li>
                                                    <a href="javascript:void(0)"
                                                       onclick="confirmDelete('{{ $category->category_id }}', '{{ $category->category_name }}')">
                                                        <em class="icon ni ni-trash"></em>
                                                        <span>Delete</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No data here to show.</td>
                                </tr>
                        @endforelse

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
        function confirmDelete(category, name) {
            // 1. Set the name in the modal text
            document.getElementById('deleteCategoryName').innerText = name;

            // 2. Update the form action URL
            let url = "{{ route('category.destroy', ':category') }}";
            url = url.replace(':category', category);
            document.getElementById('deleteModalForm').setAttribute('action', url);

            // 3. Show the modal using Bootstrap's JS (DashLite uses Bootstrap 5)
            let myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            myModal.show();
        }
    </script>
@endsection
