<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;ver=3.5.1"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/src/markerclusterer.js"></script>

<script type="text/javascript">
var map; //Map variable
var geocoder; //Geocoder variable
var infowindow;

var myOptions = {
              zoom: 2,
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              disableDefaultUI: true,
            }; 
var LatLngList = [];
var iconBase = '<?php echo get_template_directory_uri().'/images/'; ?>';

//Geocoder function
function myGeocode() {
    infowindow = new google.maps.InfoWindow({
        maxWidth: 200
    });
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
   	geocoder = new google.maps.Geocoder();
	
	var titles = [];
	var addresses = [];
	var tels = [];
	var emails = [];
	
	<?php 
	if( get_field('contactaddresses_repeater') ):

		while( has_sub_field('contactaddresses_repeater') ): 
		
			if( get_sub_field('contactaddresses_title') ) $title = get_sub_field('contactaddresses_title');
			?>
			titles.push('<?php echo $title; ?>')
			<?php
			if( get_sub_field('contactaddresses_address') ) $address = get_sub_field('contactaddresses_address');
			?>
			addresses.push('<?php echo $address; ?>')
			<?php
			if( get_sub_field('contactaddresses_telephone') ) $tel = '<span class="telephone">'.get_sub_field('contactaddresses_telephone').'</span>';
			?>
			tels.push('<?php echo $tel; ?>')
			<?php
			if( get_sub_field('contactaddresses_email') ) $email = '<span class="email">'.get_sub_field('contactaddresses_email').'</span>';
			?>
			emails.push('<?php echo $email; ?>')
			<?php

		endwhile;  
	endif; 
	?> 
   
   	var LatLngList = [];
	var markers = [];
     //private function, only need be defined once!
    function getGeocode(address, title, tels, emails) {
        geocoder.geocode( {"address": address }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                latlng = results[0].geometry.location;
                LatLngList.push(latlng);
                map.setCenter(latlng);
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: title,
					icon: iconBase + "map-pin.png"
                }); 
                markers.push(marker);
                google.maps.event.addListener(marker, "click", function () {
                    infowindow.setContent("<div class='map-infowindow'><h4 class='gm-title'>"+title+"</h4><br/><span class='address'>"+address+"</span><br/><br/><span class='tel'>T. "+tel+"</span><br/><span class='email'>E. <a class='email' href='"+email+"'>"+email+"</a></span><br/><br/><a class='gm-directions' href='http://maps.google.com/maps?saddr="+address+"'>Get directions</a></div>");
                    infowindow.open(map, marker);
                });
                if (markers.length == addresses.length) { //we have received all of our geocoder responses
                    //alert(markers);
                    var markerCluster = new MarkerClusterer(map, markers);
                    //  Create a new viewpoint bound
                    var bounds = new google.maps.LatLngBounds ();
                    //  Go through each...
                    for (var i = 0, LtLgLen = LatLngList.length; i < LtLgLen; i++) {
                        //  And increase the bounds to take this point
                        bounds.extend (LatLngList[i]);
                    }
                    //  Fit these bounds to the map
                    map.fitBounds (bounds);
                }
            } else {
                document.getElementById("text_status").value = status;
            }
        });//end of geocoder
    }
    for (var i = 0; i < addresses.length; i++) { 
        var address = addresses[i];
        var title = titles[i];
        var tel = tels[i];
        var email = emails[i];
         //put our private function to work:
        getGeocode(address, title, tel, email);
    }//end of for loop
}

window.onload=myGeocode;
</script>
<div class="map-wrapper">
	<div id="map_canvas"></div>  
</div>