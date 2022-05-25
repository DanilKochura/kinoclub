
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
			else el.classList.add("red-zone");;
}

const Select = document.querySelectorAll('.selected');
Select.forEach(element => {
  console.log(element.textContent);
  SelectCheck(element.textContent);
});

// Access the first element in the NodeList
Select[0];
function SelectCheck(el)
{
	let id = "#id-"+el
	console.log(id);
	const RateC = document.querySelector(id);
	RateC.classList.add("selected");

}
RateC[0];