<h1>Password reset</h1>

<p>Enter a new password below to proceed.</p>

<form action="reset.php?username=<?= $username ?>&email=<?= $email ?>&user_id=<?= $user_id ?>&auth=<?= $auth ?>&" method="POST">
Password: <input type="password" name="password">
<br>Password confirmation: <input type="password" name="password_confirm">
<br><input type="submit" value="Reset password">
</form>
