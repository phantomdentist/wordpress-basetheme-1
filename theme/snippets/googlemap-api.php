<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeN0GjiLbLFRWhmES78MQkZUB5LBZjfcA&sensor=false"></script>

<div id="address" class="map-address"><?php the_field('address_line_1', 'options').the_field('address_line_2', 'options').the_field('town', 'options').the_field('county', 'options').the_field('postcode', 'options'); ?></div> 
<div id="address-formatted" class="map-address"><?php echo get_field('address_line_1', 'options').'<br/>'.get_field('address_line_2', 'options').'<br/>'.get_field('town', 'options').'<br/>'.get_field('county', 'options').'<br/>'.get_field('postcode', 'options'); ?></div>

<div class="map" id="map_canvas" style="width:100%; height:350px;"></div>

<script type="text/javascript">
	//jquery to run function once for each html element with a class of map
		var geocoder;
		var map;
		geocoder = new google.maps.Geocoder();
		//create latlng variable and assign default position
		var latlng = new google.maps.LatLng(-34.397, 150.644);
		//create mapOptions variable and add options
		var myOptions = {
			zoom: 14,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		//create map variable and select html element by id
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
		//get address by element id and geocode it
		var address = document.getElementById("address").innerHTML;
		var addressFormatted = document.getElementById("address-formatted").innerHTML;
		
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				//if geocode ok center map on location
				map.setCenter(results[0].geometry.location);
				//create marker at geocoded location
				var marker = new google.maps.Marker({
					map: map, 
					position: results[0].geometry.location
				});
				//create infowindow
				var infowindow = new google.maps.InfoWindow({
					content: addressFormatted
				});
				//open infowindow by default
				infowindow.open(map, marker);
				
				//create a listener to open / close the info window when the marker is clicked
				var x = 0; 
				google.maps.event.addListener(marker, 'click', function() {
					if(x == 0){infowindow.close(); x = 1;}
					else{infowindow.open(map,marker); x = 0;}
				}); 
			} else {
				//error is geocode didn't work
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
</script>
