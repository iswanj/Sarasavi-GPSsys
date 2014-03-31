// JavaScript Document
// JavaScript Document
function resizeOverlay(){
	var sWidth = $(document).width();
	var sHeight = $(document).height();
	$('#overlay').css('width',sWidth);
	$('#overlay').css('height',sHeight);
	//alert($(document).width())
}
var cursorX;
var cursorY;
$(window).load(function(){
	resizeOverlay();
	setInterval(resizeOverlay,1);
	//alert($(document).width());
	
	document.onmousemove = function(e){
		var mouse = new mouseEvent(e);
		/*cursorX = e.pageX;
		cursorY = e.pageY;*/
		cursorX = mouse.x;
		cursorY = mouse.y;
	};
});
$(document).ready(function(){
	$("a[rel]").overlay({
		top: 'center',
		color: '#ccc',
		left: '5%',
		mask: {
			color: '#ebecff',
			loadSpeed: 200,
			opacity: 0.7
		},
		fixed: true
	});

	printResult();
	//setInterval(printResult, 10000);
	/*$('#navhover').mouseover(function(){
		$('#navigation').slideDown(300);
	});
	$('#navigation').mouseover(function(){
		$('#navigation').slideDown(300);
	});
	$('#navhover').mouseleave(function(){
		$('#navigation').slideUp(300);
	});
	$('#navigation').mouseleave(function(){
		$('#navigation').slideUp(300);
	});*/
	var state = 0;
	$('#clickable').click(function(){
		if(state==0){
			$('#navigation').slideDown(300);
			$('#clickable').html('Close');
			state = 1;
		}else{
			$('#navigation').slideUp(300);
			$('#clickable').html('Menu');
			state = 0;
		}
	});
});

var markersArray = [];
// Deletes all markers in the array by removing references to them
function deleteOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
    markersArray.length = 0;
  }
}
var directionDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
function printResult(){
	var latlng = new google.maps.LatLng(6.87088,79.8884);
	var myOptions={
		zoom: 16,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map = new google.maps.Map(document.getElementById("mymap"),myOptions);
	var home = new google.maps.MarkerImage('images/homegardenbusiness.png');
	home_shadow = new google.maps.MarkerImage('images/homegardenbusiness.shadow.png');
	home_shadow.anchor = new google.maps.Point(10, 35);
	var infowindow = new google.maps.InfoWindow();
	var defmarker = new google.maps.Marker({
		position: latlng,
		map: map,
		icon: home,
		shadow: home_shadow,
		title: 'Sarasavi Publisher'
	});
	directionsDisplay = new google.maps.DirectionsRenderer();
	directionsDisplay.setMap(map);
	/* var directionDisplay;
    var directionsService = new google.maps.DirectionsService();
    directionDisplay = new google.maps.DirectionsRenderer();
    directionDisplay.setMap(map); */
///////// start::new options ///////
	/*var weatherLayer = new google.maps.weather.WeatherLayer({
        temperatureUnits: google.maps.weather.TemperatureUnit.FAHRENHEIT
      });
      weatherLayer.setMap(map);
      var cloudLayer = new google.maps.weather.CloudLayer();
      cloudLayer.setMap(map); */
/////////// end::new options ///////
	posit();

	setInterval(posit,500);

	//"process/curlocation.php?vid=" + vhid
	function posit(){
		var vhid = $('#vid').val();
		$.ajax({
			type: "GET",
			cash: false,
			url: "process/curlocation.php?vid=" + vhid, // process query location
			success: function(xmlResponse){
				 if(xmlResponse){ // if ok					
					 var locations = new Array();
					 var speed = 0;
					 $(xmlResponse).find("tracker").each(function(index){
						 var name = $(this).find('name').text();
						 var lat = $(this).find('lat').text();
						 var lng = $(this).find('lng').text();
						 var signal = $(this).find('signal').text();
						 speed = $(this).find('speed').text();
						 $("#vimei").html(name);
						 $("#vlat").html(lat);
						 $("#vlng").html(lng);
						 $("#vspeed").html(speed);
						 $("#vsignal").html(signal);
						 var tmpvar = new Array();
						 tmpvar[0] = name;
						 tmpvar[1] = lat;
						 tmpvar[2] = lng;
						 tmpvar[3] = speed;
						 tmpvar[4] = signal;
						 locations[index] = tmpvar;
					 });
					var marker = new Array(), i;
					deleteOverlays();
					//mapView.getOverlays().remove();
					icoImg = new google.maps.MarkerImage('images/Roadside-Shop-32.png');
					//alert(locations[0][3]);
					if(locations[0][3] > 5){
						icoImg = new google.maps.MarkerImage('images/icon62.png');
						flagIcon_shadow = new google.maps.MarkerImage('images/icon62-shadow.png');
						flagIcon_shadow.anchor = new google.maps.Point(10, 35);
					}else{
						icoImg = new google.maps.MarkerImage('images/icon15.png');
						flagIcon_shadow = new google.maps.MarkerImage('images/icon15-shadow.png');
						flagIcon_shadow.anchor = new google.maps.Point(10, 35);
					}	
				    
					for (i = 0; i < locations.length; i++) {
						marker[i] = new google.maps.Marker({
					        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					        icon: icoImg,
					        map: map,
					        shadow: flagIcon_shadow,
					        title: locations[i][0]
					    });
						markersArray.push(marker[i]);
						google.maps.event.addListener(marker[i], 'mouseover', (function(marker, i) {
					        return function(e) {
					          //infowindow.setContent(locations[i][0]);
					         // infowindow.open(map, marker[i]);
							 $('#mymap').append(
							 	'<div class="divbox">'+
									'<div class="container">' +
									'<p><span class="storng">Title: </span>' + locations[i][0] + '</p>' +
									'<p><span class="storng">Speed: </span>' + locations[i][3] + '</p>' +
									'<p><span class="storng">Signal: </span>' + locations[i][4] + '</p>' +
									'</div>' +
								'</div>'
							 );
							 /*var width = $(document).width();
							 var height = $(document).height();
							 var divwidth = $('.divbox').width();
							 var divheight = $('.divbox').height();
							 var left = (width - divwidth)/2;
							 var top = (height - divheight)/2;
							 $('.divbox').css('margin-left',left);
							 $('.divbox').css('margin-top',top);*/
							//var mousobj = mouseEvent(e);
							//alert(e);
							
							var divheight = $('.divbox').height();
							$('.divbox').css('left',cursorX);
							$('.divbox').css('bottom',cursorY + (divheight-40)/2);
							//$('.divbox').css('left',mousobj.x);
							//$('.divbox').css('bottom',mousobj.y + (divheight-40)/2);
					        };

					        
							 
					     })(marker, i));
						google.maps.event.addListener(marker[i], 'mouseout', (function(marker, i) {
					        return function() {
					          $('.divbox').hide();
						      $('.divbox').remove();						
					        };	 
					     })(marker, i));
					}
					var polylines = [];
					var path = null;
					$(xmlResponse).find("loc").each(function(index){
						var lat = $(this).find('clat').text();
						var lng = $(this).find('clng').text();
						
						polylines.push(new google.maps.LatLng(lat, lng));
					});
					
					var i = 0;
					var ctLoc = $(xmlResponse).find("loc").length;
					var waypts = [];
					$(xmlResponse).find("loc").each(function(index){
						if(i==0){
							start = new google.maps.LatLng($(this).find('clat').text(), $(this).find('clng').text());
						}else if(i >= ctLoc-1){
							end = new google.maps.LatLng($(this).find('clat').text(), $(this).find('clng').text());
						}else{
							lat = $(this).find('clat').text();
							lng = $(this).find('clng').text();
							waypts.push({
				                location:new google.maps.LatLng(lat,lng),
				                stopover:true
				            });
						}
						i = i +1;
					});
					
					var request = {
			            origin: start,
			            destination: end,
			            waypoints: waypts,
			            optimizeWaypoints: true,
			            travelMode: google.maps.DirectionsTravelMode.DRIVING
			        };
					 directionsService.route(request, function(response, status) {
				          if (status == google.maps.DirectionsStatus.OK) {
				            directionsDisplay.setDirections(response);
				          }
					 });
					/*var flightPlanCoordinates = [
             		    new google.maps.LatLng(6.87099, 79.8898),
             		    new google.maps.LatLng(6.87288, 79.8894),
             		    new google.maps.LatLng(6.87388, 79.8904),
             		    new google.maps.LatLng(6.87488, 79.8984)
         		    ];*/
					var flightPath = new google.maps.Polyline({
		     		    path: polylines,
		     		    strokeColor: "#29ce08",
		     		    strokeOpacity: 1.0,
		     		    strokeWeight: 2
					});
					
					//delete old
					var prepath = path;
					if(prepath){
					    prepath.setMap(null);
					}

                 	flightPath.setMap(map);
                 	
                 	// assign toglobal var path
                 	path = polyLine;
				 }else{
					 
				 }
		   }
		});
	}
	/////////////////////////////
	function initialize() {
		  var myLatLng = new google.maps.LatLng(0, -180);
		  var myOptions = {
		    zoom: 16,
		    center: myLatLng,
		    mapTypeId: google.maps.MapTypeId.TERRAIN
		  };

		  var map = new google.maps.Map(document.getElementById("map_canvas"),
		      myOptions);
		  var flightPlanCoordinates = [
		    new google.maps.LatLng(37.772323, -122.214897),
		    new google.maps.LatLng(21.291982, -157.821856),
		    new google.maps.LatLng(-18.142599, 178.431),
		    new google.maps.LatLng(-27.46758, 153.027892)
		  ];
		  var flightPath = new google.maps.Polyline({
		    path: flightPlanCoordinates,
		    strokeColor: "#FF0000",
		    strokeOpacity: 1.0,
		    strokeWeight: 2
		  });

		  flightPath.setMap(map);
		}
	
	////////////////////////
}