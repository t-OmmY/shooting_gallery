<?php

class GoogleAuth
{
    private static $client_id = GOOGLE_CLIENT_ID; // Client ID
    private static $client_secret = GOOGLE_CLIENT_SECRET; // Client secret
    private static $redirect_path = '/Library/GoogleAuth.php';
    private static $redirect_host = REDIRECT_URI_HOST; // Redirect URIs

    private static $url = 'https://accounts.google.com/o/oauth2/auth';

    public static function getLoginParams()
    {
        return array(
            'redirect_uri'  => 'http://' . self::$redirect_host . self::$redirect_path,
            'response_type' => 'code',
            'client_id'     => self::$client_id,
            'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
        );
    }

    public static function getLoginButton()
    {
        return $link = '<a href="' . self::$url . '?' . urldecode(http_build_query(self::getLoginParams())) . '"><img src="../helpers/img/google.ico" width="30" title="Get in with Google"></a>';
    }

    public static function processLogin()
    {
        if (isset($_GET['code'])) {
            require_once '../config.php';
            $params = array(
                'client_id' => self::$client_id,
                'client_secret' => self::$client_secret,
                'redirect_uri' => 'http://' . self::$redirect_host . self::$redirect_path,
                'grant_type' => 'authorization_code',
                'code' => $_GET['code']
            );
            $url = 'https://accounts.google.com/o/oauth2/token';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($curl);
            curl_close($curl);
            $tokenInfo = json_decode($result, true);

            if (isset($tokenInfo['access_token'])) {
                $params['access_token'] = $tokenInfo['access_token'];

                $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
                if (isset($userInfo['id'])) {
                    $userInfo = array(
                        'nickname' => $userInfo['given_name'].$userInfo['id'],
                        'email' => $userInfo['email'],
                        'first_name' => $userInfo['given_name'],
                        'last_name' => $userInfo['family_name'],
                        'password' => 'Google_id'.$userInfo['id']
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
GoogleAuth::processLogin();