<h1>Full database clean</h1>

<p>This deletes any database entries that do not belong anywhere. Examples include applications whose user or club has been deleted, admins whose club has been deleted, recommendations whose user has been deleted, and club notes whose club has been deleted.</p>

<p>This should not result in any data loss.</p>

<form method="post" action="full_clean.php">
<input type="submit" name="clean" value="Full clean" />
</form>
