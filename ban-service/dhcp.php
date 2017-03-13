<!DOCTYPE html>
<html>
<head>
<title>DHCP - сервер</title>
<meta charset="utf-8"/>
<link rel="stylesheet" href="my.css">
<script type="text/javascript" src="js/jquery-3.1.1.min.js">
</script>
<script type="text/javascript" src="js/dhcp-1.js">
</script>
</head>
<body onLoad="showAddresses()">
	<div id="addresses"></div>
	<input type="text" id="host" placeHolder="host">
	<input type="text" id="ip" placeHolder="ip" PATTERN="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}">
	<input type="text" id="mac" placeHolder="mac" PATTERN="[a-f0-9]{2}">
	<input type="text" id="comment" placeHolder="Комментарий">
	<input type="button" id="button" value="Зафиксировать" onClick="addAddress()">
</body>
</html>
