<h1>Statistics</h1>

<p>This page shows general statistics for your website. Most of the fields should be self-explanatory and are simple counts.</p>

<table>
<tr>
	<th><p class="admin_table_header">Name</p></th>
	<th><p class="admin_table_header">Value</p></th>
	<th> <!--Graphs--> </tr>
</tr>

<?
foreach($stat_array as $name => $valueArray) {
	if($valueArray[1] == 0) $valueArray[1] = $valueArray[0] + 1; //avoid division by zero
?>
	<tr>
	<td><p class="admin_table_entry"><?= $name ?></p></td>
	<td><p class="admin_table_entry"><?= $valueArray[0] ?></p></td>
	<td>
	<? if($valueArray[1] != -1) { ?>
		<img src="../include/ratingbox.php?rating=<?= $valueArray[0] * 100 / $valueArray[1] ?>">
	<? } ?>
	</td>
	</tr>
<? } ?>

</table>
