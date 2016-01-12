<?php


class RegisterForm
{
    public $nickname;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $confirm_password;

    public function __construct(Request $request)
    {
        $this->nickname = $request->post('nickname');
        $this->first_name = $request->post('first_name');
        $this->last_name = $request->post('last_name');
        $this->email = $request->post('email');
        $this->password = $request->post('password');
        $this->confirm_password = $request->post('confirm_password');
    }

    public function isValid()
    {
        return $this->nickname !== '' && $this->first_name !== '' && $this->last_name !== '' && $this->email !== '' && $this->password !== '' && $this->confirm_password !== '';
    }

    public function passwordCheck()
    {
        return $this->password == $this->confirm_password;
    }

    public function validPassword()
    {
        return (strlen($this->password) > 6 && strlen($this->password) < 32);
    }

}