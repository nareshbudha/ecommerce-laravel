<!DOCTYPE html>
<html lang="en-US">

<head>
    <!-- Meta Information -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="themesflat.com">
    <title>Spell E-Commerce - Brands</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/animate.min.css">
    <link rel="stylesheet" href="/assets/css/animation.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/font/fonts.css">
    <link rel="stylesheet" href="/assets/icon/style.css">
    <link rel="stylesheet" href="/assets/css/custom.css">


    <!-- Favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/images/favicon.ico">
</head>

<body class="body">
    <div id="wrapper">
        <div id="page">
            <div class="layout-wrap">
                <!-- Sidebar Section -->
                @include('dashboard.components.sidebar')

                <!-- Main Content Area -->
                <div class="section-content-right">
                    <!-- Header Section -->
                    <header class="header-dashboard">
                        @include('dashboard.components.navbar')
                    </header>

                    <!-- Main Content -->
                    <main class="main-content">
                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <!-- Page Header -->
                                <div class="flex items-center justify-between gap-20 mb-27">
                                    <h3>Tax Details</h3>
                                    <ul class="breadcrumbs flex items-center gap-10">
                                        <li>
                                            <a href="/">
                                                <span class="text-tiny">Dashboard</span>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <span class="text-tiny">Tax</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Brand Management Section -->
                                <div class="wg-box">
                                    <!-- Search & Add Brand -->

                                    <div class=" flex items-center justify-between gap-10">
                                        <form class="form-search ">
                                            <fieldset class="name">
                                                <input type="text" placeholder="Search here..." class="" name="name"
                                                    tabindex="2" value="" aria-required="true" required="">
                                            </fieldset>
                                            <div class="button-submit">
                                                <button class="" type="submit"><i class="icon-search"></i></button>
                                            </div>
                                        </form>
                                        <a href="{{ route('tax.create') }}" class="tf-button style-1 w208">
                                            <i class="icon-plus"></i> Add new
                                        </a>

                                    </div>

                                    <!-- Brands Table -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Id</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Value</th>
                                                    <th class="text-center">Active</th>

                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($taxes as $tax)
                                                <tr>
                                                    <td class="text-center">{{ $tax->id }}</td>
                                                    <td class="text-center">{{ $tax->name}}</td>
                                                    <td class="text-center">{{ $tax->value}}</td>
                                                    <td class="text-center">{{ $tax->is_active ? 'Yes' : 'No' }}</td>


                                                    <td>
                                                        <div
                                                            class="list-icon-function d-flex justify-content-center gap-4">
                                                            <a href="{{ route('tax.edit', $tax->id) }}"
                                                                class="item edit">
                                                                <i class="icon-edit-3"></i>
                                                            </a>
                                                            <a href="{{ route('tax.show', $tax->id) }}"
                                                                class="item eye">
                                                                <i class="icon-eye"></i>
                                                            </a>
                                                            <form action="{{ route('tax.destroy', $tax->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this shipping record?');"
                                                                style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="item text-danger delete"
                                                                    style="border: none; background: none;">
                                                                    <i class="icon-trash-2"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Shipping found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between wgp-pagination">
                                        {{-- {{ $brands->links() }} --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>

                    <!-- Footer -->
                    <footer class="bottom-page">
                        <div class="body-text">Copyright © 2024 Spell E-Commerce</div>
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-select.min.js"></script>
    <script src="/assets/js/apexcharts/apexcharts.js"></script>
    <script src="/assets/js/main.js"></script>
</body>

</html>
