<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Show Category - Spell E-Commerce</title>
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
                                    <h3>Show Category Details</h3>
                                    <ul class="breadcrumbs flex items-center gap10">
                                        <li><a href="/dashboard">
                                                <div class="text-tiny">Dashboard</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><a href="/dashboard/subcategories">
                                                <div class="text-tiny">SubCategory</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <div class="text-tiny">Show SubCategory</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px;">
                                    <!-- Category Name -->
                                    <div class="body-title" style="display: flex; flex-direction: row; align-items: center;">
                                        <strong>Sub Category Name:</strong>
                                        <p>{{ ucwords($sub_category->name) }}</p>
                                    </div>

                                    <!-- Category Slug -->
                                    <div class="body-title" style="display: flex; flex-direction: row; align-items: center;">
                                        <strong>SubCategory Slug:</strong>
                                        <p>{{ $sub_category->slug }}</p>
                                    </div>
                                   

                                    <!-- Upload Image Section -->
                                    <div class="body-title" style="display: flex; flex-direction: column; align-items: flex-start;">
                                        <h3>Upload Image:</h3>

                                        @if($sub_category->image)
                                            <!-- Display Image -->
                                            <div class="item" id="imgpreview">
                                                <div class="image-container" style="max-width: 300px;">
                                                    <img
                                                        src="{{ asset('storage/' . $sub_category->image) }}"
                                                        alt="Image Preview for {{ $sub_category->name }}"
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

</html>
