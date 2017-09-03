<?php
$sec = 0;
$timeSARG = 299;
while(true){
	echo "Проверяю веб-морду\n";

	$flag = '';
	$filename = '/home/server-admin/server-admin.bpt.loc/public_html/data/banNeedRestart';
	$handle = fopen($filename, "r");
	$flag = $flag.fgets($handle);
	fclose($handle);
	if ($flag != ''){
		setMode();
		//
		restartSQUID();
		$handle = fopen($filename, 'r+');
		ftruncate($handle, 0);
		rewind($handle);
		fclose($handle);
	};
	echo "Проверил\n";

	sleep(5);
	$sec =  $sec + 5;
	if ($sec > $timeSARG){
		echo "Проверяю трафик\n";
		$output = shell_exec('sudo bash /home/server-admin/server-admin.bpt.loc/public_html/forInstall/trafMonitor.sh');
		echo $output;
		$sec = 0;
	}
}

function setMode(){
	$mode = '';
	$filename = '/home/server-admin/server-admin.bpt.loc/public_html/data/banNewMode';
	$handle = fopen($filename, "r");
	$mode = $mode.fgets($handle);
	fclose($handle);
	switch ($mode){
		case 'black':
			echo 'black';
			shell_exec('sudo cp /home/server-admin/server-admin.bpt.loc/public_html/forInstall/configs/squid.conf.BLstable /etc/squid/squid.conf');
			break;
		case 'white':
			echo 'white';
			shell_exec('sudo cp /home/server-admin/server-admin.bpt.loc/public_html/forInstall/configs/squid.conf.WLstable /etc/squid/squid.conf');
			break;
		default:
			echo 'hz';
			echo $mode;
			break;
	}
	shell_exec('sudo cp /home/server-admin/server-admin.bpt.loc/public_html/data/banNewMode /home/server-admin/server-admin.bpt.loc/public_html/data/banCurMode');
}


function restartSQUID(){
	echo 'Перезагрузка...';
	shell_exec('sudo cp /home/server-admin/server-admin.bpt.loc/public_html/data/banCurWhiteIP /etc/squid/whiteIP');
	shell_exec('sudo systemctl restart squid');
	echo 'OK';
}
?>
