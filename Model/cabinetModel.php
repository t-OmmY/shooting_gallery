<?php

class cabinetModel
{
    private static function select($query, $style = 'fetchAll')
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query($query);
            $result = $sth->$style(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array(
            'status' => $status,
            'result' => $result
        );
    }

    public function getUserSessionList($param)
    {
        return self::select('SELECT se.session_id, se.date, se.session_name FROM sessions se JOIN shooters sh ON sh.shooter_id=se.shooter_id WHERE sh.nickname = "'.$param.'"');
    }

    public function ajax_select_session($session_id)
    {
        $session_info = self::select("SELECT s.session_name, s.date, t.name as target_name, c.name as caliber_name, c.diameter as caliber_diameter FROM sessions s JOIN targets t ON t.target_id=s.target_id JOIN calibers c ON c.caliber_id=s.caliber_id WHERE session_id = {$session_id}", 'fetch');
        $session_info = $session_info['result'];
        $session_info['hits'] = self::select("SELECT h.x, h.y, c.color_name FROM hits h JOIN series s ON s.serie_id=h.serie_id JOIN colors c ON c.color_id=s.color_id WHERE session_id = {$session_id}");
        $session_info['hits'] = $session_info['hits']['result'];
        $session_info['target_name'] = str_replace(' #', '_', $session_info['target_name']);
        $session_info['serie_list'] = self::select("SELECT serie_id, number, name FROM series WHERE session_id = {$session_id}");
        $session_info['serie_list'] = $session_info['serie_list']['result'];
        if (!$session_info) {
            throw new Exception('session not found');
        }
        return $session_info;
    }

    public function ajax_select_serie($serie_id)
    {
        $serie_info = self::select("SELECT s.name, s.range, s.comment, s.number, c.color_name, f.firestyle_name, sc.scope_name FROM series s JOIN colors c ON c.color_id=s.color_id JOIN firestyle f ON f.firestyle_id=s.firestyle_id JOIN scope sc ON sc.scope_id=s.scope_id WHERE serie_id = {$serie_id}", 'fetch');
        $serie_info = $serie_info['result'];
        $serie_info['hits'] = self::select("SELECT x, y FROM hits WHERE serie_id = {$serie_id}");
        $serie_info['hits']= $serie_info['hits']['result'];
        if (!$serie_info) {
            throw new Exception('session not found');
        }
        return $serie_info;
    }



}