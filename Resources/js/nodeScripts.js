$(document).ready(function() {
	$('#map').html("Loading nodes map... Please wait.");
	loadMap();
	$(document).on('click', 'a.page', function(event) {
		event.preventDefault();
		var symbol;
		if($('input#deviceID').val() == 1){
			symbol = "ºC";
		} else symbol = "%";
		loadPage($('input#deviceID').val(), this.id, symbol);
		$('li.active').removeClass('active');
		$(this).parent('.pageNumber').addClass('active');
	});
});

function loadMap(){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'loadMap', uid:$('input#userID').val()},
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
			Mapa.AddMarker = function(lat, lng, deviceSensor, deviceID, symbol, nombre){
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
					$('div.Chart').html("Loading chart... Please wait.");
					chronoChart(deviceID, deviceSensor, symbol, nombre);
					dayChart(deviceID, deviceSensor, symbol, nombre);
					monthChart(deviceID, deviceSensor, symbol, nombre);
					yearChart(deviceID, deviceSensor, symbol, nombre);
					$('div#deviceTable').html("Fetching data... Please wait.");
					$('#pagination').html("");
					$('input#deviceID').attr('value', deviceID);
					loadDeviceTable(deviceID, symbol);
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
				Mapa.AddMarker(device[i].latitud, device[i].longitud, deviceSensor,device[i].idDispositivo, temp, device[i].nombre);
			}
		}
	});
}

function chronoChart(deviceID, deviceSensor, symbol, nombre){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'loadDeviceData', id: deviceID},
		success: function(data){
			if(data.length == 0){
				$('div#chronoChart').html("It's lonely in here...");
			}
			else{
				var chart;
				var chartData = [];
				var chartCursor;
				var color;
				if(data[0].sensor==1){color = "#FF5252";}
				else if(data[0].sensor==2){color = "#0074F0";}
				else if(data[0].sensor==3){color = "#0FF702"}
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
			    chart.fontSize = 14;
			    
			    // listen for "dataUpdated" event (fired when chart is rendered) and call zoomChart method when it happens
			    chart.addListener("dataUpdated", zoomChart);
			    // AXES
			    // category
			    var categoryAxis = chart.categoryAxis;
			    categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
			    categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
			    categoryAxis.dashLength = 1;
			    categoryAxis.gridAlpha = 0.35;
			    categoryAxis.minorGridEnabled = true;
			    categoryAxis.axisColor = color;
			    categoryAxis.title = nombre;

			    // value                
			    var valueAxis = new AmCharts.ValueAxis();
			    valueAxis.axisAlpha = 0.35;
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
			    graph.lineColor = color;
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
			    chart.write("chronoChart");
			}
		}
	});
}

function dayChart(deviceID, deviceSensor, symbol, nombre){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'dayChart', id: deviceID, anio:''},
		success: function(data){
			if(data.length == 0){
				$('div#dayChart').html("It's lonely in here...");
			}
			else{
				var color;
				if(data[0].sensor==1){color = "#FF5252";}
				else if(data[0].sensor==2){color = "#0074F0";}
				else if(data[0].sensor==3){color = "#0FF702"}
				var chart = new AmCharts.AmSerialChart();
				chart.dataProvider = data;
				chart.categoryField = 'Dia';
				chart.fontSize = 14;

				var chartCursor = new AmCharts.ChartCursor();
			    chartCursor.cursorPosition = "mouse";
			    chart.addChartCursor(chartCursor);

				var categoryAxis = chart.categoryAxis;
			    categoryAxis.dashLength = 1;
			    categoryAxis.gridAlpha = 0.35;
			    categoryAxis.minorGridEnabled = true;
			    categoryAxis.axisColor = color;
			    categoryAxis.title = "Dayly Average";

			    var valueAxis = new AmCharts.ValueAxis();
			    valueAxis.axisAlpha = 0.35;
			    valueAxis.dashLength = 1;
			    valueAxis.title = deviceSensor;
			    chart.addValueAxis(valueAxis);

				var graph = new AmCharts.AmGraph();
				graph.type = 'column';
				graph.title = data[0].Dia;
				graph.valueField = 'Promedio';
				graph.fillAlphas = 0.85;
				graph.fillColors = color;
				graph.lineColor = color;
				graph.balloonText = "Day [[category]]:<br><b><span style='font-size:14px;'> [[value]]"+symbol+"</span></b><br>";
				chart.addGraph(graph);
				chart.write("dayChart");
			}
		}
	});
}

function monthChart(deviceID, deviceSensor, symbol, nombre){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'monthChart', id: deviceID, anio:''},
		success: function(data){
			if(data.length == 0){
				$('div#monthChart').html("It's lonely in here...");
			}
			else{
				var color;
				if(data[0].sensor==1){color = "#FF5252";}
				else if(data[0].sensor==2){color = "#0074F0";}
				else if(data[0].sensor==3){color = "#0FF702"}
				var chart = new AmCharts.AmSerialChart();
				chart.dataProvider = data;
				chart.categoryField = 'Mes';
				chart.fontSize = 14;

				var chartCursor = new AmCharts.ChartCursor();
			    chartCursor.cursorPosition = "mouse";
			    chart.addChartCursor(chartCursor);

				var categoryAxis = chart.categoryAxis;
			    categoryAxis.dashLength = 1;
			    categoryAxis.gridAlpha = 0.35;
			    categoryAxis.minorGridEnabled = true;
			    categoryAxis.axisColor = color;
			    categoryAxis.title = "Monthly Average";

			    var valueAxis = new AmCharts.ValueAxis();
			    valueAxis.axisAlpha = 0.35;
			    valueAxis.dashLength = 1;
			    valueAxis.title = deviceSensor;
			    chart.addValueAxis(valueAxis);

				var graph = new AmCharts.AmGraph();
				graph.type = 'column';
				graph.title = data[0].Dia;
				graph.valueField = 'Promedio';
				graph.fillAlphas = 0.85;
				graph.fillColors = color;
				graph.lineColor = color;
				graph.balloonText = "Month [[category]]:<br><b><span style='font-size:14px;'> [[value]]"+symbol+"</span></b><br>";
				chart.addGraph(graph);
				chart.write("monthChart");
			}
		}
	});
}

function yearChart(deviceID, deviceSensor, symbol, nombre){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'yearChart', id: deviceID},
		success: function(data){
			if(data.length == 0){
				$('div#yearChart').html("It's lonely in here...");
			}
			else{
				var color;
				if(data[0].sensor==1){color = "#FF5252";}
				else if(data[0].sensor==2){color = "#0074F0";}
				else if(data[0].sensor==3){color = "#0FF702"}
				var chart = new AmCharts.AmSerialChart();
				chart.dataProvider = data;
				chart.categoryField = 'Anio';
				chart.fontSize = 14;

				var chartCursor = new AmCharts.ChartCursor();
			    chartCursor.cursorPosition = "mouse";
			    chart.addChartCursor(chartCursor);

				var categoryAxis = chart.categoryAxis;
			    categoryAxis.dashLength = 1;
			    categoryAxis.gridAlpha = 0.35;
			    categoryAxis.minorGridEnabled = true;
			    categoryAxis.axisColor = color;
			    categoryAxis.title = "Yearly Average";

			    var valueAxis = new AmCharts.ValueAxis();
			    valueAxis.axisAlpha = 0.35;
			    valueAxis.dashLength = 1;
			    valueAxis.title = deviceSensor;
			    chart.addValueAxis(valueAxis);

				var graph = new AmCharts.AmGraph();
				graph.type = 'column';
				graph.title = data[0].Dia;
				graph.valueField = 'Promedio';
				graph.fillAlphas = 0.85;
				graph.fillColors = color;
				graph.lineColor = color;
				graph.balloonText = "Year [[category]]:<br><b><span style='font-size:14px;'> [[value]]"+symbol+"</span></b><br>";
				chart.addGraph(graph);
				chart.write("yearChart");
			}
		}
	});
}

function loadDeviceTable(deviceID, symbol){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'loadDeviceTable',id:deviceID},
		success: function(response){
			if(response.length == 0)
				$('#deviceTable').html("It's lonely in here...");
			else{
				var table = '<table id="tableNodesInfo">' +
	                      '<tr>' +
	                      '<td class="tableHeading">Device Name</td>' +
	                      '<td class="tableHeading">Reading</td>' +
	                      '<td class="tableHeading">Time</td>' +
	                      '<td class="tableHeading">Date</td>' +
	                      '</tr>';
		        for(i=0; i<100; i++){
		          table+= '<tr>';
		          table+= '<td>'+response[i].Nombre+'</td>';
		          table+= '<td>'+response[i].lectura+symbol+'</td>';
		          table+= '<td>'+response[i].Hora+'</td>';
		          table+= '<td>'+response[i].Dia+'</td>';
		          table+= '</tr>';
		        }
		        table+='</table>';
		        var links = Math.ceil((response.length/100));
		        var pages='<ul id="pages">';
		        pages+='<li class="active pageNumber"><a href="" class="page" id="0">1</a></li>'
		        for(i=1; i<links;i++){
		        	pages+='<li class="pageNumber"><a href="" class="page" id="'+i+'">'+(i+1)+'</a></li>';
		        }
		       	pages+='</ul>';
		        $('#deviceTable').html(table);
		        $('#pagination').html('<center>'+pages+'</center>');
	    	}
		}
	});
}

function loadPage(deviceID, offset, symbol){
	var page;
	if(offset == 0)
		page = 1;
	else
		page = offset * 100;
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'loadTablePage',id:deviceID, page:page},
		success: function(response){
			var table = '<table id="tableNodesInfo">' +
                      '<tr>' +
                      '<td class="tableHeading">Device Name</td>' +
                      '<td class="tableHeading">Reading</td>' +
                      '<td class="tableHeading">Time</td>' +
                      '<td class="tableHeading">Date</td>' +
                      '</tr>';
	        for(i=0; i<response.length; i++){
	          table+= '<tr>';
	          table+= '<td>'+response[i].Nombre+'</td>';
	          table+= '<td>'+response[i].lectura+symbol+'</td>';
	          table+= '<td>'+response[i].Hora+'</td>';
	          table+= '<td>'+response[i].Dia+'</td>';
	          table+= '</tr>';
	        }
	        table+='</table>';
	        $('#deviceTable').html(table);
		}
	});
}