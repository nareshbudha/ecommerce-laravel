@php
    $brands = \App\Models\Brand::paginate(10);
@endphp
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
                                    <h3>Brands</h3>
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
                                            <span class="text-tiny">Brands</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Brand Management Section -->
                                <div class="wg-box">
                                    <!-- Search & Add Brand -->

                                    <div class=" flex items-center justify-between gap-10">
                                        <form class="form-search ">
                                            <fieldset class="name">
                                                <input type="text" placeholder="Search here..." class=""
                                                    name="name" tabindex="2" value="" aria-required="true"
                                                    required="">
                                            </fieldset>
                                            <div class="button-submit">
                                                <button class="" type="submit"><i
                                                        class="icon-search"></i></button>
                                            </div>
                                        </form>
                                        <a href="/dashboard/add-brand" class="tf-button style-1 w208">
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
                                                    <th class="text-center">Slug</th>
                                                    <th class="text-center">Logo</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($brands as $brand)
                                                    <tr>
                                                        <td class="text-center">{{ $brand->id }}</td>
                                                        <td class="text-center">{{ $brand->name }}</td>
                                                        <td class="text-center">{{ $brand->slug }}</td>
                                                        <td class="text-center">
                                                            <img src="{{ asset('storage/' . $brand->image) }}"
                                                                alt="{{ $brand->name }}"
                                                                style="height: 80px; border-radius: 15px;"
                                                                onerror="this.src='/assets/images/default-logo.png';">
                                                        </td>
                                                        <td>
                                                            <div class="list-icon-function">
                                                                <a href="{{ route('brands.edit', $brand->id) }}"
                                                                    class="item edit">
                                                                    <div class="item edit">
                                                                        <i class="icon-edit-3"></i>
                                                                    </div>
                                                                </a>
                                                                <a href="/dashboard/brands/{{ $brand->id }}">
                                                                    <div class="item eye">
                                                                        <i class="icon-eye"></i>
                                                                    </div>
                                                                </a>
                                                                <form action="{{ route('brands.destroy', $brand->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure you want to delete this brand?');">
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
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No brands found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between wgp-pagination">
                                        {{ $brands->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
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
