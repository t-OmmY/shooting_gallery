<?php

class infoModel
{
    public function sessionList()
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT session_id FROM sessions ORDER BY session_id');
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array(
            'status' => $status,
            'result' => $result
        );

    }

    public function serieList($param)
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT number FROM series WHERE session_id='.$param);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array(
            'status' => $status,
            'result' => $result
        );

    }

    public function serieIdList()
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT serie_id FROM series ORDER BY serie_id');
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array(
            'status' => $status,
            'result' => $result
        );

    }

    public function hitList($param)
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT hit_id FROM hits WHERE serie_id='.$param);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array(
            'status' => $status,
            'result' => $result
        );

    }

    public function forNewSession()
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT first_name FROM shooters');
            $shooter_info = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT name as caliber_name FROM caliber');
            $caliber_info = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT name as target_name FROM targets');
            $target_info = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array(
            'status'=>$status,
            'shooter_info'=>$shooter_info,
            'caliber_info'=>$caliber_info,
            'target_info'=>$target_info
        );
    }

    public function forNewSerie($param)
    {
        $status = 'Success';

        try {

            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT count(*) as number FROM series WHERE session_id='.$param);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT color_name FROM colors');
            $color_info = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT scope_name FROM scope');
            $scope_info = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT firestyle_name FROM firestyle');
            $firesyle_info = $sth->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array(
            'status'=>$status,
            'color_info'=>$color_info,
            'number'=>$result['number'] + 1,
            'firestyle_info'=>$firesyle_info,
            'scope_info'=>$scope_info,
            'session_id'=>$param
        );
    }

    public function sessionInfo($param)
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT s.session_id, s.date, s.session_name, sh.first_name as shooter, t.name as target, c.name as caliber FROM sessions s JOIN caliber c ON s.caliber_id=c.caliber_id JOIN shooters sh ON sh.shooter_id = s.shooter_id JOIN targets t ON s.target_id=t.target_id WHERE session_id='.$param);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array(
            'status'=>$status,
            'result'=>$result
        );

    }

    public function serieInfo($param)
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT s.session_id, s.serie_id, s.number, c.color_name as \'color\', s.range, sc.scope_name as \'scope\', f.firestyle_name as \'firestyle\', s.name, s.comment FROM series s JOIN firestyle f ON f.firestyle_id=s.firestyle_id JOIN colors c ON c.color_id=s.color_id JOIN scope sc ON sc.scope_id=s.scope_id WHERE serie_id='.$param);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return array(
            'status'=>$status,
            'result'=>$result
        );

    }

    public function hitInfo($param)
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT * FROM hits WHERE hit_id='.$param);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return array(
            'status'=>$status,
            'result'=>$result
        );

    }

    public function serieIdBySessionIdAndNubmer($session_id, $number)
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT serie_id FROM series WHERE session_id='.$session_id.' AND number='.$number);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return array(
            'status'=>$status,
            'result'=>$result
        );
    }
}
