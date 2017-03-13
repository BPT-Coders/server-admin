<?php
$handle = fopen("/home/server-admin/server-admin.bpt.loc/public_html/ban-service/txt/whiteIP.txt", "r");
while (!feof($handle)) {
	$buffer = fgets($handle);
	if(strlen($buffer)!=0 & $buffer!="\n"){
		echo '<div class="address" id="'.$buffer.'">';
		echo $buffer.'<div class="dropAddress" onclick="changeAccess(this)"> X </div>';
		echo '</div>';
	};
}
fclose($handle);
?>
