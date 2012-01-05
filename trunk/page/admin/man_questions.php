<h1>Question Manager</h1>

<?
page_advanced_include("category_manager", "admin", array("categories" => $categories));

if($isAvailableWindow) {
	echo '<p>WARNING: your club is currently in the available window, and users may have already added the club to their applications list! Changes will not automatically be reflected in the user application; a script in root management needs to be executed.</p>';
}

if(isset($message) && $message != "") {
	echo "<p>$message</p>";
}

if(isset($editInfo) && $editInfo !== 0) {
	echo '<form method="post" action="man_questions.php?action=edit"><table class="borderon">';
	echo '<input type="hidden" name="id" value="' . $editInfo[0] . '">';
	echo '<tr><td align="right"><p class="messpart">Name</p></td><td><input type="text" name="varname" value="' . $editInfo[1] . '" style="width:100%"></td></tr>';
	echo '<tr><td align="right"><p class="messpart">Description</p></td><td><textarea name="vardesc" style="resize:none;width:100%;height:120px">' . $editInfo[2] . '</textarea></td></tr>';
	echo '<tr><td align="right"><p class="messpart">Type</p></td><td><input type="text" name="vartype" value="' . $editInfo[3] . '" style="width:100%">';
	echo '<tr><td colspan="2" align="right"><input type="submit" value="Update"></td></tr>';
	echo '</table></form><br><br>';
} else {
	//because we have these in two columns now, we display one form for both and decide which is being submitted based on button
?>
	<form method="post" action="man_questions.php">
	
	<table class="borderon">
	<tr><td width=50%>
	<table>
	<tr><td><p align="right">Name</p></td><td><input type="text" name="varname" style="width:100%"></td></tr>
	<tr><td><p align="right">Description</p></td><td><textarea name="vardesc" style="resize:none;width:100%;height:120px"></textarea></td><tr>
	<tr><td><p align="right">Type</p></td><td><input type="text" name="vartype" style="width:100%"></td></tr>
	</table></td><td>

	<table>
	<tr><p>Data</p></tr><tr><textarea rows="10" cols="50" name="data" style="width:100%;hight=100%;resize:none"></textarea></tr>
	</table>
	</td></tr>
	

	<tr align="center"><td><input type="submit" name="action" value="Add question"></td><td><input type="submit" name="action" value="Add multiple questions"></td></tr>
	</table><br><br>

	</form>
<?
}
?>

<table cellspacing=0 class="borderon" width=100%><tr align="left"><th><p class="mess">Question name</p></th><th><p class="mess">Description</p></th><th><p class="mess">Type</p></th><th><p class="mess">Up</p></th><th><p class="mess">Down</p></th><th><p class="mess">Edit</p></th><th><p class="mess">Delete</p></th></tr>

<?
$rowcounter=0;
foreach($questionList as $question) {
?>
	<form method="post" action="man_questions.php">
	<input type="hidden" name="id" value="<?= $question[0] ?>">
	<input type="hidden" name="orderId" value="<?= $question[1] ?>">
	
	<tr class="band<?= $rowcounter % 2 + 1?>">
	<td><p class="messpart"><?= $question[2] ?></p></td>
	<td><p class="messpart"><?= $question[3] ?></p></td>
	<td><p class="messpart"><?= $question[4] ?></p></td>
	
	<td><input type="submit" name="action" value="up"></td>
	<td><input type="submit" name="action" value="down"></td>
	<td><input type="submit" name="action" value="edit"></td>
	<td><input type="submit" name="action" value="delete"></td>
	</tr></form>
<?
	$rowcounter++;
}
?>

</table>