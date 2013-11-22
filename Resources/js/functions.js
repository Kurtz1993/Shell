function UserCode(){
	
	var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    for( var i=0; i < 8; i++ ){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    $('#code').val(text);
}

function SerialNumber(){
	
	var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 12; i++ ){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    $('#code').val(text);
}

function validate(input){
	if(input.value != $('#password').val()){
	input.setCustomValidity('Passwords do not match!');
	$('#password').css('border', '1.8px solid red');
	$('#rePassword').css('border', '1.8px solid red');
	} else{
	input.setCustomValidity('');
	$('#password').css('border', '1.8px solid #09E017');
	$('#rePassword').css('border', '1.8px solid #09E017');
	}
}

function loadNodeTable(){
	$.ajax({
      url: 'resources/requests.php',
      type: 'post',
      dataType: 'json',
      data: {action: 'loadNodes', id: $('#userID').val()},
      success: function(nodeInfo){
        var table = '<table id="tableNodesInfo">' +
                      '<tr>' +
                      '<td>Node Name</td>' +
                      '<td>Action</td>' +
                      '</tr>';
        for(i=0; i<=nodeInfo.length -1; i++){
          table+= '<tr>';
          table+=   '<td>'+nodeInfo[i].Name+'</td>';
          table+=   '<td>'+
                    '<a href="" id="'+nodeInfo[i].ID+'" class="showOnMap linkNodes">View</a> | '+
                    '<a href="" id="'+nodeInfo[i].ID+'" class="delete linkNodes">Delete</a></td>';
          table+= '</tr>';
        }
        table+='</table>';
        $('#nodesTable').html(table);
      }
    });
}

function loadMap(latitude, longitude, location, sensor, name){
	var coord = new google.maps.LatLng(latitude, longitude);
	var sensType;
	switch(sensor){
		case '1':
			sensType = "Temperature";
		break;
		case '2':
			sensType = "Humidity";
		break;
		case '3':
			sensType = "Luminosity";
		break;
	}
	var optionsMap = {
		center : coord,
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		zoom : 15
	};

	var mapa = new google.maps.Map(document.getElementById(location),optionsMap);

	mapa.Markers = Array();

	mapa.DeleteMarkers = function(){
		for(marker in this.Markers){
			this.Markers[marker].setMap(null);
		}
		this.Markers = Array();
	};

	mapa.AddMarker = function(latLng){

		this.DeleteMarkers();

		var markerOptions = {
			position : latLng,
			map : this
		};

		var mapMark = new google.maps.Marker(markerOptions);
		this.Markers.push(mapMark);

		mapa.DeleteMarkers();

		var coordinates = {
			position: new google.maps.LatLng(latitude, longitude),
			map: mapa
		};
		var currentPosition = new google.maps.Marker(coordinates);
	};
	mapa.AddMarker(coord);
	var nodeLocation = {
		position: coord,
		map: mapa
	};
	var currentPosition = new google.maps.Marker(nodeLocation);
	var infoOpts = {
		content: 'Data Type: ' + sensType
	};
	var contactInfo = new google.maps.InfoWindow(infoOpts);
	contactInfo.open(currentPosition.getMap(), currentPosition);
	mapa.Markers.push(currentPosition);
}
function loadRadioButtons(){
	$.ajax({
		url: 'resources/requests.php',
		type: 'post',
		data: {action: "loadRadios"},
		dataType: 'JSON',
		success: function(radio){
			var template = '<input type="radio" class="rad" name="nodes[]" value="';
			var radiobuttons = "";
			for(i=0; i < radio.length; i++){
				radiobuttons += template + radio[i].idDispositivo+'" id="rad'+radio[i].idDispositivo+'"> ' +
				'<span class="radText">' + radio[i].nombre+ "</span>"+" ";
		}
		$('div#nodes').html(radiobuttons);
	}
	});

	$(document).ready(function() {
		table();
	});

	function table(){
		alert('vas bien');
	$.ajax({
		url : '../admintable.php',		//a donde se enviara la peticion
		type : 'get', 			//tipo de datos que se enviaran al servidor ('post', 'get')
		data: {action: "table"},	//parametros que se enviaran
		dataType : 'JSON',			//tipos de datos que regresara la consulta ('html', 'json')
		success: function(result){		//evento que se ejecutara si la resúesta es satisfactoria 
					var table = '<table id="data" border="1">' +
						'<tr id="tabHead">' +
							'<th>Id</td>' +
							'<th>Nickname</td>' +
							'<th>Password</td>' +
							'<th>Register code</td>' +
							'<th>Corporatio</td>' +
							'<th>Phone</td>' +
							'<th>E-mail</td>' +
							'<th>Opcciones</td>' +
						'</tr>';
			for (i = 0; i <= result.length - 1; i++) {
				table += '<tr>';
				table += 	'<td>' + result[i].idUsuario + '</td>';
				table += 	'<td>' + result[i].nickname + '</td>';
				table += 	'<td>' + result[i].password + '</td>';
				table += 	'<td>' + result[i].clave + '</td>';
				table += 	'<td>' + result[i].corporation + '</td>';
				table += 	'<td>' + result[i].tel + '</td>';
				table += 	'<td>' + result[i].correo + '</td>';
				table += 	'<td> <a href="" id="' + result[i].idUsuario + '" class="editar">Eliminar </a>' +
							'</td>';
				table += '</tr>';
			}
			table += '</table>';
			$('#table').html(table);
		},
		error: function(){
			alert('la estas cagando tabla');
		}
	});
}
}