<h1>Database wipe</h1>

<p>This will clear your entire database. Everything will be deleted, including admins, clubs, users, answers, responses, etc. It does not affect the filesystem (for example, generated PDFs will not be deleted).</p>

<p><b><i>This will result in data loss.</i></b></p>

<form method="post" action="dbwipe.php">
<table width=60% class="center">
<tr><td width=30%><p class="name">Password</p></td><td><input type="password" name="password" class="right" /></td>
</tr><tr><td colspan="2">
<SCRIPT LANGUAGE="JavaScript" SRC="<?= $stylePath ?>/js/confirm.js"></SCRIPT>
<input onclick="return confirmSubmit()" type="submit" name="wipe" value="Wipe the database" class="database_delete negative right"/>
</td></tr></table>
</form>
