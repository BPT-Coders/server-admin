var block  = false;	
var tempHosts = []; // Хранятся все временные изменения с хостами
var curHosts = []; // Текущий список хостов
function onLoad(){
	/*readCurMode();*/
	readHosts();
}

function readCurMode(){
	$.ajax({
			async: false,
			type: "POST",
			url: "./ajax/banReadCurMode.php",
			dataType:"text",
			error: function () {	
				alert( "Ошибка чтения текущего режима" );
			},
			success: function (response) {
				$('#curMode').html(response);
			}
	});	
}

function printHost(host, newHost=0){
	var id = host.ip.replace(/\./g, "-");
	console.log(id);
	var color = "";
	if (newHost == 1){
		color = ' style="background-color : green"';
	}
	var check = "";
    if (host.access == 1) check = "checked";
    var unlimit = "";
    if (host.unlimit == 1) unlimit = "checked";
    var limited = "";
    if (host.unlimit == -1) limited = " -  <b>Лимит превышен </b>";
    var toDel = '<span style="cursor: pointer" onClick ="delHost(\'' + id + '\')" title="Удалить хост"> X </span>';
	var toEdit = ' onChange="editHost(\'' + id + '\')"';
    $('#hosts').append('<p id="' + id + '" title="' + host.comment + '"' + color + 
			' ><input type="checkbox" ' + check + toEdit +' id="' + id +'-access" >' + host.ip + 
			'<input type="checkbox" ' + unlimit + toEdit + ' id="' + id +'-unlimit"> ' + toDel + limited + '</p>');
}

function readHosts(){
	$.ajax({
			async: false,
			type: "POST",
			url: "./ajax/ser.php",
			dataType:"json",
			data: 'act=read',
			error: function () {	
				alert( "Ошибка чтения списка разрешённых ip" );
			},
			success: function (response) {
				curHosts = response;
				for(var i = 0; i < response.length; i++){
					printHost(response[i]);
				}
			}
	});	
}
	
function addHost(){
	var ip = $('#ip').val();
	var comment = $('#comment').val();
	
	var access;
	if ($('#access').prop('checked')){
		access = 1;
	}
	else{
		access = 0;
	}
	var unlimit;
	if ($('#unlimit').prop('checked')){
		unlimit = 1;
	}
	else{
		unlimit = 0;
	}

	var host = {
			"ip" : ip,
			"comment" : comment,
			"access" : access,
			"unlimit" : unlimit,
			"act" : "add"
	}
	
	
	// Проверка втекущем списке
	var inarrC = 0;
	for(var i = 0; i < curHosts.length; i++) 
    {
        if(curHosts[i].ip == ip) {
        	inarrC = 1;
        }
    }
	
	// Проверка во временном списке
	var inarrT = 0;
	for(var i = 0; i < tempHosts.length; i++) 
    {
        if(tempHosts[i].ip == ip) {
        	inarrT = 1;
        }
    }
	
	// Принимаем решение
	/**
	 * Если элемент есть в текущем списке - жёлтый
	 * Иначе - зелёный
	 */
	
	if ((inarrC == 0) && (inarrT == 0)){
		console.log("Нет нигде");
		// Нужно добавить во временный
		tempHosts.push(host);
		printHost(host, 1);
	}
	
	if ((inarrC == 0) && (inarrT == 1)){
		console.log("Есть во временном");
		// Найти нуэный элемент массива и заменить значения
		for(var i = 0; i < tempHosts.length; i++) 
	    {
	        if(tempHosts[i].ip == ip) {
	        	// Меняем значения на новые
	        	tempHosts[i].title = host.title;
	        	tempHosts[i].access = host.access;
	        	tempHosts[i].unlimit = host.unlimit;
	        	tempHosts[i].act = host.act;
	        }
	    }
		
		
		// Перерисовать хост на странице
		var id = host.ip.replace(/\./g, "-");
		$('#' + id).css('backgroundColor', 'green');
		//Поменять title, access, unlimit
		$('#' + id).attr('title', host.comment);
		
		if(host.access == 1){
			$('#' + id + '-access').prop("checked", true);
		}
		else{
			$('#' + id + '-access').prop("checked", false);
		}
		
		if(host.unlimit == 1){
			$('#' + id + '-unlimit').prop("checked", true);
		}
		else{
			$('#' + id + '-unlimit').prop("checked", false);
		}
	}
	
	if ((inarrC == 1) && (inarrT == 0)){
		console.log("Есть в текщем");
		// По сути редактирование - добавить во временный массив новые значения
		// Узел с таким ip выделить как отредактированное и установить новые значения
		tempHosts.push(host);
		var id = host.ip.replace(/\./g, "-");
		$('#' + id).css('backgroundColor', 'yellow');
		//Поменять title, access, unlimit
		$('#' + id).attr('title', host.comment);
		
		if(host.access == 1){
			$('#' + id + '-access').prop("checked", true);
		}
		else{
			$('#' + id + '-access').prop("checked", false);
		}
		
		if(host.unlimit == 1){
			$('#' + id + '-unlimit').prop("checked", true);
		}
		else{
			$('#' + id + '-unlimit').prop("checked", false);
		}
		
		
	}
	
	if ((inarrC == 1) && (inarrT == 1)){
		console.log("Есть везде");
		
		// Найти нуэный элемент массива и заменить значения
		for(var i = 0; i < tempHosts.length; i++) 
	    {
	        if(tempHosts[i].ip == ip) {
	        	// Меняем значения на новые
	        	tempHosts[i].title = host.title;
	        	tempHosts[i].access = host.access;
	        	tempHosts[i].unlimit = host.unlimit;
	        	tempHosts[i].act = host.act;
	        }
	    }
		
		
		// Перерисовать хост на странице
		var id = host.ip.replace(/\./g, "-");
		$('#' + id).css('backgroundColor', 'yellow');
		//Поменять title, access, unlimit
		$('#' + id).attr('title', host.comment);
		
		if(host.access == 1){
			$('#' + id + '-access').prop("checked", true);
		}
		else{
			$('#' + id + '-access').prop("checked", false);
		}
		
		if(host.unlimit == 1){
			$('#' + id + '-unlimit').prop("checked", true);
		}
		else{
			$('#' + id + '-unlimit').prop("checked", false);
		}
	}
	
	console.log(tempHosts);
}

function editHost(id){
	var ip = id.replace(/-/g, ".");
	console.log("Будем менять хост" + id);
	$('#' + id).css('backgroundColor', 'yellow');
	// Получить новые значения и запушить
	var comment = $('#' + id).attr('title');
	
	var access;
	if ($('#' + id +'-access').prop('checked')){
		access = 1;
	}
	else{
		access = 0;
	}
	var unlimit;
	if ($('#' + id + '-unlimit').prop('checked')){
		unlimit = 1;
	}
	else{
		unlimit = 0;
	}

	var host = {
			"ip" : ip,
			"comment" : comment,
			"access" : access,
			"unlimit" : unlimit,
			"act" : "edit"
	}
	tempHosts.push(host);
	
}

function delHost(id){
	var ip = id.replace(/-/g, ".");
	var comment = $('#' + id).attr('title');
	var access;
	if ($('#' + id +'-access').prop('checked')){
		access = 1;
	}
	else{
		access = 0;
	}
	var unlimit;
	if ($('#' + id + '-unlimit').prop('checked')){
		unlimit = 1;
	}
	else{
		unlimit = 0;
	}
	
	console.log("Будем удалять " + ip);
	$('#' + id).css('backgroundColor', 'red');
	
	var host = {
			"ip" : ip,
			"comment" : comment,
			"access" : access,
			"unlimit" : unlimit,
			"act" : "del"
	}
	tempHosts.push(host);
	console.log(tempHosts);
}





// Сохранение
function save() {
	if (!block){
		block = true;
		$("#save").html('<img src="3.gif">');
		writeNewMode();
		saveWhiteIP();
		//
		//
		//
		//
		setNeedRestart();
		waitRestart();
	}
	else {
		alert('Пожалуйста,дождитесь сохранения предыдущих изменений');
	}
}

function writeNewMode(){
var newMode = $('#newMode').val();
	$.ajax({
		async: false,
		type: "POST",
		url: "./ajax/banSetNewMode.php",
		data: 'mode=' + newMode,
		dataType:"text",
		error: function () {	
			alert( "При записи нового режима произошла ошибка" );
		}
	});	
}

function saveWhiteIP(){
	$.ajax({
		async: false,
		type: "POST",
		url: "./ajax/banWhiteIP.php",
		data: 'act=save',
		dataType:"text",
		error: function () {	
			alert( "Ошибка при сохранении разрешённых адресов" );
		},
		success: function (response) {
			//alert(response);
		}
	});
}

function setNeedRestart(){
	$.ajax({
		async: false,
		type: "POST",
		url: "./ajax/banSetNeedRestart.php",
		dataType:"text",
		error: function () {	
			alert( "При установке флага обновления произошла ошибка" );
		}
	});	
};

function waitRestart(){
var flag;
$.ajax({
		async: false,			
		type: "POST",
		url: "./ajax/banWaitRestart.php",
		dataType:"text",
		error: function () {	
			alert( "При считывании флага обновления произошла ошибка" );
		},
		success: function (response) {
			flag = response;
		}
});
if (flag == '1'){		
				timerId = setTimeout(waitRestart, 1000);
				
			}
			else {
				$("#save").html('<input type="button" value="Сохранить и перезагрузить" onClick="save()">');
				block = false;
				onLoad();
			};
};
