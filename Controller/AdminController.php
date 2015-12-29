<?php

class AdminController
{
    public function indexAction()
    {
        $infoModel = new infoModel();
        $session_list = ($infoModel -> sessionList());
        $templateDir = str_replace('Controller', '', __CLASS__);

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . 'index.phtml';

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();
    }

    public function newSessionFormAction()
    {
        $infoModel = new infoModel();
        $for_new_session = $infoModel ->forNewSession();
        $templateDir = str_replace('Controller', '', __CLASS__);

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . 'new_session.phtml';

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();

    }

    public function addNewSessionAction()
    {
        $updateModel = new updateModel();
        $result = $updateModel->addSession($_POST);
        return ($this->newSerieFormAction($result['session_id']));
    }

    public function newSerieFormAction($param)
    {
        if (is_object( $param )){
        $param = $param->post('session_id');
        }
        $infoModel = new infoModel();
        $for_new_serie = $infoModel ->forNewSerie($param);
        $session_info = $infoModel->sessionInfo($param);
        $templateDir = str_replace('Controller', '', __CLASS__);

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . 'new_serie.phtml';

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();
    }

    public function addNewSerieAction()
    {
        $updateModel = new updateModel();
        $result = $updateModel->addSerie($_POST);
        return ($this->newHitFormAction($result));
    }

    public function newHitFormAction($param)
    {

        if (is_object( $param )){
            $param=$_POST;
        }
        $infoModel = new infoModel();
        $session_info = $infoModel->sessionInfo($param['session_id']);
        $serie_info = $infoModel->serieInfo($param['serie_id']);
        $templateDir = str_replace('Controller', '', __CLASS__);

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . 'new_hit.phtml';

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();

    }

    public function addNewHitAction()
    {
        $updateModel = new updateModel();
        $result = $updateModel->addHits($_POST);
        return ($this->selectSerieAction());
    }

    public function selectSessionAction(Request $request)
    {
        $param = $request->post('session_id');
        $infoModel = new infoModel();
        $session_info = $infoModel->sessionInfo($param);
        $serie_list = $infoModel->serieList($param);

        $templateDir = str_replace('Controller', '', __CLASS__);

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . 'select_session.phtml';

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();

    }

    public function selectSerieAction()
    {
        $infoModel = new infoModel();
        if (!isset($_POST['serie_id'])){
            $result = $infoModel->serieIdBySessionIdAndNubmer($_POST['session_id'], $_POST['serie_number']);
            $param = $result['result']['serie_id'];
        } else {
            $param = $_POST['serie_id'];
        }
        $serie_info = $infoModel->serieInfo($param);
        $hit_list = $infoModel->hitList($param);
        $templateDir = str_replace('Controller', '', __CLASS__);

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . 'select_serie.phtml';

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();


    }

    public function deleteSessionAction()
    {
        $updateModel = new updateModel();
        $updateModel->deleteSession($_POST);
        return ($this->indexAction());
    }

    public function deleteSerieAction()
    {
        $updateModel = new updateModel();
        $updateModel->deleteSerie($_POST);
        return ($this->selectSessionAction(new Request()));
    }

    public function deleteHitAction()
    {
        $updateModel = new updateModel();
        $updateModel->deleteHit($_POST);
        return ($this->selectSerieAction());
    }

    public function selectHitAction()
    {
        $infoModel = new infoModel();
        $hit_info = $infoModel->hitInfo($_POST['hit_id']);

        $templateDir = str_replace('Controller', '', __CLASS__);

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . 'select_hit.phtml';

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();
    }

    public function editSessionFormAction()
    {
        $infoModel = new infoModel();
        $for_new_session = $infoModel ->forNewSession();
        $templateDir = str_replace('Controller', '', __CLASS__);

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . 'edit_session.phtml';

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();
    }

    public function updateSessionAction()
    {
        $updateModel = new updateModel();
        $result = $updateModel ->editSession($_POST);
        return ($this->selectSessionAction(new Request()));
    }

    public function editSerieFormAction()
    {

        $infoModel = new infoModel();
        $session_list = $infoModel->sessionList();
        $for_new_serie = $infoModel ->forNewSerie($_POST['session_id']);
        $templateDir = str_replace('Controller', '', __CLASS__);

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . 'edit_serie.phtml';

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();
    }

    public function updateSerieAction()
    {
        $updateModel = new updateModel();
        $result = $updateModel ->editSerie($_POST);
        return ($this->selectSerieAction());
    }

    public function editHitFormAction()
    {
        $infoModel = new infoModel();
        $serie_list = $infoModel->serieIdList();
        $templateDir = str_replace('Controller', '', __CLASS__);

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . 'edit_hit.phtml';

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();
    }

    public function updateHitAction()
    {
        $updateModel = new updateModel();
        $result = $updateModel->editHit($_POST);
        return ($this->selectHitAction());
    }
}