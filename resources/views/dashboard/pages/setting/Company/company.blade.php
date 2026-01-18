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
        <div id="page" class="">
            <div class="layout-wrap">
                @include('dashboard.components.sidebar')
                <div class="section-content-right">
                    <div class="header-dashboard">
                        @include('dashboard.components.navbar')
                    </div>
                    <div class="main-content">
                        <style>
                            .text-danger {
                                font-size: initial;
                                line-height: 36px;
                            }

                            .alert {
                                font-size: initial;
                            }
                        </style>

                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <!-- Page Header -->
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Company</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap gap10">
                                        <li>
                                            <a href="/">
                                                <span class="text-tiny">Dashboard</span>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <span class="text-tiny">Company</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Slider Management Section -->
                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <!-- Search Bar -->
                                        <div class="wg-filter flex-grow">
                                            <form class="form-search">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Search here..." name="name"
                                                        aria-required="true" required="">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Add New Slider Button -->
                                        <a class="tf-button style-1 w208" href=" company/create">
                                            <i class="icon-plus"></i>Add New
                                        </a>
                                    </div>

                                    <!-- Slider Table -->

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Image</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Phone</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($companies as $company)
                                                <tr>
                                                    <td>{{ $company->id }}</td>
                                                    <td>{{$company->name}}</td>
                                                    <td>
                                                        <div class="image">
                                                            @if($company->logo)
                                                            <img src="{{ asset('storage/' . $company->logo) }}"
                                                                alt="{{ $company->name }}">
                                                            @else
                                                            <img src="{{ asset('assets/images/default-logo.png') }}"
                                                                alt="{{ $company->name }}">
                                                            @endif

                                                        </div>
                                                    </td>
                                                    <td>{{ $company->email }}</td>
                                                    <td>{{ $company->address }}</td>
                                                    <td>{{ $company->phone }}</td>


                                                    <td>
                                                        <div class="list-icon-function">
                                                            <a href="{{ route('company.edit', $company->id) }}">
                                                                <div class="item edit">
                                                                    <i class="icon-edit-3"></i>
                                                                </div>
                                                            </a>
                                                            <form action="{{ route('company.destroy', $company->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this company?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="item text-danger delete"
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


                                    <!-- Pagination Placeholder -->
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                                        {{-- {{ $companies->links('pagination::bootstrap-5') }} --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <footer class="bottom-page">
                            <div class="body-text">Copyright © 2024 Spell E-Commerce</div>
                        </footer>
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
