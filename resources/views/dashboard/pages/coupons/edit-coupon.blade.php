<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <!-- Head Section: Meta information, styles, and favicon -->
    <title>Spell E-Commerce</title>
    <meta charset="utf-8">
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="/assets/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/animation.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/font/fonts.css">
    <link rel="stylesheet" href="/assets/icon/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/assets/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
</head>

<body class="body">
    <div id="wrapper">
        <!-- Page Wrapper -->
        <div id="page" class="">
            <div class="layout-wrap">
                <!-- Sidebar Section -->
                @include('dashboard.components.sidebar')

                <!-- Main Content Area -->
                <div class="section-content-right">
                    <!-- Header Section -->
                    <div class="header-dashboard">
                        @include('dashboard.components.navbar')
                    </div>

                    <!-- Main Content Section -->
                    <div class="main-content">
                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Edit Coupon </h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="#">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="text-tiny">Coupons</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Edit Coupon</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="wg-box">
                                    <form class="form-new-product form-style-1" method="POST"
                                        action="{{ route('coupons.update', $coupon->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $coupon->id }}" />

                                        <fieldset class="name">
                                            <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Enter Coupon Code"
                                                name="code" tabindex="0" value="{{ old('code', $coupon->code) }}"
                                                required>
                                            @error('code')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        </fieldset>

                                        <fieldset class="category">
                                            <div class="body-title">Coupon Type</div>
                                            <div class="select flex-grow">
                                                <select name="type" required>
                                                    <option value="">Select</option>
                                                    <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ?
                                                        'selected' : '' }}>Fixed</option>
                                                    <option value="percent" {{ old('type', $coupon->type) == 'percent' ?
                                                        'selected' : '' }}>Percent</option>
                                                </select>
                                            </div>
                                            @error('type')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        </fieldset>

                                        <fieldset class="name">
                                            <div class="body-title">Value <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="number" placeholder="Enter Coupon Value"
                                                name="value" tabindex="0" value="{{ old('value', $coupon->value) }}"
                                                required>
                                            @error('value')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        
                                        <fieldset class="name">
                                            <div class="body-title">Usage Limit <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="number" placeholder="Usage Limit"
                                                name="usage_limit" tabindex="0"
                                                value="{{ old('usage_limit', $coupon->usage_limit) }}" required>
                                            @error('usage_limit')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        </fieldset>

                                        <fieldset class="name">
                                            <div class="body-title">Expiry Date <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="date" placeholder="Select Expiry Date"
                                                name="expiry_date" tabindex="0"
                                                value="{{ old('expiry_date', $coupon->expiry_date) }}" required>
                                            @error('expiry_date')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        </fieldset>

                                        <div class="bot">
                                            <div></div>
                                            <button class="tf-button w208" type="submit">Update</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>

                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2024 Spell E-Commerce</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Section -->
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-select.min.js"></script>
    <script src="/assets/js/apexcharts/apexcharts.js"></script>
    <script src="/assets/js/main.js"></script>
</body>

</html>
