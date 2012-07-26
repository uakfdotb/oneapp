<h1>Reservations</h1>

<table>
<tr>
	<th>Time</th>

<?php
//this will map from the reservable ID to column index that we're printing
$reservableToColumn = array();

$counter = 0;
foreach($reservables as $id => $reservable) { //reservable is array(name, description)
	$reservableToColumn[$id] = $counter;
	$counter++;
	
	echo "<th>{$reservable[0]}</th>";
}
?>

</tr>

<?
$keys = array_keys($events);
sort($keys);

foreach($keys as $key) {
	//print out this day
	$timeString = date('F j, Y', $key);
	echo "<tr><td colspan=\"$counter\"><center><strong>" . $timeString . "</strong></center></td></tr>";
	
	//organize events for this day into 30-minute intervals
	$timeEvents = array();
	
	for($i = 0; $i < 48; $i++) {
		$timeEvents[$i] = array();
		
		for($j = 0; $j < $counter; $j++) {
			$timeEvents[$i][$j] = -1;
		}
	}
	
	//todo: this does not correctly process when it goes to the next day :/
	foreach($events[$key] as $eventKey => $event) {
		//get the 30-minute interval start block
		//this is accomplished by simply dividing the time difference in seconds
		// from beginning of day ($key) by 1800
		$startBlock = intval(($event[3] - $key) / 1800);
		
		//for end block, we subtract one in case it's on a thirty-minute interval
		// because if it ends at 3:00 pm we don't want to say it takes up the interval from 3:00 pm - 3:30 pm
		$endBlock = intval(($event[4] - $key - 1) / 1800);
		
		for($i = $startBlock; $i <= $endBlock && $i < 48; $i++) {
			//map from time block + reservable => the current event
			$timeEvents[$i][$event[5]] = $eventKey;
		}
	}
	
	//now print based on map we made
	for($i = 0; $i < 48; $i++) {
		$str = intval($i / 2) . ":" . ($i % 2 == 0 ? "00" : "30");
		echo "<tr>";
		echo "<td>" . $str . "</td>";
		
		for($j = 0; $j < $counter; $j++) {
			if($timeEvents[$i][$j] == -1) {
				echo "<td></td>";
			} else {
				$eventKey = $timeEvents[$i][$j];
				echo "<td>{$events[$key][$eventKey][1]}</td>";
			}
		}
		
		echo "</tr>";
	}
}

?>

</table>
