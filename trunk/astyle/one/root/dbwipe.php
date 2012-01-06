<h1>Database wipe</h1>

<p>This will clear your entire database. Everything will be deleted, including admins, clubs, users, answers, responses, etc. It does not affect the filesystem (for example, generated PDFs will not be deleted).</p>

<p><b><i>This will result in data loss.</i></b></p>

<? if(isset($message) && $message != '') { ?>
<p><?= $message ?></p>
<? } ?>

<form method="post" action="dbwipe.php">
Root password: <input type="password" name="password" /><br />
<SCRIPT LANGUAGE="JavaScript" SRC="<?= $stylePath ?>/confirm.js"></SCRIPT>
<input onclick="return confirmSubmit()" type="submit" name="wipe" value="Wipe the database" />
</form>
