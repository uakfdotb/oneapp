<html>
<body>
<h2>Hello, Administrator</h2>

<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");
get_admin_header();

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	
	if($club_id != 0) {
		if(isset($_REQUEST['description']) && isset($_REQUEST['view_time']) && isset($_REQUEST['open_time']) && isset($_REQUEST['close_time'])) {
			$description = escape($_REQUEST['description']);
			$view_time = strtotime($_REQUEST['view_time']);
			$open_time = strtotime($_REQUEST['open_time']);
			$close_time = strtotime($_REQUEST['close_time']);
			$num_recommend = escape($_REQUEST['num_recommend']);
			
			mysql_query("UPDATE clubs SET description='$description', view_time='$view_time', open_time='$open_time', close_time='$close_time', num_recommend='$num_recommend' WHERE id='$club_id'");
		}
		
		$result = mysql_query("SELECT description, view_time, open_time, close_time, num_recommend FROM clubs WHERE id='$club_id'");
		
		if($row = mysql_fetch_array($result)) {
?>
			<form method="post" action="man_club.php">
			Description<br> <textarea name="description"><?= $row['description'] ?></textarea><br>
			View time <input type="text" name="view_time" value="<?= date('m/d/y H:i:s', $row['view_time']) ?>" /> MM/DD/YY (hh:mm:ss)<br>
			Open time <input type="text" name="open_time" value="<?= date('m/d/y H:i:s', $row['open_time']) ?>" /><br>
			Close time <input type="text" name="close_time" value="<?= date('m/d/y H:i:s', $row['close_time']) ?>" /><br>
			Number of recommenations <input type="text" name="num_recommend" value="<?= $row['num_recommend'] ?>" /><br>
			<input type="submit" value="Update" />
			</form>
<?
		} else {
			echo "Error: your club cannot be found in the clubs table.<br>";
		}
	} else {
		echo "General application admin does not have a club to manage.<br>";
	}
}

get_admin_footer();
?>

<a href="./">back</a>
</body>
</html>
