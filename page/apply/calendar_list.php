<?php

$keys = array_keys($events);
sort($keys);

foreach($keys as $key) {
	$time = date('F j, Y', $key);
	echo "<h3>" . $time . "</h3>";
	echo "<ul>";
	
	foreach($events[$key] as $event) {
		echo "<li>" . $event[1] . " (" . date('g:i a', $event[3]) . " to " . date('g:i a', $event[4]) . ")";
	}
	
	echo "</ul>";
}

?>
