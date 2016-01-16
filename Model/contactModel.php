<?php


class contactModel
{
    public function saveMessage($param)
    {
        $status = 'Success';
        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare('INSERT INTO messages VALUES (null, :name, :email, :message, now() )');
            $sth->execute($param);

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return array(
            'status'=>$status,
        );
    }

    public function sendMessage($param)
    {
        require_once('PHPMailer-master/PHPMailerAutoload.php');

        $mail=new PHPMailer();
        $mail->CharSet = 'UTF-8';

        $body = "<b>{$param['name']}</b> write: <p>{$param['message']}</p> <i>To contact me, use {$param['email']}</i>";

        $mail->IsSMTP();
        $mail->Host       = 'smtp.gmail.com';

        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;

        $mail->Username   = 'xperiask17ise@gmail.com';
        $mail->Password   = 'tommybiggun';

        $mail->SetFrom('xperiask17ise@gmail.com', 'Денис');
        $mail->AddReplyTo($param['email'],'no-reply');
        $mail->Subject    = 'Shooter Gallery Contact Form';
        $mail->MsgHTML($body);

        $mail->AddAddress('xperiask17ise@gmail.com', 'Shooting Admin'); // куда отправлять и как он будет подписан

        //$mail->AddAttachment($fileName); // если нужно прикреплять файл
        return $mail->send();

    }

    public function getMessages()
    {
        $db = DbConnection::getInstance()->getPDO();

        $sth = $db->prepare('SELECT name, email, message, date FROM messages ORDER BY date DESC LIMIT 3');
        $sth->execute();

        $data = $sth->fetchAll(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception('email not found');
        }
        return $data;
    }
}