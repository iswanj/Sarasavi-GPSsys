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
		$.ajax({
			type: "GET",
			cash: false,
			url: "process/historyloc.php?vid=" + vhid + "&vdate=" + fdate, // process query location
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
					//var waypts = [];
					var batches = [];
					var maxno = 10; // start, end and 8 waypoints
					var itemsCounter = 0;
					var wayptsExist = $(xmlResponse).find("loc").length > 0;

					$(xmlResponse).find("loc").each(function(index){
						var xmlR = $(xmlResponse);
						var subBatch = [];
						var subitemsCounter = 0;
						for (var j = itemsCounter; j < $(xmlResponse).find("loc").length; j++) {
							var lng = $(xmlResponse).find("loc");
							
							alert(lng(j).find('clat').text());
							//lat = $(xmlResponse).find("loc").item(j).find('clat').text();
							//lng = $(xmlResponse).find("loc").item(j).find('clng').text();
					        subitemsCounter++;
					        subBatch.push({
					            location: new window.google.maps.LatLng(lat, lng),
					            stopover: true
					        });
					        if (subitemsCounter == maxno)
					            break;
					    }
						itemsCounter += subitemsCounter;
						    batches.push(subBatch);
						    wayptsExist = itemsCounter < $(xmlResponse).find("loc").length;
						    // If it runs again there are still points. Minus 1 before continuing to
						    // start up with end of previous tour leg
						    itemsCounter--;
					});
					//alert(batches);
					for (var k = 0; k < batches.length; k++) {
						 var lastIndex = batches[k].length - 1;
				         var start = batches[k][0].location;
				         var end = batches[k][lastIndex].location;
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
						 directionsService.route(request, function(response, status) {
					          if (status == google.maps.DirectionsStatus.OK) {
					            directionsDisplay.setDirections(response);
					            var route = response.routes[0];
					          }
						 });
					}
					
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
                 	path = polylines;
				 }else{
					 
				 }
		   }
		});
	}