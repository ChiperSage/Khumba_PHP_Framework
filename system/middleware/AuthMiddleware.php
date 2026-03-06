<?php
// system/middleware/AuthMiddleware.php

class AuthMiddleware
{
    public function handle()
    {
        Session::start();

        if (!Auth::check()) {
            Response::redirect('/login');
        }
    }
}
