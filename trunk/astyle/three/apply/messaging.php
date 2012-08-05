<?
function displayBoxSelector($boxes, $default_box = -1, $select_name = "box_id") {
?>
	<select name="<?= $select_name ?>">
	<option value="0">None</option>
	<? foreach($boxes as $box_array) { //box_array is array(box id, box name) ?>
		<option value="<?= $box_array[0] ?>" <? if($box_array[0] == $default_box) echo "selected"; ?>><?= $box_array[1] ?></option>
	<? } ?>
	</select>
<? } ?>

<script>
var $tab_title_input = $( "#tab_title"),
	$tab_content_input = $( "#tab_content" );
var tab_counter = 0;

function showmessage(message_id) {
	var message_data = new Array(<?= count($message_details) ?>);
	var message_data_checker = new Array(<?= count($message_details) ?>);
	for (var i = 0; i < <?= count($message_details) ?>; i++) {
    	message_data[i] = new Array(7);
  	}

	<? $counter = 0;
	foreach($message_details as $mess_id => $mess_data) {
		$sender_id = $mess_data[0];
		$sender_name = $mess_data[1];
		$sender_user = $mess_data[2];
		$reciever_id = $mess_data[3];
		$reciever_name = $mess_data[4];
		$reciever_user = $mess_data[5];
		$title = $mess_data[6];
		$content = $mess_data[7];
		$timestamp = $mess_data[8];
		echo "message_data_checker[$counter]=$mess_id;\n";
		echo "message_data[$counter][0]=\"$sender_name\";\n";
		echo "message_data[$counter][1]=\"$reciever_name\";\n";
		echo "message_data[$counter][2]=\"" . timeString($timestamp) . "\";\n";
		echo "message_data[$counter][3]=\"" . htmlspecialchars_decode($title) . "\";\n";
		echo "message_data[$counter][4]=\"" . htmlspecialchars_decode($content). "\";\n";
		echo "message_data[$counter][5]=\"$sender_user\";\n";
		echo "message_data[$counter][6]=\"$reciever_user\";\n";
		$counter++;
	} ?>
	var message_loc = jQuery.inArray(message_id, message_data_checker);
	// tabs init with a custom tab template and an "add" callback filling in the content
	var $tabs = $( "#tabs").tabs({
		tabTemplate: "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close'>Remove Tab</span></li>",
		add: function( event, ui ) {
			var tab_sender = message_data[message_loc][0];
			var tab_reciever = message_data[message_loc][1];
			var tab_time = message_data[message_loc][2];
			var tab_subject = message_data[message_loc][3];
			var tab_content = message_data[message_loc][4];
			var sender = message_data[message_loc][5];
			$( ui.panel ).append( "<div class=\"message\"><p class=\"subject\">" + tab_subject + "</p><p class=\"date\"><label>From: </label><a href=\"#\" onclick=\"writemessage('" + sender + "')\">" + tab_sender + " (" + sender + ")</a></p><p class=\"date\"><label>To: </label>" + tab_reciever + "</p><p class=\"date separate\"><label>Time: </label>" + tab_time + "</p><p class=\"content\">" + tab_content + "</p></div>" );
		}
	});
	var tab_title = message_data[message_loc][3];
	if(tab_title.length > 10 ) {
		tab_title = tab_title.substring(0,7) + '...';
	}
	$tabs.tabs( "add", "#tabs-" + tab_counter , tab_title );
	var index = $tabs.tabs("length");
	$tabs.tabs( 'select' , index-1 );
	tab_counter++;
}

function writemessage(username) {
	$('input[name=to]').val(username);
	$( "#tabs").tabs( 'select' , 3 );
	alert();
}

</script>
<h2 class="separate">Messaging</h2>

<p>Select a messaging tool below:</p>

<style>
#tabs li .ui-icon-close { float: left; margin: 0.4em 0.2em 0 0; cursor: pointer; }
</style>

<div id="tabs">
	<ul>
		<li><a href="#inbox">Inbox</a></li>
		<li><a href="#sent">Sent</a></li>
		<li><a href="#trash">Trash</a></li>
		<? foreach($boxes as $box) {
			$box_name = $box[1];
			if($box[0] == $prefs[1]) {
				//already added
			} else if($box[0] == $prefs[2]) {
				//already added
			} else if($box[0] == $prefs[3]) {
				//already added
			} else {
				echo "<li><a href=\"#custom_$box_name\">$box_name</a></li>";
			}
		}
		?>
		<li><a href="#compose">Compose</a></li>
<!--	<li><a href="#prefs">Preferences</a></li> -->
	</ul> 
<? foreach($boxes as $box) {
	$box_id = $box[0];
	if($box_id == $prefs[1]) {
		$box_name = "inbox";
	} else if($box_id == $prefs[2]) {
		$box_name = "trash";
	} else if($box_id == $prefs[3]) {
		$box_name = "sent";
	} else {
		$box_name = "custom_" . $box[1];
	}
	?>
	<div id="<?= $box_name ?>">
		<table class="styled" width=100%>
		<tr>
			<th>From</th>
			<th>To</th>
			<th>Subject</th>
			<th>Date</th>
		</tr>
	
	<? if(count($messages[$box_id]) != 0 ) {
		foreach($messages[$box_id] as $message) { //message is array(message id, sender id, sender username, receiver id, receiver username, subject, time int) ?>
		<tr>
		<td><a href="#" onclick="writemessage('<?= $message[2] ?>')"><?= $message[2] ?></a></td>
		<td><a href="#" onclick="writemessage('<?= $message[4] ?>')"><?= $message[4] ?></a></td>
		<td><a href="#" onclick="showmessage(<?= $message[0] ?>)"><?= $message[5] ?></a></td>
		<td><?= timeString($message[6]) ?></td>
		</tr>
	<? }
	} else { ?>
		<tr><td colspan="4" align="center"><b>You have no messages in <?= $box[1] ?>!</b></td></tr>
	<? } ?>
	
	</table>
	</div>
<? } ?>
<div id="compose">
	<form method="post" action="messaging.php?action=send" class="uniForm fullwidth" />
	<fieldset>
		<input type="hidden" name="action" value="send">
		<div class="ctrlHolder">
			<label>To</label><input type="text" name="to" value="<?= $reciever ?>" style="width:100%" />
		</div>
		<div class="ctrlHolder">
			<label>Subject</label><input type="text" name="subject" style="width:100%" />
		</div>
		<div class="ctrlHolder">
			<label>Message</label><textarea name="body"  style="width:100%" ></textarea>
		</div>
	<div class="buttonHolder"><input type="submit" value="Send" class="send primaryAction"/></div>
	</fieldset>
	</form>
</div>
<!-- <div id="prefs">
	<form class="uniForm" method="get">
	<input type="hidden" name="action" value="button">
	<fieldset>
	<h3>Manage Boxes</h3>
	<? foreach($boxes as $box_array) { //box_array is array(box id, box name) ?>
		<div class="ctrlHolder"><label><?= $box_array[1] ?></label><p class="formHint">
		<button name="box_id" value="<?= $box_array[0] ?>" class="delete negative right">Delete</button>
		</p></div>
	<? } ?>
	
	<div class="ctrlHolder"><label>Box name</label><input type="text" name="name" /><p class="formHint"><input type="submit" value="Add box" class="add right"/></p></div>
	</fieldset>
	</form>
</div> -->
</div>

