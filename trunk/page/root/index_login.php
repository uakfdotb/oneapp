<h1>Root Administration Area</h1>

<!-- TODO: store sha1(root password) in config.php -->
<p>Please login with your root password to access the root administration area. Your root password is stored in plaintext in config.php, and can be reset there manually using a text editor if necessary.</p>

<form method="POST" action="index.php">
Password: <input type="password" name="password"><br>
<input type="submit" name="submit" value="Submit">
</form>
