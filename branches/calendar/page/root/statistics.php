<h1>Statistics</h1>

<p>This page shows general statistics for your website. Most of the fields should be self-explanatory and are simple counts.</p>

<table>
<tr>
	<th>Name</p></th>
	<th>Value</th>
	<th><!--Graphs--></th>
</tr>

<?
foreach($stat_array as $name => $valueArray) {
	if($valueArray[1] == 0) $valueArray[1] = $valueArray[0] + 1; //avoid division by zero
?>
	<tr>
	<td><?= $name ?></td>
	
	<td>
	<?
	echo $valueArray[0];
	if($valueArray[1] != -1) echo "/" . $valueArray[1];
	?>
	</td>
	
	<td>
	<? if($valueArray[1] != -1) { ?>
		<img src="../include/ratingbox.php?rating=<?= $valueArray[0] * 100 / $valueArray[1] ?>">
	<? } ?>
	</td>
	
	</tr>
<? } ?>

</table>
