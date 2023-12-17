@extends('layouts.app')

@section('content')
<main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <img width="100" class="me-auto" height="100" src="{{ asset('assets/img/logo.png') }}" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Sign In Into Docter</h4>
                                <p class="mb-0">Enter your email and password </p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('docter.login') }}">
                                    @csrf
                                    @method('post')
                                    <div class="flex flex-col mb-3">
                                        <input type="email" name="email" class="form-control form-control-lg"
                                            value="{{ old('email') }}" aria-label="Email" placeholder="Email or Phone">
                                        @error('email')
                                        <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col mb-3">
                                        <input type="password" name="password" class="form-control form-control-lg"
                                            aria-label="Password" placeholder="Password">
                                        @error('password')
                                        <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="remember" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign
                                            in</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('{{ asset('img/illustrations/docter-bg.jpg') }}');
              background-size: cover; background-position:70%;">
                            <span class="mask bg-gradient-primary opacity-6"></span>

                            <h4 class="mt-5 text-white font-weight-bolder position-relative">KonsulDok</h4>
                            <p class="text-white position-relative">Approval your reservation client.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection