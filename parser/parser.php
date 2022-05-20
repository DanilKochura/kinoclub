<?php 

//$a = file_get_contents('pages/mokingbird.html');

function findS($str, $start, $end)
{
	$s1 = strpos($str, $start);
	$s2 = substr($str, $s1);
	return strip_tags(substr($s2, 0, strpos($s2, $end)));

}

function Parse($param)
{
	$url = 'parser/pages/'.$param.'.html';
	$a = file_get_contents($url);
	//echo $a;
	$s = findS($a, '<script type="application/ld+json">', '</script>');
	$d = findS($a, '<script id="__NEXT_DATA__" type="application/json', '</script>');
	$d = json_decode($d, true);
	$s = json_decode($s, true);
	/*echo "<pre>";
	print_r($d);
	echo "</pre>";*/
	$id = $d['query']['id'];
	$film_index="Film:".$id;
	
	//unlink($url);
	return array(
		'name'=>$s['name'],
		'original'=>$s['alternateName'],
		'year'=>$s['datePublished'],
		'director'=>$s['director'][0]['name'],
		'genre'=>$s['genre'],
		'rating-kp'=>round($s['aggregateRating']['ratingValue'], 1),
		'duration'=>$s['timeRequired'],
		'url'=>$s['url'],
		'imdb'=>$d['props']['apolloState']['data'][$film_index]['rating']['imdb']['value']
	);
}

?>