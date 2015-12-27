<?php

abstract class Controller
{
    protected function render($template, array $args = array())
    {
        extract($args);

        // название каталога формируется по названию контроллера IndexController -> каталог Index
        $templateDir = str_replace('Controller', '', get_class($this));

        // полный путь к шаблону содержит путь к папке View в виде константы VIEW_DIR
        $templateFile = VIEW_DIR . $templateDir . DS . $template . '.phtml';

        if (!file_exists($templateFile)) {
            throw new Exception("{$templateFile} not found", 404);
        }

        // открываем буфер вывода, далее - подключение шаблона.
        // там можно использовать переменные, которые определены в контроллере - с готовыми данными
        ob_start();
        require $templateFile;

        // очистка буфера и возврат строки с динамческим контентом
        return ob_get_clean();
    }
}