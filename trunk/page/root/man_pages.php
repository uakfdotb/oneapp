<h1>Page manager</h1>

<?
if(isset($epage) && isset($contents) && $contents !== FALSE) {
?>
	<table width=100%>
	<tr>
	<form method="post" action="man_pages.php?action=Edit&page=<?= $epage ?>">
		<textarea name="contents" rows="20" cols="80" style="resize:none;width:100%"><?= $contents ?></textarea>
		<input type="submit" value="Update">
	</form>
	</tr>
	</table><br><br>

<?
}
?>

<form action="man_pages.php" method="post">
<select name="page">

<?
while($row = mysql_fetch_array($pagesResult)) {
	$pageName = $row[0];

	$selectedString = "";
	if($epage == $pageName) {
		    $selectedString = " selected";
	}

	echo "<option value=\"$pageName\"$selectedString>$pageName</option>";
}
?>

</select>
<input type="submit" name="action" value="Edit">
<input type="submit" name="action" value="Delete">
</form><br><br>

<form action="man_pages.php?action=add" method="get">
<p class="messpar">Page name <input type="text" name="page">
<input type="submit" name="action" value="Add">
</form></p>
