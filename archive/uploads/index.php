<?php

$command = "python /home/pi/time/time.py";

header('Content-Type: text/html; charset=utf-8');
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo "<style type='text/css'>
 body{
 background:#000;
 color: #7FFF00;
 font-family:'Lucida Console',sans-serif !important;
 font-size: 12px;
 }
 </style>";

$pid = popen( $command,"r");
 
while( !feof( $pid ) )
{
 echo fread($pid, 256);
}
pclose($pid);
 
?>