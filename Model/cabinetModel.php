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

    public function getAJAXinfo($param)
    {
        $hits = self::select('SELECT h.x, h.y, c.color_name FROM hits h JOIN series s ON s.serie_id=h.serie_id JOIN colors c ON c.color_id=s.color_id WHERE session_id ='.$param);
        $target = self::select('SELECT name FROM `targets` t JOIN sessions s ON t.target_id=s.target_id WHERE s.session_id ='.$param, 'fetch');
        $target['result']['name'] = str_replace(' #', '_', $target['result']['name']);
        return array(
            'hits' => $hits['result'],
            'target' => $target['result']
        );
    }




}