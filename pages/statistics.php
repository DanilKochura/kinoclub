<?php //require 'path/header.php';
require 'model/GetBase.php';
$m = new GetBase();
$arr = $m->GetAllRates();

?>



<style type="text/css">
  body
  {
     background-color: #23282b;
     color: white;
  }
  .form-select
  {
    background-color: #23282b;
    color: white;
  }
  .description, .legend
  {
      margin: 40px;
  }
  .list{
      margin: 20px 20px;
  }
  .hidden
  {
      display: none;
  }
.charts
{
    max-height: 600px;
}
.block {

    display: block;
    margin: 10px;

}
.legend
{
    border: 4px dotted gold;

}



</style>
	<div class="container charts">
    <div class="row text-center">
      <div>
        <div class="btn-group">
          <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" value=0>
          <label class="btn btn-secondary" for="option1">Инструкция</label>

          <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off" value =2>
          <label class="btn btn-secondary" for="option2">Корреляция оценок (пирсон)</label>

          <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off" value =3>
          <label class="btn btn-secondary" for="option3">Близость интересов</label>

          <input type="radio" class="btn-check" name="options" id="option4" autocomplete="off" value=1>
          <label class="btn btn-secondary" for="option4">Графики оценок</label>
        </div>
      </div>
    </div>
    <div class="row">

    </div>
		<div class="chart">
      <div class="col description text-center">

          <div class="row text-center">
              <h2>На данный момент к выбору представлены 3 типа графиков:</h2>
          </div>
        <div class="row list">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <ul>
                    <li>Графики оценок всех пользователей и среднего балла сообщества</li>
                    <li>График корреляции оценок пользователей </li>
                    <li> График близости интересов пользователей, исходя из их оценок</li>
                </ul>
                </ul>
            </div>
            <div class="col-sm-3">
            </div>

        </div>

      </div>
			
		</div>
	</div>
<div class="modal">
    dfdf
</div>

<div class="hidden json" style="display: none;"><?php echo json_encode($arr);?></div>
<script src="scripts\bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 	 <script type="text/javascript" src="scripts/chart_scr.js"></script>
	
</body>
</html>