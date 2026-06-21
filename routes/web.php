<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', \App\Http\Middleware\CheckRole::class.':admin'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('tickets', 'tickets.index')
    ->middleware(['auth', 'verified'])
    ->name('tickets.index');

Route::get('/tickets/create', \App\Livewire\Tickets\TicketForm::class)
    ->middleware(['auth', 'verified'])
    ->name('tickets.create');

Route::get('/tickets/{ticket}', \App\Livewire\Tickets\TicketDetail::class)
    ->middleware(['auth', 'verified'])
    ->name('tickets.show');

// Admin Routes
Route::middleware(['auth', 'verified', \App\Http\Middleware\CheckRole::class.':admin'])->group(function () {
    Route::get('/inventario', \App\Livewire\Inventory\InventoryList::class)->name('inventory.index');
    Route::get('/inventario/crear', \App\Livewire\Inventory\InventoryForm::class)->name('inventory.create');
    Route::get('/inventario/{id}/editar', \App\Livewire\Inventory\InventoryForm::class)->name('inventory.edit');

    Route::get('/usuarios', \App\Livewire\Users\UserList::class)->name('users.index');
    Route::get('/usuarios/crear', \App\Livewire\Users\UserForm::class)->name('users.create');
    Route::get('/usuarios/{id}/editar', \App\Livewire\Users\UserForm::class)->name('users.edit');

    Route::get('/bitacora', \App\Livewire\Bitacora\Index::class)->name('bitacora.index');
    Route::get('/reportes', \App\Livewire\Reports\Index::class)->name('reports.index');

    Route::get('/configuracion', \App\Livewire\Settings\SettingsList::class)->name('settings.index');
});

Route::get('/run-migrations', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return '¡Migraciones ejecutadas con éxito! Ya puedes volver al sistema.';
});

require __DIR__.'/auth.php';
