<?php
class AuthController extends Controller {

    public function loginForm() {
        $this->view('login');
    }

    public function login() {
        SecurityHelper::verify_csrf();

        $username = $_POST['username'] ?? null;

        if (!$username) {
            return Response::json(['error' => 'Username required'], 422);
        }

        Session::set('user_id', $username);

        Response::redirect('');
    }

    public function logout() {
        Session::destroy();
        Response::redirect('login');
    }
}
