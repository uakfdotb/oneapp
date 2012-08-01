<h1><a href="root_cat.php?cat=Database">Database</a> > Backup</h1>

<? if($backupLink !== FALSE) { ?>
<p>Your data has been backed up and is available for download at the following links:</p>
<table class="nav-button-vertical-container center">
<tr><td>
	<a href="<?= $backupLink[0] ?>"><div class="nav-button-vertical">
		<h2>Database</h2>
		<div class="zip"></div>
	</div></a>
</td><td>
	<a href="<?= $backupLink[1] ?>"><div class="nav-button-vertical">
		<h2>Submitted PDFs</h2>
		<div class="zip"></div>
	</div></a>
</td>
</table>
<? } ?>
<p>This tool will backup all of the data pertaining to your website (this excludes the oneapp installation base). Specifically, the database, any submission PDFs, and any generated PDFs (generated by admins to pdf/ directory) will be backed up.</p>

<form method="post" action="backup.php">
<input type="submit" name="backup" value="Backup" class="backup" />
</form>