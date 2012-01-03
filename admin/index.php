<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_admin_header();

$errorMessage = "";

if(isset($_REQUEST['error'])) {
	$errorMessage = $_REQUEST['error'];
}

if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
	$checkResult = checkAdmin($_REQUEST['username'], $_REQUEST['password']);
    if($checkResult !== FALSE) {
    	$_SESSION['admin_id'] = $checkResult;
    } else {
    	$errorMessage = "Incorrect username/password. You may be locked from your account.";
    }
} else if(isset($_REQUEST['action'])) {
	if($_REQUEST['action'] == 'logout') {
		$errorMessage = "You are now logged out.";
		unset($_SESSION['admin_id']);
	}
}

if(isset($_SESSION['admin_id'])) {
?>

	<h1>Welcome Administrator</h1>
	<p>This is your home. From here you have multiple options available to the right.<br />Please note, your club application will remain closed unless you activate it from <a href="man_club.php">Manage Club Information</a>.</p> 

<?
} else {
?>

	<h1>Administrator Page</h1>
	<p>Log in with the Usename and Password given to you by your root owner. If you do not have one please contact them and ask them to give you one. Root owners have all privledges granted. Please contact your local root before contacting us about any problems!</p>
	<div id="spacebox"></div>


	<div id="col_mid" class="borderon">
	<div class="center">
	<table cellpadding="0" cellspacing="0" width=100%>
	<tr bgcolor=#1A3E5B><td class="center"><h2>Log In</h2></td></tr>
	<tr bgcolor=#F2F5F7>

		<form method="POST" action="index.php">
		<table>
		<tr>
		<td><p align="right">Username:</p></td>
		<td><input type="text" name="username"/></td>
		</tr>
		<tr>
		<td><p align="right">Password:</p></td>
		<td><input type="password" name="password"/></td>
		</tr>
		<tr>
		<td colspan="2" align="right"><input type="submit" value="Submit" align="center"/></td>
		</tr>
		</table>
		</form>

	</tr>

	<?
	if(isset($errorMessage) && $errorMessage != "") {
	?>
		<tr bgcolor=#F2F5F7><td colspan="2"><p class="center"><?= $errorMessage ?></p></td></tr>
	<?
	}
	?>


	</table>
	</div>
	</div>

<?
}

get_admin_footer();
?>
