<?php

class CabinetController extends Controller
{
    public function __construct()
    {
        if (!(Session::has('user'))) {
            header('Location: /?route=security/login');
        }
    }

    public function indexAction()
    {
        $model = new cabinetModel();
        $arg = $model->getUserSessionList(Session::get('user')['nickname']);
        return $this->render('index', $arg);
    }

}