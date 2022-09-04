// $('#search').on('input', function (){
// 	$.post('/scripts/ajax/search.php',
// 		{text: this.value},
// 		function(data){
// 		alt(JSON.parse(data));
// 	});
// });
console.log($('form#Addrate'));
$('form#Addrate').submit(function (e)
{
	e.preventDefault();
	let obj = '';
	$.ajax({
		url: '/scripts/ajax/addrate.php',
		method: 'post',
		dataType: 'json',
		data: $(this).serialize(),
		success: function(data){
			console.log(data)
			if(data['state'] == 1)
			{
				obj = $('#answer');
			}
			else
			{
				obj = $('#err');
			}
			obj.find('.toast-body').text(data['text'])
			obj.show();
		},
		error: function(error){
			console.log(error);
		}
	});
	$('#rateAddModal').modal('hide');

});
console.log('dd');
let uri_dir = 'https://kinopoiskapiunofficial.tech/api/v1/staff?filmId='
let units = [['description', 'Описание: '], ['filmLength', 'Продолжительность: '], ['genres', ''], ['nameOriginal', ''], ['nameRu', ''], ['posterUrl', ''],
	['ratingImdb', 'IMDB: '], ['ratingKinopoisk', 'КП: '], ['webUrl', ''], ['year', 'Год выпуска: ']];
let data = '';
$('.search-m').submit(function (e){
	$('form#addForm').empty();
	e.preventDefault();
	let url = 'https://kinopoiskapiunofficial.tech/api/v2.2/films/'+$('#movie_input').val();
	fetch(url, {
		method: 'GET',
		headers: {
			'X-API-KEY': 'f71d6402-9cb4-4201-bfd5-e1f1536b0605',
			'Content-Type': 'application/json',
		},
	})
		.then(response => { return response.json() })
		.then(resB => {
			data = resB;
			console.log(data);
            let item= '';
			$.each(units, function (key, value)
			{
				if($('.admin-addfilm').length > 0)
				{

				}else
				{
					item ='';
					if(value[0] == 'genres')
					{
						$.each(data[value[0]], function (key, val)
						{
							item += ' '+val['genre'];
						})
					}
					else
					{
						item = data[value[0]]
					}
					if(value[0] == 'posterUrl')
					{
						$('#'+value[0]).attr('src', item);
					}else
					{
						$('#'+value[0]).text(value[1]+item);
					}

					let inp = '<input type="hidden" name="'+value[0]+'" value="'+item+'">';

					$('form#addForm').append($(inp));
				}

			});
			fetch('https://kinopoiskapiunofficial.tech/api/v1/staff?filmId='+$('#movie_input').val(), {
				method: 'GET',
				headers: {
					'X-API-KEY': 'f71d6402-9cb4-4201-bfd5-e1f1536b0605',
					'Content-Type': 'application/json',
				},
			})
				.then(resp => { return resp.json() })
				.then(res => {
					let inp = '<input type="hidden" name="director" value="'+res[0]['nameRu']+'">';

					$('form#addForm').append($(inp));
				});
            let inp ='<p>Ты искал этот фильм? Если да, то нажми кнопку "Сохранить" и он сохранится в нашей базе</p>'+
				'<button type="submit" class="btn btn-warning m-3">Сохранить</button>';

            $('form#addForm').append($(inp));

		})
			// const resp = answer.services;

			// оперируйте данными здесь сколько душе угодно
		.catch(err => console.log(err))
	// console.log(res);


	return false;
});
$('form#addForm').submit(function (e){
	e.preventDefault();

});
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
  // console.log(element.textContent);
  rateCheck(element);
});

// Access the first element in the NodeList
RateCl[0];
function rateCheck(el)
{
	// console.log(parseFloat(el.textContent))
	if(parseFloat(el.textContent)>= 7.0){el.classList.add("green-zone");}
		else if(parseFloat(el.textContent)>=5.0){el.classList.add("grey-zone");}
			else el.classList.add("red-zone");
}

const Select = document.querySelectorAll('.selected');
Select.forEach(element => {
  // console.log(element.textContent);
  SelectCheck(element);
});

// Access the first element in the NodeList
Select[0];
function SelectCheck(el)
{
    if(el.innerHTML === ""){console.log("Not selected");}
    else {
	let id = "#id-"+el.textContent;
	// console.log(id);
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
			// console.log(data); /* В переменной data содержится ответ от index.php. */
			$.each(data, function(key,val){
				// console.log("key : "+key+" ; value : "+val);
				let id= '#'+key;
				$(id).val(val);

			});
		}
	});
});
if($('.json').length>0)
{
	let jsonnn = $('.json').text();
	let text = JSON.parse(jsonnn);
// console.log(text);
	var shuffled = text.sort(function(){
		return Math.random() - 0.5;
	});
	let stage = shuffled.length/2;
// console.log(stage);
	let movie_iterator = 0;
	let elems = $(".f-1");
// console.log(text);
	/**
	 * функция генерации новой турнирной пары
	 * @constructor
	 */
	function NextTwo()
	{
		console.log(shuffled);
		// console.log('func started: shuffled: '+shuffled.length+' i='+movie_iterator);


		// console.
		// (shuffled.length - movie_iterator)
		if(shuffled.length - movie_iterator < 2)
		{
			if(shuffled.length == 1)
			{

				elems.addClass('d-none');
				let resultdiv = $('.result');
				resultdiv.removeClass('d-none');
				console.log(tour);
				$.ajax({
					url: '/scripts/ajax/endgame.php',
					method: 'post',
					dataType: 'json',
					data: {mode: 'tour', game: JSON.stringify(tour) },
					success: function(data){

						},
					error: function(error){
						$('#message').html(error);
					}
				});
				for(let j = 0; j<tour.length; j++)
				{
					resultdiv.append($('<span class="h2 text-danger"> Round:'+(j+1)+'<br></span>'));
					for (let k =0; k<tour[j].length; k++)
					{
						//console.log(tour[0][0])
						resultdiv.append($('<span class="text-warning"> #'+k+' : '+tour[j][k]['name']+'<br></span>'));
					}

				}
				return false;
			}
			shuffled.length =0;
			tour.push(new Array(...choises));
			stage/=2;
			shuffled.push(...choises);
			choises.length = 0;
			// console.log(tour);
			movie_iterator = 0;
			flag = 1;
			NextTwo();
			return;

		}
		$.each(elems, function (index, element){

			let src = $($(element).children('img')[0]).attr('src', shuffled[movie_iterator]['poster']);
			$(element).attr('id', movie_iterator);
			movie_iterator++;
			// console.log(movie_iterator);

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
			// console.log(choises);
			elems.addClass('d-none');
			let resultdiv = $('.result');
			resultdiv.removeClass('d-none');
			for(let j = 0; j<choises.length; j++)
			{
				resultdiv.append($('<p>'+shuffled[choises[j]]['name']+'</p>'));
			}

		}
		$.each(elems, function (index, element){
			// console.log($(element).attr('id')+' selected: '+ id_m);
			if($(element).attr('id') == id_m)
			{
				return;
			}
			let src = $($(element).children('img')[0]).attr('src', shuffled[movie_iterator]['poster']);
			$(element).attr('id', movie_iterator);
			movie_iterator++;
			// console.log(src);
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

	function func_set(n1, n2, mo, it)
	{
		function func_clear(n1, n2, mo, it)
		{
			// alert('dfdf');

			$(mo[n2]).removeClass('mo-passive').addClass('mo-first');
			$(mo[n1]).removeClass('mo-active').addClass('mo-first');
			// $(mo[n2]).classList.remove('mo-passive');
			// $(mo[n1]).classList.remove('mo-active');
			$(mo[n2]).text(it);
			// console.log('clear')
		}
		// alert('dfdf');
		// $(mo[n2]).removeClass('mo-first');
		// $(mo[n1]).removeClass('mo-first');
		$(mo[n2]).removeClass('mo-first').addClass('mo-passive');
		$(mo[n1]).removeClass('mo-first').addClass('mo-active');
		// console.log('set');
		setTimeout(function(){
			func_clear(n1, n2, mo, it)
		}, 1000);

	}
	let mount = $('.mo-1');
// console.log(mount);
	let iterator = 2;

	setInterval(function (){


		if(iterator==9)
		{
			iterator = 2;
			mount[0].text(2);
			mount[1].text(1);
		}
		iterator++;
		let num = Math.floor(Math.random()*2);
		let num2 = num == 1 ? 0 : 1;
		// console.log(num+' ' + num2);
		// clearTimeout();
		setTimeout(function (){
			func_set(num, num2, mount, iterator)
		}, 1000);
		clearTimeout();
	}, 2000);
}

