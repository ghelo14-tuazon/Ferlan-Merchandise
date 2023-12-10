<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

   
Route::get('/stafflogin', [StaffLoginController::class, 'showLoginForm'])->name('staff.login');
Route::post('/stafflogin', [StaffLoginController::class, 'login']);
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');

Route::group(['prefix' => 'staff', 'middleware' => ['auth', 'staff']], function () {
 // ... other staff routes ...

 // Banner routes
 Route::resource('banners', 'StaffBannerController'); 
 Route::resource('category', 'StaffCategoryController'); 
 Route::post('/category/{id}/child', 'StaffCategoryController@getChildByParent');
 Route::resource('categories', StaffCategoryController::class)->names([
     'update' => 'categories.update',
 ]);
 Route::resource('/product', 'StaffProductController');
 // Add other banner routes as needed
 // ...
 Route::resource('/shipping', 'StaffShippingController');
 Route::resource('/order', 'StaffOrderController');

 // Coupon
 Route::resource('/coupon', 'StaffCouponController');
 Route::get('/notification/{id}', [StaffNotificationController::class, 'show'])->name('staff.notification');
 Route::get('/notifications', [StaffNotificationController::class, 'index'])->name('all.notification');
 Route::delete('/notification/{id}', [StaffNotificationController::class, 'delete'])->name('notification.delete');
});
