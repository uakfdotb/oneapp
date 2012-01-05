<h1>Club management</h1>

<!-- This page uses datetimepicker, from http://www.rainforestnet.com/datetimepicker/datetimepicker.htm, which is free software released under the GNU GPL v3.0. OneApp is not affiliated with this software. -->

<SCRIPT LANGUAGE="JavaScript" SRC="../astyle/style1/datetimepicker/datetimepicker_css.js"></SCRIPT>
<form method="post" action="man_club.php">
Description<br> <textarea name="description"><?= $description ?></textarea><br>
View time <input type="text" id="view_time" name="view_time" value="<?= date('m/d/y H:i:s', $view_time) ?>" /><img src="../astyle/style1/datetimepicker/images/cal.gif" onclick="javascript:NewCssCal('view_time', 'MMddyyyy', 'arrow', true)" style="cursor:pointer"/>  MM/DD/YY (hh:mm:ss)<br>
Open time <input type="text" id="open_time" name="open_time" value="<?= date('m/d/y H:i:s', $open_time) ?>" /><img src="../astyle/style1/datetimepicker/images/cal.gif" onclick="javascript:NewCssCal('open_time', 'MMddyyyy', 'arrow', true)" style="cursor:pointer"/><br>
Close time <input type="text" id="close_time" name="close_time" value="<?= date('m/d/y H:i:s', $close_time) ?>" /><img src="../astyle/style1/datetimepicker/images/cal.gif" onclick="javascript:NewCssCal('close_time', 'MMddyyyy', 'arrow', true)" style="cursor:pointer"/><br>
Number of recommenations <input type="text" name="num_recommend" value="<?= $num_recommend ?>" /><br>
<input type="submit" value="Update" />
</form>
