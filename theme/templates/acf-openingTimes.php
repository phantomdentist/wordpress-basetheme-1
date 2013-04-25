<?php if(get_field('opening_hours_item','options')): ?>

<div class="opening-times-wrapper">
	<span class="opening-times_title">Opening Hours</span>
    <div class="table-wrapper">
    <table>
        <tbody>
            <?php while(has_sub_field('opening_hours_item','options')): ?>
                <tr>
                    <?php 
                    if(get_sub_field('opening_hours_label')) echo '<td class="label">'.get_sub_field('opening_hours_label').'</td>';
                    if( get_sub_field('opening_hours_closed') == false)
                    { 
                        if(get_sub_field('opening_hours_opentime')) echo'<td>'.get_sub_field('opening_hours_opentime').'</td>'; 
                        if (get_sub_field('opening_hours_closetime')) echo '<td>'.get_sub_field('opening_hours_closetime').'</td>'; 
                    }
                    else
                    {
                     echo '<td class="closed">Closed</td>';
                    }
                    ?> 
                </tr>
             <?php endwhile; ?> 
        </tbody>
    </table>
    </div><!-- end table-wrapper -->
</div><!-- end opening-times-wrapper -->
 
  <?php endif; ?> 