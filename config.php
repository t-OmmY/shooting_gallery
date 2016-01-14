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


//DataBase connections:
define('DB_URL', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'weber');


//Autorization params:
define ('REDIRECT_URI_HOST', 'localhost');

define ('VK_CLIENT_ID', '5224179');
define ('VK_CLIENT_SECRET', 'cOEgdVyXkV78c5UlShre');

define ('FB_CLIENT_ID', '519013468277206');
define ('FB_CLIENT_SECRET', 'd4b53a70a591a5e5010f0647c7c4cdc3');

define ('GOOGLE_CLIENT_ID', '365614718610-g9cl4s8ocuu6a8jo6ab11n97vn62itgv.apps.googleusercontent.com');
define ('GOOGLE_CLIENT_SECRET', 'tARGeIJqMqimriES-Jn_GHhY');

