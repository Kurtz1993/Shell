function Clave(){
	
	var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    for( var i=0; i < 8; i++ ){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    $('#code').val(text);
}

function loadMap(latitude, longitude){
	var optionsMap = {
		center : new google.maps.LatLng(latitude, longitude),
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		zoom : 15
	};

	var mapa = new google.maps.Map(document.getElementById('map'),optionsMap);

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
		google.maps.event.addListener(mapMark,'click',function(event){
			var optionsInfo = {
				content : 'Nombre: ' + name +'<br>Teléfono: ' + tel
			};
			var infowindow = new google.maps.InfoWindow(optionsInfo);
			infowindow.open(this.getMap(),this);
		});

		this.Markers.push(mapMark);

		mapa.DeleteMarkers();

	var coordinates = {
		position: new google.maps.LatLng(latitude, longitude),
		map: mapa
	};
	var currentPosition = new google.maps.Marker(coordinates);
	var infoOpts = {
	//	content: 'Nombre: ' + name +'<br>Teléfono: ' + tel
	};
	var contactInfo = new google.maps.InfoWindow(infoOpts);
	contactInfo.open(currentPosition.getMap(), currentPosition);
	mapa.Markers.push(currentPosition);
	};
}