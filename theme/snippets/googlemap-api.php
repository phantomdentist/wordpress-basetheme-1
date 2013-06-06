<script src="https://maps.googleapis.com/maps/api/js?key=&sensor=false"></script>

<script>
window.onload = function(){
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({address:'<?php echo do_shortcode('[address]');?>'},function(result,status){
		if(status==google.maps.GeocoderStatus.OK){
			
			var map = new google.maps.Map(document.getElementById("google-map"),{
				center: result[0].geometry.location,
				zoom: 14,
				streetViewControl: false,
				disableDefaultUI: true,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				noClear:true,
			});
			
			var iconBase = '<?php echo get_template_directory_uri().'/images/'; ?>';
			
			var marker = new google.maps.Marker({
				map: map,
				position: result[0].geometry.location,
				//icon: iconBase + "map-pin.png"
			});
			
			var infowindow = new google.maps.InfoWindow({
				content: '<?php echo do_shortcode('[address]');?>'
			});
			
			var x = 0; 
			google.maps.event.addListener(marker, 'click', function() {
				if(x == 0){infowindow.close(); x = 1;}
				else{infowindow.open(map,marker); x = 0;}
			});
			
		}else{
			alert('Address not found!');
		}
	});
}
</script>

<div class="google-map-container">
	<div id="google-map"></div>
</div>