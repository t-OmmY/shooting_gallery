<?php

class EditBaseController extends Controller
{
    public function indexAction()
    {
        $editBaseModel = new editBaseModel();
        $param = $editBaseModel->index();
        return $this->render('index', $param);

    }

    public function deleteAction()
    {
        $editBaseModel = new editBaseModel();
        $editBaseModel->del($_POST);
        $param = $editBaseModel->index();
        return $this->render('index', $param);

    }

    public function infoAction(Request $request)
    {
        $table = $request->post('table');
        $editBaseModel = new editBaseModel();
        $param = $editBaseModel -> formInfo($table);
        return $this->render('add_form', $param);

    }

    public function addAction(Request $request)
    {
        $table = $request->post('table');
        unset($_POST['table']);
        $editBaseModel = new editBaseModel();
        $editBaseModel->add($table, $_POST);
        $param = $editBaseModel->index();
        return $this->render('index', $param);
    }
}