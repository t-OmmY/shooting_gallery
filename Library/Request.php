<?php


class Request
{
    private $get = array();
    private $post = array();
    private $server = array();

    function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
    }

    private function valueByKey($property, $key)
    {
        if ($property == 'get' || 'post' || 'server') {
            $arr = $this->$property;
            return isset($arr[$key]) ? $arr[$key] : null;
        } else{
            die ($property.' - Unknown property of Request class');
        }
    }

    public function get($key)
    {
        return $this->valueByKey('get', $key);
    }

    public function post($key)
    {
        return $this->valueByKey('post', $key);
    }

    public function server($key)
    {
        return $this->valueByKey('server', $key);
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }


}