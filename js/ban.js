var block  = false;	
function onLoad(){
	readCurMode();
	readCurWhiteIP();
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

function readCurWhiteIP(){
	$.ajax({
			async: false,
			type: "POST",
			url: "./ajax/banWhiteIP.php",
			dataType:"text",
			data: 'act=read',
			error: function () {	
				alert( "Ошибка чтения списка разрешённых ip" );
			},
			success: function (response) {
				$('#listWhiteIP').html(response);
			}
	});	
}


function add(){
	var entity = $('#entity').val();
	var valueEntity = $('#valueEntity').val();
	switch (entity){
		case 'whiteIP':
			addWhiteIP(valueEntity);
			break;
		default:
			alert('Не понял что добавлять');
			break;
	}
	$('#valueEntity').val('');
}

	


function addWhiteIP(ip){
	$.ajax({
		async: false,
		type: "POST",
		url: "./ajax/banWhiteIP.php",
		data: 'act=add&ip=' + ip,
		dataType:"text",
		error: function () {	
			alert( "Ошибка при добавлении ip" );
		},
		success: function (response) {	
			$('#listWhiteIP').append('<span style="color: green;">' + ip + '</span><br>');
		}
	});
}

function del(){
	var entity = $('#entity').val();
	var valueEntity = $('#valueEntity').val();
	switch (entity){
		case 'whiteIP':
			delWhiteIP(valueEntity);
			break;
		default:
			alert('Не понял что убрать');
			break;
	}
	$('#valueEntity').val('');
}

function delWhiteIP(ip){
	$.ajax({
		async: false,
		type: "POST",
		url: "./ajax/banWhiteIP.php",
		data: 'act=del&ip=' + ip,
		dataType:"text",
		error: function () {	
			alert( "Ошибка при удалении ip" );
		},
		success: function (response) {	
			$('#listWhiteIP').append('<span style="color: red;">' + ip + '</span><br>');
		}
	});
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



//// Баловство
function hideDiv(id){
	if ($('#' + id).attr("hidden") == 'hidden'){
		$('#' + id).attr("hidden", false);
	}
	else{
		$('#' + id).attr("hidden", true);
	}
}