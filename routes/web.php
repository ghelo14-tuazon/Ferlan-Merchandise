<?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Artisan;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\StaffController;
    use App\Http\Controllers\SalesController;
    use App\Http\Controllers\Staff\BannerController;
    use App\Http\Controllers\ProductsController;
    use App\Http\Controllers\StaffLoginController;
    use App\Http\Controllers\StaffOrderController;
    use App\Http\Controllers\ProductInquiryController;
    use App\Http\Controllers\FrontendController;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\WishlistController;
    use App\Http\Controllers\WalkinSaleController;
    use App\Http\Controllers\OrderController;
    use App\Http\Controllers\ProductReviewController;
    use App\Http\Controllers\CouponController;
    use App\Http\Controllers\NotificationController;
    use App\Http\Controllers\StaffNotificationController;
    use App\Http\Controllers\StaffCateoryController;
    use App\Http\Controllers\HomeController;
    use \UniSharp\LaravelFilemanager\Lfm;
    use App\Http\Controllers\Auth\LoginStaffController;
    

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
   // web.php


// routes/web.php



Route::middleware(['auth.staff'])->group(function () {
    Route::get('/staff/index', [StaffLoginController::class, 'index'])->name('staff.index');
});

Route::get('/staff/login', [StaffLoginController::class, 'showLoginForm'])->name('staff.login');
Route::post('/staff/login', [StaffLoginController::class, 'login']);

    

    Route::group(['prefix' => 'staff', 'middleware' => ['auth', 'admin']], function () {
        Route::resource('product', 'StaffProductController')->names([
            'index' => 'staff.product.index',
            'create' => 'staff.product.create',
            'store' => 'staff.product.store',
            'show' => 'staff.product.show',
            'edit' => 'staff.product.edit',
            'update' => 'staff.product.update',
            'destroy' => 'staff.product.destroy',
        ]);
        // Add other banner routes as needed
        // ...
        Route::resource('/shipping', 'StaffShippingController')->names([
            'index' => 'staff.shipping.index',
            'create' => 'staff.shipping.create',
            'store' => 'staff.shipping.store',
            'show' => 'staff.shipping.show',
            'edit' => 'staff.shipping.edit',
            'update' => 'staff.shipping.update',
            'destroy' => 'staff.shipping.destroy',
        ]);
        
        Route::resource('/order', 'StaffOrderController')->names([
            'index' => 'staff.order.index',
            'create' => 'staff.order.create',
            'store' => 'staff.order.store',
            'show' => 'staff.order.show',
            'edit' => 'staff.order.edit',
            'update' => 'staff.order.update',
            'destroy' => 'staff.order.destroy',
        ]);
        
       
        // Coupon
        Route::resource('/coupon', 'StaffCouponController')->names([
            'index' => 'staff.coupon.index',
            'create' => 'staff.coupon.create',
            'store' => 'staff.coupon.store',
            'show' => 'staff.coupon.show',
            'edit' => 'staff.coupon.edit',
            'update' => 'staff.coupon.update',
            'destroy' => 'staff.coupon.destroy',
        ]);
        // routes/web.php

Route::get('/reset-notifications', 'StaffNotificationController@resetUnreadNotifications')->name('reset.notifications');

        Route::get('/notification/{id}', [StaffNotificationController::class, 'show'])->name('staff.notification');
        Route::get('/notifications', [StaffNotificationController::class, 'index'])->name('staff.all.notification');
        Route::delete('/notification/{id}', [StaffNotificationController::class, 'delete'])->name('notification.delete');
     Route::resource('banners', 'StaffBannerController'); 
    
     Route::post('/category/{id}/child', 'StaffCategoryController@getChildByParent');
     Route::resource('categories', StaffCategoryController::class)->names([
        'index' => 'staff.categories.index',
            'create' => 'staff.categories.create',
            'store' => 'staff.categories.store',
            'show' => 'staff.categories.show',
            'edit' => 'staff.categories.edit',
            'update' => 'staff.categories.update',
            'destroy' => 'staff.categories.destroy',
     ]);
     
 });
 
    // CACHE CLEAR ROUTE
    Route::get('cache-clear', function () {
        Artisan::call('optimize:clear');
        request()->session()->flash('success', 'Successfully cache cleared.');
        return redirect()->back();
    })->name('cache.clear');


    // STORAGE LINKED ROUTE
    Route::get('storage-link',[AdminController::class,'storageLink'])->name('storage.link');


    Auth::routes(['register' => false]);

    Route::get('user/login', [FrontendController::class, 'login'])->name('login.form');
    Route::post('user/login', [FrontendController::class, 'loginSubmit'])->name('login.submit');
    Route::get('user/logout', [FrontendController::class, 'logout'])->name('user.logout');
    
   
    Route::get('user/register', [FrontendController::class, 'register'])->name('register.form');
    Route::post('user/register', [FrontendController::class, 'registerSubmit'])->name('register.submit');
// Reset password
    Route::GET('password-reset', [FrontendController::class, 'showResetForm'])->name('password.reset');
// Socialite
    Route::get('login/{provider}/', [LoginController::class, 'redirect'])->name('login.redirect');
    Route::get('login/{provider}/callback/', [LoginController::class, 'Callback'])->name('login.callback');

    Route::get('/', [FrontendController::class, 'home'])->name('home');

// Frontend Routes
    Route::get('/home', [FrontendController::class, 'index']);
    Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about-us');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    Route::post('/contact/message', [MessageController::class, 'store'])->name('contact.store');
    Route::get('product-detail/{slug}', [FrontendController::class, 'productDetail'])->name('product-detail');
    Route::post('/product/search', [FrontendController::class, 'productSearch'])->name('product.search');
    Route::get('/product-cat/{slug}', [FrontendController::class, 'productCat'])->name('product-cat');
    Route::get('/product-sub-cat/{slug}/{sub_slug}', [FrontendController::class, 'productSubCat'])->name('product-sub-cat');

    Route::get('/add-to-cart/{slug}', [CartController::class, 'addToCart'])->name('add-to-cart')->middleware('user');
    Route::post('/add-to-cart', [CartController::class, 'singleAddToCart'])->name('single-add-to-cart')->middleware('user');
    Route::get('cart-delete/{id}', [CartController::class, 'cartDelete'])->name('cart-delete');
    Route::post('cart-update', [CartController::class, 'cartUpdate'])->name('cart.update');

    Route::get('/cart', function () {
        return view('frontend.pages.cart');
    })->name('cart');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout')->middleware('user');
// Wishlist
    Route::get('/wishlist', function () {
        return view('frontend.pages.wishlist');
    })->name('wishlist');
    Route::get('/wishlist/{slug}', [WishlistController::class, 'wishlist'])->name('add-to-wishlist')->middleware('user');
    Route::get('wishlist-delete/{id}', [WishlistController::class, 'wishlistDelete'])->name('wishlist-delete');
    Route::post('cart/order', [OrderController::class, 'store'])->name('cart.order');
    Route::get('order/pdf/{id}', [OrderController::class, 'pdf'])->name('order.pdf');
    Route::get('/income', [OrderController::class, 'incomeChart'])->name('product.order.income');
    Route::get('/product-grids', [FrontendController::class, 'productGrids'])->name('product-grids');
    Route::get('/product-lists', [FrontendController::class, 'productLists'])->name('product-lists');
    Route::match(['get', 'post'], '/filter', [FrontendController::class, 'productFilter'])->name('shop.filter');
// Order Track
    Route::get('/product/track', [OrderController::class, 'orderTrack'])->name('order.track');
    Route::post('product/track/order', [OrderController::class, 'productTrackOrder'])->name('product.track.order');
// Blog
    //Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
   // Route::get('/blog-detail/{slug}', [FrontendController::class, 'blogDetail'])->name('blog.detail');
   // Route::get('/blog/search', [FrontendController::class, 'blogSearch'])->name('blog.search');
   // Route::post('/blog/filter', [FrontendController::class, 'blogFilter'])->name('blog.filter');
   // Route::get('blog-cat/{slug}', [FrontendController::class, 'blogByCategory'])->name('blog.category');
   // Route::get('blog-tag/{slug}', [FrontendController::class, 'blogByTag'])->name('blog.tag');

// NewsLetter
   // Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');

// Product Review
   // Route::resource('/review', 'ProductReviewController');
   // Route::post('product/{slug}/review', [ProductReviewController::class, 'store'])->name('review.store');


// Coupon
    Route::post('/coupon-store', [CouponController::class, 'couponStore'])->name('coupon-store');
// Payment
    Route::get('payment', [PayPalController::class, 'payment'])->name('payment');
    Route::get('cancel', [PayPalController::class, 'cancel'])->name('payment.cancel');
    Route::get('payment/success', [PayPalController::class, 'success'])->name('payment.success');


// Backend section start

    Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        Route::get('/file-manager', function () {
            return view('backend.layouts.file-manager');
        })->name('file-manager');
        // user route
        Route::resource('users', 'UsersController');
        // Banner
        Route::resource('banner', 'BannerController');
     
        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
        Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');
        // Category
        Route::resource('/category', 'CategoryController');
        // Product
        Route::resource('product', 'ProductsController');
        // Ajax for sub category
        Route::post('/category/{id}/child', 'CategoryController@getChildByParent');
       
        // Order
        Route::resource('/order', 'OrderController');
        // Shipping
        Route::resource('/shipping', 'ShippingController');
        // Coupon
        Route::resource('/coupon', 'CouponController');
        // Settings
        Route::get('settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');

        // Notification
        Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
        Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');
        // Password Change
        Route::get('change-password', [AdminController::class, 'changePassword'])->name('change.password.form');
        Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('change.password');
    });


// User section start
    Route::group(['prefix' => '/user', 'middleware' => ['user']], function () {
        Route::get('/', [HomeController::class, 'index'])->name('user');
        // Profile
        Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');
        Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');
        //  Order
        Route::get('/order', "HomeController@orderIndex")->name('user.index');
        Route::get('/order/show/{id}', "HomeController@orderShow")->name('user.order.show');
        Route::delete('/order/delete/{id}', [HomeController::class, 'userOrderDelete'])->name('user.order.delete');
        // Product Review
        //Route::get('/user-review', [HomeController::class, 'productReviewIndex'])->name('user.productreview.index');
        //Route::delete('/user-review/delete/{id}', [HomeController::class, 'productReviewDelete'])->name('user.productreview.delete');
        //Route::get('/user-review/edit/{id}', [HomeController::class, 'productReviewEdit'])->name('user.productreview.edit');
        //Route::patch('/user-review/update/{id}', [HomeController::class, 'productReviewUpdate'])->name('user.productreview.update');

        //
        // Password Change
        Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
        Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');

    });

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        Lfm::routes();
    });
   // routes/web.php

   Route::get('/salesreport', [SalesController::class, 'index'])->name('salesreport.index');

   // routes/web.php

use App\Http\Controllers\SalesForecastController;

Route::get('/salesforecast', [SalesForecastController::class, 'index'])->name('salesforecast.index');

   




Route::get('/daily-sales', [StaffOrderController::class, 'dailySales'])->name('dailySales');
Route::post('/update-daily-sales', [StaffOrderController::class, 'updateDailySales'])->name('updateDailySales');Route::get('staff/order/{id}/receipt', 'StaffOrderController@generateReceipt')->name('staff.order.receipt');
Route::get('receipt/generate/{id}', 'StaffOrderController@generatePdf')->name('receipt.generate');


Route::get('/product-inventory', 'StaffOrderController@productInventory')->name('product.inventory');
// routes/web.php
Route::put('/product/{id}/add-stock', [ProductsController::class, 'addStock'])->name('product.addStock');
Route::post('/product/inquiry', [ProductInquiryController::class, 'submit'])->name('product.inquiry.submit');



use App\Http\Controllers\StaffInquiryController;

Route::middleware(['auth', 'admin'])->group(function () {
    // Add middleware as per your authentication and staff verification requirements

    Route::get('/staff/inquiries', [StaffInquiryController::class, 'index'])->name('staff.inquiries');
    Route::post('/staff/inquiry/reply/{id}', [StaffInquiryController::class, 'reply'])->name('staff.inquiry.reply');
});
Route::get('/product/{id}/stock-history', 'ProductsController@stockHistory')->name('product.stockHistory');


Route::get('/products/{id}/stock-history', [ProductsController::class, 'stockHistory'])->name('products.stockHistory');

Route::get('/daily-sales-history', [SalesController::class, 'dailySalesHistory'])->name('dailySalesHistory');
// routes/web.php
Route::post('product/{slug}/review', 'ProductReviewUserController@store')->name('product.review.store');

Route::get('/walkthrough-sale', [ProductsController::class, 'walkthroughSaleView']);
Route::post('/process-sale', [ProductsController::class, 'processSale']);
Route::get('/walkin-sales', 'ProductsController@showWalkinSales')->name('walkin-sales.index');

Route::get('/inventory', [ProductsController::class, 'showInventory'])->name('product.inventory');

// routes/web.php

// routes/web.php

Route::get('/download-receipt', 'ProductsController@downloadReceipt')->name('downloadReceipt');

// In your routes/web.php file
Route::delete('/product/review/{id}', 'ProductReviewUserController@deleteReview')->name('product.review.delete');


Route::get('/yearly-sales', [SalesController::class, 'yearly_sales'])->name('yearly.sales');
// routes/web.php
Route::delete('/staff/inquiry/{id}/delete', 'ProductInquiryController@deleteInquiry')->name('staff.inquiry.delete');
Route::get('storage-link',[AdminController::class,'storageLink'])->name('storage.link');
Route::get('/my-name', [SalesController::class, 'myname'])->name('myname');
Route::post('/my-name', 'SalesController@processForm');
// routes/web.php
// routes/web.php

Route::post('/user/order/cancel', 'OrderController@ajaxCancel')->name('user.order.ajaxCancel');
