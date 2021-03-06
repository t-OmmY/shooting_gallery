<?php

class VkAuth
{
    private static $client_id = VK_CLIENT_ID; // ID приложения
    private static $client_secret = VK_CLIENT_SECRET; // Защищённый ключ
    private static $redirect_path = '/Library/VkAuth.php';
    private static $redirect_host = REDIRECT_URI_HOST; // Адрес сайта

    private static $url = 'http://oauth.vk.com/authorize';

    private static function getLoginParams()
    {
        return array(
            'client_id'     => self::$client_id,
            'redirect_uri'  => 'http://' . self::$redirect_host . self::$redirect_path,
            'response_type' => 'code'
        );
    }

    public static function getLoginButton()
    {
        return $link = '<a href="' . self::$url . '?' . urldecode(http_build_query(self::getLoginParams())) . '"><img src="../helpers/img/vk.jpg" width="30" title="Get in with Vkontakte"></a>';
    }

    public static function processLogin()
    {
        if (isset($_GET['code'])) {
            require_once '../config.php';
            $params = array(
                'client_id' => self::$client_id,
                'client_secret' => self::$client_secret,
                'code' => $_GET['code'],
                'redirect_uri' => 'http://' . self::$redirect_host . self::$redirect_path
            );

            $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

            if (isset($token['access_token'])) {
                $params = array(
                    'uids'         => $token['user_id'],
                    'fields'       => 'uid,first_name,last_name',
                    'access_token' => $token['access_token']
                );

                $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
                if (isset($userInfo['response'][0]['uid'])) {
                    $userInfo = array(
                        'nickname' => $userInfo['response'][0]['first_name'].$userInfo['response'][0]['uid'],
                        'email' => null,
                        'first_name' => $userInfo['response'][0]['first_name'],
                        'last_name' => $userInfo['response'][0]['last_name'],
                        'password' => 'vk_id'.$userInfo['response'][0]['uid']
                    );
                    require_once 'Session.php';
                    session_start();
                    Session::set('user', $userInfo);
                    header('Location: /?route=security/social_auth');
                }
            }
        }
    }
}
VkAuth::processLogin();

