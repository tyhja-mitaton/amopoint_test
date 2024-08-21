<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Statistics';
$this->params['breadcrumbs'][] = $this->title;
$ipfyToken = Yii::$app->params['ipfy-token'];

$uniqueIpByHourArray = \app\models\Geo::countUniqueIpByHour();
$uniqueIpCounters = json_encode(array_keys($uniqueIpByHourArray));
$hours = json_encode(array_values($uniqueIpByHourArray));
$uniqueCityData = \app\models\Geo::uniqueCityData();
$uniqueCityCounters = json_encode(array_keys($uniqueCityData));
$uniqueCities = json_encode(array_values($uniqueCityData));
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

    <?php else: ?>

        <div class="row">
            <div class="col-lg-5">
                <div id="chart"></div>
                <div id="pie-chart"></div>
            </div>
        </div>

    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<?php $this->registerJs(<<<JS
var token = '$ipfyToken';
function setCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}
function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
function delCookie(name) {
	setCookie(name,"",-1);
}

if (getCookie("counter")) {
  var count=parseInt(getCookie("counter"))+1;
  setCookie("counter",count,365);
} else {
    fetch('https://api.ipify.org?format=json')
    .then(response => response.json())
    .then(data => {
        console.log(data.ip);
        let ip = data.ip;
        fetch('https://geo.ipify.org/api/v2/country,city?apiKey=' + token + '&ipAddress=' + ip)
        .then(response => response.json())
        .then(geodata => {
            console.log(geodata.location.city, navigator.userAgent);
            let city = geodata.location.city;
            let device = navigator.userAgent;
            $.ajax({
            type: "GET",
            url: '/site/create-geo?ip=' + ip + '&city=' + city + '&device=' + device,
            success: function(res) {
              console.log('success', res);
            }
        });
        })
    })
    .catch(error => {
        console.log('Error:', error);
    });
    
  setCookie("counter",1,365);
}

console.log("Вы зашли на эту страницу "+getCookie("counter"));

var areaChart = document.querySelector('#chart'),
areaChartConfig = {
    series: [{
            name: "Hours",
            data: $hours
        }],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Unique visitors by Hour',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
        title: {
            text: 'Unique visitors'
        },
          categories: $uniqueIpCounters
        }
};
var pieChart = document.querySelector('#pie-chart'),
pieChartConfig = {
    series: $uniqueCityCounters,
    labels: $uniqueCities,
    chart: {
          width: 380,
          type: 'pie'
    }
};
if (typeof areaChart !== undefined && areaChart !== null) {
    var chart = new ApexCharts(areaChart, areaChartConfig);
                chart.render();
}
if (typeof pieChart !== undefined && pieChart !== null) {
    var chartPie = new ApexCharts(pieChart, pieChartConfig);
                chartPie.render();
}
JS);