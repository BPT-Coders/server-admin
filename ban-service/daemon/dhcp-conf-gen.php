<?php
require_once 'connectParams.php';
$mysqli = new mysqli("localhost", $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
	printf("Ошибка подключения к БД: %s\n", $mysqli->connect_error);
	exit();
};
$query = "set names utf8";
$mysqli->query($query);

$fp = fopen("/home/server-admin/server-admin.bpt.loc/public_html/ban-service/daemon/dhcp.conf", "a"); // Открываем файл в режиме записи 

// Стираем старое содержимое
ftruncate($fp, 0);
rewind($fp);

// Пишем новый конфиг
// Пишем параметры
$mytext = 'ddns-update-style none;
option domain-name "bpt.loc";
option domain-name-servers 192.168.137.254;
default-lease-time 28800;
max-lease-time 28800;
log-facility local7;
subnet 192.168.137.0 netmask 255.255.255.0 {
  range 192.168.137.101 192.168.137.120;
  option domain-name-servers 192.168.137.254;
  option routers 192.168.137.254;
}
';

fwrite($fp, $mytext."\n");

//Прописываем статические хосты
$query = "SELECT * FROM dhcp";
	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
			$mytext = '# '.$row["comment"];
			fwrite($fp, $mytext."\n"); // Запись в файл
			$mytext = 'host '.$row["hostname"].' {';
			fwrite($fp, $mytext."\n"); // Запись в файл
			$mytext = '  hardware ethernet '.$row["mac"].';';
			fwrite($fp, $mytext."\n");
			$mytext = '  fixed-address '.$row["ip"].';';
			fwrite($fp, $mytext."\n");
			$mytext = '}';
			fwrite($fp, $mytext."\n\n");
		}
	$result->free();
	}

/*$test = fwrite($fp, $mytext."\n"); // Запись в файл
if ($test) echo 'Данные в файл успешно занесены.';
else echo 'Ошибка при записи в файл.';*/
fclose($fp); //Закрытие файла
$mysqli->close();
?>