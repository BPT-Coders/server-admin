function showDomains(){
		$.ajax({
			async: false,
			type: "POST",
			url: "myAJAX.php",
			dataType:"text",
			error: function () {	
				alert( "Ошибка" );
			},
			success: function (response) {
				$('#content').html(response);
			}
		});	
};