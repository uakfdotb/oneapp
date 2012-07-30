<h2 class="separate">Clubs</h2>
<p>Applications are available between the open time and start time.</p>

<div width=100% align="center">
<form method="GET" action="addClub.php">
<input type="submit" value="Add club application" class="add">
</form>
<br />
</div>

<? if(count($clubs)>0) { ?>
		<div id="accordion">
		<? foreach($clubs as $clubid => $club) { 
			$club_name = $club[3][0];
		?>
			<div>
				<h3><a href="#"><?= $club_name ?></a></h3>
				<div>Club Info</div>
			</div>
		<? } ?>
		</div>
<? } else { ?>
	<p>You have no organizations added!</b>
<? } ?>


