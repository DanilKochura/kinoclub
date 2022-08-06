/*$('.new').submit(function(e) {  //обработка и отправка формы
	e.preventDefault();
	let re = $('#re').val().trim();
	let text = $('#text').val().trim();
	let date= new Date();
	let time = $('.time').text();
	alert(time);
	alert(date);
	let ti = date-time;
	alert(ti)

});*/
//controller/UserFormController.php?type=feedback
$(document).ready(function(){
	$('.your-class').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		//autoplay: true,
		autoplaySpeed: 2000,
		dots: true,
		arrows: true,
		variableWidth: true,
		// centerPadding: '10px',
		infinite: true,
		responsive: [
			{
				breakpoint: 800,
				settings: {
					infinite: true,
					slidesToShow: 2
				}
			},
			{
				breakpoint: 480,
				settings: {
					infinite: true,
					centerMode: true,
					slidesToShow: 1
				}
			}
		]
});
});

const RateCl = document.querySelectorAll('.rate-ch');
RateCl.forEach(element => {
  console.log(element.textContent);
  rateCheck(element);
});

// Access the first element in the NodeList
RateCl[0];
function rateCheck(el)
{
	if(el.textContent>= 7.0){el.classList.add("green-zone");}
		else if(el.textContent>=5.0){el.classList.add("grey-zone");}
			else el.classList.add("red-zone");
}

const Select = document.querySelectorAll('.selected');
Select.forEach(element => {
  console.log(element.textContent);
  SelectCheck(element);
});

// Access the first element in the NodeList
Select[0];
function SelectCheck(el)
{
    if(el.innerHTML === ""){console.log("Not selected");}
    else {
	let id = "#id-"+el.textContent;
	console.log(id);
	const RateC = document.querySelector(id);
	RateC.classList.add("selected"); }

}

$('#mm').change(function(){
	var data_to= $(this).val();
	$('#meet_id').val(data_to);
	//alert(data_to);
	$.ajax({
		url: '/api.php',         /* Куда отправить запрос */
		method: 'get',             /* Метод запроса (post или get) */
		dataType: 'json',          /* Тип данных в ответе (xml, json, script, html). */
		data: {id: data_to},     /* Данные передаваемые в массиве */
		success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
			console.log(data); /* В переменной data содержится ответ от index.php. */
			$.each(data, function(key,val){
				console.log("key : "+key+" ; value : "+val);
				let id= '#'+key;
				$(id).val(val);

			});
		}
	});
});

let jsonnn = $('.json').text();
let text = JSON.parse(jsonnn);
console.log(text);
var shuffled = text.sort(function(){
	return Math.random() - 0.5;
});
let stage = shuffled.length/2;
// console.log(stage);
let movie_iterator = 0;
// console.log(text);

/**
 * функция генерации новой турнирной пары
 * @constructor
 */
function NextTwo()
{
	console.log('func started: shuffled: '+shuffled.length+' i='+movie_iterator);

	let elems = $(".f-1");
	// console.log(shuffled.length - movie_iterator)
	if(shuffled.length - movie_iterator < 2)
	{
		if(shuffled.length == 1)
		{
			//console.log(choises);
			elems.addClass('d-none');
			let resultdiv = $('.result');
			resultdiv.removeClass('d-none');
			for(let j = 0; j<tour.length; j++)
			{
				resultdiv.append($('<p class="h2 text-danger"> Round:'+(j+1)+'</p>'));
				for (let k =0; k<tour[j].length; k++)
				{
					//console.log(tour[0][0])
					resultdiv.append($('<p> #'+k+' : '+tour[j][k]['name']+'</p>'));
				}

			}
			return false;
		}
		// console.log('game_over');
		// console.log(choises);
		shuffled.length =0;
		tour.push(new Array(...choises));
		stage/=2;
		shuffled.push(...choises);
		choises.length = 0;
		console.log(tour);
		movie_iterator = 0;
		flag = 1;
		NextTwo();
		return;

	}
	$.each(elems, function (index, element){

		  let src = $($(element).children('img')[0]).attr('src', shuffled[movie_iterator]['poster']);
		  $(element).attr('id', movie_iterator);
		  movie_iterator++;
		console.log(movie_iterator);

		  // console.log(src);
	});
	// if(flag == 1)
	// {
	// 	flag = 0;
	// 	NextTwo();
	// 	// movie_iterator = 0;
	// }

}

/**
 * функция подмены невыбранного фильма на новый (режим "царь горы")
 * @param id_m
 * @constructor
 */
function NextFilm(id_m)
{
	let elems = $(".f-1");
	if(shuffled.length - movie_iterator < 2)
	{
		console.log('game_over');
		console.log(choises);
		elems.addClass('d-none');
		let resultdiv = $('.result');
		resultdiv.removeClass('d-none');
		for(let j = 0; j<choises.length; j++)
		{
			resultdiv.append($('<p>'+shuffled[choises[j]]['name']+'</p>'));
		}

	}
	$.each(elems, function (index, element){
		console.log($(element).attr('id')+' selected: '+ id_m);
		if($(element).attr('id') == id_m)
		{
			return;
		}
		let src = $($(element).children('img')[0]).attr('src', shuffled[movie_iterator]['poster']);
		$(element).attr('id', movie_iterator);
		movie_iterator++;
		console.log(src);
	});
}
let flag = 0;

let tour = [];
let choises = [];
let first = $('.f-1');
NextTwo();
first.on('click', function(){
	let id = $(this).attr('id');
	choises.push(shuffled[id]);
	// console.log(id);
	// 	console.log(choises);
	NextTwo();///турнир
//NextFilm(id);//царь горы
	}
);