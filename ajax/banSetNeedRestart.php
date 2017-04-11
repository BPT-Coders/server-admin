<?php
require_once 'Filer.php';

//
// Скопировать обновлённые справочники
//


// Перезагрузить сервер
$file = new Filer($_SERVER['DOCUMENT_ROOT'].'/data/banNeedRestart');
$file->clear();	
$file->addString('1');

?>