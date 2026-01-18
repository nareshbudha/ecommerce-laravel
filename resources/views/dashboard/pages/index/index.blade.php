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
                                <div class="tf-section-2 mb-30">
                                    <div class="flex gap20 flex-wrap-mobile">
                                        <div class="w-half">

                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-shopping-bag"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Total Orders</div>
                                                            <h4>{{ $total_orders }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">

                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Total Amount</div>
                                                            <h4>Rs {{ number_format($total_amount, 2) }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-shopping-bag"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Pending Orders</div>
                                                            <h4>{{ $pending_orders }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">

                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Pending Orders Amount</div>
                                                            <h4>Rs {{ number_format($pending_orders_amount, 2) }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="w-half">

                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-shopping-bag"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Delivered Orders</div>
                                                            <h4>{{ $delivered_orders }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">

                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Delivered Orders Amount</div>
                                                            <h4>Rs {{ number_format($delivered_orders_amount, 2) }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-shopping-bag"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Canceled Orders</div>
                                                            <h4>{{ $canceled_orders }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">

                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Canceled Orders Amount</div>
                                                            <h4>Rs {{ number_format($canceled_orders_amount, 2) }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="wg-box">
                                        <div class="flex items-center justify-between">
                                            <h5>Earnings revenue</h5>
                                            <div class="dropdown default">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <span class="icon-more"><i class="icon-more-horizontal"></i></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="javascript:void(0);">This Week</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Last Week</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap40">
                                            <div>
                                                <div class="mb-2">
                                                    <div class="block-legend">
                                                        <div class="dot t1"></div>
                                                        <div class="text-tiny">Revenue</div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap10">

                                                    <h4>Rs {{ number_format($revenue, 2) }}</h4>
                                                    <div class="box-icon-trending up">
                                                        <i class="icon-trending-up"></i>
                                                        <div class="body-title number">{{ $revenue_trend }}%</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="mb-2">
                                                    <div class="block-legend">
                                                        <div class="dot t2"></div>
                                                        <div class="text-tiny">Order</div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap10">

                                                    <h4>Rs {{ number_format($order_value, 2) }}</h4>
                                                    <div class="box-icon-trending up">
                                                        <i class="icon-trending-up"></i></i>
                                                        <div class="body-title number">{{ $order_trend }}%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="line-chart-8"></div>
                                    </div>

                                </div>
                                <div class="tf-section mb-30">

                                    <div class="wg-box">
                                        <div class="flex items-center justify-between">
                                            <h5>Products</h5>
                                            <div class="dropdown default">
                                                <a class="btn btn-secondary dropdown-toggle"
                                                    href="{{ route('products.index') }}">
                                                    <span class="view-all">View all</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="wg-table table-all-user">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:70px">Sn</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Category</th>
                                                            <th class="text-center">Brand</th>
                                                            <th class="text-center">Quantity</th>
                                                            <th class="text-center">Stock</th>
                                                            <th class="text-center">Color</th>
                                                            <th class="text-center">Size</th>
                                                            <th class="text-center">Regular Price</th>
                                                            <th class="text-center">Sale Price</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($product->take(5) as $pro)
                                                        <tr>
                                                            <td class="text-center">{{ $pro->id }}</td>
                                                            <td class="text-center">{{ $pro->name }}</td>
                                                            <td class="text-center">{{ $pro->category->name }}</td>
                                                            <td class="text-center">{{ $pro->brand->name }}</td>
                                                            <td class="text-center">{{ $pro->quantity }}</td>
                                                            <td class="text-center">{{ $pro->stock }}</td>
                                                            <td class="text-center">{{ $pro->color }}</td>
                                                            <td class="text-center">{{ $pro->size }}</td>
                                                            <td class="text-center">{{ $pro->regular_price }}</td>
                                                            <td class="text-center">{{ $pro->sale_price }}</td>
                                                            <td class="text-center">
                                                                <div class="list-icon-function">
                                                                    <a href="{{ route('product-detail', $pro->slug) }}">
                                                                        <div class="item eye"><i class="icon-eye"></i>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="11" class="text-center">No products found.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                <div class="tf-section mb-30">

                                    <div class="wg-box">
                                        <div class="flex items-center justify-between">
                                            <h5>Recent orders</h5>
                                            <div class="dropdown default">
                                                <a class="btn btn-secondary dropdown-toggle" href="/dashboard/orders">
                                                    <span class="view-all">View all</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="wg-table table-all-user">
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
                                                        @forelse ($orders->take(2) as $order)
                                                        <tr>
                                                            <td class="text-center">{{ $order->id }}</td>
                                                            <td class="text-center">{{ $order->name }}</td>
                                                            <td class="text-center">{{ $order->mobile_num }}</td>
                                                            <td class="text-center">Rs {{
                                                                number_format($order->subtotal, 2) }}</td>
                                                            <td class="text-center">Rs {{ number_format($order->tax, 2)
                                                                }}</td>
                                                            <td class="text-center">Rs {{ number_format($order->total,
                                                                2) }}</td>

                                                            <td class="text-center">{{ $order->created_at->format('d M
                                                                Y') }}</td>
                                                            <td class="text-center">{{ ucfirst($order->status) }}</td>
                                                            <td>
                                                                <div class="list-icon-function">
                                                                    <a href="{{ route('order.status.update.form',$order->id) }}"
                                                                        class="item edit">
                                                                        <i class="icon-edit-3"></i>
                                                                    </a>

                                                                    <a href="{{ route('orders.details', $order->id) }}">
                                                                        <div class="item eye">
                                                                            <i class="icon-eye"></i>
                                                                        </div>
                                                                    </a>

                                                                </div>


                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="11" class="text-center">No orders found.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
