<?php
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        $viewFile = BASE_PATH . '/app/view/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die('View not found');
        }
        require $viewFile;
    }
}
