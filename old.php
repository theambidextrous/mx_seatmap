<?php 
$layout = json_decode(file_get_contents('complex.json'), true);
?>
<style>
.area {
  display: flex; 
}
.item {
	text-align: center;
	padding:1.8px;
	font-size:11px;
	flex: 0 0 2%;
  	flex-wrap: wrap;
	min-width:20px;
	border-radius:4px;
}
.sold{
	background:#d8d8d8;
  border: solid 2px #fff;
}
.wheelchair{
	background:#25a08c;
  border: solid 2px #fff;
}
.available{
	background:#aa7cc1;
  border: solid 2px #fff;
}
.my{
	background:#fba316;
  border: solid 2px #fff;
}
.empty{
	background:white;
  border: solid 2px #fff;
}
</style>
<?php 
$area_loop = 0;
$row_loop = 0;
foreach( $layout['areaCategories'] as $cat):
	$area_code = $cat['areaCategoryCode'];
	$seatsToAllocate = $cat['seatsToAllocate'];
	$seatsAllocatedCount = $cat['seatsAllocatedCount'];
	$auto_assigned_seats = implode(",", $cat['selectedSeats'][$area_loop]);
		//areas data
		$all_seats = $layout['areas'][$area_loop]['numberOfSeats'];
		$cols = $layout['areas'][$area_loop]['columnCount'];
		$rows = $layout['areas'][$area_loop]['rowCount'];
		$name = $layout['areas'][$area_loop]['description'];
		$isAllocatedSeating = $layout['areas'][$area_loop]['isAllocatedSeating'];
		$height = $layout['areas'][$area_loop]['height'];
		$width = $layout['areas'][$area_loop]['width'];
		if( $layout['areas'][$area_loop]['areaCategoryCode'] == $area_code){
			foreach( array_reverse($layout['areas'][$area_loop]['rows']) as $row ):
				$label = !empty($row['rowLabel'])?$row['rowLabel']:'';
	?>
		<div class ="area">
		<?php

		if(empty($row['seats'])){
			echo '<div class="item empty"> </div>';
		}elseif(!isset($label)){
			echo '<div class="item empty"> </div>';
		}
			else{
				$seats_in_current_row = count(array_reverse($row['seats']));
				$col_index_loop = 0;
				$row_index_combination = array();
				while($col_index_loop <= $cols){
					array_push( $row_index_combination, $row_loop.'-'.$col_index_loop);
					$col_index_loop++;
				}
				$i = 0;
				foreach($row_index_combination as $comb):
					$seat = array_reverse($row['seats']);
					if(isset($seat[$i])){
                        $position_area = $seat[$i]['position']['areaNumber'];
                        $position_row_index = $seat[$i]['position']['rowIndex'];
                        $position_col_index = $seat[$i]['position']['columnIndex'];
                        $seat_label = $seat[$i]['seatLabel'];
                        $status = $seat[$i]['status'];
                        $original_status = $seat[$i]['originalStatus'];
                        $group_seats = $seat[$i]['seatsInGroup'];
                        $this_seat = $position_row_index."-".$position_col_index;
                        if(in_array($this_seat, $row_index_combination)){
                            if($status == 4){
                                echo '<div class="item my">'.$this_seat.'</div>';
                            }elseif($status == 0){
                                echo '<div class="item available">'.$comb.'</div>';
                            }
                            elseif($status == 1){
                                echo '<div class="item sold">'.$this_seat.'</div>';
                            }
                            else{
                                echo '<div class="item wheelchair">'.$this_seat.'</div>';
                            }
                        }else{
                            echo '<div class="item empty"> </div>'; 
                        }
						
					}else{
						echo '<div class="item empty">'.$this_seat.'</div>';
					}
				
					$i++;
				endforeach;
			}
		?>
		</div>
<?php
$row_loop++;
		endforeach;
		}
	//	$area_loop ++;

endforeach;
?>
<?php
echo '<pre>';
print_r($row_index_combination);
echo '</pre>';

?>