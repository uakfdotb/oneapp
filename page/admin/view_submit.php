<h1>View submissions</h1>

<p>A list of submissions appears below. Certain features allow you to better organize your submissions if you are evaluating them online, and can be enabled <a href="man_notes.php">here</a>. Otherwise, simply print the general application, supplement, and any peer recommendations for the users.</p>

<?
//box filter manager
if($box_enabled) { //just show a field with the filter text written by default
?>
	<form method="POST" action="view_submit.php">
	Textbox filter: <input type="text" name="boxFilter" value="<?= $boxFilter ?>">
	<input type="submit" value="Filter">
	</form>
<?
}

//category filter manager
if($cat_enabled) { // here, we give user a filter selection dropdown, preselecting the current filter if any
?>
	<form method="POST" action="view_submit.php">
	Category filter: <select name="catFilter">
	<option value="">No filtering</option>
	
	<?
	foreach($catList as $catElement) {
		$selectedString = ($catElement == $catFilter) ? " selected" : "";
		echo "<option value=\"$catElement\"$selectedString>$catElement</option>";
	}
	?>
	
	</select><input type="submit" value="Filter">
	</form>
<?
}
?>

<table width="100%"><tr>
	<th><p class="admin_table_header">App ID</p></th>
	<th><p class="admin_table_header">User ID</p></th>
	<th><p class="admin_table_header">General application</p></th>
	<th><p class="admin_table_header">Supplement</p></th>
	<th><p class="admin_table_header">Recommendations</p></th>
	<?
	if($box_enabled) echo "<th><p class=\"admin_table_header\">The Box</p></th>";
	if($cat_enabled) echo "<th><p class=\"admin_table_header\">Category</p></th>";
	if($comment_enabled) echo "<th><p class=\"admin_table_header\">Comments</p></th>";
	if($box_enabled || $cat_enabled) echo "<th><p class=\"admin_table_header\">Update</p></th>"; //comments are updated through separate page
	?>
</tr>

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
	$generalApp = '<a href="../submit/' . $item[2] . '.pdf">Download</a>';
	$supplement = '<a href="../submit/' . $item[3] . '.pdf">Download</a>';
	
	$peerString = "";
	foreach($item[4] as $peerEntry) {
	$band_counter=$counter%2+1;
		$peerString .= "<a href=\"../submit/$peerEntry.pdf\">PDF</a> (<a href=\"view_recommendation.php?peer_pdf=$peerEntry&user_id=" . $item[1] . "\">detail</a>) ";
	}

	echo "<tr class=\"band" . $band_counter . "\"><td class=\"top_border\"><p>$appId</p></td><td class=\"top_border\"><p>$userId</p></td><td class=\"top_border\"><p>$generalApp</p></td><td class=\"top_border\"><p>$supplement</p></td><td class=\"top_border\"><p>$peerString</p></td>";
	
	if($box_enabled) {
		if(isset($toolsMap[$appId])) $boxValue = $toolsMap[$appId][0];
		else $boxValue = "";
		
		echo "<td class=\"top_border\"><input type=\"text\" value=\"$boxValue\" name=\"box\" style=\"width:100%;resize:none\"/></td>";
	}
	
	if($cat_enabled) {
		if(isset($toolsMap[$appId])) $catValue = $toolsMap[$appId][1];
		else $catValue = "";
		
		//display a list of categories, and pre-select the catValue on dropdown
		echo "<td class=\"top_border\" width=100%><select name=\"category\">";
		echo "<option name=\"\">None</option>";
		
		foreach($catList as $catElement) {
			$selectedString = ($catElement == $catValue) ? " selected" : "";
			echo "<option name=\"$catElement\"$selectedString>$catElement</option>";
		}
		
		echo "</select></td>";
	}
	
	if($comment_enabled) {
		echo "<td class=\"top_border\"><p><a href=\"comments.php?id=$appId\">comments</a></p></td>";
	}
	
	if($box_enabled || $cat_enabled) { //comments are updated through separate page
		echo '<td class=\"top_border\"><input type="submit" value="update" /></td>';
	}
	
	if($box_enabled || $cat_enabled) echo "</form>";
	echo '</tr>';
}
?>

</table>
