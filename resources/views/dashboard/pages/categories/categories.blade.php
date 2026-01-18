@php
    $categories = \App\Models\Category::paginate(10);
@endphp
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
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Categories</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="/">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Categories</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <form class="form-search">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Search here..." class="" name="name"
                                                        tabindex="2" value="" aria-required="true" required="">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="/dashboard/add-category"><i
                                                class="icon-plus"></i>Add new</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead >
                                                <tr>
                                                    <th class="text-center" style="margin-left: 20px">Id</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Slug</th>
                                                    <th class="text-center">Logo</th>
                                                    <th class="text-center">Position</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($categories as $category)
                                                    <tr>
                                                        <!-- Category ID -->
                                                        <td>{{ $category->id }}</td>

                                                        <!-- Category Name -->
                                                        <td>{{ $category->name }}</td>

                                                        <!-- Category Slug -->
                                                        <td>{{ $category->slug }}</td>

                                                        <!-- Category Image -->
                                                        <td class="text-center">
                                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                                alt="{{ $category->name }}"
                                                                style="height: 80px; border-radius: 15px;"
                                                                onerror="this.src='/assets/images/default-logo.png';">
                                                        </td>
                                                        <td>{{ $category->position }}</td>
                                                        <td>
                                                            <div class="list-icon-function">
                                                                <a href="/categories/{{ $category->id }}/edit" class="item edit">
                                                                    <div class="item edit">
                                                                        <i class="icon-edit-3"></i>
                                                                    </div>
                                                                </a>
                                                                <a href="/categories/{{ $category->id }}">
                                                                    <div class="item eye">
                                                                        <i class="icon-eye"></i>
                                                                    </div>
                                                                </a>
                                                                <form action="/categories/{{ $category->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this brand?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="item text-danger delete" style="border: none; margin-left: -20px;">
                                                                        <i class="icon-trash-2"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No categories found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

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
