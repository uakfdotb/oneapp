<h1>Club detail: <?= $clubInfo[0] ?></h1>

<p><?= htmlentities($clubInfo[1]) ?></p>

<p>Submission window: between <?= $clubInfo[2] ?> and <?= $clubInfo[3] ?><br />
Number of recommendations required: <?= $clubInfo[4] ?></p>

<p>You may wish to <a href="submit.php?app_id=<?= $app_id ?>&club_id=<?= $club_id ?>">submit</a> your application or work on your <a href="app.php?club_id=<?= $club_id ?>&action=view">supplement</a>.</p>
