<h1>Club Statistics: <?= $club_name ?> (<?= $club_id ?>)</h1>

<p>Below are users who have applied to this club. <b>Users started</b> lists users who have started but not completed their application.</p>

<h3>Users started</h3>

<ul>
<? foreach($stat_array[0] as $usersStarted) { ?>
	<li><a href="user_detail.php?id=<?= $usersStarted[0] ?>"><?= $usersStarted[2] ?> (<?= $usersStarted[1] ?>)</a></li>
<? } ?>
</ul>

<h3>Users completed</h3>

<ul>
<? foreach($stat_array[1] as $usersCompleted) { ?>
	<li><a href="user_detail.php?id=<?= $usersCompleted[0] ?>"><?= $usersCompleted[2] ?> (<?= $usersCompleted[1] ?>)</a></li>
<? } ?>
</ul>
