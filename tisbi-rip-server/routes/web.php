<?php

use App\Livewire\Bonus;
use App\Livewire\Counter;
use App\Livewire\Employee;
use App\Livewire\Employees;
use App\Livewire\JobTitle;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->to('/employees');
})->name('home');

// Route::view('employees', 'employees')
//     ->middleware(['auth', 'verified'])
//     ->name('employees');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('/counter', Counter::class);
    Route::get('/employees', Employees::class)->name('employees');
    Route::get('/employees/{mode}/{id}', Employee::class);
    Route::get('/job_titles/edit', JobTitle::class)->name('job_titles_edit');
    Route::get('/bonuses/{mode}/{id}/{employeeId}', Bonus::class);

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
