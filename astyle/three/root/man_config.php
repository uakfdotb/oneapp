<h1>Configuration Editor</h1>

<p>Here, you can manage your configuration. You should not edit this page unless you know what you are doing!</p>

<form method="post" action="man_config.php">
<div id="tabs">
	<ul>
<?
foreach($tab_list as $tab) {
	echo "<li><a href=\"#$tab\">$tab</a></li>";
}
	echo "</ul><div><p class=\"name\" align=\"center\">Be very careful when editing the content on this page!</p></div>";
foreach($optionsMap as $key => $value) {
	$inputType = "text";
	if($value === FALSE) { //this denotes a hidden value
		$value = '';
		$inputType = "password";
	}
?>
	<div id="<?=$tabs[$key][0]?>">
		<div width=25% class="left"><p><?
			if($tabs[$key][1]=="") echo $key;
			else echo $tabs[$key][1];
		?></p></div>
		<div width=70% class="right">
			<? if(array_key_exists("options", $tabs[$key])) {
				echo "<select name=\"$key";
				echo "_control\"";
				echo ">";
				foreach($tabs[$key]["options"] as $option) {
						echo "<option value=\"$option\" ";
						if($value == $option) echo "selected";
						echo ">$option</option>";
					} ?>
				</select>
			<? } else { ?>
				<input type="<?= $inputType ?>" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>" />
			<? } ?>
		</div>
	</div>
<?
}
?>
<br />
</div>
<br />
<input type="submit" name="submit" value="Submit" class="submit right">
</form>
