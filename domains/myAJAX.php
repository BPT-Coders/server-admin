<?php
require_once 'connectParams.php';
$mysqli = new mysqli("localhost", $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
	printf("Ошибка подключения к БД: %s\n", $mysqli->connect_error);
	exit();
};
$query = "set names utf8";
$mysqli->query($query);


$query = "SELECT * FROM domains";
	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
			echo '<a href="http://'.$row["name"].'">'.$row["student"].'</a><br>';

		}
	$result->free();
	}
$mysqli->close();
?>