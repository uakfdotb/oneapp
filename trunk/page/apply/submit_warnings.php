<h1>Application submission</h1>

<p>Please review the errors with your application below before proceeding further.</p>
<p><b>Warnings for general application:</b></p>

<table>
<?
foreach($genCheck as $warning) {
	echo "<tr><td><p>" . $warning . "<p></td></tr>";
}
?>
</table>

<p><b>Warnings for supplement:</b> <i>Incomplete Answers</i></p>

<ul>
<?
foreach($appCheck as $warning) {
	echo "<li><p>" . $warning . "<p></li>";
}
?>
</ul>
