<?php

class AdminController extends Controller
{
    public function __construct()
    {
        if (!(Session::get('user')['nickname'] == 'Admin')) {
            header('Location: /?route=security/login');
        }
    }
    public function indexAction()
    {
        $adminModel = new adminModel();
        $session_list = ($adminModel -> sessionList());

        $contactModel = new contactModel();
        $messages = $contactModel->getMessages();

        $arg = array(
            'session_list'=>$session_list,
            'messages'=>$messages
        );
        return $this -> render('index', $arg);
    }

    public function ajax_contact_messagesAction()
    {
        $startFrom = $_POST['startFrom'];
        $model = new contactModel();
        echo json_encode($model->ajax_contact_messages($startFrom));
    }

    public function newSessionFormAction()
    {
        $adminModel = new adminModel();
        $for_new_session = $adminModel ->forNewSession();
        $arg = array(
            'for_new_session'=>$for_new_session
        );
        return $this -> render('new_session', $arg);
    }

    public function addNewSessionAction()
    {
        $adminModel = new adminModel();
        $result = $adminModel->addSession($_POST);
        if ( $result['status'] != 'Success'){
            return $this->render('error');
        } else {
        return ($this->newSerieFormAction($result['session_id']));
        }
    }

    public function newSerieFormAction($param)
    {
        if (is_object( $param )){
        $param = $param->post('session_id');
        }
        $adminModel = new adminModel();
        $for_new_serie = $adminModel ->forNewSerie($param);
        $session_info = $adminModel->sessionInfo($param);
        $arg = array(
            'for_new_serie'=>$for_new_serie,
            'session_info'=>$session_info
        );
        return $this->render('new_serie', $arg);
    }

    public function addNewSerieAction()
    {
        $adminModel = new adminModel();
        $result = $adminModel->addSerie($_POST);
        if ( $result['status'] != 'Success'){
            return $this->render('error');
        } else {
            return ($this->newHitFormAction($result));
        }
    }

    public function newHitFormAction($param)
    {

        if (is_object( $param )){
            $param=$_POST;
        }
        $adminModel = new adminModel();
        $session_info = $adminModel->sessionInfo($param['session_id']);
        $serie_info = $adminModel->serieInfo($param['serie_id']);
        $arg = array(
            'session_info'=>$session_info,
            'serie_info'=>$serie_info
        );
        return $this->render('new_hit', $arg);
    }

    public function addNewHitAction()
    {
        $adminModel = new adminModel();
        $result = $adminModel->addHits($_POST);
        return ($this->selectSerieAction());
    }

    public function selectSessionAction(Request $request)
    {
        $param = $request->post('session_id');
        $adminModel = new adminModel();
        $session_info = $adminModel->sessionInfo($param);
        $serie_list = $adminModel->serieList($param);
        $arg = array(
            'session_info'=>$session_info,
            'serie_list'=>$serie_list
        );
        return $this->render('select_session', $arg);
    }

    public function selectSerieAction()
    {
        $adminModeloModel = new adminModel();
        if (!isset($_POST['serie_id'])){
            $result = $adminModeloModel->serieIdBySessionIdAndNubmer($_POST['session_id'], $_POST['serie_number']);
            $param = $result['result']['serie_id'];
        } else {
            $param = $_POST['serie_id'];
        }
        $serie_info = $adminModeloModel->serieInfo($param);
        $hit_list = $adminModeloModel->hitList($param);
        $arg = array(
            'serie_info'=>$serie_info,
            'hit_list'=>$hit_list
        );
        return $this->render('select_serie', $arg);
    }

    public function deleteSessionAction()
    {
        $adminModel = new adminModel();
        $adminModel->deleteSession($_POST);
        return ($this->indexAction());
    }

    public function deleteSerieAction()
    {
        $adminModel = new adminModel();
        $adminModel->deleteSerie();
        return ($this->selectSessionAction(new Request()));
    }

    public function deleteHitAction()
    {
        $adminModel = new adminModel();
        $adminModel->deleteHit();
        return ($this->selectSerieAction());
    }

    public function selectHitAction()
    {
        $adminModel = new adminModel();
        $hit_info = $adminModel->hitInfo($_POST['hit_id']);
        $arg = array(
            'hit_info'=>$hit_info
        );
        return $this->render('select_hit', $arg);
    }

    public function editSessionFormAction()
    {
        $adminModel = new adminModel();
        $for_new_session = $adminModel ->forNewSession();
        $arg = array(
            'for_new_session'=>$for_new_session
        );
        return $this->render('edit_session', $arg);
    }

    public function updateSessionAction()
    {
        $adminModel = new adminModel();
        $result = $adminModel ->editSession($_POST);
        return ($this->selectSessionAction(new Request()));
    }

    public function editSerieFormAction()
    {

        $adminModel = new adminModel();
        $session_list = $adminModel->sessionList();
        $for_new_serie = $adminModel ->forNewSerie($_POST['session_id']);
        $arg = array(
            'session_list'=>$session_list,
            'for_new_serie'=>$for_new_serie
        );
        return $this->render('edit_serie', $arg);
    }

    public function updateSerieAction()
    {
        $adminModel = new adminModel();
        $result = $adminModel ->editSerie($_POST);
        return ($this->selectSerieAction());
    }

    public function editHitFormAction()
    {
        $adminModel = new adminModel();
        $serie_list = $adminModel->serieIdList();
        $arg = array(
            'serie_list'=>$serie_list
        );
        return $this->render('edit_hit', $arg);
    }

    public function updateHitAction()
    {
        $adminModel = new adminModel();
        $result = $adminModel->editHit($_POST);
        return ($this->selectHitAction());
    }
}