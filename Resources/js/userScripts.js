$(document).ready(function() {
	loadRadioButtons();
	loadUserBasicInfo();
	loadNodeTable();
	$(document).on('click', 'input.rad', function(event) {
		$.ajax({
			url: 'resources/requests.php',
			type: 'post',
			dataType: 'json',
			data: {action: 'loadMap', id: $(this).val()},
			success: function(nodeInfo){
				loadMap(nodeInfo[0].latitud, nodeInfo[0].longitud, 'map',nodeInfo[0].sensor,nodeInfo[0].nombre);
			}
		});
	});
	$(document).on('click', 'a.showOnMap', function(event) {
		event.preventDefault();
		$('.loginForm').hide(500);
		$.ajax({
			url: 'resources/requests.php',
			type: 'post',
			dataType: 'json',
			data: {action: 'loadMap', id:this.id},
			success: function(nodeCoordinates){
				loadMap(nodeCoordinates[0].latitud, nodeCoordinates[0].longitud,"nodesMap", nodeCoordinates[0].sensor,nodeCoordinates[0].nombre);
			}
		});
	});
	$(document).on('click', 'a.delete', function(event) {
		event.preventDefault();
		$('.loginForm').show(500);
		$('#confirmBtn').val(this.id);
	});
	$(document).on('click', 'a#dismissNotif', function(event) {
		event.preventDefault();
		$('.loginForm').hide(500);
		$('div#notification').hide(600);
	});
	$(document).on('submit', 'form#loginForm', function(event) {
		event.preventDefault();
		var psw = $('#pswd').val();
		$.ajax({
			url: 'resources/requests.php',
			type: 'post',
			dataType: 'json',
			data: {action: 'deleteNode', id:$('#userID').val(),nodeID:$('#confirmBtn').val(), pass:psw},
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
			}
		});
	});
	$(document).on('submit', 'form#editUserInfo', function(event) {
		event.preventDefault();
		$.ajax({
			url: 'resources/requests.php',
			type: 'post',
			data: {action:'editUserInfo',id:$('#userID').val(),corp:$('#corp').val(),phone:$('#phone').val(),email:$('#email').val()},
			success: function(){
				$('div#notification').html('Successfully updated!'+'<br>'+'<a href="" id="dismissNotif">Dismiss</a>');
				$('div#notification').css('backgroundColor', '#075209');
				$('div#notification').show(600);
				$('#corp').val('');
				$('#phone').val('');
				$('#email').val('');
				loadUserBasicInfo();
			}
		});
	});	
	$(document).on('submit', 'form#editUserPassword', function(event) {
		event.preventDefault();
		var pass = $('#password').val();
		$.ajax({
			url: 'resources/requests.php',
			type: 'post',
			data: {action:'editUserPassword',id:$('#userID').val(), pass:pass},
			success: function(){
				$('div#notification').html('Password Changed!'+'<br>'+'<a href="" id="dismissNotif">Dismiss</a>');
				$('div#notification').css('backgroundColor', '#075209');
				$('div#notification').show(600);
				$('#password').val('');
				$('#rePassword').val('');
			}
		});
	});
});