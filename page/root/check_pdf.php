<h1>Extra PDF check</h1>

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
