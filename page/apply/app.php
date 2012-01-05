<h1>Application</h1>

<?
if($club_id == 0) {
	writeApplication($user_id, $app_id, $cat_id);
} else {
	writeApplication($user_id, $app_id);
}
?>
