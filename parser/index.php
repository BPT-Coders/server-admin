<?php
// Подключаем библиотеку
require_once 'simple_html_dom.php';
// Подключаем клас для работы с файлами
require_once 'Filer.php';

// Выбираем файл для записи
$limitedIP = new Filer('./newLimitedIp.txt');
$limitedIP->clear();
// Получаем страницу с отчётом
$page = 'http://server-admin.bpt.loc/sarg/Daily/'.date("dMY").'-'.date("dMY").'/index.html';
$data = file_get_html($page);

// Лимит трафика
// Мегабайты
$limitMb = 200;
// Переводим в байты
$limit = $limitMb * 1024 * 1024;

// Список ip без лимита
$vip = array('192.168.137.1', '192.168.137.21', '192.168.137.53');

// Индекс первой строки репорта в файле
$beginReport = 10;

//Сохраням в массив все найденные контейнеры tr
$tr = $data->find('tr');

// Перебираем строки, пропуская первую заголовочную
for ($i = $beginReport; $i < count($tr) - 2; $i++){
	// Сохраням в массив все найденные ячейки в текущей строке
	$td = $tr[$i]->find('td');
	// Текущий ip
	//$ip = $td[2]->innertext;
	$ip = $td[2]->plaintext;
	// Трафик по текущему ip
	$trafic = $td[4]->innertext;
	// Определяем единицу измерения трафика (Гб, Мб, Кб)
	$KMG = substr($trafic, -1);
	$bytes;
	switch ($KMG){
		case 'G':
			$KMG = 'Гигабайты';
			$bytes = substr($trafic, 0, -1);
			$bytes = $bytes * 1024 * 1024 * 1024;
			break;
		case 'M':
			$KMG = 'Мегабайты';
			$bytes = substr($trafic, 0, -1);
			$bytes = $bytes * 1024 * 1024;
			break;
		case 'K':
			$KMG = 'Килобайты';
			$bytes = substr($trafic, 0, -1);
			$bytes = $bytes * 1024;
			break;
		default:
			$KMG = 'Байты';
			$bytes = $trafic;
	}
	
	  if ($bytes > $limit){
		  if(!(in_array($ip, $vip))){
			  $limitedIP->addString($ip);
		  }
		}
}
?>