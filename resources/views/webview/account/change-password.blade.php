<!-- filepath: /C:/laragon/www/e-commerce/resources/views/webview/account/my-account.blade.php -->
@extends('layouts.app')

@section('container')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Account Details</h2>
        <div class="row">
            <div class="col-lg-3">
                <ul class="account-nav">
                    <li><a href="/my-account" class="checkout-steps__item menu-link menu-link_us-s">Dashboard</a></li>
                    <li><a href="/account-details" class="checkout-steps__item menu-link menu-link_us-s active">Account Details</a></li>
                    <li><a href="/account_order" class="checkout-steps__item menu-link menu-link_us-s">Orders</a></li>
                    <li><a href="/account-wishlist" class="checkout-steps__item menu-link menu-link_us-s">Wishlist</a></li>
                    <li><a href="/account_order" class="checkout-steps__item menu-link menu-link_us-s">Orders</a></li>
                    <li><a href="{{ route('password.reset') }}" class="checkout-steps__item menu-link menu-link_us-s">Change Password</a></li>
                </ul>
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__edit">
                    <div class="my-account__edit-form">
                        <form name="account_edit_form" action="" method="POST" class="needs-validation" novalidate="">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="my-3">
                                        <h5 class="text-uppercase mb-0">Password Change</h5>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old password" required="">
                                        <label for="old_password">Old password</label>
                                        @error('old_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New password" required="">
                                        <label for="new_password">New password</label>
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password" required="">
                                        <label for="new_password_confirmation">Confirm new password</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
