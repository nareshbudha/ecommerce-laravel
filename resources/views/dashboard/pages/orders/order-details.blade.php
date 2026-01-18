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

                        <style>
                            .table-transaction>tbody>tr:nth-of-type(odd) {
                                --bs-table-accent-bg: #fff !important;
                            }
                        </style>
                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Order Details</h3>
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
                                            <div class="text-tiny">Order Details</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <h5>Ordered Details</h5>
                                        </div>
                                        <a class="tf-button style-1 w208" href="{{ route('orders') }}">Back</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">

                                            <tr>
                                                <th>Order No</th>
                                                <td>{{ $order->id }}</td>
                                                <th>Mobile</th>
                                                <td>{{ $order->mobile_num}}</td>
                                                <th>landmark</th>
                                                <td>{{ $order->landmark }}</td>
                                            </tr>
                                            <tr>
                                                <th>Order Date</th>
                                                <td>{{ $order->created_at}}</td>
                                                <th>Delivered Date</th>
                                                <td>{{ $order->delivered_date}}</td>
                                                <th>Cancle Date</th>
                                                <td>{{ $order->canceled_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Order Status</th>
                                                <td colspan="5">
                                                    @if($order->status=='delivered')
                                                    <span class="badge bg-success">Delivered</span>
                                                    @elseif($order->status=='canceled')
                                                    <span class="badge bg-danger">Canceled</span>
                                                    @else

                                                    <span class="badge bg-warning">Pending</span>

                                                    @endif
                                                </td>

                                            </tr>

                                        </table>
                                    </div>
                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <h5>Ordered Items</h5>
                                        </div>

                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">SKU</th>
                                                    <th class="text-center">Category</th>
                                                    <th class="text-center">Sub Category</th>
                                                    <th class="text-center">Brand</th>
                                                    <th class="text-center">Options</th>
                                                    <th class="text-center">Return Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orderItems as $item)
                                                <tr>
                                                    <td class="text-center">{{ $item->product->name }}</td>
                                                    <td class="text-center">Rs {{ $item->price }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-center">{{ $item->product->sku }}</td>
                                                    <td class="text-center">
                                                        @if($item->product->category)
                                                        {{ $item->product->category->name }}
                                                        @else
                                                        N/A
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($item->product->subCategory)
                                                        {{ $item->product->subCategory->name }}
                                                        @else
                                                        N/A
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($item->product->brand)
                                                        {{ $item->product->brand->name }}
                                                        @else
                                                        N/A
                                                        @endif
                                                    </td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center">No</td>
                                                    <td class="text-center">
                                                        <div class="list-icon-function view-icon">
                                                            <div class="item eye">
                                                                <i class="icon-eye"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                                    </div>
                                </div>

                                <div class="wg-box mt-5">
                                    <h5>Shipping Address</h5>
                                    <div class="my-account__address-item col-md-6">
                                        <div class="my-account__address-item__detail">
                                            <p><strong>Name:</strong></span>{{ $order->name }}</p>
                                            <br>
                                            <p> <strong>House Number:</strong>{{ $order->house_no_building }}, {{
                                                $order->road_area_colony }}</p>
                                            <br>
                                            <p> <strong>City:</strong>{{ $order->town_city }}, {{ $order->district }}
                                            </p>
                                            <br>
                                            <p><strong>State:</strong>{{ $order->state }}</p>
                                            <br>
                                            <p><strong>Lanfmark:</strong>{{ $order->landmark }}</p>

                                            <br>
                                            <p><strong>Mobile: </strong>{{ $order->mobile_num }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="wg-box mt-5">
                                    <h5>Transactions</h5>
                                    <table class="table table-striped table-bordered table-transaction">
                                        <tbody>
                                            <tr>
                                                <th>Subtotal</th>
                                                <td>Rs {{ number_format($order->subtotal, 2) }}</td>
                                                <th>Tax</th>
                                                <td>Rs {{ number_format($order->tax, 2) }}</td>
                                                <th>Discount</th>
                                                <td>Rs {{ number_format($order->discount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td>Rs {{ number_format($order->total, 2) }}</td>
                                                <th>Payment Mode</th>
                                                <td>{{ $transaction->mode }}</td>
                                                <th>Status</th>
                                                <td>{{ $transaction->status }}</td>
                                            </tr>
                                            <tr>
                                                <th>Order Date</th>
                                                <td>{{ $order->created_at }}</td>
                                                <th>Delivered Date</th>
                                                <td>{{ $order->delivered_date ?? 'N/A' }}</td>
                                                <th>Canceled Date</th>
                                                <td>{{ $order->canceled_date ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
