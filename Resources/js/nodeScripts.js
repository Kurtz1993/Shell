$(document).ready(function() {
	loadMap();
	$(document).on('click', 'a.page', function(event) {
		event.preventDefault();
		var symbol;
		if($('input#deviceID').val() == 1){
			symbol = "ºC";
		} else symbol = "%";
		loadPage($('input#deviceID').val(), this.id,symbol);
		$('li.active').removeClass('active');
		$(this).addClass('active');
	});
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
					$('div#readChart').html("Loading chart... Please wait.");
					deviceCharts(deviceID, deviceSensor, symbol, nombre);
					$('div#deviceTable').html("Loading all registries... Please wait.");
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

function deviceCharts(deviceID, deviceSensor, symbol, nombre){
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
		    categoryAxis.title = nombre;

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

function loadDeviceTable(deviceID, symbol){
	$.ajax({
		url:'resources/requests.php',
		type:'post',
		dataType:'json',
		data:{action:'loadDeviceTable',id:deviceID},
		success: function(response){
			var table = '<table id="tableNodesInfo">' +
                      '<tr>' +
                      '<td class="tableHeading">Nº of registry</td>' +
                      '<td class="tableHeading">Device Name</td>' +
                      '<td class="tableHeading">Reading</td>' +
                      '<td class="tableHeading">Time</td>' +
                      '<td class="tableHeading">Date</td>' +
                      '</tr>';
	        for(i=0; i<100; i++){
	          table+= '<tr>';
	          table+= '<td>'+response[i].ID+'</td>';
	          table+= '<td>'+response[i].Nombre+'</td>';
	          table+= '<td>'+response[i].lectura+symbol+'</td>';
	          table+= '<td>'+response[i].Hora+'</td>';
	          table+= '<td>'+response[i].Dia+'</td>';
	          table+= '</tr>';
	        }
	        table+='</table>';
	        var links = Math.ceil((response.length/100));
	        var pages='<ul id="pages">';
	        pages+='<li class="active pageNumber"><a href="" id="0">1</a></li>'
	        for(i=1; i<links;i++){
	        	pages+='<li class="pageNumber"><a href="" class="page" id="'+i+'">'+(i+1)+'</a></li>';
	        }
	       	pages+='</ul>';
	        $('#deviceTable').html(
	        	'<center>'+pages+'</center>' + '<br>'+	table
	        );
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
                      '<td class="tableHeading">Nº of registry</td>' +
                      '<td class="tableHeading">Device Name</td>' +
                      '<td class="tableHeading">Reading</td>' +
                      '<td class="tableHeading">Time</td>' +
                      '<td class="tableHeading">Date</td>' +
                      '</tr>';
	        for(i=0; i<100; i++){
	          table+= '<tr>';
	          table+= '<td>'+response[i].ID+'</td>';
	          table+= '<td>'+response[i].Nombre+'</td>';
	          table+= '<td>'+response[i].lectura+symbol+'</td>';
	          table+= '<td>'+response[i].Hora+'</td>';
	          table+= '<td>'+response[i].Dia+'</td>';
	          table+= '</tr>';
	        }
	        table+='</table>';
	        var links = Math.ceil((response.length/100));
	        var pages='<ul id="pages">';
	        pages+='<li class="active pageNumber"><a href="" id="1">1</a></li>'
	        for(i=2; i<=links;i++){
	        	pages+='<li class="pageNumber"><a href="" id="'+i+'">'+i+'</a></li>';
	        }
	       	pages+='</ul>';
	        $('#deviceTable').html(
	        	'<center>'+pages+'</center>' + '<br>'+	table
	        );
		}
	});
}