<?php
class Controller
{
    /**
     * Render view tanpa layout.
     *
     * Usage: $this->view('home');
     *        $this->view('user/profile', ['user' => $user]);
     */
    protected function view($view, $data = [])
    {
        extract($data);
        $viewFile = BASE_PATH . '/app/view/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            die("View not found: $view");
        }

        require $viewFile;
    }

    /**
     * Render view di dalam layout.
     *
     * Usage: $this->layout('main', 'home');
     *        $this->layout('main', 'user/profile', ['user' => $user]);
     *
     * Di dalam layout.php, gunakan variabel $content untuk
     * menampilkan konten view yang di-render:
     *   <?= $content ?>
     */
    protected function layout($layout, $view, $data = [])
    {
        extract($data);
        $viewFile   = BASE_PATH . '/app/view/' . $view . '.php';
        $layoutFile = BASE_PATH . '/app/view/layouts/' . $layout . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            die("View not found: $view");
        }

        if (!file_exists($layoutFile)) {
            http_response_code(500);
            die("Layout not found: $layout");
        }

        // Render view ke buffer terlebih dahulu
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Inject $content ke dalam layout
        require $layoutFile;
    }

    /**
     * Redirect ke URL lain.
     *
     * Usage: $this->redirect('login');
     *        $this->redirect('user/profile');
     */
    protected function redirect($url)
    {
        Response::redirect($url);
    }

    /**
     * Kirim response JSON.
     *
     * Usage: $this->json(['status' => 'ok']);
     *        $this->json(['error' => 'not found'], 404);
     */
    protected function json($data, $status = 200)
    {
        Response::json($data, $status);
    }
}
