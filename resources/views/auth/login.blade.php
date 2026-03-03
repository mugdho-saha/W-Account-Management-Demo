@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="card">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Sign-In</h4>
                                        <div class="nk-block-des">
                                            <p>Access the panel using your email and passcode.</p>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-icon">
                                        <em class="icon ni ni-cross-circle"></em>
                                        <strong>Login Failed!</strong>
                                        <ul class="list list-sm list-checked">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-label-group"><label class="form-label" for="default-01">Email</label></div>
                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" id="default-01" placeholder="Enter your email address or username" name="email" value="{{old('email')}}" required></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group"><label class="form-label" for="password">Passcode</label><a class="link link-primary link-sm" href="{{route('password.request')}}">Forgot Code?</a></div>
                                        <div class="form-control-wrap"><a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password"><em class="passcode-icon icon-show icon ni ni-eye"></em><em class="passcode-icon icon-hide icon ni ni-eye-off"></em></a>
                                            <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Enter your passcode" required></div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block">Sign in</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3 mx-auto">
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="text-soft">&copy; 2026 DashLite. All Rights Reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
