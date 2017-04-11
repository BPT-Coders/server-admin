<?php
require_once 'Filer.php';
$file = new Filer($_SERVER['DOCUMENT_ROOT'].'/data/banCurMode');
$file->getStrings();
?>