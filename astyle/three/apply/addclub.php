<h2 class="separate">Add Club</h2>
<p>From here, you can add any organization that is availble. You can sort organizations by click on the header you wish to sort by.</p>
<p>Click on a club to view its details.</p>
<br />
<table class="sortable styled" width=100%>
	<tr>
		<th width=30% align="left">Name</th>
		<th width=30% align="left">Deadline</th>
		<th class="sorttable_nosort"></th>
		<th class="sorttable_nosort"></th>
	</tr>
	<?
	foreach($clubs as $club) {
		$club_id = $club[0];
		$club_name = $club[1];
		$deadline = clubdue($club_id);
		?>
		<tr>
			<td><a href="#"><?= $club_name ?></a></td>
			<td><?= clubTimeString($deadline) ?></td>
			<td>
				<form action="addClub.php?mode=subscribe" method="POST">
				<button name="club" value="<?=$club_id?>" class="email_add">Subscribe</button>
				</form>
			</td>
			<td>
				<form action="addClub.php?mode=apply" method="POST">
				<button name="club" value="<?=$club_id?>" class="app_add" <?= (time() > $deadline) ? "disabled /> Not Availible" : " />Apply" ?></button>
				</form>
			</td>
		</tr>
	<?	} ?>
	
</table>
