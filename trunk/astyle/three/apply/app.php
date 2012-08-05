<h2 class="separate"><?= $title ?></h2>
<p>Please note we highly recommend that you first enter your responses in a separate Word software before submitting your answers on this page! </p>
<?
if($club_id == 0) {
	writeApplication($user_id, $app_id, $cat_id);
} else {
	writeApplication($user_id, $app_id);
}
?>
