<?php
// Подключаем библиотеку
require_once 'Filer.php';

// Глобальные переменные
$temp = $_SERVER['DOCUMENT_ROOT'].'/data/serbanTempWhiteIP'; // Файл с временными адресами
$cur = $_SERVER['DOCUMENT_ROOT'].'/data/serbanCurWhiteIP'; // Файл с сохранёнными адресами


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
    $save = $file->getStrings();
    
    $hosts = [];
    //print_r($hosts);
    // Распаковываем
    $hosts = unserialize($save);
    //print_r($hosts);
    
    echo json_encode($hosts); // Передаём JSON объект js скрипту
    
    
    // Стереть временные
    $file = new Filer($temp);
    $file->clear();
}

function add(){
    global $cur, $temp;
    $file = new Filer($temp);
    // Входной набор данных
    
    /*$hosts[] = ["ip" => "192.168.137.1", "access" => "1", "unlimit" => "1", "comment" => "Мой ПК"];
     $hosts[] = ["ip" => "192.168.137.2", "access" => "0", "unlimit" => "-1", "comment" => "Студент"];
     $hosts[] = ["ip" => "192.168.137.53", "access" => "1", "unlimit" => "0", "comment" => "Колотилов"];
     */
    
    // считать из файла имеющиеся записи
    //
    $save = $file->getStrings();
    $hosts = [];
    $hosts = unserialize($save);
    print_r($hosts);
    
    // получить и дописать новые записи
    //
    $ip = $_POST["ip"];
    $access = $_POST["access"];
    $unlimit = $_POST["unlimit"];
    $comment = $_POST["comment"];
    
    // проверить на наличие имеющихся записей по данному ip адресу
    $rewrite = 0;
    foreach ($hosts as $k => &$v){
        if ($v['ip'] == $ip){
            echo "Запись уже имеется";
            $rewrite = 1;
            $v['ip'] = $ip;
            $v['access'] = $access;
            $v['unlimit'] = $unlimit;
            $v['comment'] = $comment;
            $v['act'] = "add";
            break;
        }
        else {
            echo "мимо";
        }
    }
    if ($rewrite == 0){
        $hosts[] = ["ip" => $ip, "access" => $access, "unlimit" => $unlimit, "comment" => $comment];
    }
    
    
    echo 'После добавления';
    print_r($hosts);
    
    // Упаковываем
    $save = serialize($hosts);
    echo $save;
    
    
    $file->clear();
    $file->addString($save);
}

function del(){
    global $cur, $temp;
    $ip = $_POST["ip"];
    $file = new Filer($temp);
    $file->addString('-'.$ip);
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