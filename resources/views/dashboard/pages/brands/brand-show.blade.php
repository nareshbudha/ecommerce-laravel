<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Show Brand- Spell E-Commerce</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/font/fonts.css">
    <link rel="stylesheet" href="/assets/icon/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
</head>

<body class="body">
    <div id="wrapper">
        <div id="page">
            <div class="layout-wrap">
                <!-- Sidebar -->
                @include('dashboard.components.sidebar')

                <!-- Main Content -->
                <div class="section-content-right">
                    <div class="header-dashboard">
                        @include('dashboard.components.navbar')
                    </div>

                    <div class="main-content">
                        <div class="main-content-inner">
                            <div class="" >
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Show Brand Details</h3>
                                    <ul class="breadcrumbs flex items-center gap10">
                                        <li><a href="/dashboard">
                                                <div class="text-tiny">Dashboard</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><a href="/dashboard/brands">
                                                <div class="text-tiny">Brand</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <div class="text-tiny">Show Brand</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px;">
                                    <!-- Category Name -->
                                    <div class="body-title" style="display: flex; flex-direction: row; align-items: center;">
                                        <strong>Brand Name:</strong>
                                        <p>{{ ucwords($brand->name) }}</p>
                                    </div>

                                    <!-- Category Slug -->
                                    <div class="body-title" style="display: flex; flex-direction: row; align-items: center;">
                                        <strong>Brand Slug:</strong>
                                        <p>{{ $brand->slug }}</p>
                                    </div>

                                    <!-- Upload Image Section -->
                                    <div class="body-title" style="display: flex; flex-direction: column; align-items: flex-start;">
                                        <h3>Upload Image:</h3>

                                        @if($brand->image)
                                            <!-- Display Image -->
                                            <div class="item" id="imgpreview">
                                                <div class="image-container" style="max-width: 300px;">
                                                    <img
                                                        src="{{ asset('storage/' . $brand->image) }}"
                                                        alt="Image Preview for {{ $brand->name }}"
                                                        id="previewImage"
                                                        class="effect8"
                                                        style="width: 100%; height: 200px; padding: 20px; object-fit: contain; border-radius: 8px;">
                                                </div>
                                            </div>
                                        @else
                                            <p>No image uploaded.</p>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
  <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-select.min.js"></script>
    <script src="/assets/js/apexcharts/apexcharts.js"></script>
    <script src="/assets/js/main.js"></script>
</html>
