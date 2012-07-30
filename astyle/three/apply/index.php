<?
//find username
if(isset($_SESSION['user_id'])){
	$user_id = escape($_SESSION['user_id']);
	$result = mysql_query("SELECT username FROM users WHERE id = '$user_id'");

	if($row = mysql_fetch_array($result)) { //this should always occur
		$username = $row[0];
	?>

	<h2 class="separate">My Workspace</h2>

	<p>Hello, <b><?= $username ?></b>. Welcome to your workspace. From here, you can select links to the left to manage your applications and above to manage your account. To start, we recommend you either select the general application and begin working there or add a few clubs by selecting clubs.</p>

	<? } 
}
?>

