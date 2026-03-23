<?php

use App\Livewire\DocumentPanel;
use App\Livewire\WorkOrderPanel;
use Illuminate\Support\Facades\Route;

Route::get('/', WorkOrderPanel::class);
Route::get('/documents', DocumentPanel::class);
