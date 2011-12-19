<html>
<body>
<h2>Hello, Administrator</h2>

<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	$database = "supplements";
	$whereString = "club_id = '$club_id'";
	$catHidden = ""; //outputted for forms in case we need category specification
	
	if($club_id == 0) { //use category instead of club_id if we're dealing with the base application
		$database = "baseapp";
		
		if(isset($_REQUEST['category'])) {
			$category = escape($_REQUEST['category']);
		} else {
			$category = 0;
		}
		
		$whereString = "category = '$category'";
		$catHidden = '<input type="hidden" name="category" value="' . $category . '">';
		
		//allow user to select category
		echo '<form method="get" action="man_questions.php">';
		echo '<select name="category">';
		echo '<option value="0">Profile</option>';
		
		$result = mysql_query("SELECT id,name FROM basecat");
		while($row = mysql_fetch_array($result)) {
			$selectedString = "";
			if($row['id'] == $category) {
				$selectedString = " selected";
			}
			echo '<option value="' . $row['id'] . '"' . $selectedString . '>' . $row['name'] . '</option>';
		}
		
		echo '</select><input type="submit" value="Set category"></form>';
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
					mysql_query("UPDATE $database SET orderId='$orderId' WHERE orderId='$rowOrderId'");
					mysql_query("UPDATE $database SET orderId='$rowOrderId' WHERE id='$qid'");
					
					echo "<p>Move successful!</p>";
				}
			}
		} else if($_REQUEST['action'] == "add") {
			if(isset($_REQUEST['varname']) && isset($_REQUEST['vardesc']) && isset($_REQUEST['vartype'])) {
				if($club_id == 0) { //use category instead of club_id if we're dealing with the base application
					$category = escape($_REQUEST['category']);
				}
				
				$varname = escape($_REQUEST['varname']);
				$vardesc = escape($_REQUEST['vardesc']);
				$vartype = escape($_REQUEST['vartype']);
				
				//increment from highest orderId
				$result = mysql_query("SELECT MAX(orderId) FROM $database WHERE $whereString");
				
				if($row = mysql_fetch_array($result)) {
					$orderId = escape($row[0] + 1);
					
					if($club_id == 0) {
						mysql_query("INSERT INTO baseapp (orderId, varname, vardesc, vartype, category) VALUES ('$orderId', '$varname', '$vardesc', '$vartype', '$category')");
					} else {
						mysql_query("INSERT INTO supplements (orderId, varname, vardesc, vartype, club_id) VALUES ('$orderId', '$varname', '$vardesc', '$vartype', '$club_id')");
					}
					
					echo "<p>Addition successful!</p>";
				}
			}
		}
	}
	
	$result = mysql_query("SELECT id, orderId, varname, vardesc, vartype FROM $database WHERE $whereString ORDER BY orderId");
	
	echo "<table><tr><th>Question name</th><th>Description</th><th>Type</th><th>Up</th><th>Down</th><th>Edit</th></tr>";
	
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
		echo "</tr></form>";
	}
	
	echo '</table><br><br><form method="post" action="man_questions.php?action=add">';
	echo $catHidden;
	echo 'Name: <input type="text" name="varname">';
	echo '<br>Description: <br><textarea name="vardesc"></textarea>';
	echo '<br>Type: <input type="text" name="vartype">';
	echo '<br><input type="submit" value="Add question">';
	echo '</form>';
}
?>

</body>
</html>