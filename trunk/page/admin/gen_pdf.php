<h1>Generate PDF</h1>

<?
page_advanced_include("category_manager", "admin", array("categories" => $categories));

if(isset($message) && $message != "") {
	echo "<p>$message</p>";
}
?>

<form method="post" action="gen_pdf.php">
<input type="submit" name="gen" value="Generate">
</form>
