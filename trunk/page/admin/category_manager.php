<?
if($_SESSION['category'] != -2) {
?>
	<form method="get" action="<?= $_SERVER['REQUEST_URI'] ?>">
	<select name="category">

	<?
	foreach($categories as $id => $name) {
		$selectedString = "";
		if($id == $_SESSION['category']) {
			$selectedString = " selected";
		}
	
		echo "<option value=\"$id\"$selectedString>$name</option>";
	}
	?>

	</select>
	<input type="submit" value="Set category">
	</form>
<?
}
?>
