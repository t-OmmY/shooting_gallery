<?php
require_once '../config.php';
require_once '../Library/DbConnection.php';

class AJAXselectSession
{
    public static function select()
    {
        $session_id = $_POST['session_id'];
        //$session_id = 42;
        $db = DbConnection::getInstance()->getPDO();

        $sth = $db->prepare("SELECT s.session_name, s.date, t.name as target_name, c.name as caliber_name, c.diameter as caliber_diameter FROM sessions s JOIN targets t ON t.target_id=s.target_id JOIN calibers c ON c.caliber_id=s.caliber_id WHERE session_id = {$session_id}");
        $sth->execute();
        $session_info = $sth->fetch(PDO::FETCH_ASSOC);
        $sth = $db->prepare("SELECT h.x, h.y, c.color_name FROM hits h JOIN series s ON s.serie_id=h.serie_id JOIN colors c ON c.color_id=s.color_id WHERE session_id = {$session_id}");
        $sth->execute();
        $session_info['hits'] = $sth->fetchAll(PDO::FETCH_ASSOC);
        $session_info['target_name'] = str_replace(' #', '_', $session_info['target_name']);

        if (!$session_info) {
            throw new Exception('session not found');
        }

        echo json_encode($session_info);
    }
}
AJAXselectSession::select();