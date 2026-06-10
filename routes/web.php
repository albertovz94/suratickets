<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/tickets/{ticket}', \App\Livewire\Tickets\TicketDetail::class)
    ->middleware(['auth', 'verified'])
    ->name('tickets.show');

require __DIR__.'/auth.php';
