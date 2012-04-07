<h1>Club manager</h1>

<p>This manager allows you to add, remove, and edit clubs. If you delete a club that has a supplement, the supplement will no longer be accessible (and you can delete these residual questions through the <a href="check_nohome">Delete questions without a home</a> tool). Also, you will need to create one or more admins for a club before the club information can be edited.</p>
<br />
<form action="man_clubs.php?action=add_club" method="post">
<table style="margin:0 auto" bgcolor=#F2F5F7>
<tr><td><p>Club name</p></td><td><p><input type="text" name="name" style="width:100%"></p></td></tr>
<tr><td><p>Description</p></td><td><p><textarea name="description" style="width:100%;resize:vertical"></textarea></p></td></tr>
<tr><td colspan="2" align="right"><input type="submit" value="Add club" class="add"></td></tr>
</table>
</form>

<br /><br />
<table class="tbl_repeat">
<?
$counter =0;
while($row = mysql_fetch_array($clubsResult)) {
	if($counter > 0) {
		$class_string = "class=\"top_border\"";
	} else {
		$class_string = "";
	}
	
	$band_class = ($counter + 1) % 2 + 1;
?>
	<tr><table <?=$class_string?> width=100% cellspacing=0>
	<tr class="band<?=$band_class?>"><td colspan="2" height=10</tr>
	<form method="post" action="man_clubs.php">
	<input type="hidden" name="id" value="<?= $row['id'] ?>">
	<tr class="band<?=$band_class?>"><td width=20%><p style="font-weight:bold">Club ID:</p></td><td><p><?= $row['id'] ?></p></td></tr>
	<tr class="band<?=$band_class?>"><td><p style="font-weight:bold">Club Name:</p></td><td><p><?= $row['name'] ?></p></td></tr>
	<tr class="band<?=$band_class?>" align="center"><td colspan="2"><p style="font-weight:bold" align="left">Description:</p><textarea name="description" style="width:95%;height:100;resize:none" class="band<?=$band_class?>"><?= $row['description'] ?></textarea></td></tr>
	<tr class="band<?=$band_class?>"><td></td><td align="right"><input type="submit" name="action" value="update"><input type="submit" name="action" value="delete"><br></td></tr>
	</form>
	<tr class="band<?=$band_class?>"><td colspan="2" height=10px></td></tr>
	</table></tr>
<?
	$counter=$counter+1;
}
?>
</table>
