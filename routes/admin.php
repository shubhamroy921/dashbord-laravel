<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemsController;
use App\Http\Controllers\Admin\PageBuilderController;
use App\Http\Controllers\Admin\ProductCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;

# dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

#products
Route::post('products/update-status', [ProductController::class, 'updateStatus'])->name('products.updateStatus');
Route::post('products/reorder', [ProductController::class, 'reorder'])->name('products.reorder');
Route::resource('products', ProductController::class);

#categories
Route::post('categories/update-status', [ProductCategoryController::class, 'updateStatus'])->name('categories.updateStatus');
Route::post('categories/reorder', [ProductCategoryController::class, 'reorder'])->name('categories.reorder');
Route::resource('product/categories', ProductCategoryController::class);

#sub-category
Route::prefix('sub-category')->name('subcategory.')->group(function () {
    Route::post('reorder', [SubCategoryController::class, 'reorder'])->name('reorder');
    Route::post('update-status', [SubCategoryController::class, 'updateStatus'])->name('updateStatus');
    Route::get('{category}/index', [SubCategoryController::class, 'index'])->name('index');
    Route::get('{category}/create', [SubCategoryController::class, 'create'])->name('create');
    Route::get('edit/{category}/{subcategory}', [SubCategoryController::class, 'edit'])->name('edit');
    Route::post('store', [SubCategoryController::class, 'store'])->name('store');
    Route::put('{subcategory}/update', [SubCategoryController::class, 'update'])->name('update');
    Route::delete('{subcategory}/destroy', [SubCategoryController::class, 'destroy'])->name('destroy');
});

/** Setting Routes */
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::put('/general-setting', [SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');
Route::put('/pusher-setting', [SettingController::class, 'UpdatePusherSetting'])->name('pusher-setting.update');
Route::put('/mail-setting', [SettingController::class, 'UpdateMailSetting'])->name('mail-setting.update');
Route::put('/email-setting', [SettingController::class, 'UpdateEmailSetting'])->name('email-setting.update');
Route::put('/logo-setting', [SettingController::class, 'UpdateLogoSetting'])->name('logo-setting.update');
Route::put('/appearance-setting', [SettingController::class, 'UpdateAppearanceSetting'])->name('appearance-setting.update');
Route::put('/seo-setting', [SettingController::class, 'UpdateSeoSetting'])->name('seo-setting.update');
Route::put('/footer-setting', [SettingController::class, 'UpdateFooterSetting'])->name('footer-setting.update');

# email templates
Route::resource('email-templates', EmailTemplateController::class);
# menu
Route::resource('menu', MenuController::class);
Route::post('menu/reorder', [MenuController::class, 'reorder'])->name('menu.reorder');
Route::post('menu/update-status', [MenuController::class, 'updateStatus'])->name('menu.updateStatus');

#sub-menu
Route::prefix('menuitems')->name('menuitems.')->group(function () {
    Route::post('reorder', [MenuItemsController::class, 'reorder'])->name('reorder');
    Route::post('update-status', [MenuItemsController::class, 'updateStatus'])->name('updateStatus');
    Route::get('{menu}/index', [MenuItemsController::class, 'index'])->name('index');
    Route::get('{menu}/create', [MenuItemsController::class, 'create'])->name('create');
    Route::get('edit/{menu}/{menuitems}', [MenuItemsController::class, 'edit'])->name('edit');
    Route::post('store', [MenuItemsController::class, 'store'])->name('store');
    Route::put('{menuitems}/update', [MenuItemsController::class, 'update'])->name('update');
    Route::delete('{menuitems}/destroy', [MenuItemsController::class, 'destroy'])->name('destroy');
});

Route::get('billing', function () {
    return view('billing');
})->name('billing');


Route::resource('pages', PageBuilderController::class);
// Route::post('pages/reorder', [PageBuilderController::class, 'reorder'])->name('pages.reorder');
Route::post('pages/update-status', [PageBuilderController::class, 'updateStatus'])->name('pages.updateStatus');
Route::get('user/index', [UserController::class, 'index'])->name('user.index');
Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::put('user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::get('user/create', [UserController::class, 'create'])->name('user.create');
Route::post('user/store', [UserController::class, 'store'])->name('user.store');
Route::get('user/reset-password/{id}', [UserController::class, 'resetPasswordForm'])->name('user.reset-password-form');
Route::put('user/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.reset-password');
