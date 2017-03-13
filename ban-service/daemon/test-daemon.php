<?php
echo'Прописываю фаервол';
//shell_exec('sudo bash /home/server-admin/server-admin.bpt.loc/public_html/ban-service/daemon/firewall.sh');
while(true){
	//ban();
	dhcp();
	sleep(5);
}

function ban(){
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
}

////

function dhcp(){
	$mysqli = new mysqli('localhost', 'server-admin', '0000', 'server-admin');


	$query = "set names utf8";
	$mysqli->query($query);

	$query = "select * from daemons where service='dhcp'";
	$results = $mysqli->query($query);
	$flag;
	while($row = $results->fetch_assoc()){
		$flag = $row["flag"];
	}
	if ($flag == 1){
		echo 'Нужно перезапустить dhcp';
		shell_exec('sudo bash /home/server-admin/server-admin.bpt.loc/public_html/ban-service/daemon/dhcp.sh');
		$query = "update daemons set flag=0 where service='dhcp'";
		$mysqli->query($query);
	}
}
?>
