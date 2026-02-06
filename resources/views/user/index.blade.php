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
                            <li><a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em><span><span class="d-md-none">Add</span><span class="d-none d-md-block">Add Campaign</span></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--main page content--}}
    <div class="nk-block">
        <div class="row g-gs">
            <div class="nk-block nk-block-lg">
                <div class="card card-preview">
                    <table class="table table-tranx">
                        <thead class="bg-light bg-opacity-75">
                        <tr class="tb-tnx-head">
                            <th class="tb-tnx-id"><span class="">#</span></th>
                            <th class="tb-tnx-info"><span class="tb-tnx-desc d-none d-sm-inline-block"><span>Bill For</span></span><span class="tb-tnx-date d-md-inline-block d-none"><span class="d-md-none">Date</span><span class="d-none d-md-block"><span>Issue Date</span><span>Due Date</span></span></span></th>
                            <th class="tb-tnx-amount is-alt"><span class="tb-tnx-total">Total</span><span class="tb-tnx-status d-none d-md-inline-block">Status</span></th>
                            <th class="tb-tnx-action"><span>&nbsp;</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="tb-tnx-item">
                            <td class="tb-tnx-id"><a href="#"><span>4947</span></a></td>
                            <td class="tb-tnx-info">
                                <div class="tb-tnx-desc"><span class="title">Enterprize Year Subscription</span></div>
                                <div class="tb-tnx-date"><span class="date">10-05-2019</span><span class="date">10-13-2019</span></div>
                            </td>
                            <td class="tb-tnx-amount is-alt">
                                <div class="tb-tnx-total"><span class="amount">$599.00</span></div>
                                <div class="tb-tnx-status"><span class="badge badge-dot bg-warning">Due</span></div>
                            </td>
                            <td class="tb-tnx-action">
                                <div class="dropdown">
                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                        <ul class="link-list-plain">
                                            <li><a href="#">View</a></li>
                                            <li><a href="#">Edit</a></li>
                                            <li><a href="#">Remove</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="tb-tnx-item">
                            <td class="tb-tnx-id"><a href="#"><span>4904</span></a></td>
                            <td class="tb-tnx-info">
                                <div class="tb-tnx-desc"><span class="title">Maintenance Year Subscription</span></div>
                                <div class="tb-tnx-date"><span class="date">06-19-2019</span><span class="date">06-26-2019</span></div>
                            </td>
                            <td class="tb-tnx-amount is-alt">
                                <div class="tb-tnx-total"><span class="amount">$99.00</span></div>
                                <div class="tb-tnx-status"><span class="badge badge-dot bg-success">Paid</span></div>
                            </td>
                            <td class="tb-tnx-action">
                                <div class="dropdown">
                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                        <ul class="link-list-plain">
                                            <li><a href="#">View</a></li>
                                            <li><a href="#">Edit</a></li>
                                            <li><a href="#">Remove</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="tb-tnx-item">
                            <td class="tb-tnx-id"><a href="#"><span>4829</span></a></td>
                            <td class="tb-tnx-info">
                                <div class="tb-tnx-desc"><span class="title">Enterprize Year Subscription</span></div>
                                <div class="tb-tnx-date"><span class="date">10-04-2018</span><span class="date">10-12-2018</span></div>
                            </td>
                            <td class="tb-tnx-amount is-alt">
                                <div class="tb-tnx-total"><span class="amount">$599.00</span></div>
                                <div class="tb-tnx-status"><span class="badge badge-dot bg-success">Paid</span></div>
                            </td>
                            <td class="tb-tnx-action">
                                <div class="dropdown">
                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                        <ul class="link-list-plain">
                                            <li><a href="#">View</a></li>
                                            <li><a href="#">Edit</a></li>
                                            <li><a href="#">Remove</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="tb-tnx-item">
                            <td class="tb-tnx-id"><a href="#"><span>4830</span></a></td>
                            <td class="tb-tnx-info">
                                <div class="tb-tnx-desc"><span class="title">Enterprize Anniversary Subscription</span></div>
                                <div class="tb-tnx-date"><span class="date">12-04-2018</span><span class="date">14-12-2018</span></div>
                            </td>
                            <td class="tb-tnx-amount is-alt">
                                <div class="tb-tnx-total"><span class="amount">$399.00</span></div>
                                <div class="tb-tnx-status"><span class="badge badge-dot bg-success">Paid</span></div>
                            </td>
                            <td class="tb-tnx-action">
                                <div class="dropdown">
                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                        <ul class="link-list-plain">
                                            <li><a href="#">View</a></li>
                                            <li><a href="#">Edit</a></li>
                                            <li><a href="#">Remove</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="tb-tnx-item">
                            <td class="tb-tnx-id"><a href="#"><span>4840</span></a></td>
                            <td class="tb-tnx-info">
                                <div class="tb-tnx-desc"><span class="title">Enterprize Coverage Subscription</span></div>
                                <div class="tb-tnx-date"><span class="date">12-08-2018</span><span class="date">13-22-2018</span></div>
                            </td>
                            <td class="tb-tnx-amount is-alt">
                                <div class="tb-tnx-total"><span class="amount">$99.00</span></div>
                                <div class="tb-tnx-status"><span class="badge badge-dot bg-danger">Cancel</span></div>
                            </td>
                            <td class="tb-tnx-action">
                                <div class="dropdown">
                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                        <ul class="link-list-plain">
                                            <li><a href="#">View</a></li>
                                            <li><a href="#">Edit</a></li>
                                            <li><a href="#">Remove</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
