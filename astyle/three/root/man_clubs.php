<h1><a href="root_cat.php?cat=Manage">Manage</a> > Clubs</h1>

<p>This manager allows you to add, remove, and edit clubs. If you delete a club that has a supplement, the supplement will no longer be accessible (and you can delete these residual questions through the <a href="check_nohome">Delete questions without a home</a> tool). Also, you will need to create one or more admins for a club before the club information can be edited.</p>
<br />
<form action="man_clubs.php?action=add_club" method="post">
<table style="margin:0 auto" bgcolor=#F2F5F7>
<tr><td><p>Club name</p></td><td><p><input type="text" name="name" style="width:100%"></p></td></tr>
<tr><td><p>Description</p></td><td><p><textarea name="description" style="width:100%;resize:vertical"></textarea></p></td></tr>
<tr><td><p>Balance</p></td><td><p><input type="text" name="money" style="width:100%"></p></td></tr>
<tr><td colspan="2" align="right"><input type="submit" value="Add club" class="add"></td></tr>
</table>
</form>

<br /><br />
<?
$counter =0;
while($row = mysql_fetch_array($clubsResult)) {
	$band_class = ($counter + 1) % 2 + 1;
?>
	<div class="nav-club <? if($band_class % 2 == 0) echo "alternate";?>" >
	<table width=100% cellspacing=0>
	<form method="post" action="man_clubs.php">
	<input type="hidden" name="id" value="<?= $row['id'] ?>">
	<tr><td width=20%><p class="bold">Club Name:</p></td><td><p class="left"><?= $row['name'] ?></p></td></tr>
	<tr><td><p class="bold">Club Balance:</p></td><td><p class="left"><?= display_money($row['money']) ?></p></td></tr>
	<tr><td colspan="2"><p class="bold left">Description:</p><p><textarea name="description" style="width:95%;height:100;resize:none" class="center" ><?= $row['description'] ?></textarea></p></td></tr>
	<tr><td><input type="submit" name="action" value="update" class="update left"></td><td><input type="submit" name="action" value="delete" class="delete negative right"><br></td></tr>
	</form>
	</table></div><br />
<?
	$counter=$counter+1;
}
?>
