<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// route if unauthorized============================================================================================================
Route::get('unauthorized', function(){
    return view('auth.unauthorized');
})->name('unauthorized');
// route not found============================================================================================================
Route::fallback(function(){
    return response()->view('auth.404', [], 404);
});

// route authentikasi============================================================================================================
Route::middleware('guest')->group(function(){
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('dologin', [AuthController::class,'dologin'])->name('dologin');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('role:Admin')->group(function(){
    Route::get("dashboard", [DashboardController::class, 'index'])->name('dashboard');

    // data buku
    Route::get('books', [BukuController::class, 'index'])->name('book.index');
    Route::get('books-data', [BukuController::class, 'data'])->name('books.data');


    // kategori buku
    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category-data', [CategoryController::class, 'data'])->name('category.data');
    Route::post('category-store', [CategoryController::class, 'store'])->name('category.store');
    Route::post('category-show', [CategoryController::class, 'show'])->name('category.show');
    Route::post('category-update', [CategoryController::class, 'update'])->name('category.update');
    Route::post('category-delete', [CategoryController::class, 'destroy'])->name('category.delete');
    // publisher
    Route::get('publisher', [PublisherController::class, 'index'])->name('publisher.index');
    Route::get('publisher-data', [PublisherController::class, 'data'])->name('publisher.data');
    Route::post('publisher-store', [PublisherController::class, 'store'])->name('publisher.store');
    Route::post('publisher-pid', [PublisherController::class, 'show'])->name('publisher.show');
    Route::post('publisher-update', [PublisherController::class, 'update'])->name('publisher.update');
    Route::post('publisher-delete', [PublisherController::class, 'destroy'])->name('publisher.delete');
    // member
    Route::get('member', [MemberController::class, 'index'])->name('member.index');
    Route::get('member-data', [MemberController::class, 'data_member'])->name('member.data');
    Route::post('member-store', [MemberController::class, 'store'])->name('member.store');
    Route::post('member-show', [MemberController::class, 'show'])->name('member.show');
    Route::post('member-update', [MemberController::class, 'update'])->name('member.update');
    Route::post('member-delete', [MemberController::class, 'destroy'])->name('member.delete');
    // buku
    Route::get('buku', [BukuController::class, 'index'])->name('buku.index');

    // administrator
    Route::get('administrator', [UserController::class, 'index'])->name('administrator');
    Route::get('admin-data', [UserController::class, 'data_user'])->name('data.admin');
    Route::post('admin-store', [UserController::class, 'store'])->name('user_store');
    Route::post('admin-id', [UserController::class, 'user_id'])->name('user_id');
    Route::post('admin-update', [UserController::class, 'user_update'])->name('user_update');
    Route::post('admin-delete', [UserController::class, 'delete_user'])->name('delete_user');

    // settings up
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('settings-create', [SettingController::class, 'create'])->name('settings.create');
    Route::post('settings-store', [SettingController::class, 'store'])->name('settings.store');
    Route::get('settings-edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('settings-update', [SettingController::class, 'update'])->name('settings.update');
});
