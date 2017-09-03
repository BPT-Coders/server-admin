<?php

/*
r – открытие файла только для чтения.
r+ - открытие файла одновременно на чтение и запись.
w – создание нового пустого файла. Если на момент вызова уже существует такой файл, то он уничтожается.
w+ - аналогичен r+, только если на момент вызова файл такой существует, его содержимое удаляется.
a – открывает существующий файл в  режиме записи, при этом указатель сдвигается на  последний байт файла (на конец файла).
a+ - открывает файл в режиме чтения и записи при этом указатель сдвигается на последний байт файла (на конец файла). Содержимое файла не удаляется
*/
class Filer{
	var $name;
	
	function Filer($name){
		$this->name = $name;
		//Если не существует - создать
		if (!file_exists($name)){
			$this->create();
		}
	}
	
	//Создаёт файл
	function create(){
		$fp = fopen($this->name, 'w');
		fclose($fp);
	}
	
	/**
	 * Принимает массив и записывает каждый элемент в новую строку файла
	 * @param unknown $arr
	 */
	function writeFromArr($arr){
		$fp = fopen($this->name, 'a');
		foreach ($arr as $string){
			fwrite($fp, $string."\n");
		}
		fclose($fp);
	}
	
	//Добавляет строку в файл
	function addString($string){
		$fp = fopen($this->name, 'a');
		fwrite($fp, $string."\n");
		fclose($fp);
	}
	
	//Добавляет текст без переноса строки
	function add($string){
		$fp = fopen($this->name, 'a');
		fwrite($fp, $string);
		fclose($fp);
	}
	
	//Считывает все строки из файла
	function getStrings(){
		$bytes = 4096; // Максимальное количество байт в строке
		$fp = fopen($this->name, "r");
		$allStrings = "";
		while (!feof($fp)) {
			$buffer = fgets($fp, $bytes);
			//echo trim($buffer);
			$allStrings .= trim($buffer);
		}
		fclose($fp);
		return $allStrings;
	}
	
	/**
	 * Возвращает содержимое файла в виде массива строк
	 * @return array
	 */
	function getStringsToArr(){
		$result = array();
		$bytes = 4096; // Максимальное количество байт в строке
		$fp = fopen($this->name, "r");
		while (!feof($fp)) {
			$buffer = fgets($fp, $bytes);
			array_push($result, trim($buffer));
		}
		fclose($fp);
		return $result;
	}
	
	
	function getStringsToHTML(){
		$bytes = 4096; // Максимальное количество байт в строке
		$fp = fopen($this->name, "r");
		while (!feof($fp)) {
			$buffer = fgets($fp, $bytes);
			echo trim($buffer).'<br>';
		}
		fclose($fp);
	}
	
	//Очищает файл
	function clear(){
		$fp = fopen($this->name, 'a'); //Открываем файл в режиме записи
		ftruncate($fp, 0); // очищаем файл
		fclose($fp);
	}
}
?>