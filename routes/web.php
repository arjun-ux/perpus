<?php

use App\Http\Controllers\AsramaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PembinaController;
use App\Http\Controllers\SantriController;
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
// route admin dan pembina============================================================================================================
Route::middleware('role:dev,admin,pembina')->group(function(){
    Route::prefix('sistem')->group(function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');

        // data santri============================================================================================================
        Route::get('santri', [SantriController::class, 'index_admin'])->name('index_admin');
        Route::get('santri-data', [SantriController::class, 'data_santri'])->name('data_santri');


        // mitra============================================================================================================
        Route::post('mitra-get', [MitraController::class, 'getMitra'])->name('getMitra');
        Route::get('mitra', [MitraController::class,'index_admin_mitra'])->name('index_admin_mitra');
        Route::get('mitra-data', [MitraController::class, 'data_mitra_admin'])->name('data_mitra_admin');
        Route::post('mitra-store', [MitraController::class, 'store_mitra_admin'])->name('store_mitra_admin');
        Route::post('mitra-update', [MitraController::class, 'update_mitra'])->name('update_mitra');
        Route::post('mitra-delete', [MitraController::class, 'delete_mitra'])->name('delete_mitra');
        Route::get('donwload-mitra', [MitraController::class, 'download_mitra'])->name('download_mitra');
    })->middleware('auth');

});

// route hanya admin saja============================================================================================================
Route::middleware('role:admin,dev')->group(function(){
    Route::prefix('admin')->group(function(){
        // setting============================================================================================================
        Route::get('settings', function(){
            return view('admin.settings.index');
        })->name('settings.index');
        // user============================================================================================================
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users-data', [UserController::class, 'data_user'])->name('data.user');
        Route::post('user-edit', [UserController::class, 'user_id'])->name('user_id');
        Route::post('users-update', [UserController::class, 'user_update'])->name('user_update');
        Route::post('users-delete', [UserController::class, 'delete_user'])->name('delete_user');

        // pembina============================================================================================================
        Route::post('pembina-get',[PembinaController::class, 'getId'])->name('pembina.getid');
        Route::get('pembina', [PembinaController::class, 'index'])->name('pembina.index');
        Route::get('pembina-data', [PembinaController::class, 'data_pembina'])->name('pembina.data');
        Route::post('pembina-store', [PembinaController::class, 'store'])->name('pembina.store');
        Route::post('pembina-update', [PembinaController::class, 'update'])->name('pembina.update');
        Route::post('pembina-delete',[PembinaController::class, 'delete'])->name('pembina.delete');

        //  asrama============================================================================================================
        Route::post('asrama-get', [AsramaController::class, 'getId'])->name('asrama.id');
        Route::get('asrama', [AsramaController::class, 'index'])->name('asrama.index');
        Route::get('asrama-data', [AsramaController::class, 'dataAsrama'])->name('asrama.data');
        Route::post('asrama-simpan', [AsramaController::class, 'simpan_asrama'])->name('asrama.store');
        Route::post('asrama-update', [AsramaController::class, 'update_asrama'])->name('update.asrama');
        Route::post('asrama-delete', [AsramaController::class, 'delete_asrama'])->name('asrama.delete');

        // sesion login============================================================================================================
        Route::post('magang-get', [MagangController::class, 'getId'])->name('magang.id');
        Route::get('magang', [MagangController::class, 'index'])->name('magang.index');
        Route::get('magang-data', [MagangController::class, 'data'])->name('magang.data');
        Route::post('magang-store', [MagangController::class, 'magang_store'])->name('magang.store');
        Route::post('magang-update', [MagangController::class, 'magang_update'])->name('magang.update');
        Route::post('magang-delete', [MagangController::class, 'magang_delete'])->name('magang.delete');

        // sesion login============================================================================================================
        Route::get('session', [UserController::class, 'sesi'])->name('sesi');
        Route::get('data-sesi', [UserController::class, 'data_sesi'])->name('data_sesi');
        Route::post('delete-sesi', [UserController::class, 'delete_sesi'])->name('delete_sesi');

    })->middleware('auth');
});

// route untuk pembina============================================================================================================
Route::middleware('role:pembina,dev')->group(function(){
    Route::prefix('pembina')->group(function(){
        // dashboard pembina ikut role admin & pembina diatas============================================================================================================
    })->middleware('auth');
});




// route untuk santri============================================================================================================
Route::middleware('role:santri,dev')->group(function(){
    // route santri
    Route::prefix('santri')->group(function(){
        // dashboard santri============================================================================================================
        Route::get('/', function(){
            return view('santri.dashboard');
        })->name('santri.dashboard');
        Route::get('profile', [AuthController::class, 'profile'])->name('profile.santri');

    })->middleware('auth');

});

// route untuk mitra============================================================================================================
Route::middleware('role:mitra,dev')->group(function(){
    Route::prefix('mitra')->group(function(){
        // dashboard mitra============================================================================================================
        Route::get('/', function(){
            return view('mitra.dashboard');
        })->name('mitra.dashboard');
        Route::get('profile', [AuthController::class, 'profile'])->name('profile.mitra');
    })->middleware('auth');
});
