<?php
$mysqli = new mysqli('localhost', 'server-admin', '0000', 'server-admin');


$query = "set names utf8";
$mysqli->query($query);

$query = 'select * from dhcp order by ip';
$results = $mysqli->query($query);
while($row = $results->fetch_assoc()){
	/*switch ($row["access"]){
		case '0':
			echo '<div class="closed">';
			break;
		case '1':
			echo '<div class="opened">';
			break;
		case '2':
			echo '<div class="vip">';
			break;
	}*/
	echo $row["hostname"].' '.$row["ip"].'<br>';
}
?>