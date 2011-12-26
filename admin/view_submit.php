<html>
<body>
<h2>Hello, Administrator</h2>

<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

include("../include/apply_submit.php");

if(isset($_SESSION['admin_id'])) {
	$club_id = escape(getAdminClub($_SESSION['admin_id']));
	$array = listCompletedApplications($club_id);
?>
	<h1>Submissions list</h1>

	<p>The submissions for your club appear below. You received a total of <?= count($array) ?> submissions.</p>

	<table>
	<tr><th>App ID</th><th>User ID</th><th>General application</th><th>Supplement</th><th>Peer recommendations</th></tr>

	<?
	foreach($array as $item) {
		$appId = $item[0];
		$userId = '<a href="user_detail.php?id=' . $item[1] . '">' . $item[1] . '</a>';
		$generalApp = '<a href="../submit/' . $item[2] . '.pdf">' . $item[2] . '</a>';
		$supplement = '<a href="../submit/' . $item[3] . '.pdf">' . $item[3] . '</a>';
		
		$peerString = "";
		foreach($item[4] as $peerEntry) {
			$peerString .= '<a href="../submit/' . $peerEntry . '.pdf">' . $peerEntry . '</a> | ';
		}
	
		echo "<tr><td>$appId</td><td>$userId</td><td>$generalApp</td><td>$supplement</td><td>$peerString</td></tr>";
	}
	?>

	</table>

<?
}
?>

<a href="./">back</a>
</body>
</html>
