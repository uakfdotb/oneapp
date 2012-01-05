<?
echo "<b>Username</b>: $username<br>";

foreach($profile as $item) {
	echo "<b>" . $item[0] . "</b>: " . $item[1] . "<br>";
}
?>
