<h1>Easy Question Adder > 

<? if($type=="short") {
	echo "Short Answer";
} else if($type=="text") {
	echo "Plain Text";
} else if($type=="select") {
	echo "Selection";
} else if($type=="essay") {
	echo "Essay";
}

?>

</h1>

<p>Select from the following options.</p>

<form method="POST" action="easy_question.php">
<input type="hidden" name="type" value="<?= $type ?>" />
<table width=100%>
<tr><td width=40%><p class="name required">Question</p>
<? if($type == "type") { ?>
	<p class="desc">The user will not see this</p>
<? } ?>
</td><td><textarea name="name" style="width:100%;resize:vertical;min-height:50px"/></textarea></td></tr>


<!-- description; required field -->
<? if($type == "select") { ?>
	<tr><td><p class="name required">Description</p><p class="desc">Write response choices below, with each on a separate line. Do not use semicolons in the choices.</p></td><td>
	<textarea name="description" style="width:100%;resize:vertical;min-height:50px"></textarea></td></tr>
<? } else { ?>
	<tr><td><p class="name required">Description</p></td>
	<td><textarea name="description" style="width:100%;resize:vertical;min-height:50px"></textarea></td></tr>
<? } ?>

<!-- status:optional,required; default is optional -->
<? if($type != "text") { ?>
	<tr><td><p class="name">Status</p></td><td>
	<p class="desc"><input type="checkbox" name="state" value="required" checked />Required (if checked, system will not allow submission if response blank)</p></td></tr>
<? } ?>

<!-- showchars:true,false; default is false --> 
<? if($type == "essay" || $type == "short") { ?>
	<tr><td><p class="name">Show characters remaining</p></td><td>
	<p class="desc"><input type="checkbox" name="showchars" value="true" /> Yes</p>
	</td></tr>
<? } ?>

<!-- length:int; default is 10,000 -->
<?
if($type == "essay" || $type == "short") {
	if($type == "essay") $length = 1000;
	else $length = 80;
?>
	<tr><td><p class="name">Maximum number of characters</p></td><td>
	<input type="text" name="length" value="<?= $length ?>" />
	</td></tr>
<? } ?>

<!-- method:single,multiple,dropdown; default is single -->
<? if($type == "select") { ?>
	<tr><td><p class="name">Selection type</p></td><td>
	<p class="desc"><input type="radio" name="method" value="single" checked/> Single selection</p>
	<p class="desc"><input type="radio" name="method" value="multiple" /> Multiple selection</p>
	<p class="desc"><input type="radio" name="method" value="dropdown" /> Dropdown selection</p>
	</td></tr>
<? } ?>

<!-- size:medium,large,huge; default is medium -->
<? if($type == "essay") { ?>
	<tr><td><p class="name">Essay size</p><p class="desc">Determines size of text area</p></td><td>
	<p class="desc"><input type="radio" name="size" value="medium" checked/> Medium</p>
	<p class="desc"><input type="radio" name="size" value="large" /> Large</p>
	<p class="desc"><input type="radio" name="size" value="huge" /> Huge</p>
	</td></tr>
<? } ?>

</table>
<input type="submit" name="done" value="Generate question" />
</form>
