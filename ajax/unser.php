<?php
// Подключаем библиотеку
require_once 'Filer.php';

// Глобальные переменные
$temp = $_SERVER['DOCUMENT_ROOT'].'/data/serbanTempWhiteIP'; // Файл с временными адресами

$file = new Filer($temp);
$save = $file->getStrings();

$hosts = [];
//print_r($hosts);
// Распаковываем
$hosts = unserialize($save);
//print_r($hosts);

// Парсим массив
foreach ($hosts as $k => $v){
	$check = "";
	if ($v['access'] == 1) $check = "checked";
	$unlimit = "";
	if ($v['unlimit'] == 1) $unlimit = "checked";
	$limited = "";
	if ($v['unlimit'] == -1) $limited = " -  <b>Лимит превышен</b>";
	echo "<p title=\"{$v['comment']}\"><input type=\"checkbox\" $check>{$v['ip']} <input type=\"checkbox\" $unlimit> $limited</p>";
}

?>