<?php
$host = "localhost";
$user = "postgres";
$pass = "postgres";
$db   = "simrs";
$conn_string = "host=$host port=5433 dbname=$db user=$user password=$pass";
//mysql_connect($host,$user,$pass) or die (mysql_error());
//mysql_select_db($db) or die (mysql_error());
$conn3 = pg_connect($conn_string);
if (!$conn3)
  {exit(" koneksi gagal " . $conn3);} 

?>