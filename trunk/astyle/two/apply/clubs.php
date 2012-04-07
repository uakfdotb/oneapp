<h1>Clubs</h1>
<p>Applications are available between the open time and start time.</p>

<div width=100% align="center">
<form method="GET" action="addClub.php">
<input type="submit" value="Add club application" class="add">
</form>
</div>

<?
 	if(count($clubsApplied)>0) { ?>
	<table width=100% class="borderon">
	<tr>
		   <th colspan="3" class="table_header"><p>My Organizations</p></th>
	</tr>

	<?
		$i=0;
		$j=0;
		foreach($clubsApplied as $item){
			$clubid = $item[0];
			if($j==0){
				$firstclub=$clubid;
			}
			$club_name = $item[1];
			$app_id = $item[3];
			if($i==0) echo "<tr>";
			echo "<td class=\"orgname\" valign=\"middle\" ><a href=\"clubs.php?id=" . $clubid ."\" ";
			if($clubid==$club_id){ 
				echo "class=\"current\" ";
				$k=$j;
			}
			echo ">" . $club_name . "</td></a>";
			if($i==2) echo "</tr>";
			$i=($i+1)%3;
			$j=$j+1;
		}
	
		if($i==1) echo "<td class=\"orgname\"></td><td class=\"orgname\"></td></tr>";
		else if($i==2) echo "<td class=\"orgname\"></td></tr>";
	?>
	
</table>
<?
	if(isset($club_id)){
		$item = $clubsApplied[$k];
		$club_name = $item[1];
		$app_id = $item[3];
		$clubInfo = clubInfo($club_id);
?>	
		<br />
		<div align="center">
		<table width=80% class="borderon">
		<tr>
			   <th colspan="2" class="table_header"><p><?= $club_name ?></p></th>
		</tr>
		<tr class="club_info" class="band1">
			<td width=40%>Your Status</td><td><?= $clubStates[$club_id] ?></td>
		</tr>
		<tr class="club_info" class="band2">
			<td>Recommendations</td><td><?= $clubInfo[4] ?></td>
		</tr>
		<tr class="club_info" class="band1">
			<td>Available at</td><td><?= $clubStart[$club_id]?></td>
		</tr>
		<tr class="club_info" class="band2">
			<td>Deadline</td><td font-weight="bold"><?= $clubClose[$club_id]?></td>
		</tr>
		<tr class="club_info" class="band1">
			<td colspan="2">
				<div class="example2">
					<table width=100%>
					<?
							echo "<tr><td colspan=\"2\">" . $item[2] . "</td></tr>";
					?>
					</table>
				</div>
			</td>
		</tr>
		<tr class="club_info" class="band2">
			<td><form action="submit.php?app_id=<?=$item[3] ?>&club_id=<?=$item[0]?>"><input type="submit" value="Submit" class="positive" 
			<? if($clubStates[$club_id]!="<font color=\"blue\">Started</font>") echo "disabled=\"disabled\" ";?>
			></form></td>
			<td></td>
		</tr>
		</table>
		</div>
<?	
		}
	}
?>
