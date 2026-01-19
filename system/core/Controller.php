<?php
// system/core/Controller.php

class Controller
{
    protected function view($name, $data = [])
    {
        extract($data);
        $file = BASE_PATH . '/app/view/' . $name . '.php';

        if (!file_exists($file)) {
            echo 'View not found';
            return;
        }

        require $file;
    }
}
