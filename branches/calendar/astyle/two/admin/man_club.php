<h1>Club management</h1>

<!-- This page uses datetimepicker, from http://www.rainforestnet.com/datetimepicker/datetimepicker.htm, which is free software released under the GNU GPL v3.0. OneApp is not affiliated with this software. -->

<p>Here, you can edit settings for your club. View time is the time at which your club will be available for addition into a user's supplement list. Open time is the time when the club supplement can be submitted. Close time is the submission deadline. The number of recommendations field is the required number of recommendations for your club; there is no upper limit on the number that can be submitted, except the maximum number of recommendations a user can request (set in the configuration file).</p>

<p>The calendar icon to the right of certain fields allows you to more easily edit dates. Javascript must be enabled to use this function. Dates can always be entered manually, using any of the <a href="http://www.php.net/manual/en/datetime.formats.compound.php">supported formats</a>.</p>

<SCRIPT LANGUAGE="JavaScript" SRC="<?= $stylePath ?>/datetimepicker/datetimepicker_css.js"></SCRIPT>
<br />
<form method="post" action="man_club.php">
<table widh=100%>
<tr>
	<td width=50%><p class="name">Organization</p></td>
	<td><p class="name"><?= $club_name ?></p></td>
</tr><tr>
	<td><p class="name"><? echo '<img src="' . $stylePath . '/images/required.png" width="8px" class="required">'; ?>Old password</p><p class="desc">Enter old password here to update information</p></td>
	<td><p><input type="password" name="old_password"></p></td>
</tr><tr>
	<td><p class="name">New password</p><p class="desc">To change your password, fill in this and the below field</td>
	<td><p><input type="password" name="new_password"></p></td>
</tr><tr>
	<td><p class="name">Confirm new password</p></td>
	<td><p><input type="password" name="new_password_conf"></p></td>
</tr><tr>
	<td><p class="name">Email</p></td>
	<td><p><input type="text" name="new_email" value="<?= $email ?>"></p></td>
</tr>
</table>
<div class="profile">
	<div class="example2">
		<table width=100%><tr>
		<td colspan="2"><p class="name">Description</p></td><tr><td colspan="2"><p class="desc"><textarea name="description" style="width:95%;resize:vertical;min-height:50px"><?= $description ?></textarea></p></td></tr>
		<tr><td><p class="name">View time</p></td><td><p class="desc">MM/DD/YY (hh:mm:ss)<br><input type="text" id="view_time" name="view_time" value="<?= date('m/d/y H:i:s', $view_time) ?>" /><img src="<?= $stylePath ?>/datetimepicker/images/cal.gif" onclick="javascript:NewCssCal('view_time', 'MMddyyyy', 'arrow', true)" style="cursor:pointer"/></p></td></tr>
		<tr><td width=50%><p class="name">Open time</p></td><td><p class="desc"><input type="text" id="open_time" name="open_time" value="<?= date('m/d/y H:i:s', $open_time) ?>" /><img src="<?= $stylePath ?>/datetimepicker/images/cal.gif" onclick="javascript:NewCssCal('open_time', 'MMddyyyy', 'arrow', true)" style="cursor:pointer"/></p></td></tr>
		<tr><td><p class="name">Close time</p></td><td><p><input type="text" id="close_time" name="close_time" value="<?= date('m/d/y H:i:s', $close_time) ?>" /><img src="<?= $stylePath ?>/datetimepicker/images/cal.gif" onclick="javascript:NewCssCal('close_time', 'MMddyyyy', 'arrow', true)" style="cursor:pointer"/></p></td></tr>
		<tr><td><p class="name">Number of recommenations</p></td><td><p><input type="text" name="num_recommend" value="<?= $num_recommend ?>" /></p></td></tr>
		<tr><td><p class="name">User View</p></td><td><p class="desc"><input type="radio" name="user_type" value="User ID" checked/>User ID<br /><input type="radio" name="user_type" value="Name" />Name</p></td></tr>
		</table>
	</div>
</div>
<table width=100%>
	<tr><td colspan ="2" align="right"><p><input type="submit" name="action" value="Update" class="update"/></p></td></tr>
</table>
</form>
