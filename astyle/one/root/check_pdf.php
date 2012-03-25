<h1>Extra PDF check</h1>

<p>This tool displays (and also allows you to delete) extra PDF files that were generated but not used. For example, when submitting an application, the general application PDF may succeed; but, if the supplement fails, then both will be regenerated and there will be an extra PDF lying around. Also, if a user's applications are reset from the <b>User List</b>, then any submitted PDFs will not be linked to anymore.</p>

<?
if($pdfArray !== FALSE) {
	echo "<ul>";
	foreach($pdfArray as $path) {
		echo "<li><a href=\"$path\">$path</a></li>";
	}
	echo "</ul>";
}
?>

<form method="post" action="check_pdf.php">
<input type="submit" name="delete" value="Delete extra PDFs" />
</form>
