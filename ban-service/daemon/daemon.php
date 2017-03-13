<?php
shell_exec('sudo bash /home/server-admin/server-admin.bpt.loc/public_html/ban-service/daemon/firewall.sh');
while(true){
	$flag = '';
	$filename = '/home/server-admin/server-admin.bpt.loc/public_html/ban-service/txt/needUpdate.txt';
	//Считать Флаг из файла
	$handle = fopen($filename, "r");
	while (!feof($handle)) {
		$flag = fgets($handle);
	};
	fclose($handle);
	
	if ($flag == 'firewall'){
		//Запустить скрипт обновления
		$output = shell_exec('sudo bash /home/server-admin/server-admin.bpt.loc/public_html/ban-service/daemon/firewall.sh');
		echo $output;
		//очистить needUpdate
		$handle = fopen($filename, 'r+');
		ftruncate($handle, 0);
		rewind($handle);
		fclose($handle);
	};
	if ($flag == 'panic'){
		//Запустить скрипт обновления
		$output = shell_exec('sudo bash /home/server-admin/server-admin.bpt.loc/public_html/ban-service/daemon/panic.sh');
		echo $output;
		//очистить needUpdate
		$handle = fopen($filename, 'r+');
		ftruncate($handle, 0);
		rewind($handle);
		fclose($handle);
	};
	sleep(5);
	
}

?>
