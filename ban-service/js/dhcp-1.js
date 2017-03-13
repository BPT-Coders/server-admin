var block  = false;	
	function addAddress() {
		if (!block){
			block = true;
			$("#button").attr("value", "...");
			
			var host = $('#host').val();
			var ip = $('#ip').val();
			var mac = $('#mac').val();
			var comment = $('#comment').val();
			$.ajax({
				async: false,			
				type: "POST",
				url: "./ajax/dhcp-addAddress.php",
				data: 'host=' + host + '&ip=' + ip + '&mac=' + mac + '&comment=' + comment,
				dataType:"text",
				error: function () {	
					alert( "При считывании флага обновления произошла ошибка" );
					block  = false;	
				},
				success: function (response) {
					$('#host').val('');
					$('#ip').val('');
					$('#mac').val('');
					$('#comment').val('');
					waitUpdate();
				}
			});
			
			
		}
		else {
			alert('Пожалуйста,дождитесь сохранения предыдущих изменений');
		}
    }

//* Ожидание выполнения обновления
function waitUpdate(){
	var flag;
	$.ajax({
			async: false,			
			type: "POST",
			url: "./ajax/dhcp-waitUpdate.php",
			dataType:"text",
			error: function () {	
				alert( "При считывании флага обновления произошла ошибка" );
			},
			success: function (response) {
				flag = response;
			}
	});
	if (flag == 1){		
					timerId = setTimeout(waitUpdate, 1000);
				}
				else {
					showAddresses();
					$("#button").attr("value", "Зафиксировать");
				};
				
};

function showAddresses(){
	$.ajax({
			async: false,			
			type: "POST",
			url: "./ajax/dhcp-showAddresses.php",
			dataType:"text",
			error: function () {	
				alert( "При обновлении произошла ошибка" );
			},
			success: function (response) {
				$("#addresses").html(response);
				block = false;
			}
	});
}


