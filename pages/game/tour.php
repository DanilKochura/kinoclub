<?php
require_once PATH . '/model/GetBase.php';
$db = new GetBase();
$r = $db->GetGameFilms();
$films = $db->GetResTour();
//debug($films); exit;

?>

    <div class="container-fluid h-xl-100 " style="padding-top: 100px;background: linear-gradient(rgb(56 56 56 / 100%), rgb(110 110 110 / 76%)), url(https://imdibil.ru/image/bg.jpg) center/cover; margin-bottom:-20px;">
        <div class="container game">
          <div class="row my-2">

              <div class="col-md-7">
                  <div class="d-none result bg-dark b1-warning h-100p rounded">

                  </div>
                  <div class="row">
                      <div class="col-6 f-1" style="height: 380px" id="12">
                          <img src="image/real.jpg" alt="" class="img img-fluid tour-t rounded">
                      </div>
                      <div class="col-6 f-1" style="height: 380px" id="36">
                          <img src="image/midnight.jpg" alt="" class="img img-fluid tour-t rounded">
                      </div>
                  </div>
              </div>
              <div class="col-md-5 bg-dark b1-warning h-100p rounded">
                  <h2 class="name">Победители</h2>
                  <div class="text-white container">
                      <?php for($i = 0; $i<count($films); $i++):?>
                         <div class="row">
                             <div class="col-2"><?=$i+1?></div>
                             <div class="col-8"><?=$films[$i]['name_m']?></div>
                             <div class="col-2"><?=$films[$i]['co']?></div>
                         </div>


                      <?php endfor; ?>
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



<?php //require_once 'path/footer.php';