<h1>Application preview</h1>

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
<table>
<?
foreach($questionList as $questionInfo) {
	writeField(0, 0, $questionInfo[0], $questionInfo[1], $questionInfo[2]);
}
?>
</table>
