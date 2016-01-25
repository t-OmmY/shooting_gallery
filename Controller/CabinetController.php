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

    public function ajax_select_sessionAction(Request $request)
    {
        $session_id = $request->post('session_id');
        $model = new cabinetModel();
        echo json_encode($model->ajax_select_session($session_id));
    }

    public function ajax_select_serieAction(Request $request)
    {
        $serie_id = $request->post('serie_id');
        $model = new cabinetModel();
        echo json_encode($model->ajax_select_serie($serie_id));
    }
}