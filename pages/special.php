<?php

require 'config/bd.php';


$db = new DB();
$total = [];
$movs= [];

$pairs = $db->Query_try("SELECT poster, url, name_m, id_m, id_event_vote, id_v, selected  from pairs join movie on (first = id_m or second = id_m) join vote on vote.id_event = id_event_vote where pairs.id_event = 'first'");
while($row = $pairs->fetch_assoc())
{
    $id_event = $row['id_event_vote'];
    $votes = $db->Query_try("SELECT avatar, id_e from votelist join expert using(id_e) join vote on id_vote = id_v where id_event = '$id_event' and choise='{$row['id_m']}'");
     $count = $db->Query_try("SELECT COUNT(*) as co from votelist join vote on id_vote = id_v where id_event = '{$row['id_event_vote']}'");
    while($vote = $votes->fetch_assoc())
    {
        if(($count->fetch_assoc()['co'])==9)
        {
            $row['done'] = 1;
        }
        $row['votes'][] = $vote['avatar'];
    }
    $movs[1][] = $row;
}
$pairs = $db->Query_try("SELECT poster, url, name_m, id_m, id_event_vote, id_v, selected  from pairs join movie on (first = id_m or second = id_m) join vote on vote.id_event = id_event_vote where pairs.id_event = 'second'");
while($row = $pairs->fetch_assoc())
{
    $id_event = $row['id_event_vote'];
    $votes = $db->Query_try("SELECT avatar, id_e from votelist join expert using(id_e) join vote on id_vote = id_v where id_event = '$id_event' and choise='{$row['id_m']}'");
    $count = $db->Query_try("SELECT COUNT(*) as co from votelist join vote on id_vote = id_v where id_event = '{$row['id_event_vote']}'");

    while($vote = $votes->fetch_assoc())
    {
        if(($count->fetch_assoc()['co'])==9)
        {
            $row['done'] = 1;
        }
        $row['votes'][] = $vote['avatar'];
    }
    $movs[2][] = $row;
}
$pairs = $db->Query_try("SELECT poster, url, name_m, id_m, id_event_vote, id_v, selected  from pairs join movie on (first = id_m or second = id_m) join vote on vote.id_event = id_event_vote where pairs.id_event = 'third'");
while($row = $pairs->fetch_assoc())
{
    $id_event = $row['id_event_vote'];
    $votes = $db->Query_try("SELECT avatar, id_e from votelist join expert using(id_e) join vote on id_vote = id_v where id_event = '$id_event' and choise='{$row['id_m']}'");
    $count = $db->Query_try("SELECT COUNT(*) as co from votelist join vote on id_vote = id_v where id_event = '{$row['id_event_vote']}'");

    while($vote = $votes->fetch_assoc())
    {
        if(($count->fetch_assoc()['co'])==9)
        {
            $row['done'] = 1;
        }
        $row['votes'][] = $vote['avatar'];
    }
    $movs[3][] = $row;
}
$pairs = $db->Query_try("SELECT poster, url, name_m, id_m, id_event_vote, id_v, selected  from pairs join movie on (first = id_m or second = id_m) join vote on vote.id_event = id_event_vote where pairs.id_event = 'final'");
while($row = $pairs->fetch_assoc())
{
    $id_event = $row['id_event_vote'];
    $votes = $db->Query_try("SELECT avatar, id_e from votelist join expert using(id_e) join vote on id_vote = id_v where id_event = '$id_event' and choise='{$row['id_m']}'");
    while($vote = $votes->fetch_assoc())
    {
        if(($count->fetch_assoc()['co'])==9)
        {
            $row['done'] = 1;
        }
        $row['votes'][] = $vote['avatar'];
    }
    $movs[4][] = $row;
}
//debug($movs);
//exit;
?>
<div class="container-fluid bg-main rad-0 main content py-2" style="margin-top: 88px; margin-bottom: -20px">
<div class="row totot ">
    <div class="col type-descr bg-main text-white  mb-3">
        <div class="container tour-table middle">
            <div class="col-13">
                <?php for($i=0; $i<8; $i+=2):
                    $a=$i+1;?>
                <div class="cell-pair mb-4 modal-vote <?=($movs[1][$i]['done']==1 || $movs[1][$a]['done']==1) ? 'selected' : ''?>"  data-vote='<?=$movs[1][$i]['id_event_vote']?>' data-movies='<?=json_encode(array('first'=>$movs[1][$i], 'second'=>$movs[1][$a]), true)?>'>
                    <div class="cell"> <img class="vote-image <?=($movs[1][$i]['selected']==$movs[1][$i]['id_m']  or  $movs[1][$i]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[1][$i]['poster']?>"> </div>
                    <div class="cell"><img class="vote-image <?=($movs[1][$a]['selected']==$movs[1][$a]['id_m']  or  $movs[1][$a]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[1][$a]['poster']?>"></div>
                </div>
                <?php endfor; ?>
            </div>
            <div class="col-13">
                <?php if($movs[2]): ?>
                <?php for($i=0; $i<4; $i+=2):
                    $a=$i+1;?>
                    <div class="cell-pair mb-4 modal-vote <?=($movs[2][$i]['done']==1 || $movs[2][$a]['done']==1) ? 'selected' : ''?>"  data-vote='<?=$movs[2][$i]['id_event_vote']?>' data-movies='<?=json_encode(array('first'=>$movs[2][$i], 'second'=>$movs[2][$a]), true)?>'>
                        <div class="cell"> <img class="vote-image <?=($movs[2][$i]['selected']==$movs[2][$i]['id_m'] or  $movs[2][$i]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[2][$i]['poster']?>"> </div>
                        <div class="cell"><img class="vote-image <?=($movs[2][$a]['selected']==$movs[2][$a]['id_m']  or  $movs[2][$a]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[2][$a]['poster']?>"></div>
                    </div>
                <?php endfor; ?>
                <?php else: ?>
                    <div class="cell-pair">
                        <div class="cell a-t1"> 2 </div>
                        <div class="cell p-t1"> 3 </div>
                    </div>
                    <div class="cell-pair">
                        <div class="cell a-t1"> 2 </div>
                        <div class="cell p-t1"> 3 </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-13">
                <?php if($movs[3]): ?>
                    <?php for($i=0; $i<2; $i+=2):
                        $a=$i+1;?>
                        <div class="cell-pair mb-4 modal-vote <?=($movs[3][$i]['done']==1 || $movs[3][$a]['done']==1) ? 'selected' : ''?>"  data-vote='<?=$movs[3][$i]['id_event_vote']?>' data-movies='<?=json_encode(array('first'=>$movs[3][$i], 'second'=>$movs[3][$a]), true)?>'>
                            <div class="cell"> <img class="vote-image  <?=($movs[3][$i]['selected']==$movs[3][$i]['id_m'] or  $movs[3][$i]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[3][$i]['poster']?>"> </div>
                            <div class="cell"><img class="vote-image  <?=($movs[3][$a]['selected']==$movs[3][$a]['id_m']  or  $movs[3][$a]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[3][$a]['poster']?>"></div>
                        </div>
                    <?php endfor; ?>
                <?php else: ?>
                    <div class="cell-pair">
                        <div class="cell a-t2"> 2 </div>
                        <div class="cell p-t2"> 3 </div>
                    </div>

                <?php endif; ?>
            </div>
            <div class="col-22 col-final">
                <?php if($movs[4]): ?>
                        <div class=" mb-4 cell-final modal-vote <?=($movs[4][1]['done']==1 || $movs[4][2]['done']==1) ? 'selected' : ''?>"  data-vote='<?=$movs[4][1]['id_event_vote']?>' data-movies='<?=json_encode(array('first'=>$movs[4][0], 'second'=>$movs[4][1]), true)?>'>
                            <div class="cell-f"> <img class="vote-image vote-image-final <?=($movs[4][0]['selected']==$movs[4][0]['id_m'] or  $movs[4][0]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[4][0]['poster']?>"> </div>
                            <div class="cell-f"><img class="vote-image vote-image-final <?=($movs[4][1]['selected']==$movs[4][1]['id_m']  or  $movs[4][1]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[4][1]['poster']?>"></div>
                        </div>
                <?php else: ?>
                    <div class=" row cell-pair final m-0">
                        <div class="cell a-t3"> 2 </div>
                        <div class="cell p-t3"> 7 </div>
                    </div>

                <?php endif; ?>

            </div>
            <div class="col-13">
                <?php if($movs[3]): ?>
                    <?php for($i=2; $i<4; $i+=2):
                        $a=$i+1;?>
                        <div class="cell-pair mb-4 modal-vote <?=($movs[3][$i]['done']==1 || $movs[3][$a]['done']==1) ? 'selected' : ''?>"  data-vote='<?=$movs[3][$i]['id_event_vote']?>' data-movies='<?=json_encode(array('first'=>$movs[3][$i], 'second'=>$movs[3][$a]), true)?>'>
                            <div class="cell"> <img class="vote-image <?=($movs[3][$i]['selected']==$movs[3][$i]['id_m'] or  $movs[3][$i]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[3][$i]['poster']?>"> </div>
                            <div class="cell"><img class="vote-image <?=($movs[3][$a]['selected']==$movs[3][$a]['id_m']  or  $movs[3][$a]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[3][$a]['poster']?>"></div>
                        </div>
                    <?php endfor; ?>
                <?php else: ?>
                    <div class="cell-pair">
                        <div class="cell a-t2"> 2 </div>
                        <div class="cell p-t2"> 3 </div>
                    </div>

                <?php endif; ?>

            </div>
            <div class="col-13">
                <?php if($movs[2]): ?>
                    <?php for($i=4; $i<8; $i+=2):
                        $a=$i+1;?>
                        <div class="cell-pair mb-4 modal-vote <?=($movs[2][$i]['done']==1 || $movs[2][$a]['done']==1) ? 'selected' : ''?>"  data-vote='<?=$movs[2][$i]['id_event_vote']?>' data-movies='<?=json_encode(array('first'=>$movs[2][$i], 'second'=>$movs[2][$a]), true)?>'>
                            <div class="cell"> <img class="vote-image <?=($movs[2][$i]['selected']==$movs[2][$i]['id_m'] or  $movs[2][$i]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[2][$i]['poster']?>"> </div>
                            <div class="cell"><img class="vote-image <?=($movs[2][$a]['selected']==$movs[2][$a]['id_m']  or  $movs[2][$a]['selected']==0) ? '' : 'opacity-25'?>" src="<?=$movs[2][$a]['poster']?>"></div>
                        </div>
                    <?php endfor; ?>
                <?php else: ?>
                    <div class="cell-pair">
                        <div class="cell a-t1"> 2 </div>
                        <div class="cell p-t1"> 3 </div>
                    </div>
                    <div class="cell-pair">
                        <div class="cell a-t1"> 2 </div>
                        <div class="cell p-t1"> 3 </div>
                    </div>
                <?php endif; ?>

            </div>
            <div class="col-13">
                <?php for($i=8; $i<16; $i+=2):
                    $b=$i+1?>
                    <div class="cell-pair mb-4 modal-vote  <?=($movs[1][$i]['done']==1 || $movs[1][$b]['done']==1) ? 'selected' : ''?>" data-vote='<?=$movs[1][$i]['id_event_vote']?>' data-movies='<?=json_encode(array('first'=>$movs[1][$i], 'second'=>$movs[1][$b]), true)?>'>
                        <div class="cell"> <img class="vote-image <?=($movs[1][$i]['selected']==$movs[1][$i]['id_m'] or $movs[1][$i]['selected']==0 )? '' : 'opacity-25'?>" src="<?=$movs[1][$i]['poster']?>"> </div>
                        <div class="cell"><img class="vote-image <?=($movs[1][$b]['selected']==$movs[1][$b]['id_m'] or $movs[1][$i]['selected']==0 )? '' : 'opacity-25'?>" src="<?=$movs[1][$b]['poster']?>"></div>
                    </div>
                <?php endfor; ?>

            </div>
        </div>


    </div>


</div>

    <div id="statsBySeasons">





    </div>
</div>
<div class="modal fade" id="pairVoteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Проголосовать</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-6"  id="first">

                                <a href="" target="_blank"><img src=""  class="img-fluid rounded" id="first" style="width: 150px; height: 200px"alt=""></a>
                                <button class="btn btn-warning mt-3 btn-vote">Проголосовать</button>
                            <div class="avatars mt-1 text-center">

                            </div>


                        </div>
                        <div class="col-6"  id="second">
                            <a href="" target="_blank"><img src=""  class="img-fluid rounded"  style="width: 150px; height: 200px"alt=""></a>
                            <button class="btn btn-warning mt-3 btn-vote">Проголосовать</button>
                            <div class="avatars mt-1 text-center">

                            </div>

                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-absolute bottom-0 end-0 p-3">

    </div>

    <!--        <div class="toast" id="test" role="alert" aria-live="assertive" aria-atomic="true">-->
    <!--            <div class="toast-header">-->
    <!--                <img src="..." class="rounded me-2" alt="...">-->
    <!--                <strong class="me-auto">Bootstrap</strong>-->
    <!--                <small class="text-muted">2 seconds ago</small>-->
    <!--                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>-->
    <!--            </div>-->
    <!--            <div class="toast-body">-->
    <!--                Heads up, toasts will stack automatically-->
    <!--            </div>-->
    <!--        </div>-->
</div>
<style>

    .col-13
    {
        width: 13%;
        /* height: 20px; */
        /* background-color: white; */
        /* border: 1px solid red; */
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
        flex-wrap: nowrap;
    }
    .col-22
    {
        width: 22%;
        /* height: 20px; */
        /* background-color: white; */
        /* border: 1px solid red; */
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
        flex-wrap: nowrap;
    }
    .tour-table
    {
        max-height: none;
    }
    .totot
    {
        height: 100%;
        margin-bottom: -40px;

    }
    .vote-image
    {
        width: 50px;
        height: 75px;
        border-radius: 5px;
    }
    .vote-image-final
    {
        width: 100px;
        height: 150px;
    }
    .cell
    {
        width: 50px;
        height: 75px;
    }
    .cell-f
    {
        width: 100px;
        height: 150px;
    }
    .cell-pair
    {
        display: flex;
        height: 100px;
    }
    .type-descr
    {
        border-radius: 0;
    }
    .cell-final
    {
        display: block;
    }
</style>
