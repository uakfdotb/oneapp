<h1>Question Manager</h1>

<p>Here, you can customize your application. You can either add one question at a time, or multiple questions. With multiple questions, the name goes on the first line, then the description, then the type on the third line.</p>

<p>If you are not sure what to do here, you should use the <a href="easy_question.php">Easy Question Adder</a> to generate the name, description, and type (then, copy and paste the output to the form on the right).</p>

<div align="center">
<?
page_advanced_include("category_manager", "admin", array("categories" => $categories));
if($isAvailableWindow) {
	echo '<br /><div class="warning">Your club is currently in the available window, and users may have already added the club to their applications list! Changes will not automatically be reflected in the user application; a script in root management needs to be executed.</div><br />';
}

if(isset($editInfo) && $editInfo !== 0) {
	echo '<form method="post" action="man_questions.php?action=edit"><table align="center">';
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
	
	<table  align="center">
	<tr><td width=50%>
	<table>
	<tr><td><p class="name">Name</p></td><td><textarea name="varname" class="right" style="resize:vertical;width:90%;min-height:60px"></textarea></td></tr>
	<tr><td><p class="name">Description</p></td><td><textarea name="vardesc" class="right" style="resize:vertical;width:90%;min-height:60px"></textarea></td><tr>
	<tr><td><p class="name">Type</p></td><td><textarea name="vartype" class="right" style="resize:vertical;width:90%;min-height:60px"></textarea></tr>
	</table></td><td>

	<table>
	<tr><p class="name">Data</p></tr><tr><textarea rows="10" name="data" class="right" style="width:90%; min-height:120px; resize:vertical"></textarea></tr>
	</table>
	</td></tr>
	

	<tr align="center"><td><input type="submit" name="action" value="Add question" class="add right"></td><td><input type="submit" name="action" value="Add multiple questions" class="add right"></td></tr>
	</table><br><br>

	</form>
<?
}
if(count($questionList)==0) {
	echo "<p class=\"name\">You don't have any questions in your supplement!</p>";
} else {
?>
<SCRIPT LANGUAGE="JavaScript" SRC="<?= $stylePath ?>/confirm.js"></SCRIPT>
<p align="right"><a onclick="return confirmSubmit()" href="man_questions.php?action=deleteall">Delete All Questions!</a></p>

<table class="tbl_repeat">
	<tr align="left">
		<th><p>Name</p></th>
		<th><p>Description</p></th>
		<th><p>Type</p></th>
		<th><p></p></th>
		<th><p></p></th>
	</tr>

	<?
	foreach($questionList as $question) {
	?>
		<tr><form method="post" action="man_questions.php">
			<input type="hidden" name="id" value="<?= $question[0] ?>">
			<input type="hidden" name="orderId" value="<?= $question[1] ?>">
			<td><p class="messpart"><?= $question[2] ?></p></td>
			<td><p class="messpart"><?= $question[3] ?></p></td>
			<td><p class="messpart"><?= $question[4] ?></p></td>
			<td><button name="action" value="edit" class="edit">Edit</button></td>
			<td><button name="action" value="delete" class="delete negative">Delete</button></td>
		</form></tr>
	<?
	}
	?>
	</table>
<? } ?>
<br />

