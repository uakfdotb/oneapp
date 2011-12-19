<h1>Application submission</h1>

<p>Please review the errors with your application below before proceeding further. Warnings for general application:</p>

<table>
<?
foreach($genCheck as $warning) {
	echo "<td>" . $warning . "</td>";
}
?>
</table>

<p>Warnings for supplement:</p>

<table>
<?
foreach($appCheck as $warning) {
	echo "<td>" . $warning . "</td>";
}
?>
</table>
