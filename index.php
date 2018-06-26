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
<table>
<?php 
$area_loop = 0;
$count = 0;
foreach( $layout['areas'] as $a):
	$anumber = $a['number'];
	$acode = $a['areaCategoryCode'];
	$aseats_count = $a['numberOfSeats'];
	$acols = $a['columnCount'];
	$arows_count = $a['rowCount'];
	$arows = $a['rows'];
	echo '<table>';	
	foreach( array_reverse($arows) as $ar){
		$seat_in_row = count($ar['seats']);
		$pos_in_row = $acols;
		$looper = 0;
		$rlabel = !empty($ar['rowLabel'])?$ar['rowLabel']:'';
		echo '<tr>';
		while($looper < $pos_in_row ){
			if(isset( $ar['seats'][$looper] )){
			$diff = 0;
			$seatlabel = $ar['seats'][$looper]['seatLabel'];
				$current_ci = $ar['seats'][$looper]['position']['columnIndex'];
				$next_ci = !empty($ar['seats'][$looper+1]['position']['columnIndex'])?$ar['seats'][$looper+1]['position']['columnIndex']:$acols;
				$diff = $next_ci - $current_ci;
				$rounder_up = 1;
			if($ar['seats'][0]['position']['columnIndex'] != 0 && $looper == 0){
				while( $rounder_up <= $ar['seats'][0]['position']['columnIndex']){
					echo '<td><div class="item empty"></div></td>';
					$rounder_up++;
				}
			}
			echo '<td><div class="item available">'.$rlabel.$seatlabel.'</div></td>';
			$rounder_up = 1;
			while($rounder_up < $diff){
				echo '<td><div class="item empty"></div></td>';
				$rounder_up++;
			}
			
			}
			$looper++;
		}	
		echo '</tr>';
	}
	echo '</table>';
	$area_loop ++;
endforeach;
?>
</table>
<?php
echo '<pre>';
print_r($layout);
echo '</pre>';

?>