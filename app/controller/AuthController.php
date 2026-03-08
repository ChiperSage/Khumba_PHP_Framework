<?php
class AuthController extends Controller
{
    public function loginForm()
    {
        $this->layout('main', 'login', [
            'title' => 'Login'
        ]);
    }

    public function login()
    {
        // CSRF sudah diverifikasi otomatis oleh Router
        $v = Validate::check($_POST, [
            'username' => ['required', 'min:3', 'max:50'],
        ]);

        if ($v->hasError()) {
            return $this->json(['errors' => $v->firstErrors()], 422);
        }

        Session::set('user_id', $_POST['username']);
        $this->redirect('');
    }

    public function logout()
    {
        Session::destroy();
        $this->redirect('login');
    }
}
