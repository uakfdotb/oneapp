<h1>Application submission</h1>

<p>Please review the errors with your application below before proceeding further. Warnings for general application:</p>

<table>
<?
foreach($genCheck as $warning) {
	echo "<tr><td>" . $warning . "</td></tr>";
}
?>
</table>

<p>Warnings for supplement:</p>

<table>
<?
foreach($appCheck as $warning) {
	echo "<tr><td>" . $warning . "</td></tr>";
}
?>
</table>
