<?php
$address = $_POST["address"];
$fp = fopen("/home/server-admin/server-admin.bpt.loc/public_html/ban-service/txt/whiteIP.txt", "a"); // Открываем файл в режиме записи 
$mytext = "Это строку необходимо нам записать\r\n"; // Исходная строка
$test = fwrite($fp, $address."\n"); // Запись в файл
if ($test) echo 'Данные в файл успешно занесены.';
else echo 'Ошибка при записи в файл.';
fclose($fp); //Закрытие файла
?>
