<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// route if unauthorized
Route::get('unauthorized', function(){
    return view('auth.unauthorized');
})->name('unauthorized');


// route authentikasi
Route::middleware('guest')->group(function(){
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('dologin', [AuthController::class,'dologin'])->name('dologin');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// route admin dan pembina
Route::middleware('role:dev,admin,pembina')->group(function(){
    Route::prefix('sistem')->group(function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');

        // data santri
        Route::get('santri', [SantriController::class, 'index_admin'])->name('index_admin');
        Route::get('santri-data', [SantriController::class, 'data_santri'])->name('data_santri');


        // mitra
        Route::get('mitra', [MitraController::class,'index_admin_mitra'])->name('index_admin_mitra');
        Route::get('mitra-data', [MitraController::class, 'data_mitra'])->name('data_mitra');

    })->middleware('auth');

});


// route hanya admin saja
Route::middleware('role:admin,dev')->group(function(){
    Route::prefix('admin')->group(function(){
        // setting
        Route::get('settings', function(){
            return view('admin.settings.index');
        })->name('settings.index');
        // user
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users-data', [UserController::class, 'data_user'])->name('data.user');
        Route::post('uses-edit', [UserController::class, 'user_id'])->name('user_id');
        Route::post('users-update', [UserController::class, 'user_update'])->name('user_update');

        // sesion login
        Route::get('session', [UserController::class, 'sesi'])->name('sesi');
        Route::get('data-sesi', [UserController::class, 'data_sesi'])->name('data_sesi');
        Route::post('delete-sesi', [UserController::class, 'delete_sesi'])->name('delete_sesi');

    })->middleware('auth');
});

// route untuk pembina
Route::middleware('role:pembina,dev')->group(function(){
    Route::prefix('pembina')->group(function(){
        //
    })->middleware('auth');
});




// route untuk santri
Route::middleware('role:santri,dev')->group(function(){
    // route santri
    Route::prefix('santri')->group(function(){
        // dashboard santri
        Route::get('/', function(){
            return view('santri.dashboard');
        })->name('santri.dashboard');

    })->middleware('auth');

});

// route untuk mitra
Route::middleware('role:mitra,dev')->group(function(){
    Route::prefix('mitra')->group(function(){
        // dashboard mitra
        Route::get('/', function(){
            return view('mitra.dashboard');
        })->name('mitra.dashboard');
    })->middleware('auth');
});
