<h1><a href="root_cat.php?cat=Database">Database</a> > Full Clean</h1>

<p>This deletes any database entries that do not belong anywhere. Examples include:
<ul class="bullet">
<li><b>Applications</b> whose user or club has been deleted</li>
<li><b>Admins</b> whose club has been deleted</li>
<li><b>Recommendations</b> whose user has been deleted</li>
<li><b>Club</b> notes whose club has been deleted</li>
</ul>
</p>

<p>This should not result in any data loss.</p>

<form method="post" action="full_clean.php">
<input type="submit" name="clean" value="Full clean" class="clean"/>
</form>
