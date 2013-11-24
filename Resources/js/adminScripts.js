$(document).ready(function() {
	loadUsersTable();
	loadAllNodes();
	$(document).on('click', 'a.delete', function(event) {
		event.preventDefault();
		$('.loginForm').show(500);
		$('#confirmBtn').val(this.id);
	});
	$(document).on('click', 'a#dismissNotif', function(event) {
		event.preventDefault();
		$('.loginForm').hide(500);
	});
	$(document).on('submit', 'form#loginForm', function(event) {
		event.preventDefault();
		var psw = $('#pswd').val();
		$.ajax({
			url: 'resources/requests.php',
			type: 'post',
			dataType: 'json',
			data: {action: 'deleteUser', userID:$('#userID').val(), pass:psw},
			success: function(result){
				if(result.res == true){
					$('#pswd').val('');
					$('div#notifier').html(result.msg);
					$('div#notifier').css('color', 'green');
					loadNodeTable();
				}
				else{
					$('div#notifier').html(result.msg);
					$('div#notifier').css('color', '#BA0D0D');
				}
				loadUsersTable();
			}
		});
	});
});