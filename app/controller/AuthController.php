<?php
class AuthController extends Controller {

    public function loginForm() {
        $this->view('login');
    }

    public function login() {
        $username = $_POST['username'] ?? null;

        if (!$username) {
            return Response::json(['error' => 'Username required'], 422);
        }

        Session::set('user', $username);

        Response::redirect('');
    }
}
