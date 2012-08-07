<script>
	function editquestion(id, name, desc, type) {	
		$("#editInfo").find("[name=varname]").val(name);
		$("#editInfo").find("[name=vardesc]").val(desc);
		$("#editInfo").find("[name=vartype]").val(type);
		$("#editInfo").find("[name=id]").val(id);
		$("#editInfo").css("display","block");
		$("#editInfo").siblings("h3").css("display","none");
		$("#tabs").tabs('select',2);
	}
</script>

<h2 class="separate">Question Manager</h2>

<p>Here, you can customize your application. You can either add one question at a time, or multiple questions. With multiple questions, the name goes on the first line, then the description, then the type on the third line.</p>

<p>If you are not sure what to do here, you should use the <a href="easy_question.php">Easy Question Adder</a> to generate the name, description, and type (then, copy and paste the output to the form on the right).</p>

<div>
<? page_advanced_include("category_manager", "admin", array("categories" => $categories)); ?>
<div id="tabs">
	<ul>
		<li><a href="#tab-1">Add Question</a></li>
		<li><a href="#tab-2">Add Multiple Questions</a></li>
		<li><a href="#tab-3">Edit Question</a></li>
	</ul>
<div id="tab-1">
	<form method="post" action="man_questions.php" class="uniForm fullwidth">
	<fieldset>
		<div class="ctrlHolder">
			<label>Name</label>
			<input type="text" name="varname" />
		</div>
		<div class="ctrlHolder">
			<label>Description</p></label>
			<textarea name="vardesc" style="height:40px" /></textarea>
		</div>
		<div class="ctrlHolder">
			<label>Type</label>
			<textarea name="vartype" style="height:40px" /></textarea>
		</div>
	
		<div class="buttonHolder">
			<input type="submit" name="action" value="Add question" class="add primaryAction">
		</div>
	</fieldset>
	</form>
</div>
<div id="tab-2">
	<form method="post" action="man_questions.php" class="uniForm fullwidth">
	<fieldset>
		<div class="ctrlHolder">
			<label>Data</label>
			<textarea name="data" /></textarea>
		</div>
	
		<div class="buttonHolder">
			<input type="submit" name="action" value="Add multiple questions" class="add primaryAction">
		</div>
	</fieldset>
	</form>
</div>
<div id="tab-3">
	<h3 align="center">Select a question below you want to edit!</h3>
	<div id="editInfo" style="display:none">
		<form method="post" action="man_questions.php?action=edit" class="uniForm fullwidth">
		<fieldset>
		<input type="hidden" name="id" value="">
		<div class="ctrlHolder"><label>Name</label><input type="text" name="varname" value="" ></div>
		<div class="ctrlHolder"><label>Description</label><textarea name="vartype" style="height:40px" ></textarea></div>
		<div class="ctrlHolder"><label>Type</label><textarea name="vartype" style="height:40px" ></textarea></div>
		<div class="buttonHolder"><input type="submit" value="Update" class="update primaryAction"></div>
		</fieldset>
		</form>
	</div>
</div>
</div>
<? if(count($questionList)==0) {
	echo "<p class=\"name\">You don't have any questions in your supplement!</p>";
} else {
?>
<SCRIPT LANGUAGE="JavaScript" SRC="<?= $stylePath ?>/confirm.js"></SCRIPT>
<p align="right"><a onclick="return confirmSubmit()" href="man_questions.php?action=deleteall">Delete All Questions!</a></p>
<form method="post" action="man_questions.php" class="uniForm fullwidth">
	<?
	foreach($questionList as $question) {
	?>
			<div class="ctrlHolder">
				<ul>
				<li><label for=""><pre style="white-space:normal"><?= $question[2] ?><br /><?= $question[3] ?><br /><?= $question[4] ?></pre><input type="checkbox" name="delete_array[]" value="<?= $question[0] ?>"></label><li>
				</ul>
				<p class="formHint"><a href="#tabs" onclick="editquestion('<?= $question[0] ?>', '<?= $question[2] ?>', '<?= $question[3] ?>', '<?= $question[4] ?>')" class="button app_edit">Edit</a></p>
			</div>
			<div class="ctrlHolder">
          		<p class="label">Privacy agreement</p>
          		<ul class="blockLabels">
            		<li><label for=""><input type="checkbox" name="agreement" class="required"> I have read the agreement</label></li>
          		</ul>
        	</div>
	<?
	}
	?>
	</form>
<? } ?>
<br />
</div>
