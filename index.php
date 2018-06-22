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
			foreach( $layout['areas'][$area_loop]['rows'] as $row ):
				$label = $row['rowLabel'];
	?>
		<div class ="area">
		<?php 
		if(empty($row['seats'])){
			echo '<div class="item empty"> </div>';
		}else{
		 foreach( $row['seats'] as $seat):
			$position_area = $seat['position']['areaNumber'];
			$position_row_index = $seat['position']['rowIndex'];
			$position_col_index = $seat['position']['columnIndex'];
			$seat_label = $seat['seatLabel'];
			$status = $seat['status'];
			$original_status = $seat['originalStatus'];
			$group_seats = $seat['seatsInGroup'];
			$this_seat = $position_area.",".$position_row_index.",".$position_col_index;
	
			if($status == 4){
				echo '<div class="item my">'.$label.$seat_label.'</div>';
			}elseif($status == 0){
				echo '<div class="item available">'.$label.$seat_label.'</div>';
			}
			elseif($status == 1){
				echo '<div class="item sold">'.$label.$seat_label.'</div>';
			}
			else{
				echo '<div class="item wheelchair">'.$label.$seat_label.'</div>';
			}

		endforeach;
			}
		?>
		</div>
<?php
		endforeach;
		}
endforeach;
?>
<?php
echo '<pre>';
print_r($layout);
echo '</pre>';

?>