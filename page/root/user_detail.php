<h1>User details</h1>

<table width="100%">
<?
echo "<tr><td width=\"20%\"><p><b>Username</b></p></td><td><p>$username</p></td></tr>";
page_advanced_include("user_profile", "apply", array('profile' => $profile));
?>
</table>
