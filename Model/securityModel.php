<?php

class securityModel
{
    public function isValid($param)
    {
        foreach ($param as $check){
            if ($check == ''){
                return false;
            }
        }
        return true;
    }

    public function addLogin($params)
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare('INSERT INTO shooters VALUES (
      null,
      :nickname,
      :first_name,
      :last_name,
      :email,
      :password
      )');
            $sth->execute($params);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return $status;
    }

    public function getUser($nickname, $password)
    {

        $db = DbConnection::getInstance()->getPDO();
        $sth = $db->prepare('SELECT nickname FROM shooters WHERE nickname = :nickname AND password = :password');
        $params = array(
            'nickname' => $nickname,
            'password' => (string)$password
        );

        $sth->execute($params);

        $data = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception('User not found');
        }

        return $data;
    }
}