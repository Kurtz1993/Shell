$(document).ready(function() {
	$(document).on('click', '.rad', function(event) {
		//alert($(this).val());
		$.ajax({
			url: 'resources/requests.php',
			type: 'post',
			dataType: 'json',
			data: {action: 'loadMap', id: $(this).val()},
			success: function(nodeInfo){
				loadMap(nodeInfo[0].latitud, nodeInfo[0].longitud);
			}
		});
	});
});