<?php


class contactModel
{
    public function getUserEmail($param)
    {
        $db = DbConnection::getInstance()->getPDO();

        $sth = $db->prepare('SELECT email FROM shooters WHERE nickname = :nickname');
        $sth->execute($param);

        $data = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception('email not found');
        }
        return $data;
    }

    public function sendMessage($param)
    {
        $status = 'Success';
        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare('INSERT INTO messages VALUES (null, :email, :message, now() )');
            $sth->execute($param);

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return array(
            'status'=>$status,
        );
    }

    public function saveMessage($param)
    {
        $to  = "<xperiask17ise@gmail.com>" ;

        $subject = "From shooting gallery";

        $message = " <p>{$param['email']} write:</p> </br> <i>{$param['message']} </i>";

        $headers  = "Content-type: text/html; charset=windows-1251 \r\n";
        $headers .= "From: <test@pisem.net>\r\n";
        $headers .= "Reply-To: {$param['email']}\r\n";

        mail($to, $subject, $message, $headers);
    }
}