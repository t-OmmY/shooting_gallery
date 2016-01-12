<?php

class Password
{
    const SALT_TEXT = 'I have 2 hands but it is night';

    private $password;
    private $hashedPassword;
    private $salt;

    function __construct($password, $saltText = null)
    {
        $password = trim($password);

        if (empty($password)) {
            throw new Exception('Empty password...', 500);
        }

        $this->password = $password;
        $this->salt = md5(is_null($saltText) ? self::SALT_TEXT : $saltText);
        $this->hashedPassword = md5($this->salt . $password);
    }

    public function __toString()
    {
        return $this->hashedPassword;
    }
}