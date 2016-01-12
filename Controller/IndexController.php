<?php

class IndexController extends Controller
{
    /**
     * действие для главной странички - Home
     *
     * @param Request $request
     * @return int
     */
    public function indexAction(Request $request)
    {
/*
        $mainPage = 'it\'s Work!';

        ob_start();
        require $mainPage;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();
*/
        return 'Happy BirthDAY!!!';
    }


    /**
     * действие для странички о нас - About
     *
     * @param Request $request
     * @return int
     */
    public function aboutAction(Request $request)
    {

        return '!!!!34!!!!';
    }


    /**
     * действие для странички с контактной формой - Contact
     *
     * @param Request $request
     * @return int
     */
    public function contactAction(Request $request)
    {
        $arg = array();
        if (Session::has('user')) {
            $model = new contactModel();
            $arg = $model->getUserEmail($_SESSION['user']);
        }
        if ($request->isPost()) {
            if ($request->post('email')&&$request->post('message')){
                $model = new contactModel();
                $param = array(
                    'email' => $request->post('email'),
                    'message' => $request->post('message')
                );
                $result = $model->sendMessage($param);
                if ($result['status'] == 'Success'){
                    Session::setFlash('Message send');
                }
                $model->saveMessage($param);
            } else {
                Session::setFlash('Fill the fields');
            }
        }
        return $this->render('contact', $arg);
    }

}