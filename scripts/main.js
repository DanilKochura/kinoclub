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
