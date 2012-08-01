<h1>Club management</h1>
	<div class="example-container">
		<pre>
		$(function() {
			$( "#slider-range-min" ).slider({
				range: "min",
				value: <? if($num_recommend!="") echo $num_recommend; else echo "0"; ?>,
				min: 0,
				max: <?= $config['max_recommend']?>,
				slide: function( event, ui ) {
					$( "#amount" ).val( ui.value );
				}
			});
			$( "#amount" ).val( $( "#slider-range-min" ).slider( "value" ) );
		});
		var ex11 = $('#view_time');
		ex11.datetimepicker('setDate', new Date(<?= date('Y,m,d,H,i', $view_time) ?>));
		var ex12 = $('#open_time');
		ex12.datetimepicker('setDate', new Date(<?= date('Y,m,d,H,i', $open_time) ?>));
		var ex13 = $('#close_time');
		ex13.datetimepicker('setDate', new Date(<?= date('Y,m,d,H,i', $close_time) ?>));
		
		$('#view_time').datetimepicker({
			numberOfMonths: 2,
			maxDate: new Date(<?= date('Y,m,d,H,i', $open_time) ?>),
			onClose: function(dateText, inst) {
				var endDateTextBox = $('#open_time');
				if (endDateTextBox.val() != '') {
				    var testStartDate = new Date(dateText);
				    var testEndDate = new Date(endDateTextBox.val());
				    if (testStartDate > testEndDate)
				        endDateTextBox.val(dateText);
				}
				else {
				    endDateTextBox.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				var start = $(this).datetimepicker('getDate');
				$('#open_time').datetimepicker('option', 'minDate', new Date(start.getTime()));
				}
		});
		$('#open_time').datetimepicker({
			numberOfMonths: 2,
			minDate: new Date(<?= date('Y,m,d,H,i', $view_time) ?>),
			maxDate: new Date(<?= date('Y,m,d,H,i', $close_time) ?>),
			onClose: function(dateText, inst) {
				var endDateTextBox = $('#close_time');
				if (endDateTextBox.val() != '') {
				    var testStartDate = new Date(dateText);
				    var testEndDate = new Date(endDateTextBox.val());
				    if (testStartDate > testEndDate)
				        endDateTextBox.val(dateText);
				}
				else {
				    endDateTextBox.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				var start = $(this).datetimepicker('getDate');
				$('#close_time').datetimepicker('option', 'minDate', new Date(start.getTime()));
			}
		});
		$('#close_time').datetimepicker({
			numberOfMonths: 2,
			minDate: new Date(<?= date('Y,m,d,H,i', $open_time) ?>),
			onClose: function(dateText, inst) {
				var startDateTextBox = $('#open_time');
				if (startDateTextBox.val() != '') {
				    var testStartDate = new Date(startDateTextBox.val());
				    var testEndDate = new Date(dateText);
				    if (testStartDate > testEndDate)
				        startDateTextBox.val(dateText);
				}
				else {
				    startDateTextBox.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				var end = $(this).datetimepicker('getDate');
				$('#open_time').datetimepicker('option', 'maxDate', new Date(end.getTime()) );
			}
		});
		
		$(function() {
			$( "#tabs" ).tabs();
		});
		</pre>
	</div>

<p>Here, you can edit settings for your club. View time is the time at which your club will be available for addition into a user's supplement list. Open time is the time when the club supplement can be submitted. Close time is the submission deadline. The number of recommendations field is the required number of recommendations for your club; there is no upper limit on the number that can be submitted, except the maximum number of recommendations a user can request (set in the configuration file).</p>

<br />
<form method="post" action="man_club.php">
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Club Settings</a></li>
		<li><a href="#tabs-2">My Account</a></li>
	</ul>
<div id="tabs-1">
<table widh=100%>
<tr>
	<td width=50%><p class="name">Organization</p></td>
	<td><p class="name"><?= $club_name ?></p></td>
</tr>
<tr>
		<td colspan="2"><p class="name">Description</p></td><tr><td colspan="2"><p><textarea name="description" style="width:95%;resize:vertical;min-height:50px"><?= $description ?></textarea></p></td></tr>
		<tr><td><p class="name">View time</p></td><td><p><input type="text" id="view_time" name="view_time" value="<?= date('m/d/Y H:i', $view_time) ?>" style="width:230px"/></p></td></tr>
		<tr><td width=50%><p class="name">Open time</p></td><td><p><input type="text" id="open_time" name="open_time" value="<?= date('m/d/Y H:i', $open_time) ?>" style="width:230px"/></p></td></tr>
		<tr><td><p class="name">Close time</p></td><td><p><input type="text" id="close_time" name="close_time" value="<?= date('m/d/Y H:i', $close_time) ?>" style="width:230px"/></p></td></tr>
		<tr><td><p class="name"><label for="amount">Number of recommendations: </label><input type="text" name="num_recommend" id="amount" style="border:0; font-weight:bold; width: 50px" readonly="readonly" /></p></td><td><p><div id="slider-range-min" style="width:230px; margin-left:10px"></div></p></td></tr>
</table>
</div>
<div id="tabs-2">
<table width=100%>
<tr>
	<td><p class="name">Name</p></td>
	<td><p class="name"><?= $name ?></p></td>
</tr>
<tr>
	<td><p class="name">Username</p></td>
	<td><p class="name"><?= $username ?></p></td>
</tr>
<tr>
	<td><p class="name">Email</p></td>
	<td><p><input type="text" name="email" style="width:230px" value="<?= $email ?>"/></p></td>
</tr>
<tr>
	<td><p class="name">New password</p><p class="desc">To change your password, fill in this and the below field</p></td>
	<td><p><input type="password" name="new_password" style="width:230px"/></p></td>
</tr><tr>
	<td><p class="name">Confirm new password</p></td>
	<td><p><input type="password" name="new_password_conf" style="width:230px" /></p></td>
</tr>
</table>
</div>
</div>
<table width=100%>
	<tr><td><p class="name required">Old password</p><p class="desc">Enter old password here to update information</p></td>
	<td><p><input type="password" name="old_password" style="width:230px" class="right"/><br /><input type="submit" name="action" value="Update" class="update right"/></p></td></tr>
</table>
</form>
