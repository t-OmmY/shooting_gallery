<?php

class CabinetController
{
    public function __construct()
    {
        if (!(Session::has('user'))) {
            header('Location: /?route=security/login');
        }
    }
    public function indexAction()
    {
        return 'Welcome to your cabinet, '.Session::get('user')['first_name'];
    }
}