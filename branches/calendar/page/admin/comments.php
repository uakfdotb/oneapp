<h1>Update comments</h1>

<p>You can update your comments on a user's application using the form below. When you save, you will be taken back to the list of the applications.</p>

<!-- updated comments is handled in view_submit for now so that user can return and to avoid code duplication -->
<form method="POST" action="view_submit.php?id=<?= $app_id ?>">
<?= $t_hidden ?>
<textarea name="comments"><?= $comments ?></textarea>
<br /><input type="submit" value="Save">
</form>
