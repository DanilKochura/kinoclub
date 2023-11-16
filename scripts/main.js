// $('.search-opt').on("click", function (){
// 	alert('a');
// 	console.log('aa');
// 	let name = this.textContent;
// 	let id = this.attr('id');
// 	$('.selected').append('<div>'+name+'</div>');
// });

let third = [];
let pair = [];
function vote(id_event, id_m, third)
{
	$.ajax({
		url: '/scripts/ajax/vote.php',
		method: 'post',
		dataType: 'json',
		data: {id_event: id_event, id_m: id_m},
		success: function(data){
			console.log(data);
			// return;
			if(data['state'] == 1)
			{
				obj = $('#answer');
			}
			else
			{
				obj = $('#err');
			}
			let buttons = $('.btn-vote-'+third);
			$.each(buttons, function (key, value)
			{
				value.remove();
			})

			obj.find('.toast-body').text(data['text'])
			obj.show();
			setTimeout(()=> {
				obj.hide();
			}, 3000);
		}
	});

}
function delete_user_third(id)
{
	$.post('/scripts/ajax/delete.php?type=third',
		{id: id},
		function(data){

			let a = JSON.parse(data);
			console.log(a)
			if(a['state'] == 1)
			{
				obj = $('#answer');
			}
			else
			{
				obj = $('#err');
			}
			$('#thirdAddModal').modal('hide');

			obj.find('.toast-body').text(a['text']);
			setTimeout(() =>{
				location.reload()

			}, 2000
		);
			obj.show();
		});
}
function delete_user_pair(id)
{
	$.post('/scripts/ajax/delete.php?type=pair',
		{id: id},
		function(data){

			let a = JSON.parse(data);
			console.log(a)
			if(a['state'] == 1)
			{
				obj = $('#answer');
			}
			else
			{
				obj = $('#err');
			}
			$('#thirdAddModal').modal('hide');

			obj.find('.toast-body').text(a['text']);
			setTimeout(() =>{
					location.reload()

				}, 2000
			);
			obj.show();
		});
}
function film_add(id, name)
{
	if(third[0] == name || third[1] == name || third[2] == name)
	{
		return;
	}
	if(third.length == 3)
	{
		alert('Выбрано максимальное количество фильмов!');
		return;
	}
	third.push(name)
	console.log(third);

	$('#thirdadd').append('<input type="hidden" class="'+name+'" name="film[]" value="'+name+'">');
	if(third.length == 3)
	{
		$('#thirdadd').append('<input type="submit" class="btn btn-warning">');
	}
	$('.selected.t').append('<div class="row" id="'+name+'"><span class="col-11">'+id+'</span> <button type="button" onclick="delete_film(this);" class="btn-close btn-third-close col" aria-label="Закрыть"></button></div>');

}
function film_add_two(id, name)
{
	if(pair[0] == name || pair[1] == name)
	{
		return;
	}
	if(pair.length == 2)
	{
		alert('Выбрано максимальное количество фильмов!');
		return;
	}
	pair.push(name)
	console.log(pair);

	$('#pairadd').append('<input type="hidden" class="'+name+'" name="film[]" value="'+name+'">');
	if(pair.length == 2)
	{
		$('#pairadd').append('<input type="submit" class="btn btn-warning">');
	}
	$('.selected.p').append('<div class="row" id="'+name+'"><span class="col-11">'+id+'</span> <button type="button" onclick="delete_film_two(this);" class="btn-close btn-third-close col" aria-label="Закрыть"></button></div>');

}
function delete_film_two(obj){
	let div = 	$(obj).parent();
	let id = div.attr('id');
	let inp = $('input.'+id);
	if(pair[0] == id)
	{
		pair[0] = pair[1];
		pair.pop();
	}
	else if(pair[1] == id)
	{
		pair.pop();
	}
	if(pair.length == 1 && !pair[0])
	{
		pair.shift();
	}
	div.remove();
	console.log(inp)
	inp.remove();
	console.log(pair);
}

function delete_film(obj){
	let div = 	$(obj).parent();
	let id = div.attr('id');
	let inp = $('input.'+id);
	if(third[0] == id)
	{
		third[0] = third[1];
		third[1] = third[2];
		third.pop();
	}
	else if(third[1] == id)
	{
		third[1] = third[2];
		third.pop();
	}
	else if(third[2] == id)
	{
		third.pop();
	}
	if(third.length == 1 && !third[0])
	{
		third.shift();
	}
	div.remove();
	console.log(inp)
	inp.remove();
	console.log(third);
}
$('.search').on('input', function (){
	$('.results').empty();
	let id = $(this).attr('id');

	$.post('/scripts/ajax/search.php',
		{text: this.value},
		function(data){
			console.log(data)
			let a = JSON.parse(data);

			$.each(a, function (key, value)
			{
				if(id.length > 0)
				{
					$('.results').append('<p onclick="film_add_two(\''+value['name_m']+'\','+value['id_m']+')" class="search-opt" id="'+value['id_m']+'">'+value['name_m']+'</p>');

				}
				else{
					$('.results').append('<p onclick="film_add(\''+value['name_m']+'\','+value['id_m']+')" class="search-opt" id="'+value['id_m']+'">'+value['name_m']+'</p>');

				}
			});

		// alert(JSON.parse(data));
	});
});

$('form#Addrate').submit(function (e)
{
	e.preventDefault();	
	let obj = '';
	$.ajax({
		url: '/scripts/ajax/addrate.php',
		method: 'post',
		dataType: 'json',
		data: $(this).serialize(),
		success: function(data) {
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
$('form#pairadd').submit(function (e)
{
	e.preventDefault();
	let obj = '';
	$.ajax({
		url: '/scripts/ajax/addpair.php',
		method: 'post',
		dataType: 'json',
		data: $(this).serialize(),
		success: function(data){
			console.log(data);
			if(data['state'] == 1)
			{
				obj = $('#answer');
			}
			else
			{
				obj = $('#err');
			}
			$('#pairAddModal').modal('hide');
			obj.find('.toast-body').text(data['text']);
			obj.show();
			setTimeout(()=> {
				location.reload()
			} ,2000);


		},
		error: function(error){
			console.log(error);
		}
	});
	// $('#rateAddModal').modal('hide');

});
$('form#thirdadd').submit(function (e)
{
	e.preventDefault();
	let obj = '';
	$.ajax({
		url: '/scripts/ajax/addthird.php',
		method: 'post',
		dataType: 'json',
		data: $(this).serialize(),
		success: function(data){
			console.log(data);
			if(data['state'] == 1)
			{
				obj = $('#answer');
			}
			else
			{
				obj = $('#err');
			}
			$('#thirdAddModal').modal('hide');
			obj.find('.toast-body').text(data['text']);
			obj.show();
			setTimeout(()=> {
				location.reload()
			} ,2000);


		},
		error: function(error){
			console.log(error);
		}
	});
	// $('#rateAddModal').modal('hide');

});

// console.log('dd');
let uri_dir = 'https://kinopoiskapiunofficial.tech/api/v1/staff?filmId='



let units =
	[
		['description', 'Описание: '],
		['filmLength', 'Продолжительность: '],
		['genres', ''],
		['nameOriginal', ''],
		['nameRu', ''],
		['posterUrl', ''],
	['ratingImdb', 'IMDB: '],
		['ratingKinopoisk', 'КП: '],
		['webUrl', ''],
		['year', 'Год выпуска: ']
	];
let data = '';
$('.search-m').submit(function (e){
	$('form#addForm').empty();
	e.preventDefault();
	// let url = 'https://kinopoiskapiunofficial.tech/api/v2.2/films/'+$('#movie_input').val();
	// fetch(url, {
	// 	method: 'GET',
	// 	headers: {
	// 		'X-API-KEY': 'f71d6402-9cb4-4201-bfd5-e1f1536b0605',
	// 		'Content-Type': 'application/json',
	// 	},
	// })
	// 	.then(response => {
	// 		if(response.status == 404)
	// 		{
	// 			let inp = '<p>Ничего не найдено(</p>';
	//
	// 			$('form#addForm').append($(inp));
	// 			return false;
	// 		}
	// 			return response.json() })
	// 	.then(resB => {
	// 		data = resB;
	// 		console.log(data);
    //         let item= '';
	// 		$.each(units, function (key, value)
	// 		{
	// 			if($('.admin-addfilm').length > 0)
	// 			{
	//
	// 			}else
	// 			{
	// 				item ='';
	// 				if(value[0] == 'genres')
	// 				{
	// 					$.each(data[value[0]], function (key, val)
	// 					{
	// 						item += ' '+val['genre'];
	// 					})
	// 				}
	// 				else
	// 				{
	// 					item = data[value[0]]
	// 				}
	// 				if(value[0] == 'posterUrl')
	// 				{
	// 					$('#'+value[0]).attr('src', item);
	// 				}else
	// 				{
	// 					$('#'+value[0]).text(value[1]+item);
	// 				}
	//
	// 				let inp = '<input type="hidden" name="'+value[0]+'" value="'+item+'">';
	//
	// 				$('form#addForm').append($(inp));
	// 			}
	//
	// 		});
	// 		fetch('https://kinopoiskapiunofficial.tech/api/v1/staff?filmId='+$('#movie_input').val(), {
	// 			method: 'GET',
	// 			headers: {
	// 				'X-API-KEY': 'f71d6402-9cb4-4201-bfd5-e1f1536b0605',
	// 				'Content-Type': 'application/json',
	// 			},
	// 		})
	// 			.then(resp => { return resp.json() })
	// 			.then(res => {
	// 				let inp = '<input type="hidden" name="director" value="'+res[0]['nameRu']+'">';
	//
	// 				$('form#addForm').append($(inp));
	// 			});
    //         let inp ='<p>Ты искал этот фильм? Если да, то нажми кнопку "Сохранить" и он сохранится в нашей базе</p>'+
	// 			'<button type="submit" class="btn btn-warning m-3">Сохранить</button>';
	//
    //         $('form#addForm').append($(inp));
	//
	// 	})
	// 	.catch(err => console.log(err))
	// // console.log(res);
	let url_new = "https://api.kinopoisk.dev/v1.3/movie?selectFields=persons&selectFields=poster&selectFields=name&selectFields=alternativeName&selectFields=description&selectFields=id&selectFields=genres&selectFields=logo&selectFields=year&selectFields=movieLength&selectFields=rating&page=1&limit=10"


	$.ajax({
		url: url_new,
		method: 'get',
		headers: { 'X-API-KEY': 'BJW5RB7-7EPMVH8-HYD1773-4VEDA34' },
		contentType: 'application/json',
		data: {name: $('#movie_input').val()},
		success: function(data){
			dataDecoder(data)

		},
		error: function(error){
			console.log(error)
		}
	});

	return false;
});


function dataDecoder(data)
{
	console.log(data)
	let name, original_name, id, description, genres, logo, imdb, kp, year, duration, director

	let movie = data.docs[0]
	name = movie.name
	original_name = movie.alternativeName
	description = movie.description
	id = movie.id
	genres = movie.genres
	logo = movie.poster.url
	imdb = movie.rating.imdb
	kp = movie.rating.kp
	year = movie.year
	duration = movie.movieLength
	let persons = movie.persons
	$.each(persons, function (key, value){
		console.log(value.enProfession)
		if(value.enProfession === "director"){
			director = value.name
			return false
		}
	})
	let inp = '<input type="hidden" name="director" value="'+director+'">';
	inp += '<input type="hidden" name="description" value="'+description+'">';
	inp += '<input type="hidden" name="filmLength" value="'+duration+'">';
	inp += '<input type="hidden" name="genres" value="'+genres.join(' ')+'">';
	inp += '<input type="hidden" name="nameOriginal" value="'+original_name+'">';
	inp += '<input type="hidden" name="nameRu" value="'+name+'">';
	inp += '<input type="hidden" name="posterUrl" value="'+logo+'">';
	inp += '<input type="hidden" name="ratingImdb" value="'+imdb+'">';
	inp += '<input type="hidden" name="ratingKinopoisk" value="'+kp+'">';
	inp += '<input type="hidden" name="webUrl" value="https://www.kinopoisk.ru/film/'+id+'">';
	inp += '<input type="hidden" name="year" value="'+year+'">';
	inp += '<input type="hidden" name="id" value="'+id+'">';
	$('form#addForm').append($(inp));

	let comparer =
		{
			nameOriginal: [original_name, ''],
			nameRu: [name, ''],
			ratingImdb: [imdb, "IMDB: "],
			ratingKinopoisk: [kp, "КП: "],
			filmLength: [duration, 'Продолжительность: '],
			year: [year, "Год выпуска: "]

		}
	$('#posterUrl').attr('src', logo);
	$.each(comparer, function (key, val){
		$('#'+key).text(val[1]+val[0]);

	})
	let units =
		[
			['description', 'Описание: '],
			['filmLength', 'Продолжительность: '],
			['genres', ''],
			['nameOriginal', ''],
			['nameRu', ''],
			['posterUrl', ''],
			['ratingImdb', 'IMDB: '],
			['ratingKinopoisk', 'КП: '],
			['webUrl', ''],
			['year', 'Год выпуска: ']
		];
	let input ='<p>Ты искал этот фильм? Если да, то нажми кнопку "Сохранить" и он сохранится в нашей базе</p>'+
		'<button type="submit" class="btn btn-warning m-3">Сохранить</button>';
	//
	$('form#addForm').append($(input));
}
$('form#addForm').submit(function (e){
	e.preventDefault();
	$.ajax({
		url: '/scripts/ajax/addfilm.php',
		method: 'post',
		dataType: 'html',
		data: $(this).serialize(),
		success: function(data){

			// console.log(data);
			$('form#addForm').empty();
			// $('.').empty()
			$('#movieAddModal').modal('hide');
			$('#answer').find('.toast-body').text(data)
			$('#answer').show();
			setTimeout(function (){
				$('#answer').hide();
			}, 3000);


		},
		error: function(error){
			$('#message').html(error);
		}
	});

});
//controller/UserFormController.php?type=feedback

$(document).ready(function(){
	
	// $('body').scroll(function () {
	// 	let topHead = $(this).scrollTop();
	// 	if ((topHead) >= 1) {
	// 		alert('a');
	// 	} else {
	// 		alert('a');
	//
	// 	}
	// });

	// alert('before')
	let div = "<div class=\"season\"\n" +
		"             data-aos=\"fade-up\"\n" +
		"             data-aos-offset=\"200\"\n" +
		"             data-aos-delay=\"50\"\n" +
		"\n" +
		"             data-aos-duration=\"1000\"\n" +
		"             data-aos-easing=\"ease-in-out\"\n" +
		"             data-aos-mirror=\"true\"\n" +
		"             data-aos-once=\"true\"\n" +
		"             data-aos-anchor-placement=\"top-center\">\n" +
		"            \n" +
		"\n" +
		"        </div>";
	if($('#statsBySeasons').length)
	{



		function animateValue(obj, start, end, duration) {
			if (start === end) return;
			let avg = false;
			if (end * 10 % 10 === 0)
			{
				console.log('true')
				avg = true
			}
			var range = end - start;
			var current = start;
			var increment = end > start? 0.1 : -0.1;
			var stepTime = Math.abs(Math.floor(duration / range));
			var timer = setInterval(function() {
				current += increment;
				if(!avg)
				{
					if (Math.abs(current - end) <= 0.1) {
						clearInterval(timer);
						return;

					}
				} else
				{
					if (parseInt(current) === parseInt(end)) {
						clearInterval(timer);
						return;
					}
				}
				obj.innerHTML = Math.round(current * 1000) / 1000;
				if(current)
				{
					if (current > 5.0)
					{
						$(obj).addClass('grey-zone')
						$(obj).removeClass('red-zone')
					} if(current > 7.0)
				{
					$(obj).removeClass('grey-zone')
					$(obj).addClass('green-zone')


				}
				}

			}, stepTime);
		}
		let timers = $('[data-toggle="count-animate"]')
		for(let i = 0; i < timers.length; i++)
		{
			let timer = timers[i]
			let from = $(timer).data("count-from")
			let to = $(timer).data("count-to")
			let duration = $(timer).data("count-duration")
			animateValue(timer, from, to, duration)
		}



	}
	$('body').scroll(function(){
		// alert('after')
		// console.log('as');
		if ($(this).scrollTop() > 100) {
			// console.log('ada');
			console.log($('.scrollup'));
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});

	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);

	});
	let verifyModal = $('#verifyEmailModal');
	if(verifyModal)
	{
		setTimeout(()=>
		{
			verifyModal.modal('show');
		}, 3000)
	}
	$('form#EmailVerification').submit(function (e) {
		e.preventDefault();

		console.log($(this).find('input[name="email"]').val());
		let id = $(this).find('input[name="id"]').val();
		$('.hideafter').empty();
		$.ajax({
			url: '/scripts/ajax/mail/SendCode.php',
			method: 'post',
			dataType: 'json',
			data: $(this).serialize(),
			success: function(data){
				console.log(data);
				$(verifyModal).find('.openafter').removeClass('d-none');
				$('#CodeCheck').on('input', function (e) {
					// console.log(this.value+toString(data[1]));
					if(this.value.length == 4)
					{
						$.ajax({
							url: '/scripts/ajax/verify.php',
							method: 'post',
							dataType: 'json',
							data: {id: id, code: this.value},
							success: function (data) {
								if(data['state'] == 1)
								{
									obj = $('#answer');
									obj.find('.toast-body').text(data['text'])
									obj.show();
									verifyModal.modal('hide');
									setTimeout(()=> {
										obj.hide();
									}, 1000);
								}
								else
								{
									console.log('nope')
								}



							}
				});
			}
		});
	}
	});
	});

	let votemodal = $('#pairVoteModal');
	console.log(votemodal);
	$('.modal-vote').on('click', function (e) {
		let data = JSON.parse($(this).attr('data-movies'));
		let vote = $(this).attr('data-vote');
		votemodal.find('#first').find('.avatars').empty();
		votemodal.find('#second').find('.avatars').empty();
		console.log(data);
		$.each(data['first']['votes'], function (key, val) {
			votemodal.find('#first').find('.avatars').append('<img  class="h-30p w-30p avatar" src="https://imdibil.ru/uploads/' + val + '">');
		});
		$.each(data['second']['votes'], function (key, val) {
			votemodal.find('#second').find('.avatars').append('<img  class="h-30p w-30p avatar" src="https://imdibil.ru/uploads/' + val + '">');
		});

		votemodal.find('#first').find('a').attr('href', data['first']['url']).find('img').attr('src', data['first']['poster']);
		votemodal.find('#second').find('a').attr('href', data['second']['url']).find('img').attr('src', data['second']['poster']);
		votemodal.find('#first').find('button').attr('data-movie', data['first']['id_m'])
		votemodal.find('#second').find('button').attr('data-movie', data['second']['id_m'])
		votemodal.find('.btn-vote').attr('data-vote',vote );

		votemodal.modal('show');
	});
	$('.btn-vote').on('click', function (e) {
		console.log('test')
		let film = $(this).attr('data-movie');
		let vote = $(this).attr('data-vote');
		$.ajax({
			url: 'https://imdibil.ru/scripts/ajax/votepair.php',
			method: 'post',
			dataType: 'json',
			data: {id_vote: vote, id_m: film},
			success: function(data){
				console.log(data);
				// return;
				if(data['state'] == 1)
				{
					$.SOW.core.toast.show('success', '', data['text'], 'top-center', 4000, true);
				}
				else
				{
					$.SOW.core.toast.show('error', '', data['text'], 'top-center', 4000, true);
				}

				votemodal.modal('hide');
			}
		});

	})
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
	if(!RateC) {return;}
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
		// console.log(shuffled);
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
						console.log(data)
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


