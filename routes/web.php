<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Route::get('/test-scheduler', function () {
    Log::info('🔄 Manual scheduler triggered via URL');
    
    $output = [];
    $result = Artisan::call('schedule:run', [], $output);
    
    Log::info('Scheduler result: ' . $result);
    
    return response()->json([
        'status' => 'success',
        'message' => 'Scheduler executed manually',
        'time' => now()->toDateTimeString(),
        'result' => $result
    ]);
});

Route::get('/test-discord', function () {
    Log::info('🔄 Manual discord command triggered via URL');
    
    $result = Artisan::call('discord:notify', ['message' => '⚡ Test dari Manual URL']);
    
    return response()->json([
        'status' => 'success', 
        'message' => 'Discord command executed',
        'time' => now()->toDateTimeString(),
        'result' => $result
    ]);
});


Route::get('/', function () {
    return view('welcome');
});
