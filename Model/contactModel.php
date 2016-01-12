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

            $sth = $db->prepare('INSERT INTO messages VALUES (null, :email, :message, CURRENT_TIME )');
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
        $to  = "Denys &lt;xperiask17ise@gmail.com>, " ;

        $subject = "Contact form from Shooting Gallery";

        $message = "
<html>
    <head>
        <title>Message from {$param['email']}:</title>
    </head>
    <body>
        <p>{$param['message']}</p>
    </body>
</html>";

        $headers  = "Content-type: text/html; charset=windows-1251 \r\n";

        mail($to, $subject, $message, $headers);
    }
}