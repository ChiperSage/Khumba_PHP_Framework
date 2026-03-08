<?php
class HomeController extends Controller
{
    public function index()
    {
        $this->layout('main', 'home', [
            'title' => 'Home'
        ]);
    }
}
