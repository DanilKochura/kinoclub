<?php

require 'config/bd.php';
if($_SESSION['user']['id'] != 4 and $_SESSION['user']['id'] != 29)
{
    header('Location: /');
}

$db = new DB();
$total = [];
$movs= [];

$pairs = $db->Query_try("SELECT poster, url, name_m, id_m, id_event_vote, id_v, selected  from pairs join movie on (first = id_m or second = id_m) join vote on vote.id_event = id_event_vote where pairs.id_event = 'first'");
while($row = $pairs->fetch_assoc())
{
    $id_event = $row['id_event_vote'];
    $votes = $db->Query_try("SELECT avatar, id_e from votelist join expert using(id_e) join vote on id_vote = id_v where id_event = '$id_event' and choise='{$row['id_m']}'");
    while($vote = $votes->fetch_assoc())
    {
        if($vote['id_e'] == $_SESSION['user']['id'])
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
    while($vote = $votes->fetch_assoc())
    {
        if($vote['id_e'] == $_SESSION['user']['id'])
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
    while($vote = $votes->fetch_assoc())
    {
        if($vote['id_e'] == $_SESSION['user']['id'])
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
        if($vote['id_e'] == $_SESSION['user']['id'])
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
<div class="container-fluid rad-0">
<div class="row totot bg-dark">
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
                        <div class=" mb-4 cell-final modal-vote <?=($movs[3][1]['done']==1 || $movs[3][2]['done']==1) ? 'selected' : ''?>"  data-vote='<?=$movs[3][1]['id_event_vote']?>' data-movies='<?=json_encode(array('first'=>$movs[3][1], 'second'=>$movs[3][2]), true)?>'>
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
    <div class="toast" id="answer" role="alert" aria-atomic="true">
        <div class="toast-header text-white bg-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
            </svg>
            <strong class="me-auto mx-1">IMDbil</strong>
            <small class="text-muted">just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">

        </div>
    </div>
    <div class="toast" id="err" role="alert" aria-atomic="true">
        <div class="toast-header text-white bg-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
            </svg>
            <strong class="me-auto mx-1">IMDbil</strong>
            <small class="text-white">just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">

        </div>
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