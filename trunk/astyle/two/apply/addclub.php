<h1>Add Club</h1>
<p>From here, you can add any organization that is availble. You can sort organizations by click on the header you wish to sort by.</p>
<p>Click on a club to view its details.</p>
<br />
<table class="sortable" class="borderon" width=100%>
	<tr class="table_header">
	<th width=30%>Name</th>
	<th width=30%>Start Date</th>
	<th width=30%>Deadline</th>
	<th class="sorttable_nosort"></th>
	</tr>
	<?
	foreach($clubs as $club) {
		$club_id = $club[0];
		$club_name = $club[1];
		echo "<tr class=\"club_info\"><td><a href=\"club_detail.php?id=$club_id\">" . $club_name . "</a></td><td>" . $clubStart[$club_id] . "</td><td>" . $clubClose[$club_id] . "</td><td>";
		?>
		<form action="addClub.php" method="POST">
		<div class="buttons"><button name="club" value="<?=$club_id?>" class="add">Add</button></div>
		</form>
		
		<?
		echo "</td></tr>";
	}
?>
	
</table>
