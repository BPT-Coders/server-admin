<?php
require_once 'Filer.php';

$mode = $_POST["mode"];
$file = new Filer($_SERVER['DOCUMENT_ROOT'].'/data/banNewMode');
$file->clear();
$file->add($mode);

?>
