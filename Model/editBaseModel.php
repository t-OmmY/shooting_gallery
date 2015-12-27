<?php

class editbaseModel
{
    public function index()
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SELECT color_name FROM colors ORDER BY color_id');
            $color_list = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT name, diameter FROM caliber ORDER BY caliber_id');
            $caliber_list = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT firestyle_name FROM firestyle ORDER BY firestyle_id');
            $firestyle_list = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT scope_name FROM scope ORDER BY scope_id');
            $scope_list = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT name FROM targets ORDER BY target_id');
            $target_list = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query('SELECT first_name, last_name FROM shooters ORDER BY shooter_id');
            $shooter_list = $sth->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array(
            'status' => $status,
            'color_list' => $color_list,
            'caliber_list' => $caliber_list,
            'firestyle_list' => $firestyle_list,
            'scope_list' => $scope_list,
            'target_list' => $target_list,
            'shooter_list' => $shooter_list
        );

    }

    public function del($param)
    {
        $status = 'Success';
        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare('DELETE FROM '.$param["table"].' WHERE '.$param["key"].'="'.$param['value'].'"');
            $sth->execute();
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return $status;

    }

    public function formInfo($param)
    {
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query('SHOW columns FROM '.$param);
            $columns = $sth->fetchAll(PDO::FETCH_ASSOC);
            $field = array();
            foreach ($columns as $val){
                array_push($field, $val['Field']);
            }
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }

        return array(
            'status' => $status,
            'field' => $field
        );
    }

    public function add($table, $values)
    {
        $param = '';
        foreach ($values as $key => $value){
            $param.= ':'.$key.',';
        }
        $param = rtrim($param, ',');
        $status = 'Success';
        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->prepare ('INSERT INTO '.$table.' VALUES (
      null, '.$param.')');
            $sth->execute($values);

        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
        }
        return array(
            'status'=>$status,
        );

    }
}