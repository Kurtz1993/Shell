$(document).ready(function() {
	loadMap();
});

function loadMap(){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'loadMap'},
		success: function(device){
			var mapConfs = {
				center : new google.maps.LatLng(19.26610289674101,-103.73572035692632),
				mapTypeId : google.maps.MapTypeId.ROADMAP,
				zoom : 8
			}
			var Mapa = new google.maps.Map(document.getElementById('map'),mapConfs);
			var Markers = Array();
			//Funciones del Mapa.
			Mapa.DeleteMarkers = function(){ //Elimina las marcas creadas.
				for(marker in this.Markers){
					this.Markers[marker].setMap(null);
				}
				this.Markers = Array();
			};
			Mapa.AddMarker = function(lat, lng, deviceSensor, deviceID, symbol){
				this.DeleteMarkers();		//Elimina las marcas.
				var markerOptions = {		//Coordenadas de la marca a crear.
					position: new google.maps.LatLng(lat,lng),
					map: this
				};

				var mapMark = new google.maps.Marker(markerOptions);	//Se crea la marca.
				this.Markers.push(mapMark);								//Se añade al array de marcas.

				var coordinates = {								//Coordenadas de la nueva marca
					position: new google.maps.LatLng(lat,lng),
					map: Mapa
				};
				var currentPosition = new google.maps.Marker(coordinates);	//Se agrega la marca al mapa.

				google.maps.event.addListener(currentPosition,'click',function(event){
					deviceCharts(deviceID, deviceSensor, symbol);
				});
			};
			for(i=0; i<device.length; i++){
				var deviceSensor;
				switch(device[i].sensor){
					case '1':
						deviceSensor = "Temperature";
						temp = "ºC";
					break;
					case '2':
						deviceSensor = "Humidity";
						temp= "%";
					break;
					case '3':
						deviceSensor = "Luminosity";
						temp= "%";
					break;
				}
				Mapa.AddMarker(device[i].latitud, device[i].longitud, deviceSensor,device[i].idDispositivo, temp);
			}
		}
	});
}

function deviceCharts(deviceID, deviceSensor,symbol){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'loadDeviceData', id: deviceID},
		success: function(data){
			var chart;
			var chartData = [];
			var chartCursor;
			function zoomChart() {
			    // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
			    chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
			}
			for(i=0; i<data.length; i++){
				chartData.push({
			        date: data[i].diaLectura,
			        read: data[i].lectura
			    });
			}

			chart = new AmCharts.AmSerialChart();
			chart.pathToImages = "http://www.amcharts.com/lib/3/images/";
		    chart.dataProvider = chartData;
		    chart.categoryField = "date";
		    
		    // listen for "dataUpdated" event (fired when chart is rendered) and call zoomChart method when it happens
		    chart.addListener("dataUpdated", zoomChart);
		    // AXES
		    // category
		    var categoryAxis = chart.categoryAxis;
		    categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
		    categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
		    categoryAxis.dashLength = 1;
		    categoryAxis.gridAlpha = 0.15;
		    categoryAxis.minorGridEnabled = true;
		    categoryAxis.axisColor = "#DADADA";
		    categoryAxis.title = "Date";

		    // value                
		    var valueAxis = new AmCharts.ValueAxis();
		    valueAxis.axisAlpha = 0.2;
		    valueAxis.dashLength = 1;
		    valueAxis.title = deviceSensor;
		    chart.addValueAxis(valueAxis);
		    
		    // GRAPH
		    var graph = new AmCharts.AmGraph();
		    graph.title = deviceSensor;
		    graph.valueField = "read";
		    graph.bullet = "round";
		    graph.bulletBorderColor = "#FFFFFF";
		    graph.bulletBorderThickness = 2;
		    graph.bulletBorderAlpha = 1;
		    graph.lineThickness = 2;
		    graph.lineColor = "#b5030d";
		    graph.balloonText = "[[category]]<br><b><span style='font-size:14px;'> [[value]]"+symbol+"</span></b><br>";
		    graph.hideBulletsCount = 50; // this makes the chart to hide bullets when there are more than 50 series in selection
		    chart.addGraph(graph);
		    
		    // CURSOR
		    chartCursor = new AmCharts.ChartCursor();
		    chartCursor.cursorPosition = "mouse";
		    chart.addChartCursor(chartCursor);
		    
		    // SCROLLBAR
		    var chartScrollbar = new AmCharts.ChartScrollbar();
		    chartScrollbar.graph = graph;
		    chartScrollbar.scrollbarHeight = 40;
		    chartScrollbar.color = "#FFFFFF";
		    chartScrollbar.autoGridCount = true;
		    chart.addChartScrollbar(chartScrollbar);
		    
		    // WRITE
		    chart.write("readChart");
		}
	});
}














