<h1>Statistics</h1>

<p>This page shows general statistics for your website. Most of the fields should be self-explanatory and are simple counts.</p>

<table width=100%>
<tr>
	<th width=40%><p class="admin_table_header" align="left">Name</p></th>
	<th width=20%><p class="admin_table_header" align="center">Value</p></th>
	<th><!--Graphs--></th>
</tr>

<?
foreach($stat_array as $name => $valueArray) {
	if($valueArray[1] == 0) $valueArray[1] = $valueArray[0] + 1; //avoid division by zero
?>
	<tr>
	<td><p class="admin_table_entry"><?= $name ?></p></td>
	<td align="center"><p class="admin_table_entry">

<? echo $valueArray[0];
   if($valueArray[1]!=-1){ echo "/".$valueArray[1];} 
?>
	</p></td>
	<td>
	<? if($valueArray[1] != -1) { ?>
		<img src="../include/ratingbox.php?rating=<?= $valueArray[0] * 100 / $valueArray[1] ?>" width=50%>
	<? } ?>
	</td>
	</tr>
<? } ?>

</table>
