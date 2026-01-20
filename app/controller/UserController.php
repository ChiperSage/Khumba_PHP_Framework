<?php

class UserController extends Controller
{
    public function profile($id)
    {
        $this->view('user', [
            'id' => $id
        ]);
    }
}
