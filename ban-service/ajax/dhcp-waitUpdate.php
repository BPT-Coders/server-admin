<?php
$mysqli = new mysqli('localhost', 'server-admin', '0000', 'server-admin');


$query = "set names utf8";
$mysqli->query($query);

$query = "select * from daemons where service='dhcp'";
$results = $mysqli->query($query);
while($row = $results->fetch_assoc()){
	echo $row["flag"];
}
?>