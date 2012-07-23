<h1><a href="root_cat.php?cat=Statistics">Statistics</a> > <a href="statistics_club.php">Club</a> > <?= $club_name ?></h1>

<p>Below are users who have applied to this club. <b>Users started</b> lists users who have started but not completed their application.</p>

<table width=100%>
<tr><td width=50% valign="top" style="padding-right:10px">
<table class="tbl_repeat" title="These users have not yet submitted their application">
	<tr><th align="left">Started (<?= count($stat_array[0]) ?>)</th></tr>
<? foreach($stat_array[0] as $usersStarted) { ?>
	<tr><td><a href="user_detail.php?id=<?= $usersStarted[0] ?>"><?= $usersStarted[2] ?> (<?= $usersStarted[1] ?>)</a></td></tr>
<? } ?>
</table>
</td>
<td valign="top">

<table class="tbl_repeat">
	<tr><th align="left">Submitted (<?= count($stat_array[1]) ?>)</th></tr>
<? foreach($stat_array[1] as $usersCompleted) { ?>
	<tr><td><a href="user_detail.php?id=<?= $usersCompleted[0] ?>"><?= $usersCompleted[2] ?> (<?= $usersCompleted[1] ?>)</a></td></tr>
<? } ?>
</table>
</td>
</tr>
</table>
