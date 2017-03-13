var block  = false;	
	function saveChanges() {
		if (!block){
			block = true;
			$("#button").html('<img src="3.gif">');
			//DONE: Очистить файл с адресами    	
			cleanFile();
			//DONE: Запись в файл		
			writeListToFile();
			//DONE: в файл needUpdate.txt установить единицу
			setNeedUpdate('firewall');
			//DONE: в цикле проверять выполнеие обновления с интервалом в секунду
			//DONE: при подтверждении обновления - вывести алерт
			waitUpdate();
		}
		else {
			alert('Пожалуйста,дождитесь сохранения предыдущих изменений');
		}
    }

function panic() {
		if (!block){
			block = true;
			$("#button").html('<img src="3.gif">');
			$("#buttonPanic").html('<img src="3.gif">');
			//DONE: в файл needUpdate.txt установить единицу
			setNeedUpdate('panic');
			//DONE: в цикле проверять выполнеие обновления с интервалом в секунду
			//DONE: при подтверждении обновления - вывести алерт
			waitUpdate();
		}
		else {
			alert('Пожалуйста,дождитесь сохранения предыдущих изменений');
		}
    }

//* Очистка файла whiteIP.txt
function cleanFile(){
		$.ajax({
			async: false,
			type: "POST",
			url: "./ajax/cleanWhiteIP.php",
			dataType:"text",
			error: function () {	
				alert( "При очистке файла произошла ошибка" );
			}
		});	
};

//* перебирает все адреса из класса разрешённых
//*записывает их значения в файл whiteIP.txt
function writeListToFile(){
	$('.dropAddress').each(function(i,elem) {
		$.ajax({
			async: false,
			type: "POST",
			url: "./ajax/writeAddresses.php",
			dataType:"text",
			data: "address=" + elem.parentNode.id,
			error: function () {	
				alert( "При выполнении запроса произошла ошибка" );
			}
		});	
	});
};

//* установка единицы в needUpdate.txt
function setNeedUpdate(mode){
		$.ajax({
			async: false,
			type: "POST",
			url: "./ajax/setNeedUpdate.php",
			data: 'mode=' + mode,
			dataType:"text",
			error: function () {	
				alert( "При установке флага обновления произошла ошибка" );
			}
		});	
};

//* Ожидание выполнения обновления
function waitUpdate(){
	var flag;
	$.ajax({
			async: false,			
			type: "POST",
			url: "./ajax/waitUpdate.php",
			dataType:"text",
			error: function () {	
				alert( "При считывании флага обновления произошла ошибка" );
			},
			success: function (response) {
				flag = response;
			}
	});
	if (flag == 'firewall' | flag == 'panic'){		
					timerId = setTimeout(waitUpdate, 1000);
				}
				else {
					reprintWhiteIP();
					$("#button").html('Сохранить изменения');
					$("#buttonPanic").html('!!! Р Е Ж И М _ П Р О В Е Р К И !!!');
				};
				
};

//Обновить на странице список адресов в соответствии с файлом whiteIP.txt
function reprintWhiteIP(){
	$.ajax({
			async: false,			
			type: "POST",
			url: "./ajax/printWhiteIP.php",
			dataType:"text",
			error: function () {	
				alert( "При обновлении произошла ошибка" );
			},
			success: function (response) {
				$("#whiteAddress").html(response);
				block = false;
			}
	});

}
//////////////////////////////////////

function changeAccess (el) {
	if (el.getAttribute("class") == 'acceptAddress') {
		$(el).removeClass("acceptAddress");
    	$(el).addClass("dropAddress");
    	$(el).html(' X ');
    	$('#whiteAddress').append( $('#blackAddress>#' + el.parentNode.id + '') );
	}
	else {
		$(el).removeClass("dropAddress");
    	$(el).addClass("acceptAddress");
    	$(el).html(' + ');
    	$('#blackAddress').append( $('#whiteAddress>#' + el.parentNode.id + '') );
	}


};



function acceptAddress(){
	var address = $("#newAddress").val();
	$("#whiteAddress").append('<div class="address" id="' + address + '">' + address + '<div class="dropAddress" onclick="changeAccess(this)"> X </div></div>');
	$("#newAddress").val('');
};





