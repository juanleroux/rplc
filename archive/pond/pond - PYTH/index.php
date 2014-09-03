<?php 

// include JPGraph Library
include ("/usr/share/jpgraph/jpgraph.php");
include ("/usr/share/jpgraph/jpgraph_line.php");
include ("/usr/share/jpgraph/jpgraph_date.php");

// The callback that converts timestamp to minutes and seconds 
function TimeCallback($aVal) {
return Date('Y.M.d-H:i',$aVal);
}

// create new graph 
$graph = new Graph(1650,900,"auto");

// Query DB
$db = new SQLite3('/home/philipw/pond/pond.db');
$results = $db->query('SELECT * FROM temps order by timestamp DESC limit 1440');

$i = 0;
while ($row = $results->fetchArray()) 
{
	$datum[$i] = $row[0] - 3600;
	$temp1[$i] = $row[2];
	$temp2[$i] = $row[3];
	$temp3[$i] = $row[4];
	$temp4[$i] = $row[5];
	$temp5[$i] = $row[6];
	$i++;
}

$graph->SetScale("int");
//$graph->SetYScale("lin");


$lineplot1=new LinePlot($temp1, $datum);
$lineplot1->SetLegend('Pond Top');
$lineplot1->SetColor('blue');

$lineplot2=new LinePlot($temp2, $datum);
$lineplot2->SetLegend('Pond Bottom');
$lineplot2->SetColor('black');

$lineplot3=new LinePlot($temp3, $datum);
$lineplot3->SetLegend('Pond Out');
$lineplot3->SetColor('white');

$lineplot4=new LinePlot($temp4, $datum);
$lineplot4->SetLegend('Shed Top');
$lineplot4->SetColor('yellow');

$lineplot5=new LinePlot($temp5, $datum);
$lineplot5->SetLegend('Shed Bottom');
$lineplot5->SetColor('red');

$graph->xaxis->SetLabelFormatCallback('TimeCallback');
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetTextLabelInterval(2);

$graph->SetMargin(40,40,30,130);
$graph->SetColor('wheat3');
$graph->legend->Pos(0.06,0.04, "center", "bottom ");
$graph->title->Set('Garden Temperatures');

$graph->Add($lineplot1);
$graph->Add($lineplot2);
$graph->Add($lineplot3);
$graph->Add($lineplot4);
$graph->Add($lineplot5);

// display graph
$graph->Stroke();

?>
