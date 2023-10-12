<?php
ini_set('display_errors', true);
error_reporting(E_ERROR);



require 'model/GetBase.php';
$base = new DB();



//получение оценок по сезонам

$res = $base->Query_try("SELECT * FROM `expert_rate` join expert on id_exp = id_e where rate is not null");
$resU = $base->Query_try("SELECT * from expert");

$exps = [];


while ($row = $resU->fetch_assoc())
{
    $exps[(int)$row['id_e']] = $row;
}
$rates = [];

$num = $res->num_rows;

$seasons = [
    'first' => ["count" => 0, 'limits' => [1,10]],
    'second' => ["count" => 0, 'limits' => [11,18]],
    'third' => ["count" => 0, 'limits' => [19,27]],
    'forth' => ["count" => 0, 'limits' => [28,37]],
    'global' => ["count" => 0],
];


while ($row = $res->fetch_assoc())
{
    $season = null;

    foreach ($seasons as $index => $item) {
        if($item['limits'])
        {
            if($row['id_meet'] >= $item['limits'][0] and $row['id_meet'] <= $item['limits'][1])
            {
                $season = $index;
            }
        }
    }

    //region Example
    //    if($row['id_meet'] >= 1 and $row['id_meet'] <= 11) //1st
//    {
//        $season = "first";
//    } elseif ($row['id_meet'] >= 12 and $row['id_meet'] <= 19) //2nd
//    {
//        $season = "second";
//    } elseif ($row['id_meet'] >= 20 and $row['id_meet'] <= 28) //3rd
//    {
//        $season = "third";
//    }elseif ($row['id_meet'] >= 29 and $row['id_meet'] <= 38) //4th
//    {
//        $season = "forth";
//    }
    //endregion

    if($season)
    {
        if(!isset($seasons[$season]['count']))
        {
            $seasons[$season]['count'] = 1;
        } else
        {
            $seasons[$season]['count']++;
        }
        $rates[$season]['rates']+= $row['rate'];
        $rates[$season]['users'][$row['id_exp']][] = $row['rate'];

    }
    $rates["global"]['rates'] += $row['rate'];
    $rates["global"]['users'][$row['id_exp']][] = $row['rate'];

    if(!isset($seasons["global"]['count']))
    {
        $seasons["global"]['count'] = 1;
    } else
    {
        $seasons["global"]['count']++;
    }
}

foreach ($seasons as $season => $prop)
{
    $rates[$season]['avg'] = $rates[$season]['rates'] /  $seasons[$season]['count'];
    foreach ($rates[$season]['users'] as $key => &$arr)
    {
        $co = count($arr);
        $sum = array_sum($arr);
        $arr = [];
        $arr['count'] = $co;
        $arr['avg'] = $sum / $co;
        $arr['user'] = $exps[$key];

    }
    unset($arr);
}
$res = $base->Query_try("SELECT * FROM meeting");
$users = $rates['global']['users'];

while($row = $res->fetch_assoc())
{
    foreach ($seasons as $index => &$item)
    {
        if(isset($item['period']) and
            count($item['period']) == 2)
        {
            continue;
        }
        foreach ($item['limits'] as $limit)
        {
            if($row['id_meet'] == $limit)
            {
                $item['period'][] = $row['date_at'];
                break;
            }
        }
    }
}


foreach ($seasons as $index => $item)
{
    if(!isset($item['period'])) continue;
    $date1 = date_create($item['period'][0]);
    $date2 = date_create( $item['period'][1] );
    $diff = date_diff( $date1, $date2 );
    $rates[$index]['season_length'] = $diff->days;
    $rates[$index]['avg_days'] = $diff->days / ($item['limits'][1] - $item['limits'][0]+1);
    $rates[$index]['period'] = $item['period'];
    $rates[$index]['count'] = $item['limits'][1] -$item['limits'][0]+1;
}


$date1 = date_create($seasons['first']['period'][0]);
$date2 = date_create($seasons['forth']['period'][1]);
$diff = date_diff( $date1, $date2 );
$rates['global']['season_length'] = $diff->days;
$rates['global']['period'] = [$item['period'][0], $item['period'][1]];
$rates["global"]['count'] = $seasons['forth']['limits'][1] - $seasons['first']['limits'][0]+1;
$rates["global"]['avg_days'] =   $diff->days / ($seasons['forth']['limits'][1] - $seasons['first']['limits'][0]+1);
$arr = [
        "Первый сезон" => $rates['first'],
    "Второй сезон" => $rates['second'],
    "Третий сезон" => $rates['third'],
    "Четвертый сезон" => $rates['forth'],
    "За все время" => $rates["global"]];

$avg = [];
$avg_days = [];

$usersC = [];




?>
<style>
    .season-block
    {
        padding: 20px;
        background: rgb(141 141 141 / 30%);
        border-radius: 20px;
        margin: 20px auto;
    }
</style>
<div class="container-fluid w-100 content bg-main mt-5">
        <div class="container pt-5 text-center" id="statsBySeasons">
            <?php foreach ($arr as $key => $rate1): $avg[] = $rate1['avg']; $avg_days[] = $rate1['avg_days']; ?>
               <div class="row season-block"



               >
                   <h2 class="text-warning my-3"><?=$key?></h2>

                   <div class="row justify-content-evenly">
                       <div class="col-sm-3">
                           <div class="text-gray-400 fs-10">Средняя оценка</div>
                           <div data-toggle="count-animate"
                                data-count-from="0"
                                data-count-to="<?=round($rate1['avg'], 1)?>"
                                data-count-duration="200"
                                data-count-decimals="" class="fs-2 red-zone">0</div>
                       </div>
                       <div class="col-sm-3">
                           <div class="text-gray-400 fs-12">Количество заседаний</div>
                           <div data-toggle="count-animate"
                                data-count-from="0"
                                data-count-to="<?=round($rate1['count'])?>"
                                data-count-duration="250"
                                data-count-decimals="" class="fs-2 text-warning">0</div>
                       </div>
                       <div class="col-sm-3">
                           <div class="text-gray-400 fs-12">Сезон длился</div>
                           <div>
                            <span data-toggle="count-animate"
                                  data-count-from="0"
                                  data-count-to="<?=round($rate1['season_length'], 2)?>"
                                  data-count-duration="1"
                                  data-count-decimals="" class="fs-2 text-warning">0</span>
                               <span class="text-gray-400"> дня</span>
                           </div>
                       </div>
                       <div class="col-sm-3">
                           <div class="text-gray-400 fs-12">Cредний перерыв</div>
                           <div>
                            <span data-toggle="count-animate"
                                  data-count-from="0"
                                  data-count-to="<?=round($rate1['avg_days'], 2)?>"
                                  data-count-duration="250"
                                  data-count-decimals="2" class="fs-2 text-warning">0</span>
                               <span class="text-gray-400"> дня</span>
                           </div>
                       </div>
                   </div>
                   <div class="row mt-5">
                       <?php  foreach ($rate1['users'] as $kk => $user):  $usersC[$user['user']['id_e']]["data"][] = round($user['avg'], 2)?>
                            <div class="col">
                                <img src="/uploads/<?=$user['user']['avatar']?>" alt="" class="avatar">
                                <div class="row justify-content-center" >
                                    <div class="col-4">
                                        <span
                                              data-count-decimals="0" class="fs-4 text-warning"><?=round($user['count'])?></span>
                                    </div>
                                    <div class="col-4">
                                        <div
                                             data-count-decimals="0" class="fs-4 rate-ch fw-normal"><?=round($user['avg'], 2)?></div>
                                    </div>
                                </div>
                            </div>
                       <?php endforeach; ?>
                   </div>
               </div>
            <?php endforeach; ?>
    <?php array_unshift($usersC[8]['data'], null); array_unshift($usersC[8]['data'], null);   ?>
        <div class="season-block">
            <canvas id="mychart">

            </canvas>
        </div>
            <div class="season-block">
                <canvas id="mychartUsers">

                </canvas>
            </div>
        </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    const labels = ['<?=implode("','", array_keys($arr))?>'];
    const dataC = {
        labels: labels,
        datasets: [
            {
                label: 'Средняя оценка',
                data: [<?=implode(",", $avg)?>],
                backgroundColor: "orange",
            },
            {
                label: 'Средний перерыв',
                data: [<?=implode(",", $avg_days)?>],
                backgroundColor: "white",
            },

        ]
    };
    const config = {
        type: 'bar',
        data: dataC,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Посезонная аналитика'
                }
            }
        },
    };
    const myChart = new Chart(
        document.getElementById('mychart'),
        config
    );


    const labelsU = ['<?=implode("','", array_keys($arr))?>'];
    const dataCU = {
        labels: labels,
        datasets: [
            <?php foreach ($usersC as $key => $user)
            {
                $dataset = [
                        'data' => array_values($user['data']),
                    'label' => $exps[$key]['name'],
                    'backgroundColor' => 'gold'
                ];

                echo json_encode($dataset).",";
            }

            ?>

        ]
    };
    const configU = {
        type: 'bar',
        data: dataCU,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Посезонная аналитика'
                }
            }
        },
    };
    const myChartU = new Chart(
        document.getElementById('mychartUsers'),
        configU
    );
</script>
