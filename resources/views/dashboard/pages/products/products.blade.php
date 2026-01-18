

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
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
                                    <h3>All Products</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li><a href="/">
                                                <div class="text-tiny">Dashboard</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <div class="text-tiny">All Products</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <form class="form-search" method="GET" action="/dashboard/products">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Search here..." name="name"
                                                        aria-required="true" required="">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="/dashboard/add-product"><i
                                                class="icon-plus"></i>Add new</a>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Id</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>SalePrice</th>
                                                    {{-- <th class="text-center" style="width: 100px;">Image</th> --}}
                                                    <th>SKU</th>
                                                    <th class="text-center">Category </th>
                                                    <th class="text-center">Sub Category </th>
                                                    <th>Brand </th>
                                                    <th>Featured</th>
                                                    <th>HotDeals</th>
                                                    <th>Stock</th>
                                                    <th>Quantity</th>
                                                    <th class="text-center" style="width: 150px;">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td class="text-center">{{ $product->id }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td class="text-center">{{ $product->regular_price }}</td>
                                                        <td class="text-center">{{ $product->sale_price }}</td>
                                                        {{-- <td class="text-center">
                                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                                alt="{{ $product->name }}"
                                                                style="height: 80px; border-radius: 15px;"
                                                                onerror="this.src='/assets/images/default-logo.png';">
                                                        </td> --}}
                                                        <td>{{ $product->sku }}</td>
                                                        <td class="text-center">
                                                            {{ $product->category_id ? $product->category->name : 'N/A' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $product->sub_category_id ? $product->subCategory->name : 'N/A' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $product->brand ? $product->brand->name : 'N/A' }}</td>
                                                        <td>{{ $product->featured }}</td>
                                                        <td>{{ $product->hot_deals }}</td>
                                                        <td>{{ $product->stock }}</td>
                                                        <td class="text-center">{{ $product->quantity }}</td>

                                                        <td class="text-center">
                                                            <div class="list-icon-function">
                                                                <a href="/products/{{ $product->id }}/edit"
                                                                    class="item edit">
                                                                    <i class="icon-edit-3"></i>
                                                                </a>
                                                                <a href="/products/{{ $product->slug}}"
                                                                    class="item eye">
                                                                    <i class="icon-eye"></i>
                                                                </a>
                                                                <form action="/products/{{ $product->id }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
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

                                    <!-- Pagination Links -->
                                    <div class="pagination">
                                      {{ $products->links() }}
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
