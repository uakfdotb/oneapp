<h1>Statistics</h1>

<table>
<tr>
	<th><p class="admin_table_header">Name</p></th>
	<th><p class="admin_table_header">Value</p></th>
</tr>

<?
foreach($stat_array as $name => $value) {
?>
	<tr>
	<td><p class="admin_table_entry"><?= $name ?></p></td>
	<td><p class="admin_table_entry"><?= $value ?></p></td>
	</tr>
<? } ?>

</table>
