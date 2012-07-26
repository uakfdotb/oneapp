<h1>Viewing events from <?= date('F j, Y', $timeStart) ?> to <?= date('F j, Y', $timeEnd - 1) ?></h1>

<? $duration = $timeEnd - $timeStart; ?>
<a href="calendar.php?time_start=<?= $timeStart - $duration ?>&time_end=<?= $timeEnd - $duration ?>">&lt;</a>
<a href="calendar.php?time_start=<?= $timeStart + $duration ?>&time_end=<?= $timeEnd + $duration ?>">&gt;</a>

<?php

page_advanced_include("calendar_$mode", "apply", array('events' => $events, 'reservables' => $reservables));

?>
