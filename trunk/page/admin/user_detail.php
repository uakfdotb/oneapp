<h1>User details</h1>

<?
echo "<b>Username</b>: $username<br>";
page_advanced_include("user_profile", "apply", array('profile' => $profile));
?>
