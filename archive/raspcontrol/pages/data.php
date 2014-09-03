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

$con = mysql_connect("localhost","root","");

if (!$con) {
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("history", $con);

$result = mysql_query("SELECT * FROM sensors WHERE timestamp > " . $time1d . " ORDER BY timestamp ASC");

while($row = mysql_fetch_array($result)) {
  echo $row['timestamp'] * 1000 . "\t" . $row['temp1']. "\t". $row['temp2']. "\t" . $row['barometer']. "\t". $row['altitude']. "\t". $row['humidity']. "\t". $row['luminosity']. "\n";
  echo $time1d;
}


mysql_close($con);
?> 