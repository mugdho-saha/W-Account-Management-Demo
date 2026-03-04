@extends('layouts.theme')
@section('title', 'Profile Settings')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-lg">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">Profile Settings</h4>
                                <div class="nk-block-des">
                                    <p>Update your personal information and security settings.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="nk-block">
                        <div class="row g-gs">
                            {{-- Section 1: Personal Info --}}
                            <div class="col-lg-6">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="card-head">
                                            <h5 class="title">Personal Information</h5>
                                        </div>
                                        <form method="post" action="{{ route('profile.update') }}">
                                            @csrf
                                            @method('patch')

                                            <div class="form-group">
                                                <label class="form-label" for="name">Full Name</label>
                                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
                                                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label" for="email">Email Address</label>
                                                <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
                                                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group mt-3">
                                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                                @if (session('status') === 'profile-updated')
                                                    <span class="text-success ms-2">Saved.</span>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Section 2: Security/Password --}}
                            <div class="col-lg-6">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="card-head">
                                            <h5 class="title">Change Password</h5>
                                        </div>
                                        <form method="post" action="{{ route('password.update') }}">
                                            @csrf
                                            @method('put')

                                            <div class="form-group">
                                                <label class="form-label" for="current_password">Current Password</label>
                                                <input type="password" name="current_password" class="form-control" id="current_password">
                                                @error('current_password', 'updatePassword') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label" for="password">New Password</label>
                                                <input type="password" name="password" class="form-control" id="password">
                                                @error('password', 'updatePassword') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                                            </div>

                                            <div class="form-group mt-3">
                                                <button type="submit" class="btn btn-warning">Update Password</button>
                                                @if (session('status') === 'password-updated')
                                                    <span class="text-success ms-2">Password Updated.</span>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- .row --}}
                    </div> {{-- .nk-block --}}

                    <div class="nk-block mt-4">
                        <div class="card card-bordered border-danger">
                            <div class="card-inner">
                                <h5 class="title text-danger">Delete Account</h5>
                                <p>Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
