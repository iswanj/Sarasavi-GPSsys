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
	scroller = $('.box-wrap').antiscroll().data('antiscroll');
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
var infowindow;
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
		title: 'Sarasavi Publisher',
	});
	directionsDisplay = new google.maps.DirectionsRenderer({
        suppressMarkers: true,
        suppressInfoWindows: true,
	});
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

	//setInterval(posit,500);

	
	function posit(){
		var vhid = $('#vid').val();
		var ndate = new Date();
		var y = ndate.getFullYear();
		var m = ndate.getMonth();
		var d = ndate.getDate();
		if(d >=1 || d<=9){
			dd = "0" + d;
		}else{
			dd = d;
		}
		var findate = y+"-"+(m+1)+"-"+dd;
		var seledate = $('#vdate').val();
		if(seledate == ''){
			fdate = findate;
		}else{
			fdate = seledate;
		}
		
		
		if(window.XMLHttpRequest){
			Nxhr = new XMLHttpRequest();
		}
		else{
			if(window.ActiveXObject){
				try{
					Nxhr = new ActiveXObject("Microsoft.XMLHTTP");	
				}
				catch (e) {}
			}
		}
		if(Nxhr){
			var url = "process/historyloc.php?vid=" + vhid + "&vdate=" + fdate;
			Nxhr.onreadystatechange = getmap;
			Nxhr.open("GET",url,true);
			Nxhr.send(null);
			return false;
		}
		else{
			alert("Sorry, but I couldn't create an XMLHttpRequest");
		}
		function getmap(){
			if(Nxhr.readyState == 4){
				if(Nxhr.status == 200){
					var locations = new Array();
					var speed = 0;
					var tracker = Nxhr.responseXML.getElementsByTagName("tracker");
						 var name = tracker[0].getElementsByTagName("name")[0].firstChild.nodeValue;
						 var lat = tracker[0].getElementsByTagName("lat")[0].firstChild.nodeValue;
						 var lng = tracker[0].getElementsByTagName("lng")[0].firstChild.nodeValue;
						 var signal = tracker[0].getElementsByTagName("signal")[0].firstChild.nodeValue;
						 speed = tracker[0].getElementsByTagName("speed")[0].firstChild.nodeValue;
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
						 locations = tmpvar;
						 var marker = new Array(), i;
							deleteOverlays();
							//mapView.getOverlays().remove();
							icoImg = new google.maps.MarkerImage('images/Roadside-Shop-32.png');
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
								google.maps.event.addListener(marker[i], 'click', (function(marker, i) {
							        return function(e) {
							         //infowindow.setContent("Works");
							        // infowindow.open(map, marker[i]);
							        };
							        
									 
							     })(marker, i));
							}
					///////////// Get Distance between two point //////////////
					
					//////////////////////////////////////////////////////////
					var polylines = [];
					var path = null;
					var location = Nxhr.responseXML.getElementsByTagName("locationsList");
					var arLocs = location[0].getElementsByTagName("loc");
					var startmark;
					var endmark;
					for(var k=0; k<arLocs.length; k++){
						var lat = arLocs[k].getElementsByTagName("clat")[0].firstChild.nodeValue;
						var lng = arLocs[k].getElementsByTagName("clng")[0].firstChild.nodeValue;
						
						polylines.push(new google.maps.LatLng(lat, lng));
						
					}
					var i = 0;
					var locAr = [];
					var ctLoc = arLocs.length;
					//var waypts = [];
					var batches = [];
					var itemsPerBatch = 10; // start, end and 8 waypoints
					var itemsCounter = 0;
					var wayptsExist = arLocs.length > 0;
					while (wayptsExist) {
						var subBatch = [];
						var subitemsCounter = 0;
						for(var i=itemsCounter; i<arLocs.length; i++){
							subitemsCounter++;
							lat = arLocs[i].getElementsByTagName("clat")[0].firstChild.nodeValue;
							lng = arLocs[i].getElementsByTagName("clng")[0].firstChild.nodeValue;
							subBatch.push({
					            location: new window.google.maps.LatLng(lat, lng),
					            stopover: true
					        });
					        if (subitemsCounter == itemsPerBatch)
					            break;
							//ar[i] = arLocs[i].getElementsByTagName("clat")[0].firstChild.nodeValue;
						}
						itemsCounter += subitemsCounter;
					    batches.push(subBatch);
					    wayptsExist = itemsCounter < arLocs.length;
					    // If it runs again there are still points. Minus 1 before continuing to
					    // start up with end of previous tour leg
					    itemsCounter--;
					    
					}
					
					var combinedResults;
				    var unsortedResults = [{}]; // to hold the counter and the results themselves as they come back, to later sort
				    var directionsResultsReturned = 0;
				    for (var k = 0; k < batches.length; k++) {
				    	var lastIndex = batches[k].length - 1;
		    	        var start = batches[k][0].location;
		    	        var end = batches[k][lastIndex].location;
		    	        
			    	     // trim first and last entry from array
		                var waypts = [];
		                waypts = batches[k];
		                waypts.splice(0, 1);
		                waypts.splice(waypts.length - 1, 1);
		                var request = {
				            origin: start,
				            destination: end,
				            waypoints: waypts,
				            optimizeWaypoints: true,
				            travelMode: google.maps.DirectionsTravelMode.DRIVING
				        };
		                (function (kk) {
		        			directionsService.route(request, function (result, status) {
		        				if (status == window.google.maps.DirectionsStatus.OK) {
		        					var unsortedResult = {
		        						order : kk,
		        						result : result
		        					};
		        					unsortedResults.push(unsortedResult);
		        					
		        					directionsResultsReturned++;
		        					
		        					if (directionsResultsReturned == batches.length) // we've received all the results. put to map
		        					{
		        						// sort the returned values into their correct order
		        						unsortedResults.sort(function (a, b) {
		        							return parseFloat(a.order) - parseFloat(b.order);
		        						});
		        						var count = 0;
		        						for (var key in unsortedResults) {
		        							if (unsortedResults[key].result != null) {
		        								if (unsortedResults.hasOwnProperty(key)) {
		        									if (count == 0) // first results. new up the combinedResults object
		        										combinedResults = unsortedResults[key].result;
		        									else {
		        										// only building up legs, overview_path, and bounds in my consolidated object. This is not a complete
		        										// directionResults object, but enough to draw a path on the map, which is all I need
		        										combinedResults.routes[0].legs = combinedResults.routes[0].legs.concat(unsortedResults[key].result.routes[0].legs);
		        										combinedResults.routes[0].overview_path = combinedResults.routes[0].overview_path.concat(unsortedResults[key].result.routes[0].overview_path);
		        										combinedResults.routes[0].bounds = combinedResults.routes[0].bounds.extend(unsortedResults[key].result.routes[0].bounds.getNorthEast());
		        										combinedResults.routes[0].bounds = combinedResults.routes[0].bounds.extend(unsortedResults[key].result.routes[0].bounds.getSouthWest());
		        									}
		        									count++;
		        								}
		        							}
		        						}
		        						directionsDisplay.setDirections(combinedResults);
		        					}
		        				}
		        			});
		        		})(k);	
		                var flightPath = new google.maps.Polyline({
			     		    path: polylines,
			     		    strokeColor: "#29ce08",
			     		    strokeOpacity: 1.0,
			     		    strokeWeight: 2
						});
				    }
				    var infomarker = new Array();
				    var posicon;
				    var curspeed = new Array();
					var curdatetiem = new Array();
				    for(var y=0; y<arLocs.length; y++){
						var lat = arLocs[y].getElementsByTagName("clat")[0].firstChild.nodeValue;
						var lng = arLocs[y].getElementsByTagName("clng")[0].firstChild.nodeValue;
						curspeed[y] = arLocs[y].getElementsByTagName("curspeed")[0].firstChild.nodeValue;
						curdatetiem[y] = arLocs[y].getElementsByTagName("datetime")[0].firstChild.nodeValue;
						if(y==0){
							posicon = new google.maps.MarkerImage('images/start.png');
						}else if(y==arLocs.length-1){
							posicon = new google.maps.MarkerImage('images/end.png');
						}else{
							posicon = new google.maps.MarkerImage('images/mapmarker.png');						
						}
						var latlng = new google.maps.LatLng(lat,lng);
						infomarker[y] = new google.maps.Marker({
							position: latlng,
							map: map,
							icon: posicon,
							title: 'Position',
						});
						//delinfowindow();
						google.maps.event.addListener(infomarker[y], 'click', (function(infomarker, y) {
					        return function(e) {
							if(infowindow){
								infowindow.close();
							}
					        infowindow = new google.maps.InfoWindow({
					        	content: '<div style="display:block; overflow: visible;">Speed :- ' + curspeed[y] + '<br />Position :- ' + lat + ', ' + lng + '<br />Date and Time = ' + curdatetiem[y] + '</div>',
					        	boxStyle: {
					        		border: "1px solid black"
					        		,textAlign: "center"
						            ,fontSize: "12px"
						            ,width: "50px"
						        }
					        	,disableAutoPan: true
					        	,enableEventPropagation: true
					        });
					        infowindow.open(map, infomarker[y]);
					        };
					     })(infomarker, y));
					}
					//delete old
					var prepath = path;
					if(prepath){
					    prepath.setMap(null);
					}

                 	flightPath.setMap(map);
                 	// assign toglobal var path
                 	path = polylines;
				}
				else{
					alert("There was a problem with the request" + Nxhr.status);
				}
			}else{
				
			}
		}
		
		
		
	}
	/////////////////////////////
	function initialize(){
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

function delinfowindow(){
	if(infowindow){
		infowindow.close();
	}
}
var marker;
function placeMarker(Lat,Lng) {
	delmarker();
  var LatLngLoc = new google.maps.LatLng(Lat,Lng);
  marker = null;
  marker = new google.maps.Marker({
      position: LatLngLoc,
      map: map
  });
}
function delmarker(){
	if(marker){
		marker.setMap(null);
	}
}
