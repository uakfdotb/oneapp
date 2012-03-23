<h1>User details</h1>

<table>
<tr>
	<td><b>Name</b></td>
	<td><?= $name ?></td>
</tr>
<tr>
	<td><b>Username</b></td>
	<td><?= $username ?></td>
</tr>
<tr>
	<td><b>Email</b></td>
	<td><?= $email ?></td>
</tr>

<?
//TODO: combine this user_detail with root user_detail!
page_advanced_include("user_profile", "apply", array('profile' => $profile));
?>
</table>
