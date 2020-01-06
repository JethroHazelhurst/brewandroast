<?php

Route::get( '/', 'Web\AppController@getApp' )->middleware('auth');
Route::get('/login', 'Web\AppController@getLogin' )
      ->name('login')
      ->middleware('guest');
