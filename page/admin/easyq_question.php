<h1>Easy Question Adder</h1>

<p>Select from the following options.</p>

<form method="POST" action="easy_question.php">
<input type="hidden" name="type" value="<?= $type ?>" />

<p>
	Question<br />
	<textarea name="name" /></textarea>
</p>

<!-- description; required field -->
<? if($type == "select") { ?>
	<p>Write response choices below, with each on a separate line. Do not use semicolons in the choices.<br />
	<textarea name="description"></textarea></p>
<? } else { ?>
	<p>Description<br />
	<textarea name="description"></textarea></p>
<? } ?>

<!-- status:optional,required; default is optional -->
<? if($type != "text") { ?>
	<p>
	<input type="checkbox" name="status" value="required" checked /> Required (if checked, system will not allow submission if response blank)
	</p>
<? } ?>

<!-- showchars:true,false; default is false --> 
<? if($type == "essay" || $type == "short") { ?>
	<p>
	<input type="checkbox" name="showchars" value="true" /> Show characters remaining
	</p>
<? } ?>

<!-- length:int; default is 10,000 -->
<?
if($type == "essay" || $type == "short") {
	if($type == "essay") $length = 1000;
	else $length = 80;
?>
	<p>
	<input type="text" name="length" value="<?= $length ?>" /> Maximum number of characters allowed.
	</p>
	<table>
		<tr align="center">
			<td><b>Characters</b></td>
			<td><b>Approximate Equivialant</b></td>
		</tr>
		<tr align="center">
			<td>80</td>
			<td>1 sentence</td>
		</tr>
		<tr align="center">
			<td>450</td>
			<td>1 paragraph</td>
		</tr>
		<tr align="center">
			<td>2500</td>
			<td>450 words</td>
		</tr>	
		<tr align="center">
			<td>6000</td>
			<td>1000 words</td>
		</tr>
	</table>
<? } ?>

<!-- method:single,multiple,dropdown; default is single -->
<? if($type == "select") { ?>
	<p>Selection method<br />
	<input type="radio" name="method" value="single" checked /> Single selection (radio button, like this)<br />
	<input type="radio" name="method" value="multiple" /> Multiple selection (checkboxes)<br />
	<input type="radio" name="method" value="dropdown" /> Dropdown selection
	</p>
<? } ?>

<!-- size:medium,large,huge; default is medium -->
<? if($type == "essay") { ?>
	<p>Essay size, determines size of text area<br />
	<input type="radio" name="size" value="medium" checked /> Medium<br />
	<input type="radio" name="size" value="large" /> Large<br />
	<input type="radio" name="size" value="huge" /> Huge
	</p>
<? } ?>

<input type="submit" name="done" value="Generate question" />
</form>
