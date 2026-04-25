<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        use miloschuman\highcharts\Highcharts;

echo Highcharts::widget([
   'options'=>'{
	"chart": {
		"plotBackgroundColor": null,
		"plotBorderWidth": null,
		"plotShadow": false,
		"type": "pie"
	},
	"title": {
		"text": "Browser market shares January, 2015 to May, 2015"
	},
	"tooltip": {
		"pointFormat": "{series.name}: <b>{point.percentage:.1f}%</b>"
	},
	"plotOptions": {
		"pie": {
			"allowPointSelect": true,
			"cursor": "pointer",
			"dataLabels": {
				"enabled": true,
				"format": "<b>{point.name}</b>: {point.percentage:.1f} %",
				"style": {
					"color": "black"
				}
			}
		}
	},
	"series": [{
		"name": "Brands",
		"colorByPoint": true,
		"data": [{
			"name": "Microsoft Internet Explorer",
			"y": 56.33
		}, {
			"name": "Chrome",
			"y": 24.03,
			"sliced": true,
			"selected": true
		}, {
			"name": "Firefox",
			"y": 10.38
		}, {
			"name": "Safari",
			"y": 4.77
		}, {
			"name": "Opera",
			"y": 0.91
		}, {
			"name": "Proprietary or Undetectable",
			"y": 0.2
		}]
	}]
}'
]);        
        
echo Highcharts::widget([
   'options' => [
      'title' => ['text' => 'Fruit Consumption'],
      'xAxis' => [
         'categories' => ['Apples', 'Bananas', 'Oranges']
      ],
      'yAxis' => [
         'title' => ['text' => 'Fruit eaten']
      ],
      'series' => [
         ['name' => 'Jane', 'data' => [1, 0, 4]],
         ['name' => 'John', 'data' => [5, 7, 3]]
      ]
   ]
]);


        ?>
    </body>
</html>
