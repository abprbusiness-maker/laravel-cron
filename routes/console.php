<?php

use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    \Log::info("Scheduler Laravel 11 jalan!");
})->everyMinute();