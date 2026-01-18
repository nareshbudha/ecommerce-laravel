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
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Settings</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="#">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Settings</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="col-lg-12">
                                        <div class="page-content my-account__edit">
                                            <div class="my-account__edit-form">
                                                <form name="account_edit_form" action="#" method="POST"
                                                    class="form-new-product form-style-1 needs-validation"
                                                    novalidate="">

                                                    <fieldset class="name">
                                                        <div class="body-title">Name <span class="tf-color-1">*</span>
                                                        </div>
                                                        <input class="flex-grow" type="text" placeholder="Full Name"
                                                            name="name" tabindex="0" value="" aria-required="true"
                                                            required="">
                                                    </fieldset>

                                                    <fieldset class="name">
                                                        <div class="body-title">Mobile Number <span
                                                                class="tf-color-1">*</span></div>
                                                        <input class="flex-grow" type="text" placeholder="Mobile Number"
                                                            name="mobile" tabindex="0" value="" aria-required="true"
                                                            required="">
                                                    </fieldset>

                                                    <fieldset class="name">
                                                        <div class="body-title">Email Address <span
                                                                class="tf-color-1">*</span></div>
                                                        <input class="flex-grow" type="text" placeholder="Email Address"
                                                            name="email" tabindex="0" value="" aria-required="true"
                                                            required="">
                                                    </fieldset>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="my-3">
                                                                <h5 class="text-uppercase mb-0">Password Change</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <fieldset class="name">
                                                                <div class="body-title pb-3">Old password <span
                                                                        class="tf-color-1">*</span>
                                                                </div>
                                                                <input class="flex-grow" type="password"
                                                                    placeholder="Old password" id="old_password"
                                                                    name="old_password" aria-required="true"
                                                                    required="">
                                                            </fieldset>

                                                        </div>
                                                        <div class="col-md-12">
                                                            <fieldset class="name">
                                                                <div class="body-title pb-3">New password <span
                                                                        class="tf-color-1">*</span>
                                                                </div>
                                                                <input class="flex-grow" type="password"
                                                                    placeholder="New password" id="new_password"
                                                                    name="new_password" aria-required="true"
                                                                    required="">
                                                            </fieldset>

                                                        </div>
                                                        <div class="col-md-12">
                                                            <fieldset class="name">
                                                                <div class="body-title pb-3">Confirm new password <span
                                                                        class="tf-color-1">*</span></div>
                                                                <input class="flex-grow" type="password"
                                                                    placeholder="Confirm new password" cfpwd=""
                                                                    data-cf-pwd="#new_password"
                                                                    id="new_password_confirmation"
                                                                    name="new_password_confirmation"
                                                                    aria-required="true" required="">
                                                                <div class="invalid-feedback">Passwords did not match!
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="my-3">
                                                                <button type="submit"
                                                                    class="btn btn-primary tf-button w208">Save
                                                                    Changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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
