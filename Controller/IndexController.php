<?php

class IndexController
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
        return 'С Днем РОЖДЕНИЯ Брат!!!';
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
        return 'HAPPY NEW YEAR AND MERRY CHRISTMAS';
    }

}