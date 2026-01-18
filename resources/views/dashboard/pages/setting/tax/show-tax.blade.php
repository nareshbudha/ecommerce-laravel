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
                                    <h3>Show Tax Details</h3>
                                    <ul class="breadcrumbs flex items-center gap10">
                                        <li><a href="/dashboard">
                                                <div class="text-tiny">Dashboard</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><a href="{{ route('tax.index') }}">
                                                <div class="text-tiny">Tax</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <div class="text-tiny">Show Tax Details</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box"
                                    style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px;">

                                    <div class="body-title"
                                        style="display: flex; flex-direction: row; align-items: center;">
                                        <p><strong>ID:</strong> {{ $tax->id }}</p>
                                    </div>


                                    <div class="body-title"
                                        style="display: flex; flex-direction: row; align-items: center;">
                                        <p><strong>Name:</strong> {{ $tax->name }}</p>
                                    </div>

                                    <div class="body-title"
                                        style="display: flex; flex-direction: row; align-items: center;">
                                        <p><strong>Value:</strong> {{ $tax->value }}</p>
                                    </div>

                                    <div class="body-title"
                                        style="display: flex; flex-direction: row; align-items: center;">
                                        <p><strong>Active:</strong> {{ $tax->is_active ? 'Yes' : 'No' }}</p>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-select.min.js"></script>
    <script src="/assets/js/apexcharts/apexcharts.js"></script>
    <script src="/assets/js/main.js"></script>
</body>

</html>
