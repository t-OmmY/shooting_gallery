<?php

class AdminModel
{
    public function index()
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT session_id, date, session_name FROM sessions');
            $session_info = $sth->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return $session_info;


    }



    public function getInfoForNewSession()
    {
        $status = 'Success';
        $caliber_info = array();
        $shooter_info = array();
        $target_info = array();

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT first_name, last_name FROM shooters');
            $shooter_info = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT name as caliber_name, diameter FROM caliber');
            $caliber_info = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT name as target_name FROM targets');
            $target_info = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array($shooter_info, $caliber_info, $target_info, $status);
    }




    public function getInfoForNewSerie()
    {
        $status = 'Success';
        $color_info = array();

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT color_name FROM colors');
            $color_info = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array($color_info, $status);
    }




    public function getInfoAboutLastSerieAndSession()
    {
        $status = 'success';
        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT s.session_id as "id", s.date, s.session_name as "Session name", sh.first_name as shooter, t.name as target, c.name as caliber FROM sessions s JOIN caliber c ON s.caliber_id=c.caliber_id JOIN shooters sh ON sh.shooter_id = s.shooter_id JOIN targets t ON s.target_id=t.target_id ORDER BY s.session_id DESC LIMIT 1');
            $session = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT s.serie_id as "id", s.number as "№", s.name as "Serie name", c.color_name as "color", s.range, s.scope, s.firestyle, s.comment FROM series s JOIN colors c ON s.color_id=c.color_id ORDER BY s.serie_id DESC LIMIT 1');
            $serie = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array($session, $serie, $status);
    }




    public function postNewSession()
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
            $sth->execute($_POST);
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return $status;
    }

    public function postNewSerie()
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare ('INSERT INTO series VALUES (
      null,
      (SELECT color_id FROM colors WHERE color_name=:color),
      :range,
      :scope,
      :firestyle,
      :serie_name,
      :serie_comment,
      :serie_number,
      (SELECT session_id FROM sessions ORDER BY session_id DESC LIMIT 1)
      )');
            $sth->execute($_POST);

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return $status;
    }




    public function postNewHits()
    {

        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            foreach ($_POST as $hit){
                $sth = $db->prepare ('INSERT INTO hits VALUES (
          null,
          (SELECT serie_id FROM series ORDER BY serie_id DESC LIMIT 1),
          :x,
          :y
)');
                $sth->execute($hit);
            }

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return $status;
    }

}