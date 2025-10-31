<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Product\Index as ProductIndex;
use App\Livewire\Pos\Index as PosIndex;
use App\Livewire\Order\Index as OrderIndex;
use App\Livewire\Employees\Index as EmployeeIndex;
use App\Livewire\StockOpname\Index as StockOpnameIndex;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::get('employees', EmployeeIndex::class)
        ->name('employees');

    Route::get('pos', PosIndex::class)
        ->name('pos');

    Route::get('/products', ProductIndex::class)
        ->name('products');

    Route::get('/orders', OrderIndex::class)
        ->name('orders');

    Route::get('/stockopname', StockOpnameIndex::class)
        ->name('stockopname');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__ . '/auth.php';
