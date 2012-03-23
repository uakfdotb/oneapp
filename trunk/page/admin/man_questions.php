<h1>Question Manager</h1>

<p>Here, you can customize your application. You can either add one question at a time, or multiple questions. With multiple questions, the name goes on the first line, then the description, then the type on the third line.</p>

<p>If you are not sure what to do here, you should use the <a href="easy_question.php">Easy Question Adder</a> to generate the name, description, and type (then, copy and paste the output to the form on the right).</p>

<?
page_advanced_include("category_manager", "admin", array("categories" => $categories));
?>

<?
if($isAvailableWindow) {
	echo '<p>WARNING: your club is currently in the available window, and users may have already added the club to their applications list! Changes will not automatically be reflected in the user application; a script in root management needs to be executed.</p>';
}

if(isset($message) && $message != "") {
	echo "<p><b>$message</b></p>";
}

if(isset($editInfo) && $editInfo !== 0) {
?>
	<form method="post" action="man_questions.php?action=edit">
	<input type="hidden" name="id" value="<?= $editInfo[0] ?>">
	<table>
	<tr>
		<td>Name</td>
		<td><input type="text" name="varname" value="<?= $editInfo[1] ?>" style="width:100%"></td>
	</tr>
	<tr>
		<td>Description</td>
		<td><textarea name="vardesc" style="resize:none;width:100%;height:120px"><?= $editInfo[2] ?></textarea></td>
	</tr>
	<tr>
		<td>Type</td>
		<td><input type="text" name="vartype" value="<?= $editInfo[3] ?>" style="width:100%" ></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Update"></td>
	</tr>
	</table>
	</form>
<?
} else {
	//because we have these in two columns now, we display one form for both and decide which is being submitted based on button
?>
	<form method="post" action="man_questions.php">
	<table>
	<tr>
	<td>
		<table>
		<tr>
			<td>Name</td>
			<td><input type="text" name="varname" style="width:100%"></td>
		</tr>
		<tr>
			<td>Description</td>
			<td><textarea name="vardesc" style="resize:none;width:100%;height:120px"></textarea></td>
		<tr>
		<tr>
			<td>Type</td>
			<td><input type="text" name="vartype" style="width:100%"></td>
		</tr>
		</table>
	</td>
	<td>
		<table>
		<tr><td>Data</td></tr>
		<tr><td><textarea rows="10" cols="50" name="data" style="width:100%;hight=100%;resize:none"></textarea></td></tr>
		</table>
	</td>
	</tr>
	
	<tr align="center">
		<td><input type="submit" name="action" value="Add question"></td>
		<td><input type="submit" name="action" value="Add multiple questions"></td>
	</tr>
	</table>
	</form>
<?
}
?>

<p><a href="man_questions.php?action=deleteall">Delete All Questions!</a></p>

<table>
<tr>
	<th>Question name</th>
	<th>Description</th>
	<th>Type</th>
	<th>Up</th>
	<th>Down</th>
	<th>Edit</th>
	<th>Delete</th>
</tr>

<? foreach($questionList as $question) { ?>
	<form method="post" action="man_questions.php">
	<input type="hidden" name="id" value="<?= $question[0] ?>">
	<input type="hidden" name="orderId" value="<?= $question[1] ?>">
	
	<tr>
		<td><?= $question[2] ?></td>
		<td><?= $question[3] ?></td>
		<td><?= $question[4] ?></td>
	
		<td><input type="submit" name="action" value="up"></td>
		<td><input type="submit" name="action" value="down"></td>
		<td><input type="submit" name="action" value="edit"></td>
		<td><input type="submit" name="action" value="delete"></td>
	</tr>
	</form>
<? } ?>

</table>
