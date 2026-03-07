<?php

class UserController extends Controller
{
    public function profile($id)
    {
        $user = User::findOrFail($id);

        $this->view('user', [
            'user' => $user
        ]);
    }
}
