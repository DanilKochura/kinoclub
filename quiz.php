<?php  require_once 'model/GetBase.php';
$db = new GetBase();
$r = $db->GetGameFilms();
?>

    <div class="container-fluid" style="background: linear-gradient(rgb(56 56 56 / 100%), rgb(110 110 110 / 76%)), url(image/bg.jpg) center/cover; margin-bottom:-20px; min">
        <div class="container game">
            <div class="row" style="min-height: 600px">
                <!--        <div class="d-none result">-->
                <!---->
                <!--        </div>-->
                <!--        <div class="col-md-2 f-1" id="12">-->
                <!--            <img src="image/real.jpg" alt="" class="img-fluid">-->
                <!--        </div>-->
                <!--        <div class="col-md-2 f-1" id="36">-->
                <!--            <img src="image/midnight.jpg" alt="" class="img-fluid">-->
                <!--        </div>-->
                <div class="col-md-6 type-descr m-lg-1 bg-main text-white">
                    <h3 class="text-center type-header">Турнирный режим</h3>
                    <p class="type-text px-3">
                        Классическая турнирная схема. На выбор даются пары фильмов. Победитель каждой пары проходит в следующий этап, где соревнуется с победителем следующей пары.
                    </p>
                    <div class="container tour-table">
                        <div class="col-25">
                            <div class="cell-pair">
                                <div class="cell p-t1"> 1 </div>
                                <div class="cell a-t1"> 2 </div>
                            </div>
                            <div class="cell-pair">
                                <div class="cell a-t1"> 3 </div>
                                <div class="cell p-t1"> 4 </div>
                            </div>
                        </div>
                        <div class="col-25">
                            <div class="cell-pair">
                                <div class="cell a-t2"> 2 </div>
                                <div class="cell p-t2"> 3 </div>
                            </div>

                        </div>
                        <div class="col-25 col-final">

                            <div class=" row cell-pair final">
                                <div class="cell a-t3"> 2 </div>
                                <div class="cell p-t3"> 7 </div>
                            </div>
                        </div>
                        <div class="col-25">
                            <div class="cell-pair">
                                <div class="cell p-t2"> 5 </div>
                                <div class="cell a-t2"> 7 </div>
                            </div>

                        </div>
                        <div class="col-25">
                            <div class="cell-pair">
                                <div class="cell a-t1"> 5 </div>
                                <div class="cell p-t1"> 6 </div>
                            </div>
                            <div class="cell-pair">
                                <div class="cell a-t1"> 7 </div>
                                <div class="cell p-t1"> 8 </div>
                            </div>

                        </div>
                    </div>
                    <div class="col text-center">
                        <a href="game/tour/top" class="btn btn-warning w-50">Играть</a>
                    </div>

                </div>
                <div class="col-md-6 type-descr m-lg-1  bg-main text-white">
                    <h3 class="text-center type-header">Турнирный режим</h3>
                    <p class="type-text px-3">
                        Классическая турнирная схема. На выбор даются пары фильмов. Победитель каждой пары проходит в следующий этап, где соревнуется с победителем следующей пары.
                    </p>
                    <div class="container mount-an">
                        <div class="row">

                            <div class="col-6 mount mx-1 mount-move">1</div>
                            <div class="col-6 mount mx-1">2</div>
                        </div>

                    </div>
                    <div class="col text-center">
                        <a href="game/tour/top" class="btn btn-warning w-50">Играть</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="json d-none">
        <?=$r?>
    </div>
    <script>

    </script>



<?php require_once 'path/footer.php';