<script type="text/javascript">
$("JQUERY SELECTOR").simpletip({ 
	position: 'right', 
	offset: [30, 0],
	content: 'TESTING'
}); 
</script>

<h1>View submissions</h1>

<p>A list of submissions appears below. Certain features allow you to better organize your submissions if you are evaluating them online, and can be enabled <a href="man_notes.php">here</a>. Otherwise, simply print the general application, supplement, and any peer recommendations for the users.</p>

<?
//box filter manager
if($box_enabled) { //just show a field with the filter text written by default
?>
	<form method="POST" action="view_submit.php">
	<table style="margin:5px auto"><tr><td style="padding-right:10px">Textbox filter</td><td><input type="text" name="boxFilter" value="<?= $boxFilter ?>"></td><td><input type="submit" value="Filter"></td></tr></table>
	</form>
<?
}

//category filter manager
if($cat_enabled) { // here, we give user a filter selection dropdown, preselecting the current filter if any
?>
	<form method="POST" action="view_submit.php">
	<table style="margin:5px auto"><tr><td style="padding-right:10px">Category filter</td><td><select name="catFilter">
	<option value="">No filtering</option>
	
	<?
	foreach($catList as $catElement) {
		$selectedString = ($catElement == $catFilter) ? " selected" : "";
		echo "<option value=\"$catElement\"$selectedString>$catElement</option>";
	}
	?>
	
	</select></td><td><input type="submit" value="Filter">
	</td></tr></table>
	</form>
<?
}
?>

<table class="tbl_repeat"><tr>
	<!--<th><p class="admin_table_header">App ID</p></th>-->
	<th><p class="admin_table_header">ID</p></th>
	<th><p class="admin_table_header">GenApp</p></th>
	<th><p class="admin_table_header">OrgApp</p></th>
	<th><p class="admin_table_header">Recs</p></th>
	<?
	if($box_enabled) echo "<th><p class=\"admin_table_header\">TheTextBox</p></th>";
	if($cat_enabled) echo "<th><p class=\"admin_table_header\">Category</p></th>";
	if($comment_enabled) echo "<th></th>";
	if($box_enabled || $cat_enabled) echo "<th><p class=\"admin_table_header\"></p></th>"; //comments are updated through separate page
	?>
</tr>

<script type="text/javascript" src="<?=$stylePath?>/jquery.js"></script>

<script type="text/javascript">
$(document).ready(function(){

	$(".menu a").hover(function() {
		$(this).next("em").animate({opacity: "show", top: "-75"}, "slow");
	}, function() {
		$(this).next("em").animate({opacity: "hide", top: "-75"}, "fast");
	});
	$(".menu em").hover(function() {
		$(this).animate({opacity: "show", top: "-75"}, "fast");
	}, function() {
		$(this).animate({opacity: "hide", top: "-85"}, "fast");
	});
	
});
</script>

<?
$counter=1;
foreach($array as $item) {
	$appId = $item[0];
	
	//filtering; skip if match fails
	// TODO: figure out how to put this in view_submit.php
	if($box_enabled && $boxFilter != "" && (!isset($toolsMap[$appId]) || strpos($toolsMap[$appId][0], $boxFilter) === FALSE)) continue;
	if($cat_enabled && $catFilter != "" && (!isset($toolsMap[$appId]) || $toolsMap[$appId][1] != $catFilter)) continue;
	
	//form needed in case the update categories or box
	if($box_enabled || $cat_enabled) echo "<form method=\"post\" action=view_submit.php?id=$appId>";
	
	$userId = '<a href="user_detail.php?id=' . $item[1] . '">' . $item[1] . '</a>';
	$generalApp = '<a href="../submit/' . $item[2] . '.pdf"><img src="'. $stylePath . '/images/application_word.png" width="32"></a>';
	$supplement = '<a href="../submit/' . $item[3] . '.pdf"><img src="'. $stylePath . '/images/application_word.png" width="32"></a>';
	
	$peerString = ""; //bad variable name; actually this will include files now
	foreach($item[4] as $peerEntry) {
		$user_id = $item[1];
		$rec_result = mysql_query("SELECT author, email FROM recommendations WHERE filename = '$peerEntry' AND user_id = '$user_id'");
		$row = mysql_fetch_array($rec_result);
		$author = $row[0];
		$email = $row[1];
		
		if($peerEntry[0] != "*") { //if this is not an uploaded file
		$peerString .= "<ul class=\"menu\"><li><a href=\"../submit/$peerEntry.pdf\"><img src=\"". $stylePath . "/images/contact.png\" width=\"32\"></a><em><p>Recommender: ". $author ."<br />Email: ". $email ."</p></em></li></ul>";
		} else {
			$fileTuple = explode(",", substr($peerEntry, 1)); //now array of file id, filename
			$peerString .= "<ul class=\"menu\"><li><a href=\"../download.php?file=" . $fileTuple[0] . "&filename=" . $fileTuple[1] . "\"><img src=\"". $stylePath . "/images/contact.png\" width=\"32\"></a><em><p>Filename: " . $fileTuple[1] . "</p></em></li></ul>";
		}
	}
	
	$band_counter=$counter%2+1;
	echo "<tr><td><p>$userId</p></td><td align=\"center\"><p>$generalApp</p></td><td align=\"center\"><p>$supplement</p></td><td align=\"center\"><p>$peerString</p></td>";
	
	if($box_enabled) {
		if(isset($toolsMap[$appId])) $boxValue = $toolsMap[$appId][0];
		else $boxValue = "";
		
		echo "<td><input type=\"text\" value=\"$boxValue\" name=\"box\" style=\"width:100%;resize:none\"/></td>";
	}
	
	if($cat_enabled) {
		if(isset($toolsMap[$appId])) $catValue = $toolsMap[$appId][1];
		else $catValue = "";
		
		//display a list of categories, and pre-select the catValue on dropdown
		echo "<td width=100%><select name=\"category\">";
		echo "<option name=\"\">None</option>";
		
		foreach($catList as $catElement) {
			$selectedString = ($catElement == $catValue) ? " selected" : "";
			echo "<option name=\"$catElement\"$selectedString>$catElement</option>";
		}
		
		echo "</select></td>";
	}
	
	if($comment_enabled) {
		echo "<td><a href=\"comments.php?id=$appId\"><button class=\"comment\"></button></a></td>";
	}
	
	if($box_enabled || $cat_enabled) { //comments are updated through separate page
		echo '<td><input type="submit" value="Update" class="update"/></td>';
	}
	
	if($box_enabled || $cat_enabled) echo "</form>";
	echo '</tr>';
}
?>

</table>
