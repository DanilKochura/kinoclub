
/*let d = {
  labels: [],
  datasets: [{
      label: 'My First dataset',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: ,
    }]

}


 
  $.ajax({
    url: 'api.php',
    type: 'GET',
    dataType: 'json',
    cache: false,
    data: {'id': 2},
    success: function(data) {
      for(let i in data)
      {
        d.data
      }
    },
     error: function(xhr, textStatus, errorThrown) {
      console.log("error!");
    }

  });
console.log(d)
 const config = {
    type: 'line',
    data: d,
    options: {}
  };

   const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );


let d = {
  labels: <?php echo json_encode($arr['movie']);?>,
  datasets: [{
      label: <?php echo json_encode($arr['user']['name']);?>,
      backgroundColor: '#23282b',
      borderColor: 'gold',
      data: <?php echo json_encode($arr['user']['data']);?>,
    },
    {
      label: <?php echo json_encode($arr['avg']['name']);?>,
      backgroundColor: 'white',
      borderColor: '#808080',
      data: <?php echo json_encode($arr['avg']['data']);?>,
    }]


}

*/

function avg(a) {//нахождение среднего в массиве
    let result = 0;
    for(let i = 0; i<a.length; i++)
    {
        result= result + parseInt(a[i]);
    }
    result = result / a.length;
    return result;
}//нахождение среднего в массиве

let a = JSON.parse($('.hidden').text()); //парсинг данных об оценках
console.log(a);

//a.user[6].name = 'Дмитрий Сергеевич'
function compare(a, b) { //поиск только совпадающих фильм у двух пользователей
    let first = [], second = [];

    for(let i = 0; i<a.length; i++)
    {
        if(a[i]*b[i]!=0)
        {
            first.push(a[i]);
            second.push(b[i]);
        }
    }

    let result = [first, second];
    return result;
    //console.log(a);

}//поиск только совпадающих фильм у двух пользователей

function correl(a, b) {  //нахождение корреляции оценок
    let chisl = 0, sum = 0, znam1 =0, znam2= 0;
    let res = compare(a,b);
    //console.log(res[0]);
    //console.log(res[1]);
    let first = avg(res[0]);
    let second = avg(res[1]);
    //console.log(first);
    //console.log(second);
    for(let i = 0; i<res[0].length; i++)
    {
        sum = (res[0][i]-first)*(res[1][i]-second);
        //console.log(chisl, sum);
        chisl += sum;

        znam1 += ((res[0][i]-first)*(res[0][i]-first));
        znam2 += ((res[1][i]-second)*(res[1][i]-second));

    }
    let znam = Math.sqrt(znam1)*Math.sqrt(znam2);
    //console.log(znam1, znam2, znam, chisl)
    return(chisl/znam);

}//нахождение корреляции оценок
//correl(a.kp.data, a.user[0].data)
function closeness(a, b) {
    let res = compare(a, b);
    let first = res[0];
    let second = res[1];
    let d = 0;
    for(let i =0; i<first.length; i++)
    {
        d += Math.abs(second[i]-first[i]);
        //console.log(d)
    }
    d/=first.length;
    return(100-11*d);
}//определение близости интересов


function render(val)
{
  console.log(val);
  if(val == 0)
  {
    $('.description').removeClass('hidden');
  }
  else if(val==1)
  {
    let labels = a.movies;
    let datasets =  [{
          label: a.avg.name,
          backgroundColor: 'white',
          borderColor: '#808080',
          data: a.avg.data,
        },
        {
            label: a.kp.name,
            backgroundColor: 'white',
            borderColor: 'orange',
            data: a.kp.data,
        },
        {
            label: a.imdb.name,
            backgroundColor: 'black',
            borderColor: 'yellow',
            data: a.imdb.data,
        }];
    for(let i = 0; i<a.user.length; i++)
    {
      data = 
      {
        label: a.user[i].name,
        backgroundColor: '#23282b',
        borderColor: 'gold',
        data: a.user[i].data,
        hidden: true
      };
      datasets.push(data);
    }
    let d = {
      labels: labels,
      datasets: datasets
    };
    //console.log(datasets);
    const config = {
        type: 'line',
        data: d,
        options: {
            scales: {
            y: {
              min: 4,
              max: 10.5
            }
          },
          animation:
              {
                  duration: 1000,
                  easing: 'linear'
              }

        }
  };

  const myChart = new Chart(
     document.getElementById('myChart'),
     config
    );
  }
  else if(val == 2)
  {
    let labels = [a.avg.name, a.kp.name, a.imdb.name];
    let datasets =[];

    for(let i = 0; i<a.user.length; i++)
    {
        labels.push(a.user[i].name);
        //console.log(a.user[i].name)
        let data2=[correl(a.avg.data, a.user[i].data), correl(a.kp.data, a.user[i].data), correl(a.imdb.data, a.user[i].data)];
        let bg = ['gray', 'orange','yellow'];
        for(let j = 0; j<a.user.length; j++) {
            if (i == j) {
                data2.push(0);
                continue;
            }

            data2.push(correl(a.user[i].data, a.user[j].data));

            bg.push('gold');
            //console.log(data2);

        }
        bg.push('gold');
        let dataa = {
            label: a.user[i].name,
            backgroundColor: bg,
            borderColor: 'gold',
            data: data2,
            hidden: true
        }
        datasets.push(dataa);
    }
    //let max = Math.max(datasets.data[1].data)
      //console.log(max)
    let d = {
      labels: labels,
      datasets: datasets
    };
    console.log(datasets);
    const config = {
        type: 'bar',
        data: d,
        options: {
            scales:
                {
                    y:
                        {
                            ticks: {
                                maxTicksLimit: 3,
                                color: 'white'
                            },
                            grid:
                                {
                                    color: 'white',
                                    borderDash: [0]
                                }
                        },

                },
            interaction: {
                  intersect: false,
                  mode: 'index',
                },
        }
    };

    const myChart = new Chart(
       document.getElementById('myChart'),
       config
      );

      let stat =
          {
              kp:
                  {
                      max: [-1, 0],
                      min: [1, 0]
                  },
              imdb:
                  {
                      max: [-1, 0],
                      min: [1, 0]
                  },
              common:
                  {
                      max: [-1, 0, 0],
                      min: [1, 0, 0]
                  }
          };
      for(let i =0; i<datasets.length; i++)
      {
        if(datasets[i].data[1]>stat.kp.max[0])
        {
            stat.kp.max = [datasets[i].data[1], datasets[i].label];
        }
        else if(datasets[i].data[1]<stat.kp.min[0])
        {
            stat.kp.min = [datasets[i].data[1], datasets[i].label];
        }
        if(datasets[i].data[2]>stat.imdb.max[0])
        {
            stat.imdb.max = [datasets[i].data[2], datasets[i].label];
        }
        else if(datasets[i].data[2]<stat.imdb.min[0])
        {
            stat.imdb.min = [datasets[i].data[2], datasets[i].label];
        }
        //datasets[i].data.splice(0, 3);

        for(let j = 3; j<datasets[i].data.length; j++)
        {
            if(j-3 == i)
            {
                continue;
            }
            if(datasets[i].data[j]>stat.common.max[0])
            {
                stat.common.max = [datasets[i].data[j], datasets[i].label, datasets[j-3].label];
            }
            else if(datasets[i].data[j]<Math.abs(1-stat.common.min[0]))
            {
                stat.common.min = [datasets[i].data[j], datasets[i].label, datasets[j-3].label];
            }
        }
      }
      console.log(stat);
      $('.chart').append('' +
          '<div class="row legend text-center" ><h1>Выводы</h1>' +
          '<div class="block">Максимальная корреляция оценок с Кинопоиском у пользователя: <span class="name">'+
          stat.kp.max[1]+'</span>,<br> что может означать, что он чаще чем остальные склонен ориентироваться на оценки'+
          ' КП при оценке фильма</div>'+
          '<div class="block"> Минимальная корреляция оценок с Кинопоиском у пользователя: <span class="name">'+
          stat.kp.min[1]+'</span>,<br> что может означать, что он реже чем остальные склонен ориентироваться на оценки'+
          ' КП при оценке фильма</div>'+
          '<div class="block">Максимальная корреляция оценок с IMDB у пользователя: <span class="name">'+
          stat.imdb.max[1]+'</span>,<br> что может означать, что он чаще чем остальные склонен ориентироваться на оценки'+
          ' IMDB при оценке фильма</div>'+
          '<div class="block">Минимальная корреляция оценок с IMDB у пользователя: <span class="name">'+
          stat.imdb.min[1]+'</span>,<br> что может означать, что он реже чем остальные склонен ориентироваться на оценки'+
          ' IMDB при оценке фильма</div>'+
          '<div class="block">Максимальная корреляция оценок у пользователей: <span class="name">'+
          stat.common.max[1]+'</span> и <span class="name">'+ stat.common.max[2]+ '</span>,<br> что может означать, что они примерно одинаково оценивают фильмы и/или ориентируются на оценки друг друга</div>'+
          '</div>');
  }

  else if(val==3)
    {
        let labels = ["Оценка сообщества"];
        let datasets =[];

        for(let i = 0; i<a.user.length; i++)
        {
            labels.push(a.user[i].name);
            //console.log(a.user[i].name)
            let d = closeness(a.avg.data, a.user[i].data)
            let data2=[d];
            let bg = ['gray'];
            for(let j = 0; j<a.user.length; j++) {
                if (i == j) {
                    data2.push(0);
                    continue;
                }

                data2.push(closeness(a.user[i].data, a.user[j].data));

                bg.push('gold');
                //console.log(data2);

            }
            bg.push('gold');
            let data = {
                label: a.user[i].name,
                backgroundColor: bg,
                borderColor: 'gold',
                data: data2,
                hidden: true
            }
            //console.log(data);
            datasets.push(data);
        }
        let d = {
            labels: labels,
            datasets: datasets
        };
        //console.log(datasets);
        const config = {
            type: 'bar',
            data: d,
            options: {
                scales:
                    {
                        y:
                            {
                                ticks: {
                                    maxTicksLimit: 3,
                                    color: 'white'
                                },
                                grid:
                                    {
                                        color: 'white',
                                        borderDash: [0]
                                    }
                            },

                    },

            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    }



}




$('input[type=radio]').change(function(e)
{
  $('.description').addClass('hidden');
  $('.legend').remove();
  $('#myChart').remove();
  $('.chart').append('<canvas id="myChart" class="charts"></canvas>');
  render($('input[type=radio]:checked').val());
});


