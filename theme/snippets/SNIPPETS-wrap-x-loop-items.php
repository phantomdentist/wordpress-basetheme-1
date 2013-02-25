<?php
//variable
$x = 1; 
 
// Count the field in question so we can output a closing div for the last item
$count = count( get_field('field_name') ); 
 
// Output an inital opening div
echo '<div>';  
 
//Inside loop

	// Output a closing div and opening div for every x items, unless it's the last item
	if ( $x % 3 == 0 && $x !== $count ) echo '</div><div>';
	
	// Output a final closing div if last item
	if ( $x == $count ) echo '</div>';
	
	// Up x by one each loop
	$x++;
?>