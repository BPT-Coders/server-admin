<!DOCKTYPE html>
<html>
<head>
<title>Сервер - Управление доступом в интернет</title>
<meta charset="utf-8"/>
<link rel="stylesheet" href="my.css">

<script type="text/javascript" src="js/jquery-3.1.1.min.js">
</script>
<script type="text/javascript" src="js/ban.js">
</script>
</head>
<body onLoad="onLoad()">
	<nav>
		<ul>
			<li><a href="ban.php">Интернет фильтр</a></li>
			<li><a href="domains.php">Домены</a></li>
			<li><a href="dhcp.php">dhcp</a></li>
			<li><a href="squid/">Статистика Squid</a></li>
			<li><a href="sarg/">Статистика SARG</a></li>
			
		</ul>
	</nav>
	<section>
		<h3>Режим фильтрации</h3>
		<div><span>Текущее состояние: </span><span id="curMode"></span></div>
		<div>Новое состояние: 
			<select id="newMode">
				<option val="По чёрному списку">По чёрному списку</option>
				<option val="По белому списку">По белому списку</option>
			</select>
		</div>
	</section>
	<section>
		<h3>Сохранить и перезагрузить</h3>
		<div id="save"><input type="button" value="Сохранить и перезагрузить" onClick="save()"></div>
	</section>
	<section>
		<h3>Добавить запись</h3>
		<div></div>
	</section>
	<section>
		<h3>Разрешённые ip</h3>
		<div></div>
	</section>
	<section>
		<h3>Безлимитные ip</h3>
		<div></div>
	</section>
	<section>
		<h3>Разрешённые сайты</h3>
		<div></div>
	</section>
	<section>
		<h3>Запрещённые сайты</h3>
		<div></div>
	</section>
</body>
</html>