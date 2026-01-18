@extends('layouts.app')
@section('container')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">My Account</h2>
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
          <div class="page-content my-account__dashboard">
            <p>Hello <strong></strong></p>
            <p>From your account dashboard you can view your <a class="unerline-link" href="/account_order">recent
                orders</a>, manage your <a class="unerline-link" href="/account-details">Your Personal Details and shipping
                addresses</a>, and <a class="unerline-link" href="{{ route('account.address') }}">edit your password </a></p>
          </div>
        </div>
      </div>
    </section>
  </main>



@endsection
