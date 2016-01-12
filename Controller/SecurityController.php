<?php

class SecurityController extends Controller
{
    public function registrationAction(Request $request)
    {
        if (Session::has('user')) {
            header('Location: /');
        }
        $form = new RegisterForm($request);

        if ($request->isPost()) {
            if ($form->isValid()) {
                if ($form->validPassword()){
                    if ($form->passwordCheck()){
                        $password = new Password($form->password);
                        $model = new securityModel();
                        $params = array(
                            'nickname' => $form -> nickname,
                            'first_name' => $form -> first_name,
                            'last_name' => $form -> last_name,
                            'email' => $form -> email,
                            'password' => $password
                        );
                        $status = $model->addLogin($params);
                        if ($status == 'Success'){
                            Session::setFlash('Well done! Now you can Login');
                            return $this->render('login', $params);
                        } else {
                            Session::setFlash('This nickname or email are already used, try another one');
                        }
                    } else{
                        Session::setFlash('Password not match');
                    }
                } else {
                    Session::setFlash('Password has to consist more than 6 symbols, but less then 32');
                }
            } else {
                Session::setFlash('Fill the fields');
            }
        }
        $args = array(
            'nickname' => $form->nickname,
            'first_name' => $form->first_name,
            'last_name' => $form->last_name,
            'email' => $form->email,
        );


        return $this->render('registration', $args);

    }

    public function loginAction(Request $request)
    {
        if (Session::has('user')) {
            header('Location: /');
        }

        $form = new LoginForm($request);

        if ($request->isPost()) {
            if ($form->isValid()) {
                $password = new Password($form->password);
                $model = new securityModel();

                try {
                    $user = $model->getUser($form->nickname, $password);
                    Session::set('user', $user);
                    header('Location: /');
                } catch (Exception $e) {
                    Session::setFlash($e->getMessage());
                }

            } else {
                Session::setFlash('Fill the fields');
            }
        }

        $args = array(
            'form' => $form
        );

        return $this->render('login', $args);
    }


    public function logoutAction(Request $request)
    {
        Session::remove('user');
        header('Location: \?route=security/login');
    }
}