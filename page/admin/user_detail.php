<h1>User details</h1>

<table>
<tr>
	<td width="20%"><p><b>Name</b></p></td>
	<td><p><?= $name ?></p></td>
</tr>
<tr>
	<td width="20%"><p><b>Username</b></p></td>
	<td><p><?= $username ?></p></td>
</tr>
<tr>
	<td width="20%"><p><b>Email</b></p></td>
	<td><p><?= $email ?></p></td>
</tr>

<?
//TODO: combine this user_detail with root user_detail!
page_advanced_include("user_profile", "apply", array('profile' => $profile));
?>
</table>
