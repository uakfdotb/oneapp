<h1>Configuration Editor</h1>

<form method="post" action="man_config.php">
<table>

<?
foreach($optionsMap as $key => $value) {
?>
	<tr>
	<td><p><?= $key ?></p></td>
	<td><p><input type="text" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>" /></p></td>
<?
}
?>

</table>
<input type="submit" name="submit" value="Submit">
</form>
