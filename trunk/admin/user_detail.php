<html>
<body>
<h2>Hello, Administrator</h2>

<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");
get_admin_header();

if(isset($_SESSION['admin_id']) && isset($_REQUEST['id'])) {
	$user_id = escape($_REQUEST['id']);
	$userinfo = getUserInformation($user_id); //userinfo is array(username, email)
	$username = $userinfo[0];
	$profile = getProfile($user_id);
	
	echo "<b>Username</b>: $username<br>";
	
	foreach($profile as $item) {
		echo "<b>" . $item[0] . "</b>: " . $item[1] . "<br>";
	}
}
get_admin_footer();
?>

<a href="./">back</a>
</body>
</html>
