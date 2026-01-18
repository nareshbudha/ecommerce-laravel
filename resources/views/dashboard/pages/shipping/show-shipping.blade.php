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
                            <div class="">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Show Brand Details</h3>
                                    <ul class="breadcrumbs flex items-center gap10">
                                        <li><a href="/dashboard">
                                                <div class="text-tiny">Dashboard</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><a href="{{ route('shipping.index') }}">
                                                <div class="text-tiny">shipping</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <div class="text-tiny">Show Shipping Details</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box"
                                    style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px;">
                                    <!-- Category Name -->
                                    <div class="body-title"
                                        style="display: flex; flex-direction: row; align-items: center;">
                                        <strong>Province:</strong>
                                        <p>{{ ucwords($shipping->province) }}</p>
                                    </div>

                                    <!-- Category Slug -->
                                    <div class="body-title"
                                        style="display: flex; flex-direction: row; align-items: center;">
                                        <strong>District:</strong>
                                        <p>{{ $shipping->district }}</p>
                                    </div>
                                    <div class="body-title"
                                        style="display: flex; flex-direction: column;  flex-wrap: wrap; align-items: flex-start;">
                                        <strong>Local Level:</strong>
                                        @foreach($localLevels ?? [] as $level)
                                        <p>
                                            Name: {{ $level['name'] }}, Type: {{ $level['type'] }}, Rate: {{
                                            $level['rate'] }}
                                        </p>
                                        @endforeach
                                    </div>

                                    <!-- Category Slug -->
                                    <div class="body-title"
                                        style="display: flex; flex-direction: row; align-items: center;">
                                        <strong>Method:</strong>
                                        <p>{{ $shipping->method }}</p>
                                    </div>
                                    <!-- Category Slug -->
                                    <div class="body-title"
                                        style="display: flex; flex-direction: row; align-items: center;">
                                        <strong>Estimated Delivery:</strong>
                                        <p>{{ $shipping->estimated_delivery}}</p>
                                    </div>

                                    <!-- Category Slug -->
                                    <div class="body-title"
                                        style="display: flex; flex-direction: row; align-items: center;">
                                        <strong>Notes:</strong>
                                        <p>{{ $shipping->notes }}</p>
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
