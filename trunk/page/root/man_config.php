<table>


<form method="post" action="man_config.php">

<?
foreach($optionsMap as $key => $value) {
?>
	<tr>
	<td><p><?= $key ?></p></td>
	<td><p><input type="text" name="' . $key . '" value="<?= htmlspecialchars($value) ?>" /></p></td>
<?
}
?>

<input type="submit" name="submit" value="Submit">
</form>
</table>