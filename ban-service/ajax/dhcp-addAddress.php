<?php
$mysqli = new mysqli('localhost', 'server-admin', '0000', 'server-admin');

$query = "set names utf8";
$mysqli->query($query);


$host = $_POST["host"];
$ip = $_POST["ip"];
$mac = $_POST["mac"];
$comment = $_POST["comment"];

$query = "insert into dhcp (hostname, ip, mac, comment) values ('".$host."', '".$ip."', '".$mac."', '".$comment."')";
$results = $mysqli->query($query);

$query = "update daemons set flag=1 where service='dhcp'";
$mysqli->query($query);
?>
