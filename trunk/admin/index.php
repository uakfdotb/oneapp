<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_admin_header();

if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
	$checkResult = checkAdmin($_REQUEST['username'], $_REQUEST['password']);
    if($checkResult !== FALSE) {
    	$_SESSION['admin_id'] = $checkResult;
    } else {
        echo "Username or password is incorrect, or you have been locked out for multiple attempts. Click <a href=\"index.php\">here</a> to continue.";
    }
} else if(isset($_REQUEST['action'])) {
	if($_REQUEST['action'] == 'logout') {
		unset($_SESSION['admin_id']);
		echo "You are now logged out.";
	}
}

if(isset($_SESSION['admin_id'])) {
    echo "<a href=\"man_questions.php\">Manage questions</a>";
    echo "<br><a href=\"view_submit.php\">View submissions</a>";
    echo "<br><a href=\"man_club.php\">Manage club information</a>";
    echo "<br><a href=\"preview.php\">Preview application</a>";
    
    echo "<br><br><a href=\"index.php?action=logout\">Logout</a>";
} else {
?>
	<h1>Administrator Page</h1>
	<p>Log in with the Usename and Password given to you by your root owner. If you do not have one please contact them and ask them to give you one. Root owners have all privledges granted. Please contact your local root before contacting us about any problems!</p>
<div id="spacebox"></div>

<div id="col_mid" class="borderon">
<div class="center">
<table cellpadding="0" cellspacing="0" width=100%>
<tr bgcolor=#1A3E5B><td class="center"><h2>Log In</h2></td></tr>
<tr bgcolor=#F2F5F7><td>

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

<td></tr>
</table>
</div>
</div>

<?
}

get_admin_footer();
?>
