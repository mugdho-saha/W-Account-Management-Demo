@extends('layouts.theme')

@section('content')
    {{--page title and optional buttons--}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Campaign Management</h3>
                <div class="nk-block-des text-soft">
                    <p>Welcome to Campaign Management Dashboard.</p>
                </div>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li><a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em><span><span class="d-md-none">Add</span><span class="d-none d-md-block">Add Campaign</span></span></a></li>
                            <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary"><em class="icon ni ni-reports"></em><span>Reports</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--main page content--}}
    <div class="nk-block">
        <div class="row g-gs">

        </div>
    </div>
@endsection
