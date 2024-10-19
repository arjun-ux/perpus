<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReturnsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Service\BukuService;
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

    // laporan
    Route::get('laporan', [DashboardController::class, 'laporan'])->name('laporan.index');
    Route::post('print-laporan-by-tgl-peminjaman', [DashboardController::class, 'by_tgl_peminjaman'])->name('by_tgl_peminjaman');
    Route::post('print-laporan-by-tgl-pengembalian', [DashboardController::class, 'by_tgl_pengembalian'])->name('by_tgl_pengembalian');
    Route::post('print-laporan-by-member', [DashboardController::class, 'by_member'])->name('by_member');
    Route::get('cari-member', [DashboardController::class, 'cari_member'])->name('cari_member');
    // pengembalian
    Route::get('pengembalian', [ReturnsController::class, 'create'])->name('returns.create');
    Route::post('pengembalian', [ReturnsController::class, 'get_borrow'])->name('returns.borrow');
    Route::post('pengembalian-store', [ReturnsController::class, 'store'])->name('pengembalian.store');
    // peminjaman
    Route::get('borrow-index', [BorrowController::class, 'index'])->name('borrow.index');
    Route::get('borrow-data', [BorrowController::class, 'data'])->name('borrow.data');
    Route::get('borrow-create', [BorrowController::class, 'create'])->name('borrow.create');
    Route::post('borrow-member', [BorrowController::class, 'cek_member_borrowing'])->name('cek_member_borrowing');
    Route::get('borrow-data-buku', [BorrowController::class, 'getBooks'])->name('getBooks');
    Route::post('borrow-store', [BorrowController::class, 'store'])->name('borrow.store');
    // data buku
    Route::get('books', [BukuController::class, 'index'])->name('book.index');
    Route::get('books-data', [BukuController::class, 'data'])->name('books.data');
    Route::post('books-store', [BukuController::class, 'store'])->name('book.store');
    Route::post('books-show', [BukuController::class, 'show'])->name('book.show');
    Route::post('books-update', [BukuController::class, 'update'])->name('books.update');
    Route::post('books-delete', [BukuController::class, 'destroy'])->name('book.delete');
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
    Route::post('settings-reset', [SettingController::class, 'reset'])->name('settings.reset');
});
