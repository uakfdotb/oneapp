<h1>Application submission</h1>

<p>Please review the errors with your application below before proceeding further.</p>
<h3>Warnings for general application</h3>

<table>
<?
foreach($genCheck as $warning) {
	echo "<tr><p>" . $warning . "</p></tr>";
}
?>
</table>

<h3>Warnings for supplement</h3>

<ul class="errorlist">
<?
foreach($appCheck as $warning) {
	echo "<li><p>" . $warning . "<p></li>";
}
?>
</ul>
