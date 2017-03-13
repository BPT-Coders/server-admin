<?php
$filename = '/home/server-admin/server-admin.bpt.loc/public_html/ban-service/txt/whiteIP.txt';
$handle = fopen($filename, 'r+');
ftruncate($handle, 0);
rewind($handle);
fclose($handle);
?>
