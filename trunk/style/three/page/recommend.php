<h2 class="separate">Peer recommendation submission</h2>

<?
if(isset($message) && $message != "") {
	echo "<p class=\"message\">$message</p>";
} else {
	echo '<p>Please fill in the fields below and press submit to submit your peer recommendation. You will not be able to modify any fields once you press submit; thus, you should first write your answers in a separate document. The responses will not be saved until you press submit.</p>';
}

writeRecommendation($id, $user_id, $auth);
?>
