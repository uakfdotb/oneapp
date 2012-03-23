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
page_advanced_include("user_profile", "apply", array('profile' => $profile));
?>
</table>
