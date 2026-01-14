<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/comment', function () {
    return view('comment');
});

Route::get('/apropos', function () {
    return view('apropos');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/cgu', function () {
    return view('cgu');
});

Route::get('/charte', function () {
    return view('charte');
});

Route::get('/charte-expediteur', function () {
    return view('charte_expediteur');
});

Route::get('/faq', function () {
    return view('faq');
});
