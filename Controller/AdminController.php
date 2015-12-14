<?php

class AdminController
{
    public function indexAction()
    {
        $adminModel = new AdminModel();
        $params = $adminModel -> index();

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

    public function NewSessionAction(Request $request)
    {

        $adminModel = new AdminModel();
        $params = $adminModel -> getInfoForNewSession();
        $shooter_info = $params[0];
        $caliber_info = $params[1];
        $target_info = $params[2];

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

    public function NewSerieAction(Request $request)
    {
        $adminModel = new AdminModel();

        if ($request->isPost()) {
            if (isset($_POST['hit_1'])){
                $adminModel ->postNewHits();
            } else {
                $adminModel ->postNewSession();
            }
        }

        $params = $adminModel -> getInfoForNewSerie();
        $info = $adminModel ->getInfoAboutLastSerieAndSession();
        $session_info= $info[0];
        $color_info = $params[0];

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

    public function NewHitsAction(Request $request)
    {
        $adminModel = new AdminModel();

        if ($request->isPost()) {
            $adminModel ->postNewSerie();
        }

        $info = $adminModel ->getInfoAboutLastSerieAndSession();
        $session_info = $info[0];
        $serie_info = $info[1];


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

    public function selectSessionAction(Request $request)
    {
        return 'to be continue...';

    }

}