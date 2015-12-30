<?php

class EditController extends Controller
{
    public function indexAction()
    {
        $editModel = new editModel();
        $param = $editModel->index();
        return $this->render('index', $param);

    }

    public function deleteAction()
    {
        $editModel = new editModel();
        $editModel->del($_POST);
        $param = $editModel->index();
        return $this->render('index', $param);

    }

    public function infoAction(Request $request)
    {
        $table = $request->post('table');
        $editModel = new editModel();
        $param = $editModel -> formInfo($table);
        return $this->render('add_form', $param);

    }

    public function addAction(Request $request)
    {
        $table = $request->post('table');
        unset($_POST['table']);
        $editModel = new editModel();
        $editModel->add($table, $_POST);
        $param = $editModel->index();
        return $this->render('index', $param);
    }

    public function editAction()
    {
        $editModel = new editModel();
        $param = $editModel->edit($_POST);
        return $this->render('edit_form', $param);
    }

    public function updateAction()
    {
        $editModel = new editModel();
        $editModel->update($_POST);
        $param = $editModel->index();
        return $this->render('index', $param);
    }
}