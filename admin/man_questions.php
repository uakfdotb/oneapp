<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_gen.php");

get_admin_header();

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	$database = "supplements";
	$whereString = "club_id = '$club_id'";
	$catHidden = ""; //outputted for forms in case we need category specification
	
	if($club_id == 0) { //use category instead of club_id if we're dealing with the base application
		include("category_manager.php");
	} else {
		//output a warning if we are in the available window
		if(isAvailableWindow($club_id)) {
			echo '<p>WARNING: your club is currently in the available window, and users may have already added the club to their applications list! Changes will not automatically be reflected in the user application; a script in root management needs to be executed.</p>';
		}
	}
	
	if(isset($_REQUEST['action'])) {
		if($_REQUEST['action'] == "edit" && isset($_REQUEST['id'])) {
			$qid = escape($_REQUEST['id']);
			
			if(isset($_REQUEST['varname']) && isset($_REQUEST['vardesc']) && isset($_REQUEST['vartype'])) {
				$varname = escape($_REQUEST['varname']);
				$vardesc = escape($_REQUEST['vardesc']);
				$vartype = escape($_REQUEST['vartype']);
				
				mysql_query("UPDATE $database SET varname='$varname', vardesc='$vardesc', vartype='$vartype' WHERE id='$qid' AND $whereString");
				echo "<p>Update successful!</p>";
			} else {
				$result = mysql_query("SELECT varname, vardesc, vartype FROM $database WHERE id='$qid' AND $whereString");
				
				if($row = mysql_fetch_array($result)) {
					echo '<form method="post" action="man_questions.php?action=edit">';
					echo '<input type="hidden" name="id" value="' . $qid . '">';
					echo $catHidden;
					echo 'Name: <input type="text" name="varname" value="' . $row['varname'] . '">';
					echo '<br>Description: <br><textarea name="vardesc">' . $row['vardesc'] . '</textarea>';
					echo '<br>Type: <input type="text" name="vartype" value="' . $row['vartype'] . '">';
					echo '<br><input type="submit" value="Update">';
					echo '</form>';
				}
			}
		} else if(($_REQUEST['action'] == "up" || $_REQUEST['action'] == "down") && isset($_REQUEST['id']) && isset($_REQUEST['orderId'])) {
			$qid = escape($_REQUEST['id']);
			$orderId = escape($_REQUEST['orderId']);
			
			$operation = "<"; //take next lower orderId if moving up, or next higher orderId if moving down
			$type = "MAX";
			if($_REQUEST['action'] == "down") {
				$operation = ">";
				$type = "MIN";
			}
			
			$result = mysql_query("SELECT $type(orderId) FROM $database WHERE $whereString AND orderId $operation '$orderId'");
			
			if($row = mysql_fetch_array($result)) {
				if(!is_null($row[0])) {
					$rowOrderId = escape($row[0]);
					mysql_query("UPDATE $database SET orderId='$orderId' WHERE orderId='$rowOrderId' AND $whereString");
					mysql_query("UPDATE $database SET orderId='$rowOrderId' WHERE id='$qid' AND $whereString");
					
					echo "<p>Move successful!</p>";
				}
			}
		} else if($_REQUEST['action'] == "add") {
			if(isset($_REQUEST['varname']) && isset($_REQUEST['vardesc']) && isset($_REQUEST['vartype'])) {
				$varname = escape($_REQUEST['varname']);
				$vardesc = escape($_REQUEST['vardesc']);
				$vartype = escape($_REQUEST['vartype']);
				
				//increment from highest orderId
				$result = mysql_query("SELECT MAX(orderId) FROM $database WHERE $whereString");
				
				if($row = mysql_fetch_array($result)) {
					if(is_null($row[0])) $orderId = 1;
					else $orderId = escape($row[0] + 1);
					
					if($club_id == 0) {
						mysql_query("INSERT INTO baseapp (orderId, varname, vardesc, vartype, category) VALUES ('$orderId', '$varname', '$vardesc', '$vartype', '$category')");
					} else {
						mysql_query("INSERT INTO supplements (orderId, varname, vardesc, vartype, club_id) VALUES ('$orderId', '$varname', '$vardesc', '$vartype', '$club_id')");
					}
					
					echo "<p>Addition successful!</p>";
				}
			}
		} else if($_REQUEST['action'] == "delete") {
			$qid = escape($_REQUEST['id']);
			mysql_query("DELETE FROM $database WHERE id='$qid'");
		} else if($_REQUEST['action'] == "addmulti" && isset($_REQUEST['data'])) {
			$dataText = str_replace("\r", "", $_REQUEST['data']);
			$dataLines = explode("\n", $dataText);
			
			for($i = 0; $i < count($dataLines) - 2; $i+=3) {
				$varname = escape($dataLines[$i]);
				$vardesc = escape($dataLines[$i + 1]);
				$vartype = escape($dataLines[$i + 2]);
				
				//increment from highest orderId
				$result = mysql_query("SELECT MAX(orderId) FROM $database WHERE $whereString");
				
				if($row = mysql_fetch_array($result)) {
					$orderId = escape($row[0] + 1);
					
					if($club_id == 0) {
						mysql_query("INSERT INTO baseapp (orderId, varname, vardesc, vartype, category) VALUES ('$orderId', '$varname', '$vardesc', '$vartype', '$category')");
					} else {
						mysql_query("INSERT INTO supplements (orderId, varname, vardesc, vartype, club_id) VALUES ('$orderId', '$varname', '$vardesc', '$vartype', '$club_id')");
					}
					
					echo "<p>Addition successful for $varname!</p>";
				}
			}
		}
	}
	
	$result = mysql_query("SELECT id, orderId, varname, vardesc, vartype FROM $database WHERE $whereString ORDER BY orderId");
	
	echo "<table><tr><th>Question name</th><th>Description</th><th>Type</th><th>Up</th><th>Down</th><th>Edit</th><th>Delete</th></tr>";
	
	while($row = mysql_fetch_array($result)) {
		echo "<form method=\"post\" action=\"man_questions.php\">";
		echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\">";
		echo "<input type=\"hidden\" name=\"orderId\" value=\"" . $row['orderId'] . "\">";
		echo $catHidden;
		
		echo "<tr><td>";
		echo $row['varname'];
		echo "</td><td>";
		echo $row['vardesc'];
		echo "</td><td>";
		echo $row['vartype'];
		echo "</td>";
		
		echo '<td><input type="submit" name="action" value="up"></td>';
		echo '<td><input type="submit" name="action" value="down"></td>';
		echo '<td><input type="submit" name="action" value="edit"></td>';
		echo '<td><input type="submit" name="action" value="delete"></td>';
		echo "</tr></form>";
	}
	
	echo '</table><br><br>';
	
	//single add form
	echo '<form method="post" action="man_questions.php?action=add">';
	echo $catHidden;
	echo 'Name: <input type="text" name="varname">';
	echo '<br>Description: <br><textarea name="vardesc"></textarea>';
	echo '<br>Type: <input type="text" name="vartype">';
	echo '<br><input type="submit" value="Add question">';
	echo '</form>';
	
	//multi-add form
	echo '<form method="post" action="man_questions.php?action=addmulti">';
	echo $catHidden;
	echo 'Data:<br><textarea rows="10" cols="50" name="data"></textarea>';
	echo '<br><input type="submit" value="Add multiple questions">';
	echo '</form>';
}

get_admin_footer();
?>
