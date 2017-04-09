<?php
require_once 'Filer.php';

$ip = $_POST["mode"];
$file = new Filer($_SERVER['DOCUMENT_ROOT'].'/data/banNewMode');
$file->clear();
$file->add($ip);

?>