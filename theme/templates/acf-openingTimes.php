<?php if(get_field('opening_hours_item')): ?>

<table>
    <tbody>
        <?php while(the_repeater_field('opening_hours_item')): ?>
        	<tr>
            	<?php 
                if(get_sub_field('opening_hours_label')) echo '<td class="label">'.get_sub_field('opening_hours_label').'</td>';
				if( get_sub_field('opening_hours_closed') == false)
				{ 
            		if(get_sub_field('teaserbox_content')) echo'<td>'.get_sub_field('opening_hours_opentime').'</td>'; 
            		if (get_sub_field('teaserbox_link')) echo '<td>'.get_sub_field('opening_hours_closetime').'</td>'; 
				}
				else
				{
				 echo '<td>closed</td>';
				}
				?> 
            </tr>
         <?php endwhile; ?> 
    </tbody>
</table>
 
  <?php endif; ?> 