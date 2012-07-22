<h1>Configuration Editor</h1>

<p>Here, you can manage your configuration. You should not edit this page unless you know what you are doing! Also, note that this page will only work if the permissions of config.php are set such that the webserver user can write to it.</p>

<form method="post" action="man_config.php">
<table>

<?
foreach($optionsMap as $key => $value) {
	$inputType = "text";
	if($value === FALSE) { //this denotes a hidden value
		$value = '';
		$inputType = "password";
	}
?>
	<tr>
		<td><?= $key ?></td>
		<td>
		
			<? if(array_key_exists("options", $tabs[$key])) { ?>
				<select name="<?=$key?>" style="width:204px">
					<? foreach($tabs[$key]["options"] as $option) {
						echo "<option value=\"$option\" ";
						if($value == $option) echo "selected";
						echo ">$option</option>";
					} ?>
				</select>
			<? } else { ?>
				<input type="<?= $inputType ?>" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>" style="width:200px" />
			<? } ?>
		</td>
	</tr>
<?
}
?>

</table>
<input type="submit" name="submit" value="Submit">
</form>
