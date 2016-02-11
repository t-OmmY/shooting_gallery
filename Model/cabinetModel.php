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
        $status = 'Success';

        try {
            $db = DbConnection::getInstance()->getPDO();

            $sth = $db->query("SELECT s.session_name, s.date, t.name as target_name, c.name as caliber_name, c.diameter as caliber_diameter FROM sessions s JOIN targets t ON t.target_id=s.target_id JOIN calibers c ON c.caliber_id=s.caliber_id WHERE session_id = {$session_id}");
            $session_info = $sth->fetch(PDO::FETCH_ASSOC);
            $session_info['target_name'] = str_replace(' #', '_', $session_info['target_name']);
            $sth = $db->query("SELECT h.x, h.y, c.color_name FROM hits h JOIN series s ON s.serie_id=h.serie_id JOIN colors c ON c.color_id=s.color_id WHERE session_id = {$session_id}");
            $session_info['hits'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = $db->query("SELECT s.serie_id, s.number, s.name, c.color_name, ROUND(AVG(SQRT(h.x*h.x+h.y*h.y)),2) as 'ad', ROUND(AVG(h.x),2) as 'x0', ROUND(AVG(h.y),2) as 'y0' FROM series s JOIN colors c ON c.color_id=s.color_id JOIN hits h ON s.serie_id=h.serie_id WHERE session_id = {$session_id} GROUP BY serie_id");
            $session_info['serie_list'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            if ($session_info['serie_list'] == array()){
                $session_info['serie_list'] = 'empty';
            } else {
                $sth = $db->prepare("SELECT ROUND(((x-:x0)*(x-:x0)+(y-:y0)*(y-:y0)),2) as 'distanse' FROM hits WHERE serie_id = :serie_id ORDER BY `distanse` DESC");
                $j=0;
                foreach ($session_info['serie_list'] as $serie) {
                    $param = array(
                        'x0'=>$serie['x0'],
                        'y0'=>$serie['y0'],
                        'serie_id'=>$serie['serie_id']
                    );
                    $sth->execute($param);
                    $r_all = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $r100 = round(sqrt($r_all[0]['distanse']),2);
                    $i = count($r_all);
                    $mid = intval($i/2);
                    if ($i%2==0){
                        $r50 = round((sqrt($r_all[$mid-1]['distanse'])+sqrt($r_all[$mid]['distanse']))/2,2); // потому что начинается массив с нуля, а не с 1
                    } else {
                        $r50 = round(sqrt($r_all[$mid]['distanse']),2); // потому что начинается массив с нуля, а не с 1
                    }
                    $session_info['serie_list'][$j]['r100'] = $r100;
                    $session_info['serie_list'][$j]['r50'] = $r50;
                    $j++;
                }

                $sth = $db->prepare("SELECT SUM(POW((:ad - SQRT(x*x+y*y)),2)) as 'an_sum', COUNT(x) as 'n' FROM hits WHERE serie_id = :serie_id ");
                $j=0;
                foreach ($session_info['serie_list'] as $serie) {
                    $param = array(
                        'ad' => $serie['ad'],
                        'serie_id' => $serie['serie_id']
                    );
                    $sth->execute($param);
                    $sth->execute($param);
                    $an = $sth->fetch(PDO::FETCH_ASSOC);
                    if ($an['n'] == 1){
                        $sd = 0;
                    } else {
                        $sd = round(sqrt($an['an_sum']/($an['n']-1)),2);
                    }
                    $session_info['serie_list'][$j]['sd'] = $sd;
                    $j++;
                }
                $ad = 0;
                $x0 = 0;
                $y0 = 0;
                $r100 = 0;
                $r50 = 0;
                $sd = 0;
                $den = 0;
                foreach ($session_info['serie_list'] as $serie) {
                    $ad+=$serie['ad'];
                    $x0+=$serie['x0'];
                    $y0+=$serie['y0'];
                    $r100+=$serie['r100'];
                    $r50+=$serie['r50'];
                    $sd+=$serie['sd'];
                    $den++;
                }
                $session_info['ses_stat']= array(
                    'ad' => round($ad/$den,2),
                    'x0' => round($x0/$den,2),
                    'y0' => round($y0/$den,2),
                    'r100' => round($r100/$den,2),
                    'r50' => round($r50/$den,2),
                    'sd' => round($sd/$den,2)
                );
            }
            if (!$session_info) {
                throw new Exception('session not found');
            }
        } catch (PDOException $e) {
            $status = 'Fail: ' . $e->getMessage();
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
            throw new Exception('serie not found');
        }
        return $serie_info;
    }
}