<?php
// system/middleware/AuthMiddleware.php

class AuthMiddleware
{
    public function handle()
    {
        Session::start();

        if (!Session::get('user')) {
            Response::redirect('/login');
        }
    }
}
