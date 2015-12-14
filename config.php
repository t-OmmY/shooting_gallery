<?php

/*
 * константы для удобной работы с подключением файлов
 */

// разделитель каталогов - для винды \, а для юникса /
define('DS', DIRECTORY_SEPARATOR);

// что-то типа C:\xampp\htdocs\site\ для Windows
define('ROOT', __DIR__ . DS);

define('LIB_DIR', ROOT . 'Library' . DS);
define('VIEW_DIR', ROOT . 'View' . DS);
define('CONTROLLER_DIR', ROOT . 'Controller' . DS);
define('MODEL_DIR', ROOT . 'Model' . DS);