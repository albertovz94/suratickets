<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/tickets/create', \App\Livewire\Tickets\TicketForm::class)
    ->middleware(['auth', 'verified'])
    ->name('tickets.create');

require __DIR__.'/auth.php';
