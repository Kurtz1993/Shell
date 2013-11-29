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
    $('#serial').val(text);
}

function validate(input){
	if(input.value != '' && $('#password').val() != ''){
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
                      '<td class="tableHeading">Node Name</td>' +
                      '<td class="tableHeading">Action</td>' +
                      '</tr>';
        for(i=0; i<=nodeInfo.length -1; i++){
          table+= '<tr>';
          table+=   '<td class="tableContent">'+nodeInfo[i].Name+'</td>';
          table+=   '<td class="tableContent">'+
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
		content: 'Sensor: ' + sensType
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
}

function loadUsersTable(){
	$.ajax({
		url : 'resources/requests.php',
		type : 'post',
		data: {action: "loadUsersTable"},
		dataType : 'JSON',
		success: function(result){
					var table = '<table id="data" border="1">' +
						'<tr id="tabHead">' +
							'<td class="tableHeading">Nickname</td>' +
							'<td class="tableHeading">Password</td>' +
							'<td class="tableHeading">Register code</td>' +
							'<td class="tableHeading">Corporation</td>' +
							'<td class="tableHeading">Phone</td>' +
							'<td class="tableHeading">E-mail</td>' +
							'<td class="tableHeading">Options</td>' +
						'</tr>';
			for (i = 0; i <= result.length - 1; i++) {
				table += '<tr>';
				table += 	'<td>' + result[i].nickname + '</td>';
				table += 	'<td>' + result[i].password + '</td>';
				table += 	'<td>' + result[i].clave + '</td>';
				table += 	'<td>' + result[i].corporation + '</td>';
				table += 	'<td>' + result[i].tel + '</td>';
				table += 	'<td>' + result[i].correo + '</td>';
				table += 	'<td> <a href="" id="' + result[i].idUsuario + '" class="delete">Eliminar </a>' +
							'</td>';
				table += '</tr>';
			}
			table += '</table>';
			$('#table').html(table);
		}
	});
}

function loadUserBasicInfo(){
	$.ajax({
      url: 'resources/requests.php',
      type: 'post',
      dataType: 'json',
      data: {action: 'loadUserInfo', id: $('#userID').val()},
      success: function(userData){
        $('#corp').val(userData[0].corporation);
        $('#phone').val(userData[0].tel);
        $('#email').val(userData[0].correo);
      }
    });
}

function loadAllNodes(){
	$.ajax({
      url: 'resources/requests.php',
      type: 'post',
      dataType: 'json',
      data: {action: 'loadAllNodes'},
      success: function(nodeInfo){
        var table = '<table id="tableNodesInfo">' +
                      '<tr>' +
                      '<td class="tableHeading">Device ID</td>' +
                      '<td class="tableHeading">Device Owner</td>' +
                      '<td class="tableHeading">Name</td>' +
                      '<td class="tableHeading">Latitud</td>'+
                      '<td class="tableHeading">Longitud</td>' +
                      '<td class="tableHeading">Sensor Type</td>' +
                      '<td class="tableHeading">Serial Number</td>'+
                      '</tr>';
        var sensor = "";
        for(i=0; i<=nodeInfo.length -1; i++){
          	if(nodeInfo[i].Sens == 1){sensor ="Temperature";}
          	else if(nodeInfo[i].Sens == 2){sensor="Humidity"}
          	else if(nodeInfo[i].Sens == 3){sensor="Luminosity"}
          	table+= '<tr>';
          	table+=   '<td>'+nodeInfo[i].ID+'</td>';
          	table+=   '<td>'+nodeInfo[i].Owner+'</td>';
			table+=   '<td>'+nodeInfo[i].Name+'</td>';
			table+=   '<td>'+nodeInfo[i].Lat+'</td>';
			table+=   '<td>'+nodeInfo[i].Longi+'</td>';
			table+=   '<td>'+sensor+'</td>';
			table+=   '<td>'+nodeInfo[i].SN+'</td>';
          	table+= '</tr>';
        }
        table+='</table>';
        $('#adminNodesTable').html(table);
      }
    });
}

function loadNodeData(deviceID){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'loadNodeData',id:deviceID},
		success: function(response){
			nodeData = response;
			var table = '<table id="tableNodesInfo">' +
                      '<tr>' +
                      '<td class="tableHeading">Nº</td>' +
                      '<td class="tableHeading">Value</td>' +
                      '<td class="tableHeading">Time</td>'+
                      '<td class="tableHeading">Date</td>' +
                      '</tr>';
        var sensor = "";
        for(i=0; i<=response.length -1; i++){
          	if(response[i].sensor == 1){sensor ="ºC";}
          	else{sensor="%"}
          	table+= '<tr>';
          	table+=   '<td>'+response[i].ID+'</td>';
			table+=   '<td>'+response[i].valor+" "+sensor+" "+'</td>';
			table+=   '<td>'+response[i].horaLectura+'</td>';
			table+=   '<td>'+response[i].day+'</td>';
          	table+= '</tr>';
        }
        table+='</table>';
        $('#tableData').html(table);
		}
	});
}

function loadGraph(deviceID){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'loadGraph', id:deviceID},
		success: function(response){
			var chart = new AmCharts.AmSerialChart();
			chart.dataProvider = response;
			chart.categoryField = 'Dia';
			var graph = new AmCharts.AmGraph();
			graph.type = 'column';
			graph.title = response[0].Dia;
			graph.valueField = 'Promedio';
			graph.fillAlphas = 0.9;
			graph.fillColors = '#469';
			graph.lineColor = '#469';
			chart.addGraph(graph);
			chart.write('stadistics');
		}
	});
}

function loadNewNodeMap () {
	latitude = 19.26610289674101;
	longitude = -103.73572035692632;
	var optionsMap = {
		center : new google.maps.LatLng(latitude, longitude),
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		zoom : 15
	};

	var mapa = new google.maps.Map(document.getElementById('nodesMap'),optionsMap);

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
	};

	google.maps.event.addListener(mapa,'click',function(event){
		$('#latitud').val(event.latLng.lat());
		$('#longitud').val(event.latLng.lng())
		this.AddMarker(event.latLng);
	});

	mapa.DeleteMarkers();

	var coordinates = {
		position: new google.maps.LatLng(latitude, longitude),
		map: mapa
	};
}