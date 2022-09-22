<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../../config/bd.php';
$a =
$db = new DB();
$films = [];
//$check_th = $db->Query_try("SELECT * from pairs where id_event = 'third'");
$check_th = $db->Query_try("SELECT pairs.id, id_v, id_m, id_event_vote, rating, rating_kp from pairs join vote on vote.id_event = id_event_vote join movie on (id_m = first or id_m = second) where pairs.id_event = 'third'");

if($check_th->num_rows != 0)
{
    while ($first = $check_th->fetch_assoc())
    {
        $second = $check_th->fetch_assoc();
        $pair = [$first, $second];
        $count_f = $db->Query_try("SELECT COUNT(*) as cout from votelist where id_vote = '{$first['id_v']}' and choise = '{$first['id_m']}'");
        $count_s = $db->Query_try("SELECT COUNT(*) as cout from votelist where id_vote = '{$second['id_v']}' and choise = '{$second['id_m']}'");
        $f =  ($count_f->fetch_assoc())['cout'];
        $s =  ($count_s->fetch_assoc())['cout'];
        if($f == $s)
        {
            $film = ((($first['rating']+$first['rating_kp'])/2) > (($second['rating']+$second['rating_kp'])/2)) ? $first : $second;
        }
        else
        {
            $film = ($f > $s) ? $first : $second;
        }
        $films[] = $film;


        $db->Query_try("UPDATE pairs set selected = '{$film['id_m']}' where id = '{$film['id']}'");



    }
    for($i = 0; $i < 2; $i+=2)
    {
        $j = $i+1;
        $id = uniqid();
        $db->Query_try("INSERT INTO `pairs`(`id_exp`, `first`, `second`, `id_event`, `id_event_vote`) values(NULL, '{$films[$i]['id_m']}', '{$films[$j]['id_m']}', 'final', '$id')");
    }
}
else
{
//    $check_th = $db->Query_try("SELECT * from pairs where id_event = 'second'");
    $check_th = $db->Query_try("SELECT id, id_v, id_m, id_event_vote, rating, rating_kp from pairs join vote on vote.id_event = id_event_vote join movie on (id_m = first or id_m = second) where pairs.id_event = 'second'");

    if ($check_th->num_rows != 0)
    {
        while ($first = $check_th->fetch_assoc())
        {
            $second = $check_th->fetch_assoc();
            $pair = [$first, $second];
            $count_f = $db->Query_try("SELECT COUNT(*) as cout from votelist where id_vote = '{$first['id_v']}' and choise = '{$first['id_m']}'");
            $count_s = $db->Query_try("SELECT COUNT(*) as cout from votelist where id_vote = '{$second['id_v']}' and choise = '{$second['id_m']}'");
            $f =  ($count_f->fetch_assoc())['cout'];
            $s =  ($count_s->fetch_assoc())['cout'];
            if($f == $s)
            {
                $film = ((($first['rating']+$first['rating_kp'])/2) > (($second['rating']+$second['rating_kp'])/2)) ? $first : $second;
            }
            else
            {
                $film = ($f > $s) ? $first : $second;
            }
            $films[] = $film;


            $db->Query_try("UPDATE pairs set selected = '{$film['id_m']}' where id = '{$film['id']}'");




        }
        for($i = 0; $i < 4; $i+=2)
        {
            $j = $i+1;
            $id = uniqid();
            $db->Query_try("INSERT INTO `pairs`(`id_exp`, `first`, `second`, `id_event`, `id_event_vote`) values(NULL, '{$films[$i]['id_m']}', '{$films[$j]['id_m']}', 'third', '$id')");
        }
    }
    else
    {
        $check_th = $db->Query_try("SELECT id,id_v, id_m, id_event_vote, rating, rating_kp from pairs join vote on vote.id_event = id_event_vote join movie on (id_m = first or id_m = second) where pairs.id_event = 'first'");
        if ($check_th->num_rows != 0)
        {
            while ($first = $check_th->fetch_assoc())
            {
                $second = $check_th->fetch_assoc();
                $pair = [$first, $second];
                $count_f = $db->Query_try("SELECT COUNT(*) as cout from votelist where id_vote = '{$first['id_v']}' and choise = '{$first['id_m']}'");
                $count_s = $db->Query_try("SELECT COUNT(*) as cout from votelist where id_vote = '{$second['id_v']}' and choise = '{$second['id_m']}'");
                $f =  ($count_f->fetch_assoc())['cout'];
                $s =  ($count_s->fetch_assoc())['cout'];
                if($f == $s)
                {
                    $film = ((($first['rating']+$first['rating_kp'])/2) > (($second['rating']+$second['rating_kp'])/2)) ? $first : $second;
                }
                else
                {
                    $film = ($f > $s) ? $first : $second;
                }
                $films[] = $film;
                

                $db->Query_try("UPDATE pairs set selected = '{$film['id_m']}' where id = '{$film['id']}'");




            }
            for($i = 0; $i < 7; $i+=2)
            {
                $j = $i+1;
                $id = uniqid();
                $db->Query_try("INSERT INTO `pairs`(`id_exp`, `first`, `second`, `id_event`, `id_event_vote`) values(NULL, '{$films[$i]['id_m']}', '{$films[$j]['id_m']}', 'second', '$id')");
            }
        }
    }

}
