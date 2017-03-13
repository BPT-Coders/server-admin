<!DOCTYPE html>
<html>
<head>
<title>Тест</title>
<meta charset="utf-8"/>
<link rel="stylesheet" href="my.css">
<script type="text/javascript" src="js/jquery-3.1.1.min.js">
</script>
<script type="text/javascript" src="js/1.js">
</script>
</head>
<body>
<div id="menu">
<ul>
<li><a href="iptables.html" >iptables</a></li>
</ul>
</div>
<div id="content">
	<h2>Разрешённые адреса</h2>
	<div id="whiteAddress">

<?php
require_once '/home/server-admin/server-admin.bpt.loc/public_html/ban-service/ajax/printWhiteIP.php';
?>
	</div>
	<form>
		<input type="text" id="newAddress">
		<input type="button" value="Разрешить" onClick=acceptAddress()>
	</form>

	<br/>
	<div align="center" id="button" onclick="saveChanges()">Сохранить изменения</div>
	<br/>
	<div align="center" id="buttonPanic" onclick="panic()">!!! Р Е Ж И М _ П Р О В Е Р К И !!!</div>
	<br>
</div>
</body>
</html>
