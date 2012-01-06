<h1>Statistics</h1>

<p>This page shows general statistics for your website. Most of the fields should be self-explanatory and are simple counts.</p>

<table>
<tr>
	<th><p class="admin_table_header">Name</p></th>
	<th><p class="admin_table_header">Value</p></th>
	<th> <!--Graphs--> </tr>
</tr>

<?
foreach($stat_array as $name => $value) {
?>
	<tr>
	<td><p class="admin_table_entry"><?= $name ?></p></td>
	<td><p class="admin_table_entry"><?= $value ?></p></td>
	<td><img src="../include/ratingbox.php?rating=<?= $value ?>"></td>
	</tr>
<? } ?>

</table>
