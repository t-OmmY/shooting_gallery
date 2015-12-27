<?php

class updateModel
{
    public function addSession($param)
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare('INSERT INTO sessions VALUES (
      null,
      :date,
      :session_name,
      (SELECT target_id FROM targets WHERE name=:target),
      (SELECT shooter_id FROM shooters WHERE first_name=:shooter),
      (SELECT caliber_id FROM caliber WHERE name=:caliber)
      )');
            $sth->execute($param);
            $sth = $db->query('SELECT session_id FROM sessions ORDER BY session_id DESC LIMIT 1');
            $result = ($sth->fetch(PDO::FETCH_ASSOC));

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }


        return array(
            'status'=>$status,
            'session_id'=>$result['session_id']);
    }



    public function addSerie($params)
    {
        $status = 'Success';

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
            $sth = $db->query('SELECT serie_id FROM series ORDER BY serie_id DESC LIMIT 1');
            $result = ($sth->fetch(PDO::FETCH_ASSOC));

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }


        return array(
            'status'=>$status,
            'serie_id'=>$result['serie_id'],
            'session_id'=>$params['session_id']
            );
    }


    public function addHits($param)
    {
        $status = 'Success';
        $serie_id = $param['serie_id'];
        unset($param['serie_id']);
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

    public function editSession($param)
    {
        $status = 'Success';
        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare('UPDATE sessions SET
                                 date=:date,
                                 session_name=:session_name,
                                 target_id=(SELECT target_id FROM targets WHERE name=:target),
                                 shooter_id=(SELECT shooter_id FROM shooters WHERE first_name=:shooter),
                                 caliber_id=(SELECT caliber_id FROM caliber WHERE name=:caliber)
                                 WHERE session_id=:session_id
                                ');
            $sth->execute($param);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return $status;
}

    public function editSerie($param)
    {
        $status = 'Success';
        try {
            $db = DbConnection::getInstance()->getPDO();

            if (!isset($param['serie_number'])){
                $param['serie_number']=null;
            }

            $sth = $db->prepare ('UPDATE series SET
      color_id=(SELECT color_id FROM colors WHERE color_name=:color),
      `range`=:range,
      scope_id=(SELECT scope_id FROM scope WHERE scope_name=:scope),
      firestyle_id=(SELECT firestyle_id FROM firestyle WHERE firestyle_name=:firestyle),
      `name`=:serie_name,
      comment=:serie_comment,
      `number`=:serie_number,
      session_id=:session_id
      WHERE serie_id=:serie_id
      ');
            $sth->execute($param);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return $status;
    }

    public function editHit($param)
    {
        $status = 'Success';
        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare ('UPDATE hits SET
          serie_id=:serie_id,
          x=:x,
          y=:y
          WHERE hit_id=:hit_id
');
            $sth->execute($param);

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return $status;
    }

    public function deleteSession($param)
    {
        $status = 'Success';
        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare('DELETE FROM sessions WHERE session_id=:session_id');
            $sth->execute($param);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return $status;

    }

    public function deleteSerie($param)
        {
            $status = 'Success';
            try {
                $db = DbConnection::getInstance()->getPDO();

                $sth = $db->prepare('DELETE FROM series WHERE serie_id='.$_POST['serie_id']);
                $sth->execute();
            } catch (PDOException $e) {
                $status = 'Fail: ' . $e->getMessage();
            }
            return $status;

        }

    public function deleteHit($param)
        {
            $status = 'Success';
            try {
                $db = DbConnection::getInstance()->getPDO();

                $sth = $db->prepare('DELETE FROM hits WHERE hit_id='.$_POST['hit_id']);
                $sth->execute();
            } catch (PDOException $e) {
                $status = 'Fail: ' . $e->getMessage();
            }
            return $status;

        }


}
