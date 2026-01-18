@extends('layouts.app')

@section('container')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="login-register container">
            <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
                        role="tab" aria-controls="tab-item-login" aria-selected="true">Login</a>
                </li>
            </ul>
            <div class="tab-content pt-2" id="login_register_tab_content">
                <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
                    <div class="login-form">
                        <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation"
                            novalidate="">
                            @csrf

                            {{-- Email Input --}}
                            <div class="form-floating mb-3">
                                <input id="email" type="email"
                                    class="form-control form-control_gray @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <label for="email">Email address *</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="pb-3"></div>

                            {{-- Password Input with Show/Hide --}}
                            <div class="form-floating mb-3 position-relative">
                                <input id="password" type="password"
                                    class="form-control form-control_gray @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">
                                <label for="password">Password *</label>

                                {{-- Toggle Password Icon --}}
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3"
                                    onclick="togglePassword()" style="cursor: pointer;">
                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                </span>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Remember Me Checkbox --}}
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <button class="btn btn-primary w-100 text-uppercase" type="submit">Log In</button>

                            {{-- Forgot Password and Create Account Options --}}
                            <div class="customer-option mt-4 text-center">
                                @if (Route::has('password.request'))
                                    <a class="btn-text" href="{{ route('password.request') }}">Forgot Your Password?</a>
                                @endif
                                <style>
                                    @media (max-width: 480px) {
                                        .hide-text {
                                            display: none !important;
                                        }
                                    }
                                </style>

                                <div style="display: flex; justify-content: center;">
                                    <button
                                        style="display: flex; align-items: center; gap: 8px; margin-right: 8px; margin-top: 24px; border: 1px solid red; border-radius: 16px; padding: 8px 24px; background: transparent; cursor: pointer;">
                                        <img src="assets/images/logo/googleLogo.png" alt="google logo" />
                                        <p class="hide-text" style="margin: 0;">Login with Google</p>
                                    </button>

                                    <button
                                        style="display: flex; align-items: center; gap: 8px; margin-top: 24px; border: 1px solid #1e40af; border-radius: 16px; padding: 8px 24px; background: transparent; cursor: pointer;">
                                        <img src="assets/images/logo/facebook.png" alt="facebook logo"
                                            style="width: 20px; height: 20px;" />
                                        <p class="hide-text" style="margin: 0;">Login with Facebook</p>
                                    </button>
                                </div>

                                <div class="mt-2">
                                    <span class="text-secondary">No account yet?</span>
                                    <a href="/register" class="btn-text js-show-register">Create Account</a> |
                                    <a href="/my-account" class="btn-text js-show-register">My Account</a>
                                </div>



                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Script for Show/Hide Password --}}
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("togglePasswordIcon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>

    {{-- Font Awesome for Icons (if not already included in layout) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection
