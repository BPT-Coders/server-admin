<?php
// Подключаем библиотеку
require_once 'Filer.php';

// Глобальные переменные
$temp = $_SERVER['DOCUMENT_ROOT'].'/data/banTempBlackURL'; // Файл с временными адресами
$cur = $_SERVER['DOCUMENT_ROOT'].'/data/banCurBlackURL'; // Файл с сохранёнными адресами

$act = $_POST["act"]; // Считываем действие
/*
 * Считать сохранённые адреса = read
 * Добавить адрес = add
 * Удалить адрес = del
 * Сохранить изменения = save
 */
switch ($act){
	case 'read':
		read();
		break;
	case 'add': 
		add();
		break;
	case 'del':
		del();
		break;
	case 'save':
		save();
		break;
	default:
		exit();
		break;
}

function read(){
	global $cur, $temp;
	// Вывести сохранённые
	$file = new Filer($cur);
	$file->getStringsToHTML();
	
	// Стереть временные
	$file = new Filer($temp);
	$file->clear();
}


function add(){
	global $cur, $temp;
	$url = $_POST["url"];
	$file = new Filer($temp);
	$file->addString('+'.$url);
}

function del(){
	global $cur, $temp;
	$url = $_POST["url"];
	$file = new Filer($temp);
	$file->addString('-'.$url);
}

function save(){
	global $cur, $temp;
	/*
	 * Считать сохранённые адреса
	 * Считать временные адреса
	 * Выбрать адреса на удаление
	 * Выбрать адреса на добавление
	 * Вычесть из сохранённых адреса на удаление
	 * Добавить к сохранённым адреса на добавление
	 * Удалить пустые элементы
	 * Очистить файлы
	 * Записать результат
	 */
	$curFile = new Filer($cur);
	$curAddresses = $curFile->getStringsToArr();
	
	$tempFile = new Filer($temp);
	$tempAddresses = $tempFile->getStringsToArr();
	
	$minus = array();
	$plus = array();
	foreach($tempAddresses as $row){
		$address = substr($row, 1);
		if (substr($row, 0, 1) == '-'){
			array_push($minus, $address);
		}
		else {
			array_push($plus, $address);
		}
	}
	
	// Удаляем
	foreach($minus as $address){
		$key = array_search($address, $curAddresses);
		if ($key !== false)
		{
			unset($curAddresses[$key]);
		}
	}

	// Добавляем
	foreach($plus as $address){
		if (!in_array($address, $curAddresses))
		{
			array_push($curAddresses, $address);
		}
	}
	// Удалить пустые элементы
	$curAddresses = array_diff($curAddresses, array(''));
	// Очистить файлы
	$curFile->clear();
	$tempFile->clear();
	
	// Записать результат
	$curFile->writeFromArr($curAddresses);
}
?>