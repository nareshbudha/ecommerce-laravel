@extends('layouts.app')
@section('container')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Address</h2>
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
                <div class="page-content my-account__address">
                    <div class="row">
                        <div class="col-6">
                            <p class="notice">The following addresses will be used on the checkout page by default.</p>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#" class="btn btn-sm btn-danger">Back</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-5">
                                <div class="card-header">
                                    <h5>Update Your New Address</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('account.address') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-floating mt-3 mb-3">
                                                    <input type="text" class="form-control" name="state" value="{{ old('state', $address->state ?? '') }}">
                                                    <label for="state">State *</label>
                                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="district" value="{{ old('district', $address->district ?? '') }}">
                                                    <label for="district">District *</label>
                                                    <span class="text-danger">{{ $errors->first('district') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="town_city" value="{{ old('town_city', $address->town_city ?? '') }}">
                                                    <label for="town_city">Town / City *</label>
                                                    <span class="text-danger">{{ $errors->first('town_city') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="house_no_building" value="{{ old('house_no_building', $address->house_no_building ?? '') }}">
                                                    <label for="house_no_building">House No, Building Name *</label>
                                                    <span class="text-danger">{{ $errors->first('house_no_building') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="road_area_colony" value="{{ old('road_area_colony', $address->road_area_colony ?? '') }}">
                                                    <label for="road_area_colony">Road Name, Area, Colony *</label>
                                                    <span class="text-danger">{{ $errors->first('road_area_colony') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="landmark" value="{{ old('landmark', $address->landmark ?? '') }}">
                                                    <label for="landmark">Landmark</label>
                                                    <span class="text-danger">{{ $errors->first('landmark') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="mobile_num" value="{{ old('mobile_num', $user->mobile_num ?? '') }}">
                                                    <label for="mobile_num">Mobile Number *</label>
                                                    <span class="text-danger">{{ $errors->first('mobile_num') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
