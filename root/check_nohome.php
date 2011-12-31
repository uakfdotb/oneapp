<html>
<body>

<?php
include("header.php");
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/chk.php");

if(isset($_SESSION['root'])) {
	if(isset($_REQUEST['delete'])) {
		checkNoHome();
	}
}
?>

<form method="post" action="check_nohome.php">
<input type="submit" name="delete" value="Delete questions whose club/category has been deleted" />
</form>

</body>
</html>
