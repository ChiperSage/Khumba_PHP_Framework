<?php
Router::get('', 'HomeController@index');
Router::get('login', 'AuthController@loginForm');
Router::post('login', 'AuthController@login');
Router::get('logout', 'AuthController@logout');
Router::get('user/{id}', 'UserController@profile');
