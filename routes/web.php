<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', \App\Http\Middleware\CheckRole::class.':admin,outsourcing'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('tickets', 'tickets.index')
    ->middleware(['auth', 'verified'])
    ->name('tickets.index');

Route::get('/requests', \App\Livewire\Requests\RequestList::class)
    ->middleware(['auth', 'verified'])
    ->name('requests.index');

Route::get('/requests/crear', \App\Livewire\Requests\RequestForm::class)
    ->middleware(['auth', 'verified'])
    ->name('requests.create');

Route::get('/schedules', \App\Livewire\Schedules\ScheduleList::class)
    ->middleware(['auth', 'verified'])
    ->name('schedules.index');

Route::get('/schedules/configuracion', \App\Livewire\Schedules\ScheduleForm::class)
    ->middleware(['auth', 'verified'])
    ->name('schedules.config');

Route::get('/schedules/outsourcing', \App\Livewire\Schedules\WorkShiftsList::class)
    ->middleware(['auth', 'verified'])
    ->name('schedules.outsourcing');

Route::get('/tickets/create', \App\Livewire\Tickets\TicketForm::class)
    ->middleware(['auth', 'verified'])
    ->name('tickets.create');

Route::get('/tickets/{ticket}', \App\Livewire\Tickets\TicketDetail::class)
    ->middleware(['auth', 'verified'])
    ->name('tickets.show');

// Admin Routes
Route::middleware(['auth', 'verified', \App\Http\Middleware\CheckRole::class.':admin,outsourcing'])->group(function () {
    Route::get('/inventario', \App\Livewire\Inventory\InventoryList::class)->name('inventory.index');
    Route::get('/inventario/crear', \App\Livewire\Inventory\InventoryForm::class)->name('inventory.create');
    Route::get('/inventario/{id}/editar', \App\Livewire\Inventory\InventoryForm::class)->name('inventory.edit');

    Route::get('/usuarios', \App\Livewire\Users\UserList::class)->name('users.index');
    Route::get('/usuarios/crear', \App\Livewire\Users\UserForm::class)->name('users.create');
    Route::get('/usuarios/{id}/editar', \App\Livewire\Users\UserForm::class)->name('users.edit');


    Route::get('/reportes', \App\Livewire\Reports\Index::class)->name('reports.index');

    Route::get('/configuracion', \App\Livewire\Settings\SettingsList::class)->name('settings.index');
});

require __DIR__.'/auth.php';
