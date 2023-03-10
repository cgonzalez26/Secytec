<?php 
/*
 * This file contains the HTML generated for small calendars. You can copy this file to yourthemefolder/plugins/events-manager/templates and modify it in an upgrade-safe manner.
 * 
 * There are two variables made available to you: 
 * 
 * 	$calendar - contains an array of information regarding the calendar and is used to generate the content
 *  $args - the arguments passed to EM_Calendar::output()
 * 
 * Note that leaving the class names for the previous/next links will keep the AJAX navigation working.
 */
?>
<table class="em-calendar">
	<thead>
		<tr>
			<td><a class="em-calnav em-calnav-prev" href="<?php echo $calendar['links']['previous_url']; ?>" rel="nofollow"><img src="wp-content/plugins/events-manager/includes/images/arrow-left.png" border="0"></img></a></td>
			<td class="month_name" colspan="5"><?php echo strtoupper(date_i18n(get_option('dbem_small_calendar_month_format'), $calendar['month_start'])); ?></td>
			<td><a class="em-calnav em-calnav-next" href="<?php echo $calendar['links']['next_url']; ?>" rel="nofollow"><img src="wp-content/plugins/events-manager/includes/images/arrow-right.png" border="0"></img></a></td>
		</tr>
	</thead>
	<tbody>
		<tr class="days-names">
			<td><?php echo implode('</td><td>',$calendar['row_headers']); ?></td>
		</tr>
		<tr>
			<?php
			$cal_count = count($calendar['cells']);
			$col_count = $count = 1; //this counts collumns in the $calendar_array['cells'] array
			$col_max = count($calendar['row_headers']); //each time this collumn number is reached, we create a new collumn, the number of cells should divide evenly by the number of row_headers
			foreach($calendar['cells'] as $date => $cell_data ){
				//$class = ( !empty($cell_data['events']) && count($cell_data['events']) > 0 ) ? 'eventful':'eventless';
				$color = '';
				$class = 'eventless';
				if( !empty($cell_data['events']) && count($cell_data['events']) > 0 ){
					$class = 'eventful';
					//obtenemos color de la categoria. Cristian 
					foreach( $cell_data['events'] as $EM_Event ){
						$color = $borderColor = $orig_color;
						$textColor = '#fff';
						if ( !empty ( $EM_Event->get_categories()->categories )) {
							foreach($EM_Event->get_categories()->categories as $EM_Category){
								/* @var $EM_Category EM_Category */
								if( $EM_Category->get_color() != '' ){
									$color = $borderColor = $EM_Category->get_color();
									if( preg_match("/#fff(fff)?/i",$color) ){
										$textColor = '#777';
										$borderColor = '#ccc';
									}
									break;
								}
							}
						}
					}
				}
				
				if(!empty($cell_data['type'])){
					$class .= "-".$cell_data['type']; 
				}
				
				?>
				<!--<td class="<?php echo $class; ?>" style="background:<?php echo $color;?>"> cristian 15-01-2015-->
				<td class="<?php echo $class; ?>">
					<?php if( !empty($cell_data['events']) && count($cell_data['events']) > 0 ): ?>
					<a href="<?php echo esc_url($cell_data['link']); ?>" title="<?php echo esc_attr($cell_data['link_title']); ?>"><?php echo date('j',$cell_data['date']); ?></a>
					<?php else:?>
					<?php echo date('j',$cell_data['date']); ?>
					<?php endif; ?>
				</td>
				<?php
				//create a new row once we reach the end of a table collumn
				$col_count= ($col_count == $col_max ) ? 1 : $col_count+1;
				echo ($col_count == 1 && $count < $cal_count) ? '</tr><tr>':'';
				$count ++; 
			}
			?>
		</tr>
	</tbody>
</table>