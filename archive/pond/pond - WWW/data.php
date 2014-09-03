<?php

// Get time and work out time 1 day ago
$span = $_GET["tspan"];
if ($span < 0.1)
{
	$span = 0.1;
}
if ($span > 7)
{
	$span = 7;
}

$time1d = time() - ($span * 86400);

// Query DB
$db = new SQLite3('/home/philipw/pond/pond.db');
$results = $db -> query('SELECT * FROM temps where timestamp > ' . $time1d . ' order by timestamp ASC');

// Loop through the data
while ($row = $results -> fetchArray()) 
{
	echo $row['timestamp'] * 1000 . "\t" . $row['pond_top']. "\t" . $row['pond_bot']. "\t" . $row['pond_out']. "\t" . $row['shed_top']. "\t" . $row['shed_bot']. "\n";
}

$db -> close;

?>