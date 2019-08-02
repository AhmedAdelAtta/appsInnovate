<?php

Route::get('/', 'HomeController@home');

Route::any('/search','HomeController@search');


?>