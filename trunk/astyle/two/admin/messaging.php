<h1>Messaging</h1>

<p>This page allows you to send a message to your organization. Replies to these messages will be directed to your email address (see club settings), so make sure that that is set first.</p>

<form method="POST" action="messaging.php">
<?= $t_hidden ?>
Select recipient group
<br /><input type="radio" name="target" value="subscribe" checked />Subscribed users</input>
<br /><input type="radio" name="target" value="all" />All applicants</input>
<br /><input type="radio" name="target" value="complete" />Applicants who have submitted their applications</input>
<br /><input type="radio" name="target" value="uncomplete" />Applicants who have not submitted their applications</input>
<br />Subject: <input type="text" name="subject" />
<br />Enter your plain-text message below:
<br /><textarea name="body" rows="10" cols="40"></textarea>
<br /><input type="submit" value="Send">
</form>
