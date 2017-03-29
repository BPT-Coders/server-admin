var block  = false;	
function onLoad(){
	readCurMode();
}

function readCurMode(){
	$.ajax({
			async: false,
			type: "POST",
			url: "./ajax/banReadCurMode.php",
			dataType:"text",
			error: function () {	
				alert( "При установке флага обновления произошла ошибка" );
			},
			success: function (response) {
				$('#curMode').html(response);
			}
	});	
}

function save() {
		if (!block){
			block = true;
			writeNewMode();
			//
			//
			//
			//
			$("#save").html('<img src="3.gif">');
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
	//alert(flag);
	if (flag == '1'){		
					timerId = setTimeout(waitRestart, 1000);
					
				}
				else {
					$("#save").html('<input type="button" value="Сохранить и перезагрузить" onClick="save()">');
					block = false;
					readCurMode();
				};
};

