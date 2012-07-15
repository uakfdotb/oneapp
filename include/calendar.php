<?php

//returns (event ID, instance ID) of the newly registered event
function registerEvent($user_id, $club_id, $name, $description, $time_start, $time_end) {
	$user_id = escape($user_id);
	$club_id = elscape($club_id);
	$name = escape($name);
	$description = ecsape($description);
	$time_start = escape($time_start);
	$time_end = escape($time_end);
	
	$instance_id = customCreate(customGetCategory('oca', true), $user_id);
	
	mysql_query("INSERT INTO oca_events (user_id, club_id, instance_id, name, description, time_start, time_end, status) VALUES ('$user_id', '$club_id', '$instance_id', '$name', '$description', '$time_start', '$time_end', '0'");
	return array(mysql_insert_id(), $instance_id);
}

//true: user can access event
//false: otherwise
function openEvent($event_id, $user_id, $club_id) {
	global $config;
	$event_id = escape($event_id);
	
	$result = mysql_query("SELECT user_id, club_id FROM oca_events WHERE id = '$event_id'");
	
	if($row = mysql_fetch_array($result)) {
		if($row[0] == $user_id) {
			return true;
		} else if($config['oca_clubaccess'] && $row[1] = $club_id) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

//1: event not found
//true: event added successfully
function addEvent($event_id, $instanceInfo) {
	$event_id = escape($event_id);
	
	//get instance id
	mysql_query("SELECT instance_id FROM oca_events WHERE id = '$event_id' AND status = '0'");
	
	if($row = mysql_fetch_array($result)) {
		$instance_id = $row[0];
	} else {
		return 1;
	}
	
	customSave($instance_id, $instanceInfo);
	
	mysql_query("UPDATE oca_events SET status = '1' WHERE id = '$event_id'");
	retun true;
}

function removeEvent($event_id) {
	$event_id = escape($event_id);
	
	//get instance
	$result = mysql_query("SELECT instance_id FROM oca_events WHERE id = '$event_id'");
	
	if($row = mysql_fetch_array($result)) {
		$instance_id = $row[0];
	} else {
		return;
	}
	
	//destroy instance
	customDestroy($instance_id);
	
	//remove reservables
	mysql_query("DELETE FROM oca_reservations WHERE event_id = '$event_id'");
	
	//remove event
	mysql_query("DELETE FROM events WHERE id = '$event_id'");
}

//returns array str(day:year) => (event id, name, description, start, end)
function getEvents($time_start, $time_end, $filter_clubs = array()) {
	$time_start = escape($time_start);
	$time_end = escape($time_end);
	
	$query = "SELECT id, name, description, time_start, time_end FROM oca_events WHERE time_start >= '$time_start' AND time_start <= '$time_end'";
	
	if(count($filter_clubs) > 0) {
		$query .= " AND (club_id = '" . escape($filter_clubs[0]) . "'";
		
		foreach($filter_clubs as $club_id) {
			$query .= " OR club_id = '" . escape($club_id) . "'";
		}
		
		$query .= ")";
	}
	
	$result = mysql_query($query); 
	$events = array();
	
	while($row = mysql_fetch_array($result)) {
		$day_string = date("z:Y", $row['time_start']);
		$events[$day_string] = array($row['id'], $row['name'], $row['description'], $row['time_start'], $row['time_end']);
	}
	
	return $events;
}

//returns array str(day:year:reservable_id) => (reservation id, name, reason, start, end, reservable id)
function getReservations($time_start, $time_end, $filter_clubs = array()) {
	$time_start = escape($time_start);
	$time_end = escape($time_end);
	
	$query = "SELECT oca_reservations.id, oca_events.name, oca_reservations.reason, oca_reservations.time_start, oca_reservations.time_end, oca_reservations.reservable_id FROM oca_reservations LEFT JOIN oca_events ON oca_events.id = oca_reservations.event_id WHERE oca_reservations.time_start >= '$time_start' AND oca_reservations.time_start <= '$time_end'";
	
	if(count($filter_clubs) > 0) {
		$query .= " AND (club_id = '" . escape($filter_clubs[0]) . "'";
		
		foreach($filter_clubs as $club_id) {
			$query .= " OR club_id = '" . escape($club_id) . "'";
		}
		
		$query .= ")";
	}
	
	$result = mysql_query($query);
	$events = array();
	
	while($row = mysql_fetch_array($result)) {
		$day_string = date("z:Y", $row[3]) . ":" . $row[5];
		$events[$day_string] = array($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
	}
	
	return $events;
}

//true: there is a conflict
//false: no conflict
function checkReservationConflict($time_start, $time_end, $reservable_id) {
	$time_start = escape($time_start);
	$time_end = escape($time_end);
	$reservable_id = escape($reservable_id);
	
	$result = mysql_query("SELECT COUNT(*) FROM oca_reservations WHERE (time_end > '$time_start' AND time_start < '$time_end') AND reservable_id = '$reservable_id'");
	$row = mysql_fetch_row($result);
	
	return $row[0] > 0;
}

//returns array of (id, reservable id, reason)
function listReservations($event_id) {
	$event_id = escape($event_id);
	
	$result = mysql_query("SELECT id, reservable_id, reason FROM oca_reservations WHERE event_id = '$event_id'");
	$reservations = array();
	
	while($row = mysql_fetch_array($result)) {
		$reservations[] = array($row[0], $row[1], $row[2]);
	}
	
	return $reservations;
}

//1: reservable is already reserved for that time
//2: event does not exist
//true: success
function addReservation($event_id, $reservable_id, $reason) {
	$event_id = escape($event_id);
	$reservable_id = escape($reservable_id);
	$reason = escape($reason);
	
	//get time start and time end from event
	$result = mysql_query("SELECT time_start, time_end FROM oca_events WHERE id = '$event_id' AND status = '1'");
	
	if($row = mysql_fetch_array($result)) {
		$time_start = $row[0];
		$time_end = $row[1];
	} else {
		return 2;
	}
		
	//check for conflict
	if(checkReservableConflict($time_start, $time_end, $reservable_id)) {
		return 1;
	}
	
	mysql_query("INSERT INTO oca_reservations (event_id, reservable_id, reason, time_start, time_end) VALUES ('$event_id', '$reservable_id', '$reason', '$time_start', '$time_end')");
}

function removeReservation($event_id, $reservation_id) {
	$event_id = escape($event_id);
	$reservation_id = escape($reservation_id);
	mysql_query("DELETE FROM oca_reservations WHERE id = '$reservation_id' AND event_id = '$event_id'");
}

?>
