<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
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

Route::get('/inventario', \App\Livewire\Inventory\InventoryList::class)
    ->middleware(['auth', 'verified'])
    ->name('inventory.index');

Route::get('/usuarios', \App\Livewire\Users\UserList::class)
    ->middleware(['auth', 'verified'])
    ->name('users.index');
Route::get('/usuarios/crear', \App\Livewire\Users\UserForm::class)
    ->middleware(['auth', 'verified'])
    ->name('users.create');
Route::get('/usuarios/{id}/editar', \App\Livewire\Users\UserForm::class)
    ->middleware(['auth', 'verified'])
    ->name('users.edit');

Route::get('/run-migrations', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return '¡Migraciones ejecutadas con éxito! Ya puedes volver al sistema.';
});

require __DIR__.'/auth.php';
