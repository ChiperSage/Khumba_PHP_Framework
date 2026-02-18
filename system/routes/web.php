<?php
Router::get('', 'HomeController@index');
Router::get('login', 'AuthController@loginForm');
Router::post('login', 'AuthController@login');
