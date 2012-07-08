<!-- This is an included category manager, not an actual page. This page should only display the update category form. -->

<?
if($_SESSION['category'] != -3) {
?>
	<form method="get" action="<?= $_SERVER['REQUEST_URI'] ?>">
	<?= $t_hidden ?>
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
