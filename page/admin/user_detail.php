<h1>User details</h1>

<table>
<?
echo "<tr><td><b>Username</b></td><td>$username</td></tr>";
page_advanced_include("user_profile", "apply", array('profile' => $profile));
?>
</table>
