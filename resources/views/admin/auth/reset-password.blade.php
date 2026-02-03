@extends('admin.layouts.master2')

@section('css')
    <link href="{{URL::asset('assets/admin/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{URL::asset('assets/admin/img/media/reset.avif')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-50p ht-xl-60p mx-auto" alt="logo">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="mb-5 d-flex">
                                    <a href="#"><img src="{{URL::asset('assets/admin/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a>
                                    <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Learn To Earn</h1>
                                </div>

                                <div class="main-card-signin d-md-flex">
                                    <div class="wd-100p">
                                        <div class="main-signin-header">
                                            <div class="">
                                                <h2>Welcome back!</h2>
                                                <h4 class="text-left">Reset Your Password</h4>

                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul class="mb-0">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                <form action="{{ route('admin.password.store') }}" method="post" data-parsley-validate="">
                                                    @csrf

                                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                                    <div class="form-group text-left">
                                                        <label>Email</label>
                                                        <input class="form-control" name="email" type="email"
                                                               value="{{ old('email', $request->email) }}"
                                                               readonly required>
                                                    </div>

                                                    <div class="form-group text-left">
                                                        <label>New Password</label>
                                                        <input id="password" class="form-control"
                                                               placeholder="Enter your password"
                                                               type="password" name="password"
                                                               required minlength="8"
                                                               data-parsley-errors-container="#password-error">
                                                        <div id="password-error"></div>
                                                    </div>

                                                    <div class="form-group text-left">
                                                        <label>Confirm Password</label>
                                                        <input class="form-control"
                                                               placeholder="Confirm Password"
                                                               type="password" name="password_confirmation"
                                                               required
                                                               data-parsley-equalto="#password"
                                                               data-parsley-error-message="Passwords do not match"
                                                               data-parsley-errors-container="#confirm-error">
                                                        <div id="confirm-error"></div>
                                                    </div>

                                                    <button type="submit" class="btn ripple btn-main-primary btn-block">Reset Password</button>
                                                </form>
                                            </div>
                                        </div>
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

@section('js')
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/form-validation.js')}}"></script>
@endsection
