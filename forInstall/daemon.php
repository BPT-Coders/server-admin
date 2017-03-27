<?php
$sec = 0;
while(true){
	echo "Проверяю веб-морду\n";

$flag = '';
	$filename = '/home/server-admin/server-admin.bpt.loc/public_html/data/banNeedRestart';
	//Считать Флаг из файла
	$handle = fopen($filename, "r");
	while (!feof($handle)) {
		$flag = $flag.fgets($handle);
	};
	fclose($handle);
	echo $flag;
	if ($flag != ''){
		echo "Перезагружаюсь\n";
		//Запустить скрипт обновления
		//$output = shell_exec('sudo bash /home/server-admin/server-admin.bpt.loc/public_html/ban-service/daemon/firewall.sh');
		//echo $output;
		//очистить needUpdate
		$handle = fopen($filename, 'r+');
		ftruncate($handle, 0);
		rewind($handle);
		fclose($handle);
	};

	echo "Проверил\n";

	sleep(5);
	$sec =  $sec + 5;
	if ($sec > 59){
		echo "Проверяю трафик\n";
		$output = shell_exec('sudo bash /home/server-admin/server-admin.bpt.loc/public_html/forInstall/trafMonitor.sh');
		echo $output;
		$sec = 0;
	}
}

?>
