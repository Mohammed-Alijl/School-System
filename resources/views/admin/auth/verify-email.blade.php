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
                                            <h2>Verify Your Email</h2>
                                            <h6 class="text-muted mb-4">
                                                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
                                            </h6>

                                            @if (session('status') == 'verification-link-sent')
                                                <div class="alert alert-success" role="alert">
                                                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <strong>Sent!</strong> A new verification link has been sent to your email.
                                                </div>
                                            @endif

                                            <form method="POST" action="{{ route('admin.verification.send') }}">
                                                @csrf
                                                <button type="submit" class="btn btn-main-primary btn-block">
                                                    Resend Verification Email
                                                </button>
                                            </form>

                                            <div class="mt-3 text-center">
                                                <form method="POST" action="{{ route('admin.logout') }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link text-danger pl-0">
                                                        Log Out
                                                    </button>
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
@endsection
