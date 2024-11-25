@extends('layouts.master-login')
@section('title')
    Login
@endsection
@section('page-title')
    Login
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5>Welcome Back !</h5>
                    <p class="text-muted">Sign in to continue to ATS Portal.</p>
                </div>
                <div class="p-2 mt-4">
                    <form method="POST" action="{{ route('login') }}" class="auth-input">
                        @csrf
                        <div class="mb-2">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                value="admin@themesbrand.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="float-end">
                                <a href="{{ route('password.update') }}" class="text-muted text-decoration-underline">Forgot
                                    password?</a>
                            </div>
                            <label class="form-label" for="password-input">Password <span
                                    class="text-danger">*</span></label>
                            <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                <span class="bx bx-lock-alt"></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter password" id="password-input" name="password" required
                                    autocomplete="current-password" value="12345678">
                                <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0"
                                    id="password-addon">
                                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">

                            <label class="form-label" for="google2fa">One Time Password(OTP)</label>

                            <input id="google2fa" type="number" min="0" max="999999"
                                class="form-control @error('google2fa') is-invalid @enderror" name="google2fa" required
                                autofocus>

                            @error('google2fa')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <p class="text-center font-size-12">Please enter the <strong>OTP</strong> generated on your
                                Authenticator App. Ensure you submit the current one because it refreshes every 30 seconds.
                            </p>

                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember
                                me</label>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-success w-100" type="submit">Sign
                                In</button>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Don't have an account ? <br />Contact with Success HR Admin</p>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="{{ URL::asset('build/js/pages/pass-addon.init.js') }}"></script>
    @endsection
