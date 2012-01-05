<h1>Check for questions without a home</h1>

<p>Questions without a home means that the question's club or category has been deleted. You should rename clubs and categories instead of deleting and re-adding them if you wish to retain the questions. If you accidentally deleted a category, you can update the ID manually via MySQL by performing an UPDATE on the questions table.</p>

<form method="post" action="check_nohome.php">
<input type="submit" name="delete" value="Delete questions whose club/category has been deleted" />
</form>
