<?php
$handle = fopen("/home/server-admin/server-admin.bpt.loc/public_html/ban-service/txt/needUpdate.txt", "r");
while (!feof($handle)) {
	$buffer = fgets($handle);
	echo $buffer;
	};
fclose($handle);
?>
