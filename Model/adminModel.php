<?php

class adminModel
{
    public static function select($query, $style = 'fetchAll')
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

    public function sessionList()
    {
        return self::select('SELECT session_id, date, session_name FROM sessions ORDER BY date DESC');
    }

    public function serieList($param)
    {
        return self::select('SELECT number, name FROM series WHERE session_id='.$param);
    }

    public function serieIdList()
    {
        return self::select('SELECT serie_id, number, name FROM series ORDER BY serie_id');
    }

    public function hitList($param)
    {
        return self::select('SELECT hit_id FROM hits WHERE serie_id='.$param);
    }

    public function forNewSession()
    {
        $shooter_info = self::select('SELECT nickname, first_name, last_name FROM shooters');
        $caliber_info = self::select('SELECT name as caliber_name FROM calibers');
        $target_info = self::select('SELECT name as target_name FROM targets');
        return array(
            'shooter_info'=>$shooter_info['result'],
            'caliber_info'=>$caliber_info['result'],
            'target_info'=>$target_info['result']
        );
    }

    public function forNewSerie($param)
    {
        $number = self::select('SELECT max(number)+1 as number FROM series WHERE session_id='.$param, 'fetch');
        if ($number['result']['number'] == array()){
            $number['result']['number'] = 1;
        }
        $color_info = self::select("SELECT color_name FROM colors WHERE color_id not in(SELECT color_id FROM series WHERE session_id = {$param})");
        $scope_info = self::select('SELECT scope_name FROM scope');
        $firesyle_info = self::select('SELECT firestyle_name FROM firestyle');
        return array(
            'color_info'=>$color_info['result'],
            'number'=>$number['result']['number'],
            'firestyle_info'=>$firesyle_info['result'],
            'scope_info'=>$scope_info['result'],
            'session_id'=>$param
        );
    }

    public function sessionInfo($param)
    {
        return self::select('SELECT s.session_id, s.date, s.session_name, sh.nickname as shooter, t.name as target, c.name as caliber FROM sessions s JOIN calibers c ON s.caliber_id=c.caliber_id JOIN shooters sh ON sh.shooter_id = s.shooter_id JOIN targets t ON s.target_id=t.target_id WHERE session_id='.$param, 'fetch');
    }

    public function serieInfo($param)
    {
        return self::select('SELECT s.session_id, s.serie_id, s.number, c.color_name as \'color\', s.range, sc.scope_name as \'scope\', f.firestyle_name as \'firestyle\', s.name, s.comment FROM series s JOIN firestyle f ON f.firestyle_id=s.firestyle_id JOIN colors c ON c.color_id=s.color_id JOIN scope sc ON sc.scope_id=s.scope_id WHERE serie_id='.$param, 'fetch');
    }

    public function hitInfo($param)
    {
        return self::select('SELECT * FROM hits WHERE hit_id='.$param, 'fetch');
    }

    public function serieIdBySessionIdAndNubmer($session_id, $number)
    {
        return self::select('SELECT serie_id FROM series WHERE session_id='.$session_id.' AND number='.$number, 'fetch');
    }

    public function prepare($query, $param = array())
    {
        $status = 'Success';
        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare($query);
            $sth->execute($param);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return $status;

    }

    public function deleteSession($param)
    {
        return self::prepare('DELETE FROM sessions WHERE session_id=:session_id', $param);
    }

    public function deleteSerie()
    {
        return self::prepare('DELETE FROM series WHERE serie_id='.$_POST['serie_id']);
    }

    public function deleteHit()
    {
        return self::prepare('DELETE FROM hits WHERE hit_id='.$_POST['hit_id']);
    }

    public function editHit($param)
    {
        return self::prepare('UPDATE hits SET
          serie_id=:serie_id,
          x=:x,
          y=:y
          WHERE hit_id=:hit_id
', $param);
    }

    public function editSerie($param)
    {
        return self::prepare('UPDATE series SET
      color_id=(SELECT color_id FROM colors WHERE color_name=:color),
      `range`=:range,
      scope_id=(SELECT scope_id FROM scope WHERE scope_name=:scope),
      firestyle_id=(SELECT firestyle_id FROM firestyle WHERE firestyle_name=:firestyle),
      `name`=:serie_name,
      comment=:serie_comment,
      `number`=:serie_number,
      session_id=:session_id
      WHERE serie_id=:serie_id
      ', $param);
    }

    public function editSession($param)
    {
        return self::prepare('UPDATE sessions SET
                                 date=:date,
                                 session_name=:session_name,
                                 target_id=(SELECT target_id FROM targets WHERE name=:target),
                                 shooter_id=(SELECT shooter_id FROM shooters WHERE first_name=:shooter),
                                 caliber_id=(SELECT caliber_id FROM calibers WHERE name=:caliber)
                                 WHERE session_id=:session_id
                                ', $param);
    }

    public function addSession($param)
    {
        $status = 'Success';
        $session_id = null;

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare('INSERT INTO sessions VALUES (
      null,
      :date,
      :session_name,
      (SELECT target_id FROM targets WHERE name=:target),
      (SELECT shooter_id FROM shooters WHERE nickname=:shooter),
      (SELECT caliber_id FROM calibers WHERE name=:caliber)
      )');
            $sth->execute($param);
            $session_id = $db->lastInsertId();

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return array(
            'status'=>$status,
            'session_id'=>$session_id
        );
    }



    public function addSerie($params)
    {
        $status = 'Success';
        $serie_id = null;

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare ('INSERT INTO series VALUES (
      null,
      (SELECT color_id FROM colors WHERE color_name=:color),
      :range,
      (SELECT scope_id FROM scope WHERE scope_name=:scope),
      (SELECT firestyle_id FROM firestyle WHERE firestyle_name=:firestyle),
      :serie_name,
      :serie_comment,
      :serie_number,
      :session_id
      )');
            $sth->execute($params);
            $serie_id = $db->lastInsertId();

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }


        return array(
            'status'=>$status,
            'serie_id'=>$serie_id,
            'session_id'=>$params['session_id']
        );
    }


    public function addHits($param)
    {
        $status = 'Success';
        $serie_id = $param['serie_id'];
        unset($param['serie_id']);
        unset($param['session_id']);
        try {
            $db = DbConnection::getInstance()->getPDO();

            foreach ($param as $hit){
                $sth = $db->prepare ('INSERT INTO hits VALUES (
          null,
          '.$serie_id.',
          :x,
          :y
)');
                $sth->execute($hit);
            }

            $sth = $db->query('SELECT session_id FROM series WHERE serie_id='.$serie_id);
            $result = ($sth->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return array(
            'status'=>$status,
            'session_id'=>$result['session_id']);
    }
}


