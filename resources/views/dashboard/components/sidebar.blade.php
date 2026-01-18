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

<body>
    <div class="section-menu-left">
        <div class="box-logo">
            <a href="/dashboard" id="site-logo-inner" aria-label="Homepage">
                <img id="logo-header" class="logo" alt="Site Logo" src="/assets/images/logo/logo.png"
                    data-light="/assets/images/logo/logo-light.png" data-dark="/assets/images/logo/logo-dark.png">
            </a>

            <div class="button-show-hide">
                <i class="icon-menu-left"></i>
            </div>
        </div>
        <div class="center">
            <div class="center-item">
                <div class="center-heading">Main Home</div>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="/dashboard" class="">
                            <div class="icon"><i class="icon-grid"></i></div>
                            <div class="text">Dashboard</div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="center-item">
                <ul class="menu-list">
                    <li class="menu-item has-children">
                        <a href="javascript:void(0);" class="menu-item-button">
                            <div class="icon"><i class="icon-shopping-cart"></i></div>
                            <div class="text">Products Management</div>
                        </a>
                        <ul class="sub-menu">
                            <li class="sub-menu-item">
                                <a href="/dashboard/brands" class="">
                                    <div class="text">Brands</div>
                                </a>
                            </li>

                            <ul class="sub-menu">


                            </ul>
                    </li>
                    <li class="sub-menu-item">
                        <a href="/dashboard/categories" class="">
                            <div class="text">Categories</div>
                        </a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="/dashboard/subcategories" class="">
                            <div class="text">Sub Categories</div>
                        </a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="/dashboard/products" class="">
                            <div class="text">Product</div>
                        </a>
                    </li>

                </ul>
                </li>


                <li class="menu-item has-children">
                    <a href="javascript:void(0);" class="menu-item-button">
                        <div class="icon"><i class="icon-file-plus"></i></div>
                        <div class="text">Order</div>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="/dashboard/orders" class="">
                                <div class="text">Orders</div>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="/dashboard/order-tracking" class="">
                                <div class="text">Order Tracking</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item">
                    <a href="{{ route('slider.index') }}" class="">
                        <div class="icon"><i class="icon-image"></i></div>
                        <div class="text">Slider</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="/dashboard/coupons" class="">
                        <div class="icon"><i class="icon-grid"></i></div>
                        <div class="text">Coupons</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/dashboard/users" class="">
                        <div class="icon"><i class="icon-user"></i></div>
                        <div class="text">Users</div>
                    </a>
                </li>

                <li class="menu-item has-children">
                    <a href="javascript:void(0);" class="">
                        <div class="icon"><i class="icon-settings"></i></div>
                        <div class="text">Settings</div>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="/dashboard/company" class="">
                                <div class="text">Company</div>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="/dashboard/shipping" class="">
                                <div class="text">Shipping Details</div>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="/dashboard/tax" class="">
                                <div class="text">Tax</div>
                            </a>
                        </li>
                    </ul>
                </li>
                </ul>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.menu-item > a, .sub-menu-item > a');

    menuLinks.forEach(link => {
        const linkPath = link.getAttribute('href');

        // Activate the exact link
        if(currentPath === linkPath) {
            link.parentElement.classList.add('active');

            // Recursively activate all parent menus
            let parentMenu = link.closest('.has-children');
            while(parentMenu) {
                parentMenu.classList.add('active');
                parentMenu = parentMenu.parentElement.closest('.has-children');
            }
        }
    });
});
</script>


<style>
    .menu-item.has-children .sub-menu {
        display: none;
        transition: max-height 0.3s ease;
        overflow: hidden;
    }

    .menu-item.has-children.active .sub-menu {
        display: block;
    }
</style>


</html>
