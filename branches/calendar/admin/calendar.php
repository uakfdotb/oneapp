<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");
include("../include/apply_submit.php");
include("../include/custom.php");
include("../include/calendar.php");

function editPage($event_id) {
	$info = getEventInformation($event_id);
	$reservations = listReservations($event_id);
	$reservables = getReservables();
	
	$parameters = array('event_id' => $event_id, 'info' => $info, 'reservations' => $reservations, 'reservables' => $reservables);
	
	if(isset($GLOBALS['error'])) {
		$parameters['error'] = $GLOBALS['error'];
	}
	
	get_page_advanced("calendar_edit", "admin", $parameters);
}

if(isset($_SESSION['admin'])) {
	$club_id = $_SESSION['admin_club_id'];
	$user_id = $_SESSION['user_id'];
	
	if(isset($_REQUEST['action'])) {
		if($_REQUEST['action'] == "register" && isset($_REQUEST['name']) && isset($_REQUEST['description']) && isset($_REQUEST['start_time']) && isset($_REQUEST['end_time'])) {
			registerEvent($user_id, $club_id, $_REQUEST['name'], $_REQUEST['description'], strtotime($_REQUEST['start_time']), strtotime($_REQUEST['end_time']));
		} else if($_REQUEST['action'] == "add" && isset($_REQUEST['id'])) {
			if(openEvent($_REQUEST['id'], $user_id, $club_id)) {
				$info = getEventInformation($_REQUEST['id']);
				get_page_advanced("calendar_add", "admin", array('instance_id' => $info[2], 'event_id' => $_REQUEST['id'], 'event_info' => $info));
				return;
			}
		} else if($_REQUEST['action'] == "add_do" && isset($_REQUEST['id'])) {
			if(openEvent($_REQUEST['id'], $user_id, $club_id)) {
				$data = processSubmission($_REQUEST);
				$result = addEvent($_REQUEST['id'], $data);
			
				if($result !== TRUE) {
					if($result === 1) {
						$error = "Event could not be found.";
					} else {
						$error = $result; //result is error string in this case
					}
				}
			}
		} else if($_REQUEST['action'] == "edit" && isset($_REQUEST['id'])) {
			if(openEvent($_REQUEST['id'], $user_id, $club_id)) {
				editPage($_REQUEST['id']);
				return;
			}
		} else if($_REQUEST['action'] == "edit_do" && isset($_REQUEST['id']) && isset($_REQUEST['description'])) {
			if(openEvent($_REQUEST['id'], $user_id, $club_id)) {
				editEvent($_REQUEST['id'], "", $_REQUEST['description'], 0, 0); //empty fields means to not change
				
				//display updated edit page
				editPage($_REQUEST['id']);
				return;
			}
		} else if($_REQUEST['action'] == "reserve" && isset($_REQUEST['id']) && isset($_REQUEST['reservable_id']) && isset($_REQUEST['reason'])) {
			if(openEvent($_REQUEST['id'], $user_id, $club_id)) {
				$result = addReservation($_REQUEST['id'], $_REQUEST['reservable_id'], $_REQUEST['reason']);
				
				if($result === 1) {
					$error = "The requested reservation has a conflict.";
				}
				
				//display updated edit page
				editPage($_REQUEST['id']);
				return;
			}
		} else if($_REQUEST['action'] == "unreserve" && isset($_REQUEST['id']) && isset($_REQUEST['reservable_id'])) {
			if(openEvent($_REQUEST['id'], $user_id, $club_id)) {
				removeReservation($_REQUEST['id'], $_REQUEST['reservable_id']);
				
				//display updated edit page
				editPage($_REQUEST['id']);
				return;
			}
		}
	}
	
	$events = adminGetEvents($user_id, $club_id);
	$parameters = array();
	$parameters['events'] = $events;
	
	if(isset($error)) {
		$parameters['error'] = $error;
	}
	
	get_page_advanced("calendar", "admin", $parameters);
} else {
	header('Location: index.php');
}
?>
