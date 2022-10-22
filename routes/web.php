<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

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

// Home routes
Route::controller(Controllers\HomeController::class)->group(function() {
    Route::get('/', 'landing')->middleware(['guest'])->name('landing');
    Route::get('/language/{locale}', 'language')->name('language');
    Route::get('/document/{document}', 'document')->name('document');
});

require __DIR__ . '/auth.php';

// Admin panel ("/admin/*")
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function() {
    Route::get('/', Controllers\Admin\PanelController::class)->name('admin');
    Route::get('/alert', Controllers\Admin\AlertController::class)->name('admin.alert');

    Route::controller(Controllers\Admin\UserProfileController::class)->group(function() {
        Route::get('/user/profile', 'view')->name('admin.user.profile');
        Route::post('/user/profile', 'load');
    });

    Route::controller(Controllers\Admin\PermissionsController::class)->group(function() {
        Route::get('/permissions', 'view')->name('admin.permissions');
        Route::post('/permissions', 'store');
    });

    Route::prefix('game-server')->group(function() {
        Route::controller(Controllers\Admin\GameServerController::class)->group(function() {
            Route::get('/state', 'state');
            Route::get('/all', 'all')->name('admin.game-server.all');
            Route::get('/create', 'store')->name('admin.game-server.create');
            Route::get('/{id}', 'view')->name('admin.game-server.view');
            Route::get('/{id}/manage', 'manage')->name('admin.game-server.manage');
            Route::post('/{id}/logs', 'logs');
        });
    });

    Route::prefix('ban')->group(function () {
        Route::get('/', Controllers\Admin\BanController::class)->name('admin.ban');
        Route::get('/ip', Controllers\Admin\IpAddressBanController::class)->name('admin.ban.ip');
        Route::post('/information', Controllers\Admin\BanInformationController::class);
    });

    Route::controller(Controllers\Admin\ActionLogController::class)->group(function() {
        Route::get('/log', 'view')->name('admin.action-log');
    });
});

// Authenticated Features ("/my/*", "/discord/*", etc)
Route::middleware(['auth'])->group(function() {
    Route::get('/heartbeat', [Controllers\Account\SettingsController::class, 'heartbeat']);

    if (config('tadah.discord_required'))
    {
        Route::controller(Controllers\Account\DiscordController::class)->prefix('discord')->group(function() {
            Route::get('/callback', 'callback')->name('account.discord.callback');
            Route::get('/link', 'redirect')->name('account.discord.redirect');
            Route::get('/unlink', 'unlink')->name('account.discord.unlink');
        });
    }

    Route::prefix('my')->group(function() {
        Route::get('/dashboard', Controllers\Account\DashboardController::class)->name('dashboard');
        Route::post('/revoke-session', Controllers\Account\SessionController::class);

        Route::controller(Controllers\Account\SettingsController::class)->group(function() {
            Route::get('/account', 'view')->name('account');
            Route::get('/update-email', 'updateEmail')->middleware('password.confirm')->name('account.email.update');
            Route::post('/update-email', 'updateEmail')->middleware('password.confirm');
        });

        Route::controller(Controllers\Account\InviteKeyController::class)->group(function() {
            Route::get('/invites', 'view')->name('invites');
            Route::post('/invites', 'purchase');
        });
    });

    // Ban note
    Route::controller(Controllers\Account\DisabledAccountController::class)->group(function() {
        Route::get('/disabled', 'view')->name('account.disabled');
        Route::post('/disabled/unban', 'store')->name('account.unban');
    });
});

// Games ("/games/*")
Route::middleware(['auth'])->group(function() {
    Route::prefix('games')->group(function() {
        Route::get('/', [Controllers\GamesController::class, 'list'])->name('games');
    });

    Route::prefix('develop')->group(function() {
        Route::get('/', [Controllers\DevelopController::class, 'index'])->name('develop');
    });
});

// Catalog ("/catalog/*")
Route::prefix('catalog')->middleware(['auth'])->group(function() {
    Route::get('/', [Controllers\CatalogController::class, 'index'])->name('catalog');
    Route::get('/{id}', [Controllers\ItemController::class, 'view'])->name('item.view');
    Route::get('/{id}/configure', [Controllers\ItemController::class, 'configure'])->name('item.configure');
});

// Users ("/users/*", "/people")
Route::middleware(['auth'])->group(function() {
    Route::get('/people', [Controllers\UsersController::class, 'list'])->name('users');

    Route::prefix('users')->group(function() {
        Route::get('/{id}/profile', [Controllers\UsersController::class, 'profile'])->name('users.profile');
    });
});

// Forums ("/forum/*")
Route::prefix('forum')->middleware(['auth'])->group(function() {
    Route::get('/', [Controllers\ForumController::class, 'index'])->name('forum');
    Route::get('/category/{id}', [Controllers\ForumController::class, 'category'])->name('forum.category');
    Route::get('/thread/{id}', [Controllers\ForumController::class, 'thread'])->name('forum.thread');
});
