<h1>Application preview</h1>

<?
page_advanced_include("category_manager", "admin", array("categories" => $categories));
?>
<table>
<?
if(count($questionList) == 0 ) {
	echo "<p>You don't have any questions in your application!</p>";
} else { ?>
<p>The below questions represent the content that will be viewable to the applicant.</p><br />
<tr><td width=80%>
<form class="uniForm fullwidth"><fieldset>
<?
	foreach($questionList as $questionInfo) {
		echo '<div class="ctrlHolder">';
		writeField(0, 0, $questionInfo[0], $questionInfo[1], $questionInfo[2]);
		echo '</div>';
	}
?>
</fieldset></form>
</td><td width=20%>
<?
	if(isset($message) && $message != "") {
?>
	<form method="post" action="preview.php">
	<input type="submit" name="gen" value="Re-Generate PDF" class="pdf_icon right">
	</form>
<?
		echo "$message";
	} else {
?>
	<form method="post" action="preview.php">
	<input type="submit" name="gen" value="Generate PDF" class="pdf_icon right">
	</form>
<? }
echo "</td></tr>";
}
?>
</table>
