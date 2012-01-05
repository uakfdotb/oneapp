<h1>Update comments</h1>

<!-- updated comments is handled in view_submit for now so that user can return and to avoid code duplication -->
<form method="POST" action="view_submit.php?id=<?= $app_id ?>">
<textarea name="comments"><?= $comments ?></textarea>
<br /><input type="submit" value="Save">
</form>
