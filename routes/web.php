<?php

use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebView\BuyController;
use App\Http\Controllers\WebView\CartController;
use App\Http\Controllers\WebView\HomeController;
use App\Http\Controllers\WebView\ShopController;
use App\Http\Controllers\DashBoard\TaxController;
use App\Http\Controllers\WebView\SearchController;
use App\Http\Controllers\DashBoard\BrandController;
use App\Http\Controllers\DashBoard\OrderController;
use App\Http\Controllers\WebView\WebViewController;
use App\Http\Controllers\DashBoard\CouponController;
use App\Http\Controllers\DashBoard\ReviewController;
use App\Http\Controllers\DashBoard\SliderController;
use App\Http\Controllers\DashBoard\CompanyController;
use App\Http\Controllers\DashBoard\ProductController;
use App\Http\Controllers\DashBoard\CategoryController;
use App\Http\Controllers\DashBoard\ShippingController;
use App\Http\Controllers\DashBoard\DashboardController;
use App\Http\Controllers\DashBoard\SubCategoryController;
use App\Http\Controllers\DashBoard\EsewaPaymentController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::middleware(['auth', AuthAdmin::class])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/users', fn() => view('dashboard.pages.users.users'))->name('users');
    Route::resource('/slider', SliderController::class);
    Route::get('/add-product', fn() => view('dashboard.pages.products.add-product'))->name('add_product');
    Route::get('/add-brand', fn() => view('dashboard.pages.brands.add-brand'))->name('add_brand');
    Route::get('/add-subcategories', fn() => view('dashboard.pages.sub-categories.add-subcategory'))->name('add-subcategory');
    Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
    Route::get('/order-details/{id}', [OrderController::class, 'order_details'])->name('orders.details');
    Route::get('/orders/{id}/status', [OrderController::class, 'showOrderStatusUpdateForm'])->name('order.status.update.form');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateOrderStatus'])->name('order.status.update');
    Route::get('/order-tracking', fn() => view('dashboard.pages.orders.order-tracking'))->name('order_tracking');
    Route::get('/subcategories', fn() => view('dashboard.pages.sub-categories.subcategories'))->name('sub-categories');
    Route::get('/brands', fn() => view('dashboard.pages.brands.brands'))->name('brands');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/add-category', fn() => view('dashboard.pages.categories.add-category'))->name('add_category');
    Route::get('/categories', fn() => view('dashboard.pages.categories.categories'))->name('categories');
    Route::resource('/coupons', CouponController::class);
    Route::resource('/shipping', ShippingController::class);
    Route::resource('/company', CompanyController::class);
    Route::resource('/tax', TaxController::class);
    Route::get('/get-subcategories/{categoryId}', [SubCategoryController::class, 'getSubcategoriesByCategory'])->name('get.subcategories');
});

// Only authenticated users can access these routes
Route::middleware(['auth'])->group(function () {
    Route::get('/my-account', [WebViewController::class, 'myaccount'])->name('account.dashboard');
    Route::match(['get', 'post'], '/account/address', [WebViewController::class, 'accountAddress'])->name('account.address');
    Route::get('/account-details', [WebViewController::class, 'accountDetails'])->name('account.details');
    Route::get('/account_order', [WebViewController::class, 'accountOrder'])->name('account.orders');
    Route::get('/account-orders-details/{id}', [WebViewController::class, 'accountOrderDetails'])->name('account.orders.details');
    Route::get('/contact', [WebViewController::class, 'contact'])->name('contact');
    Route::get('/order-confirmation/{order_id}', [OrderController::class, 'orderConfirm'])->name('order.confirmation');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addcart'])->name('cart.add');
    Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increasequantity'])->name('cart.qty.increase');
    Route::put('/cart/decrease-quantity/{rowId}', [CartController::class, 'decreasequantity'])->name('cart.qty.decrease');
    Route::delete('/cart/remove/{rowId}', [CartController::class, 'removeitem'])->name('cart.item.remove');
    Route::delete('/cart/clear', [CartController::class, 'emptycart'])->name('cart.empty');
    Route::post('/cart/apply-coupon', [CouponController::class, 'applycoupon'])->name('cart.coupon.apply');
    Route::delete('/cart/remove-coupon', [CartController::class, 'remove'])->name('cart.coupon.remove');


    Route::post('/place-an-order', [OrderController::class, 'placeorder'])->name('place.order');
    Route::post('/buy-now', [BuyController::class, 'buyNow'])->name('buy.now');
    Route::get('/buy-now', [BuyController::class, 'buyNow'])->name('buy.now');
    Route::get('/product/{id}', [CartController::class, 'showProduct'])->name('show_product');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.page');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

    Route::post('/update-buyitem-quantity', [CartController::class, 'updateQuantity'])->name('buyitem.updateQuantity');
    Route::get('/payment/form', [EsewaPaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/esewa', [EsewaPaymentController::class, 'submitToEsewa'])->name('esewa');
    Route::get('/payment/success', [EsewaPaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/failure', [EsewaPaymentController::class, 'paymentFailure'])->name('payment.failure');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/wiselist', [BuyController::class, 'wiselist'])->name('wiselist');
    Route::delete('/wish/clear/{id}', [BuyController::class, 'removewise'])->name('remove.wise');
    Route::delete('/wishlist/clear', [BuyController::class, 'emptywise'])->name('empty.wise');
    Route::put('/wishlist/increase-quantity/{rowId}', [BuyController::class, 'increasebuyquantity'])->name('buy.qty.increase');
    Route::put('/wishlist/decrease-quantity/{rowId}', [BuyController::class, 'decreasebuyquantity'])->name('buy.qty.decrease');
    Route::resource('wise', BuyController::class);
    Route::delete('/cart/remove-coupon', [CouponController::class, 'remove'])->name('cart.coupon.remove');
});

Route::get('/product.{slug}', [ProductController::class, 'showBySubCategory'])->name('products.bySubCategory');
Route::resource('brands', BrandController::class);
Route::resource('categories', CategoryController::class);
Route::get('/get-subcategories/{categoryId}', [SubCategoryController::class, 'getSubcategoriesByCategory'])->name('get.subcategories');
Route::resource('sub-categories', SubCategoryController::class);
Route::get('products/{slug}', [ProductController::class, 'detail'])->name('product-detail');
Route::resource('products', ProductController::class);
// Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
Route::get('/password-reset', [WebViewController::class, 'user_passwordreset'])->name('password.reset');
Route::get('/about', [WebViewController::class, 'about'])->name('home.about');/*  */
Route::get('/order/{id}/pdf', [OrderController::class, 'downloadPDF'])->name('order.pdf');
Route::get('/products/{id}/variants', [ProductController::class, 'getVariants']);
Route::get('/search', [SearchController::class, 'globalSearch'])->name('global.search');


// SHOP ROUTES
Route::prefix('shop')->group(function () {
    Route::get('/', [ShopController::class, 'shop'])->name('shop');
    Route::get('/brand/{brand:slug}', [ShopController::class, 'shop'])->name('shop.brand');
    Route::get('/category/{category:slug}', [ShopController::class, 'shop'])->name('shop.category');
    Route::get('/category/{category:slug}/subcategory/{subcategory:slug?}', [ShopController::class, 'shop'])->name('shop.subcategory');
    Route::get('/category/{category:slug}/subcategory/{subcategory:slug}', [ShopController::class, 'shop'])->name('shop.subcategory');
    Route::get('/category/{category:slug}/subcategory/{subcategory:slug}/color/{color?}', [ShopController::class, 'shop'])->name('shop.subcategory.color');
    Route::get('/category/{category:slug}/subcategory/{subcategory:slug}/size/{size?}', [ShopController::class, 'shop'])->name('shop.subcategory.size');
    Route::get('/category/{category:slug}/subcategory/{subcategory:slug}/brand/{brand:slug}', [ShopController::class, 'shop'])->name('shop.subcategory.brand');
    Route::get('/category/{category:slug}/subcategory/{subcategory:slug}/price/{price?}', [ShopController::class, 'shop'])->name('shop.subcategory.price');
    Route::get('/hot-deals', [HomeController::class, 'hotdeal'])->name('shop.hot-deals');
    Route::get('/featured', [HomeController::class, 'featured'])->name('shop.featured');
    Route::get('/all', [ShopController::class, 'allshop'])->name('shop.allshop');
    Route::get('/brand/{brand:slug}', [HomeController::class, 'showProductsByBrand'])->name('shop-by-brand');
    Route::get('/new-arrivals', [HomeController::class, 'newarrival'])->name('shop.new-arrivals');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
