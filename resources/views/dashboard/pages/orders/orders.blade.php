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
                                    <h3>Orders</h3>
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
                                            <div class="text-tiny">Orders</div>
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
                                    </div>

                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width:70px">OrderNo</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Phone</th>
                                                        <th class="text-center">Subtotal</th>
                                                        <th class="text-center">Tax</th>
                                                        <th class="text-center">Total</th>
                                                        <th class="text-center">Order Date</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($orders as $order)
                                                        <tr>
                                                            <td class="text-center">{{ $order->id }}</td>
                                                            <td class="text-center">{{ $order->name }}</td>
                                                            <td class="text-center">{{ $order->mobile_num }}</td>
                                                            <td class="text-center">Rs {{ number_format($order->subtotal, 2) }}</td>
                                                            <td class="text-center">Rs {{ number_format($order->tax, 2) }}</td>
                                                            <td class="text-center">Rs {{ number_format($order->total, 2) }}</td>
                                                            <td class="text-center">{{ $order->created_at->format('d M Y') }}</td>
                                                            <td class="text-center">{{ ucfirst($order->status) }}</td>
                                                            <td>
                                                                <div class="list-icon-function">

                                                                    <a href="{{ route('order.status.update.form',$order->id) }}"  class="item edit">
                                                                        <i class="icon-edit-3"></i>
                                                                    </a>
                                                                    <a href="{{ route('orders.details', $order->id) }}" >
                                                                        <div class="item eye">
                                                                            <i class="icon-eye"></i>
                                                                        </div>
                                                                    </a>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="11" class="text-center">No orders found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                                        {{ $orders->links('pagination::bootstrap-5') }}
                                    </div>
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
