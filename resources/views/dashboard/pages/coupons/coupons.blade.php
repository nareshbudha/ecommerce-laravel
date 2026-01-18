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
                                    <h3>Coupons</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="/">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Coupons</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <form class="form-search">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Search here..." class="" name="name"
                                                        tabindex="2" value="" aria-required="true" required="">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="{{ route('coupons.create') }}"><i
                                                class="icon-plus"></i>Add new</a>
                                    </div>
                                    <div class="wg-table table-all-user">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Code</th>
                                                        <th>Type</th>
                                                        <th>Value</th>
                                                        <th>Usage Limit</th>
                                                        <th>Times Used</th>
                                                        <th>Expiry Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($coupons as $coupon)
                                                    <tr>
                                                        <td>{{ $coupon->id }}</td>
                                                        <td>{{ $coupon->code }}</td>
                                                        <td>{{ $coupon->type }}</td>
                                                        <td>{{ $coupon->value }}</td>
                                                        <td>{{$coupon->usage_limit}}</td>
                                                         <td>{{$coupon->times_used}}</td>
                                                        <td>{{ $coupon->expiry_date }}</td>
                                                        <td>
                                                            <div class="list-icon-function">
                                                                <a
                                                                    href="{{ route('coupons.edit', ['coupon' => $coupon->id]) }}">
                                                                    <div class="item edit">
                                                                        <i class="icon-edit-3"></i>
                                                                    </div>
                                                                </a>
                                                                <form
                                                                    action="{{ route('coupons.destroy', ['coupon' => $coupon->id]) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure you want to delete this Cupon?');"
                                                                    style='display:inline;'>
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="item text-danger delete"
                                                                        style="border: none; margin-left: -20px;">
                                                                        <i class="icon-trash-2"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    {{-- <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                                        {{ $coupon->links('pagination::bootstrap-5')}}
                                    </div> --}}
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
