<?php

class FbAuth
{
    private static $client_id = FB_CLIENT_ID; // Client ID
    private static $client_secret = FB_CLIENT_SECRET; // Client secret
    private static $redirect_path = '/Library/FbAuth.php';
    private static $redirect_host = REDIRECT_URI_HOST; // Redirect URIs

    private static $url = 'https://www.facebook.com/dialog/oauth';

    private static function getLoginParams()
    {
        return array(
            'client_id'     => self::$client_id,
            'redirect_uri'  => 'http://' . self::$redirect_host . self::$redirect_path,
            'response_type' => 'code',
            'scope'         => 'email,user_birthday,user_posts'
        );
    }

    private static function get_curl($url)
    {
        if(function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $output = curl_exec($ch);
            echo curl_error($ch);
            curl_close($ch);
            return $output;
        } else {
            return file_get_contents($url);
        }
    }

    public static function getLoginButton()
    {
        return $link = '<a href="' . self::$url . '?' . urldecode(http_build_query(self::getLoginParams())) . '"><img src="../helpers/img/facebook.png" width="30" title="Get in with Vkontakte"></a>';
    }

    public static function processLogin()
    {
        if ( isset($_GET['code']))  {
            require_once '../config.php';
            $params = array(
                'client_id'     => self::$client_id,
                'redirect_uri'  => 'http://' . self::$redirect_host . self::$redirect_path,
                'client_secret' => self::$client_secret,
                'code'          => $_GET['code']
            );

            $url = 'https://graph.facebook.com/oauth/access_token';
            $tokenInfo = null;

            parse_str(file_get_contents($url . '?' . http_build_query($params)), $tokenInfo);
            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
                $params = array(
                    'access_token' => $tokenInfo['access_token']
                );
                $url = 'https://graph.facebook.com/me';
                $userInfo = json_decode(self::get_curl($url. '?' . urldecode(http_build_query($params))), true);
                $user = explode('  ', $userInfo['name']);
                $userInfo = array(
                    'nickname' => $user[0].$userInfo['id'],
                    'email' => null,
                    'first_name' => $user[0],
                    'last_name' => $user[1],
                    'password' => 'fb_id'.$userInfo['id']
                );
                require_once 'Session.php';
                session_start();
                Session::set('user', $userInfo);
                header('Location: /?route=security/social_auth');
            }
        }
    }
}
FbAuth::processLogin();
