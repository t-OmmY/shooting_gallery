<?php


class LoginForm
{
    public $nickname;
    public $password;

    public function __construct(Request $request)
    {
        $this->nickname = $request->post('nickname');
        $this->password = $request->post('password');
    }

    public function isValid()
    {
        return $this->nickname !== '' && $this->password !== '';
    }

}