<h1>Generate PDF</h1>

<p>Press generate to create an empty PDF of answers. Note that your old PDF will not be deleted when you generate a new one, but you will receive a new link. This link will not be saved and you should record it.</p>

<p>If you are a general application administrator and want to combine PDFs for all categories into one PDF, you can use a utility such as <a href="http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/">pdftk</a> (recommended) or the online <a href="http://foxyutils.com/mergepdf/">Merge PDF</a>.</p>

<?
page_advanced_include("category_manager", "admin", array("categories" => $categories));

if(isset($message) && $message != "") {
	echo "<p>$message</p>";
}
?>

<form method="post" action="gen_pdf.php">
<?= $t_hidden ?>
<input type="submit" name="gen" value="Generate">
</form>
