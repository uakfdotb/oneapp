<form method="post" action="man_club.php">
Description<br> <textarea name="description"><?= $description ?></textarea><br>
View time <input type="text" name="view_time" value="<?= date('m/d/y H:i:s', $view_time) ?>" /> MM/DD/YY (hh:mm:ss)<br>
Open time <input type="text" name="open_time" value="<?= date('m/d/y H:i:s', $open_time) ?>" /><br>
Close time <input type="text" name="close_time" value="<?= date('m/d/y H:i:s', $close_time) ?>" /><br>
Number of recommenations <input type="text" name="num_recommend" value="<?= $num_recommend ?>" /><br>
<input type="submit" value="Update" />
</form>
