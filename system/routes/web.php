<?php

Router::get('/', 'HomeController@index');

Router::get('user/{id}', 'UserController@show');

Router::post('login', 'AuthController@login');

Router::get('admin', 'AdminController@index', ['AuthMiddleware']);
