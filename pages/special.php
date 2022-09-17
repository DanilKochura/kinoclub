<?php

require 'config/bd.php';
if($_SESSION['user']['id'] != 4)
{
    header('Location: /');
}

$db = new DB();
$total = [];
$movs= [];

$pairs = $db->Query_try("SELECT poster, url, name_m, id_m   from pairs join movie on (first = id_m or second = id_m) where id_exp is not null");
while($row = $pairs->fetch_assoc())
{
    $movs[] = $row;
}
debug($movs);

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
        padding-top: 40px;
    }
    .totot
    {
        height: 450px;
        margin-bottom: -40px;

    }

    .cell
    {
        width: 40px;
        height: 30px;
    }
    .type-descr
    {
        border-radius: 0;
    }
</style>
<!--<div class="container-fluid rad-0">-->
<!--<div class="row totot">-->
<!--    <div class="col type-descr bg-main text-white pt-2 mb-3">-->
<!--        <div class="container tour-table middle">-->
<!--            <div class="col-13">-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell p-t1"> 1 </div>-->
<!--                    <div class="cell a-t1"> 2 </div>-->
<!--                </div>-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell a-t1"> 3 </div>-->
<!--                    <div class="cell p-t1"> 4 </div>-->
<!--                </div>-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell p-t1"> 1 </div>-->
<!--                    <div class="cell a-t1"> 2 </div>-->
<!--                </div>-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell a-t1"> 3 </div>-->
<!--                    <div class="cell p-t1"> 4 </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-13">-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell p-t1"> 1 </div>-->
<!--                    <div class="cell a-t1"> 2 </div>-->
<!--                </div>-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell a-t1"> 3 </div>-->
<!--                    <div class="cell p-t1"> 4 </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-13">-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell a-t2"> 2 </div>-->
<!--                    <div class="cell p-t2"> 3 </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--            <div class="col-22 col-final">-->
<!---->
<!--                <div class=" row cell-pair final m-0">-->
<!--                    <div class="cell a-t3"> 2 </div>-->
<!--                    <div class="cell p-t3"> 7 </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-13">-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell p-t2"> 5 </div>-->
<!--                    <div class="cell a-t2"> 7 </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--            <div class="col-13">-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell a-t1"> 5 </div>-->
<!--                    <div class="cell p-t1"> 6 </div>-->
<!--                </div>-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell a-t1"> 7 </div>-->
<!--                    <div class="cell p-t1"> 8 </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--            <div class="col-13">-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell a-t1"> 5 </div>-->
<!--                    <div class="cell p-t1"> 6 </div>-->
<!--                </div>-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell a-t1"> 7 </div>-->
<!--                    <div class="cell p-t1"> 8 </div>-->
<!--                </div>-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell a-t1"> 5 </div>-->
<!--                    <div class="cell p-t1"> 6 </div>-->
<!--                </div>-->
<!--                <div class="cell-pair">-->
<!--                    <div class="cell a-t1"> 7 </div>-->
<!--                    <div class="cell p-t1"> 8 </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!---->
<!---->
<!--    </div>-->
<!---->
<!---->
<!--</div>-->
<!--</div>-->
