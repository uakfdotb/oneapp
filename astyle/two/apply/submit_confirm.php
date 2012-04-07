<h1>Application submission</h1>

<form method="POST" action="submit.php?club_id=<?= $club_id ?>&app_id=<?= $app_id ?>">
No errors were found with either your general application or the club supplement. <b><i>You may wish to <a target="_blank" href="preview.php?club_id=<?= $club_id ?>&app_id=<?= $app_id ?>">preview your submission</a> before you submit.</i></b> Are you sure you wish to submit?
<br><input type="submit" name="confirm" value="Yes, submit" />
<input type="submit" value="Cancel" />
</form>
