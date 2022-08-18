<?php
require_once PATH . '/model/GetBase.php';
$db = new GetBase();
$r = $db->GetGameFilms();
?>

    <div class="container-fluid h-xl-100" style="background: linear-gradient(rgb(56 56 56 / 100%), rgb(110 110 110 / 76%)), url(https://imdibil.ru/image/bg.jpg) center/cover; margin-bottom:-20px;">
        <div class="container game">
          <div class="row my-2">
              <div class="d-none result">

              </div>
              <div class="col-md-7">
                  <div class="row">
                      <div class="col-6 f-1" id="12">
                          <img src="image/real.jpg" alt="" class="img img-fluid tour rounded">
                      </div>
                      <div class="col-6 f-1" id="36">
                          <img src="image/midnight.jpg" alt="" class="img img-fluid tour rounded">
                      </div>
                  </div>
              </div>
              <div class="col-md-5 bg-dark b1-warning h-100p rounded">
                  <h2 class="name">Топ 16 фильмов IMDIbil</h2>

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