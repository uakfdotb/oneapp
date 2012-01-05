<h1>Club detail: <?= $clubInfo[0] ?></h1>

<p><?= htmlentities($clubInfo[1]) ?></p>

<p>Submission window: between <?= $clubInfo[2] ?> and <?= $clubInfo[3] ?><br />
Number of recommendations required: <?= $clubInfo[4] ?></p>

<? if($checkStatus == 0) { // application is editable ?>
<p>You may wish to <a href="submit.php?app_id=<?= $app_id ?>&club_id=<?= $club_id ?>">submit</a> your application or work on your <a href="app.php?club_id=<?= $club_id ?>&action=view">supplement</a>.</p>
<? } else if($checkStatus == -1) { //application has been submitted ?>
<p>Your application has been submitted. You can still <a href="app.php?club_id=<?= $club_id ?>&action=view">view your supplement</a>.
<? } else if($checkStatus == -3) { //supplement submission has closed ?>
<p>You cannot submit your supplement for this club.</p>
<? } else { ?>
<p>The state of your application is unknown.</p>
<? } ?>
