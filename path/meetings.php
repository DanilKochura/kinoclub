<?php
require ROOT.'/config/bd.php';
function getMovieDescr($conn, $j)
{
		$descr_q = "SELECT id_m, name_m, original, year_of_cr, name_d,duration,rating, our_rate,rating_kp, poster from movie
				join director on id_d=director join meeting using(id_m) where id_meet=". $j;
		$descr_genre = "select name_g from genre 
						join gen_to_mov using(id_g) 
						join movie using(id_m)
						join meeting using(id_m) where id_meet=".$j.";";
		$descr = $conn->query($descr_q);
		if(!$descr) die("Error");
		$genre = $conn->query($descr_genre);
		if(!$genre) die("Error");
		foreach($descr as $row)
		{
		echo '<div class="container rounded forum-card">
  				<div class="row">
  					<div class="col-md-2 poster"><a href="https://kinopoisk.ru"><img src="'.$row['poster']. '" class="img-fluid rounded"id="IM"></a></div>
  						<div class="col-md-4 text-left description">';
		echo '<div class="name">'. $row['name_m']. "</div>";
		echo '<div class="original">'. $row['original']. "</div>";
		
		getGenre($genre);
		
		echo '<div class="year">Год создания: '.$row['year_of_cr']. "</div>";
		echo '<div class="director">Режиссер: '.$row['name_d']. "</div>";
		echo '<div class="time">Продолжительность: '.$row['duration']. " мин.</div>";
		getRateTable($row['rating'], $row['rating_kp'], $row['our_rate']);
		}
		echo '</div>';
	/*$j = json_encode($descr);*/
}
function getGenre($genre)
{
	echo '<div class="type">Жанр: ';
	$n = $genre->num_rows;
	$i=0;
	for($i; $i<$n-1; ++$i)
	{
		$genre->data_seek($i);
		echo $genre->fetch_assoc()['name_g']. ", ";
	}
	$genre->data_seek($i+1);
	echo $genre->fetch_assoc()['name_g']. "</div>";
}


function getExpertRate($conn, $j)
{

		$descr_q = "SELECT id_meet, avatar, name, rate from expert
		join expert_rate on id_e=id_exp where id_meet=".$j." order by rate desc";
		$descr = $conn->query($descr_q);
		echo '<table class="table-rate">';
  				echo	"<thead>";
				echo	    "<tr>";
				echo	      '<th scope="col">Эксперт</th>';
				echo	      '<th scope="col">Оценка</th>
					    </tr>
					  </thead>
					  <tbody>';
		foreach($descr as $row)
		{
		
					   	echo '<tr>';
					     echo '<th scope="row" class="ex-name"><img src="'.$row['avatar'].'"alt="'.$row['name'].'"class="avatar"></th>
					      <td class="rate '.rateCheck($row['rate']).'">'.$row['rate'].'</td>
					    </tr>';
	/*$j = json_encode($descr);*/
		}
		echo '</tbody></table>';
}


function getMeetCard($conn)
{
  	$query_num = "SELECT * FROM meeting";

	$numer =$conn->query("SELECT * FROM meeting");
	if(!$numer) die("Error");
	$num=$numer->num_rows;
	for($j=1; $j<$num+1; ++$j)
	{
			echo '<div class="three"><h1>Заседание #'.$j.'</h1></div>';
			getMovieDescr($conn, $j);
			echo '<div class="rating-tab col-md-2 text-center">';
  			getExpertRate($conn, $j);
  			echo '</div>
  			<div class="col-md-4 text-center">Цитаты
  			<blockquote class="blockquote text-center">
  				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante<br><br>
  				<footer class="blockquote-footer">Кто-то знаменитый в <cite title="Название источника">Название источника</cite></footer>
				</blockquote>
			</div>
  		</div>
  	</div>';

	}
	$conn->close();
}



function getRateTable($r1, $r2, $r3)
{
	echo '<div class="rates"><table class="table-rate text-center">
        <thead>
            <tr>
                <th scope="col"><img src="image/imdb.png" class="res_logo"></th>
                <th scope="col"><img src="image/kp.png" class="res_logo"></th>
                <th scope="col"><img src="image/logogo.png" class="res_logo"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td class="'.rateCheck($r1).'">'.round($r1, 1).'</td>
               <td class="'.rateCheck($r2).'">'.$r2.'</td>
                  <td class="'.rateCheck($r3).'">'.round($r3, 1).'</td>
                      </tr>
                    </tbody>
                    </table>
                </div>';
}

?>
