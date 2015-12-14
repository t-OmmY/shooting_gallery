<?php
/**
 * Created by PhpStorm.
 * User: Andrii
 * Date: 22.07.2015
 * Time: 16:05
 */

class User
{
    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    public function get($username, $password)
    {
        /** @var PDO $db */
        $db = Registry::get('db');
        $sth = $db->prepare("SELECT * FROM user WHERE username = :username  AND password = :password");

        $arr = array(
            'username' => $username,
            'password' => $password
        );

        $sth->execute($arr);
        $userData = $sth->fetch(PDO::FETCH_ASSOC);

        return $userData;
    }

}