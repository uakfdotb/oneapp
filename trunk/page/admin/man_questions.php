<h1>Question Manager</h1>

<p>Here, you can customize your application. You can either add one question at a time, or multiple questions. With multiple questions, the name goes on the first line, then the description, then the type on the third line.</p>

<p>If you are not sure what to do here, you should use the <b>Easy Question Adder</b> to generate the name, description, and type (then, copy and paste the output to the form on the right). NOTE: at the time of this message, the easy question adder is still in development.</p>

<div align="center">
<?
page_advanced_include("category_manager", "admin", array("categories" => $categories));
?>
<div id="spacebox"></div>
</div>
<?
if($isAvailableWindow) {
	echo '<p>WARNING: your club is currently in the available window, and users may have already added the club to their applications list! Changes will not automatically be reflected in the user application; a script in root management needs to be executed.</p>';
}

if(isset($message) && $message != "") {
	echo "<p>$message</p>";
}

if(isset($editInfo) && $editInfo !== 0) {
	echo '<form method="post" action="man_questions.php?action=edit"><table class="borderon band1" align="center">';
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
	
	<table class="borderon band1" align="center">
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
<p align="right"><a href="man_questions.php?action=deleteall">Delete All Questions!</a>.</p>

<table cellspacing=0 width=100%><tr align="left"><th><p class="admin_table_header">Question name</p></th><th><p class="admin_table_header">Description</p></th><th><p class="admin_table_header">Type</p></th><th><p class="admin_table_header">Up</p></th><th><p class="admin_table_header">Down</p></th><th><p class="admin_table_header">Edit</p></th><th><p class="admin_table_header">Delete</p></th></tr>

<?
$rowcounter=0;
foreach($questionList as $question) {
?>
	<form method="post" action="man_questions.php">
	<input type="hidden" name="id" value="<?= $question[0] ?>">
	<input type="hidden" name="orderId" value="<?= $question[1] ?>">
	
	<tr class="band<?= $rowcounter % 2 + 1?>">
	<td class="top_border"><p class="messpart"><?= $question[2] ?></p></td>
	<td class="top_border"><p class="messpart"><?= $question[3] ?></p></td>
	<td class="top_border"><p class="messpart"><?= $question[4] ?></p></td>
	
	<td class="top_border"><input type="submit" name="action" value="up"></td>
	<td class="top_border"><input type="submit" name="action" value="down"></td>
	<td class="top_border"><input type="submit" name="action" value="edit"></td>
	<td class="top_border"><input type="submit" name="action" value="delete"></td>
	</tr></form>
<?
	$rowcounter++;
}
?>

</table>
