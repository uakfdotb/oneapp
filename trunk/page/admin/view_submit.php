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

<table>
<tr>
	<th>User ID</th>
	<th>General application</th>
	<th>Supplement</th>
	<th>Recommendations and uploads</th>
	<?
	if($box_enabled) echo "<th>The Text Box</th>";
	if($cat_enabled) echo "<th>Category</th>";
	if($comment_enabled) echo "<th>Comments</th>";
	if($box_enabled || $cat_enabled) echo "<th>Update</th>"; //comments are updated through separate page
	?>
</tr>

<?
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
	
	$peerString = ""; //bad variable name; actually this will include files now
	
	foreach($item[4] as $peerEntry) {
		if($peerEntry[0] != "*") { //if this is not an uploaded file
			$peerString .= "<a href=\"../submit/$peerEntry.pdf\">PDF</a> (<a href=\"view_recommendation.php?peer_pdf=$peerEntry&user_id=" . $item[1] . "\">detail</a>) ";
		} else {
			$fileTuple = explode(",", substr($peerEntry, 1)); //now array of file id, filename
			$peerString .= "<a href=\"../download.php?file=" . $fileTuple[0] . "&filename=" . $fileTuple[1] . "\">" . $fileTuple[1] . "</a> ";
		}
	}
	
	echo "<tr>";
	echo "<td>$userId</td>";
	echo "<td>$generalApp</td>";
	echo "<td>$supplement</td>";
	echo "<td>$peerString</td>";
	
	if($box_enabled) {
		if(isset($toolsMap[$appId])) $boxValue = $toolsMap[$appId][0];
		else $boxValue = "";
		
		echo "<td><input type=\"text\" value=\"$boxValue\" name=\"box\" /></td>";
	}
	
	if($cat_enabled) {
		if(isset($toolsMap[$appId])) $catValue = $toolsMap[$appId][1];
		else $catValue = "";
		
		//display a list of categories, and pre-select the catValue on dropdown
		echo "<td><select name=\"category\">";
		echo "<option name=\"\">None</option>";
		
		foreach($catList as $catElement) {
			$selectedString = ($catElement == $catValue) ? " selected" : "";
			echo "<option name=\"$catElement\"$selectedString>$catElement</option>";
		}
		
		echo "</select></td>";
	}
	
	if($comment_enabled) {
		echo "<td><a href=\"comments.php?id=$appId\">comments</a></td>";
	}
	
	if($box_enabled || $cat_enabled) { //comments are updated through separate page
		echo '<td><input type="submit" value="update" /></td>';
	}
	
	if($box_enabled || $cat_enabled) echo "</form>";
	echo '</tr>';
}
?>

</table>
