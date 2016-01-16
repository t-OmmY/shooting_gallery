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
            $arg = array(
                'email' => Session::get('user')['email'],
                'first_name' => Session::get('user')['first_name']
            );
        }
        if ($request->isPost()) {
            if ($request->post('email')&&$request->post('message')&&$request->post('name')){
                $model = new contactModel();
                $param = array(
                    'name' => $request->post('name'),
                    'email' => $request->post('email'),
                    'message' => $request->post('message')
                );
                $save_result = $model->saveMessage($param);
                $send_result = $model->sendMessage($param);
                if ($save_result['status'] == 'Success' && $send_result){
                    Session::setFlash('Message send');
                } else {
                    Session::setFlash('Something wrong. Try later or send mail to <i>xperiask17ise@gmail.com</i>');
                }
            } else {
                Session::setFlash('Fill the fields');
            }
        }
        return $this->render('contact', $arg);
    }

}