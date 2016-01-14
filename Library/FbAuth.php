<?php

class FbAuth
{
    private static $client_id = '519013468277206'; // Client ID
    private static $client_secret = 'd4b53a70a591a5e5010f0647c7c4cdc3'; // Client secret
    private static $redirect_uri = 'http://localhost/?route=security/fb_auth'; // Redirect URIs

    private static $url = 'https://www.facebook.com/dialog/oauth';

    private static function getLoginParams()
    {
        return array(
            'client_id'     => self::$client_id,
            'redirect_uri'  => self::$redirect_uri,
            'response_type' => 'code'
        );
    }

    public static function getLoginButton()
    {
        return $link = '<a href="' . self::$url . '?' . urldecode(http_build_query(self::getLoginParams())) . '"><img src="../helpers/img/facebook.png" width="30" title="Get in with Facebook"></a>';
    }

    public static function processLogin()
    {
        if (isset($_GET['code'])) {
            $result = false;
            $params = array(
                'client_id'     => self::$client_id,
                'redirect_uri'  => self::$redirect_uri,
                'client_secret' => self::$client_secret,
                'code'          => $_GET['code']
            );

            $url = 'https://graph.facebook.com/oauth/access_token';

            $tokenInfo = null;
            parse_str(file_get_contents($url . '?' . http_build_query($params)), $tokenInfo);

            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
                $params = array('access_token' => $tokenInfo['access_token']);

                $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params))), true);

                if (isset($userInfo['id'])) {
                    $user = explode('  ', $userInfo['name']);
                    $userInfo = array(
                        'nickname' => $user[0].$userInfo['id'],
                        'email' => null,
                        'first_name' => $user[0],
                        'last_name' => $user[1],
                        'password' => 'fb_id'.$userInfo['id']
                    );
                    $result = true;
                }
            }
            if ($result) {
                $user['nickname'] = $userInfo['nickname'];
                Session::set('user', $user);
            }
            return $userInfo;
        }

    }
}

