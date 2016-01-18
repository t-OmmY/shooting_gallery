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
        return "<iframe width=\"854\" height=\"480\" src=\"https://www.youtube.com/embed/U-x2jBbmSso\" frameborder=\"0\" allowfullscreen></iframe>";
    }


    /**
     * действие для странички о нас - About
     *
     * @param Request $request
     * @return int
     */
    public function aboutAction(Request $request)
    {

        return "<b>Lorem Ipsum</b> <p>tas ir teksta salikums, kuru izmanto poligrāfijā un maketēšanas darbos. Lorem Ipsum ir kļuvis par vispārpieņemtu teksta aizvietotāju kopš 16. gadsimta sākuma. Tajā laikā kāds nezināms iespiedējs izveidoja teksta fragmentu, lai nodrukātu grāmatu ar burtu paraugiem. Tas ir ne tikai pārdzīvojis piecus gadsimtus, bet bez ievērojamām izmaiņām saglabājies arī mūsdienās, pārejot uz datorizētu teksta apstrādi. Tā popularizēšanai 60-tajos gados kalpoja Letraset burtu paraugu publicēšana ar Lorem Ipsum teksta fragmentiem un, nesenā pagātnē, tādas maketēšanas programmas kā Aldus PageMaker, kuras šablonu paraugos ir izmantots Lorem Ipsum teksts.</p>";
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