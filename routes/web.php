<?php

use Illuminate\Support\Facades\Route;
use App\Faker\FakerImageProvider;
use Faker\Factory;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/faker', function () {
    $faker = Factory::create();
    for ($i = 0; $i < 5; $i++) {
        (new FakerImageProvider($faker))->loremflickr('posts');
    }
});

