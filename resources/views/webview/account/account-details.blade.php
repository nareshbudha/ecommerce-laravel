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
                        <div class="needs-validation">
                            {{-- Personal Details --}}
                            <section>
                                <div class="my-3">
                                    <h5 class="text-uppercase mb-0">Personal Details</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Name:</strong>{{$user->name?? 'null'}}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <p><strong>Mobile Number:</strong>{{$address->mobile_num?? 'null'}}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <p><strong>Email Address:</strong>{{$user->email?? 'null'}}</p>
                                    </div>

                            </section>

                            {{-- Address Details --}}
                            <section>
                                <div class="my-3">
                                    <h5 class="text-uppercase mb-0">Address Details</h5>
                                </div>

                                <div class="col-md-12">
                                    <p><strong>State:</strong>{{$address->state?? 'null'}}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>District:</strong>{{$address->district?? 'null'}}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Town City:</strong>{{$address->town_city?? 'null'}}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>House Number:</strong>{{$address->house_no_building?? 'null'}}</p>
                                </div>

                                <div class="col-md-12">
                                    <p><strong>Road Area Colony:</strong>{{$address->road_area_colony?? 'null'}}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Landmark:</strong>{{$address->landmark?? 'null'}}</p>
                                </div>
                                <a href="{{ route('account.address') }}">If You Want To Change Address</a>

                            </Section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>



@endsection
