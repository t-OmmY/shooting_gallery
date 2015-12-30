<?php

class EditbaseController extends Controller
{
    public function indexAction()
    {
        $editBaseModel = new editbaseModel();
        $param = $editBaseModel->index();
        return $this->render('index', $param);

    }

    public function deleteAction()
    {
        $editBaseModel = new editbaseModel();
        $editBaseModel->del($_POST);
        $param = $editBaseModel->index();
        return $this->render('index', $param);

    }

    public function infoAction(Request $request)
    {
        $table = $request->post('table');
        $editBaseModel = new editbaseModel();
        $param = $editBaseModel -> formInfo($table);
        return $this->render('add_form', $param);

    }

    public function addAction(Request $request)
    {
        $table = $request->post('table');
        unset($_POST['table']);
        $editBaseModel = new editbaseModel();
        $editBaseModel->add($table, $_POST);
        $param = $editBaseModel->index();
        return $this->render('index', $param);
    }

    public function editAction()
    {
        $editBaseModel = new editbaseModel();
        $param = $editBaseModel->edit($_POST);
        return $this->render('edit_form', $param);
    }

    public function updateAction()
    {
        $editBaseModel = new editbaseModel();
        $editBaseModel->update($_POST);
        $param = $editBaseModel->index();
        return $this->render('index', $param);
    }
}
