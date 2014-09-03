<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
 
<?php
 $timeinterval = $_GET["timespan"];
 ?>
 
<title>Analytics</title>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="js/highcharts.js" ></script>
<script type="text/javascript" src="js/modules/exporting.js" ></script>

<script type="text/javascript">
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});
    var chart;
            $(document).ready(function() {
                var options = {
                    chart: {
                        renderTo: 'container',
                        type: 'spline',
                        marginRight: 130,
                        marginBottom: 25,
						zoomType: 'xy'
                    },
					area: {
//						cropThreshold: 3000
					},
					title: {
                text: 'Daily Weather Analytics',
                x: -20 //center
            },
            subtitle: {
                text: 'Source: http://juanleroux.dtdns.net/',
                x: -20
            },
                    xAxis: {
                        type: 'datetime',
						//tickInterval: 3600 * 1000, // one hour
                        tickWidth: 0,
                        gridLineWidth: 0,
                        labels: {
                            align: 'center',
                            x: -3,
                            y: 20,
                            formatter: function() {
                                return Highcharts.dateFormat('%l%p', this.value);
                            }
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Values'
                        },
						gridLineWidth: 1,
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
						headerFormat: '<b>{series.name}</b><br>',
						pointFormat: '{point.x:%b %e, %H:%M}: {point.y:.1f} °C',
						crosshairs: [true, true]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 1
                    },
			        plotOptions: {
						series: {
							lineWidth: 2
						}
					},
					series: [{
                        name: 'Temperature 1',
						},
						{
						name: 'Temperature 2'
						},
						{
						name: 'Barometer'
						},
						{
						name: 'Altitude'
						},
						{
						name: 'Humidity'
						},
						{
						name: 'Luminosity'
                    }]
                }
                jQuery.get('data.php?tspan=<?php echo $timeinterval ?>', null, function(tsv) {
                    temp_1 = [];
					temp_2 = [];
                    baro = [];
					alto = [];
					humidity = [];
					luminosity = [];
                    try {
                        // split the data return into lines and parse them
                        tsv = tsv.split(/\n/g);
                        jQuery.each(tsv, function(i, line) {
                            line = line.split(/\t/);
                            date = line[0];
							temp_1.push([date, parseFloat(line[1].replace(',', ''))]);
                            temp_2.push([date, parseFloat(line[2].replace(',', ''))]);
                            baro.push([date, parseFloat(line[3].replace(',', ''))]);
							alto.push([date, parseFloat(line[4].replace(',', ''))]);
							humidity.push([date, parseFloat(line[5].replace(',', ''))]);
							luminosity.push([date, parseFloat(line[6].replace(',', ''))]);
                        });
                    } catch (e) {  }
                    options.series[0].data = temp_1;
                    options.series[1].data = temp_2;
					options.series[2].data = baro;
                    options.series[3].data = alto;
					options.series[4].data = humidity;
					options.series[5].data = luminosity;
                    chart = new Highcharts.Chart(options);
                });
            });
</script>

</head>
<body>

<div id="container" style="width: 100%; height: 400px; margin: 0 auto"></div>
	
</body>
</html>
