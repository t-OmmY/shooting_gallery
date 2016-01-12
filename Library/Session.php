<?php

/**
 * Class Session
 */
abstract class Session
{

    /**
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * if isset by key
     *
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        if ($key !== 'flash') {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * get a value by key
     *
     * @param $key
     * @return null|mixed
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    /**
     * delete a value by key
     *
     * @param $key
     */
    public static function remove($key)
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * start
     */
    public static function start()
    {
        session_start();
    }

    /**
     *  destroy everything :)
     */
    public static function destroy()
    {
        session_destroy();
    }


    /**
     * @param $message
     */
    public static function setFlash($message)
    {
        $_SESSION['flash'] = $message;
    }


    /**
     * @return string
     */
    public static function getFlash()
    {
        $message = self::get('flash');
        self::remove('flash');

        return (string)$message;
    }
}