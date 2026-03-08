<?php
class UserController extends Controller
{
    public function profile($id)
    {
        $user = User::findOrFail($id);

        $this->layout('main', 'user', [
            'title' => 'Profile',
            'user'  => $user
        ]);
    }
}
