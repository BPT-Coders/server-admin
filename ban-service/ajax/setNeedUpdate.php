<?php
$fp = fopen("/home/server-admin/server-admin.bpt.loc/public_html/ban-service/txt/needUpdate.txt", "a"); // Открываем файл в режиме записи 
$mode = $_POST["mode"];
$test = fwrite($fp, $mode); // Запись в файл
fclose($fp); //Закрытие файла
?>
