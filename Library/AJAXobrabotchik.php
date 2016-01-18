<?php
require_once '../config.php';
require_once '../Library/DbConnection.php';

class AJAXobrabotchik
{
    public static function contactAJAX()
    {
        $startFrom = $_POST['startFrom'];
        $db = DbConnection::getInstance()->getPDO();

        $sth = $db->prepare("SELECT name, email, message, date FROM messages ORDER BY date DESC LIMIT {$startFrom}, 5");
        $sth->execute();

        $messages = $sth->fetchAll(PDO::FETCH_ASSOC);

        if (!$messages) {
            throw new Exception('email not found');
        }

        echo json_encode($messages);
    }
}
AJAXobrabotchik::contactAJAX();