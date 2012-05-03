<h1>User List</h1>

<p>Here, all registered users are listed. Note that this includes users who have registered but not logged in yet (highlighted). <b>Reset apps</b> will delete all applications and responses of the user from the database, including on the general application. <b>Delete user</b> will delete the user completely (but will not delete applications and responses).</p>

<script type="text/javascript">

$(document).ready(function() {
  $('td.checking').hide(); 
  $('tr.after_border').hover(function() {  
    $(this).addClass("selected").find('td.checking').show();
  }, function() {  
    $(this).removeClass("selected").find('td.checking').hide();
 });
}):


</script>

<table class="tbl_repeat">
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Username</th>
	<th>Email</th>
	<th>Last active</th>
</tr>

<?
foreach($userList as $user_id => $user) {
	$infoUser = $user[1]; //array of (username, email)
?>
	
	<form method="post" action="userlist.php">
	<input type="hidden" name="id" value="<?= $user_id ?>">
	<tr class="hide_border">
		<td><a href="user_detail.php?id=<?= $user_id ?>"><?= $user_id ?></a></td>
		<td><a href="user_detail.php?id=<?= $user_id ?>"><?= $infoUser[2] ?></a></td>
		<td><?= $infoUser[0] ?></td></a>
		<td><?= $infoUser[1] ?></td>
		<td><?= timeString($user[0]) ?></td>
	</tr>
	<tr class="after_border">
		<td colspan="3" align="left"><input type="submit" name="action" value="Reset" class="reset positive" /></td>
		<td colspan="2" align="right" class="checking"><input type="submit" name="action" value="Delete" class="delete negative" /></td>
	</tr>
	</form>
<? } ?>

</table>
