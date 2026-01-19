<?php
// app/controller/HomeController.php

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home', [
            'title' => 'Khumba Framework',
            'message' => 'Framework ringan siap jalan'
        ]);
    }
}
