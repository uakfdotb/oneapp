<h1>Easy Q Adder</h1>

<p>The three-line format has been generated and should appear below. You may wish to <a href="easy_question.php">try again</a> or press the button below to add your question.</p>

<form method="POST" action="man_questions.php">
<input type="hidden" name="action" value="Add multiple questions" />
<textarea name="data" cols="60" rows="10"><?= $generate ?></textarea>
<br /><input type="submit" value="Add your question" />
</form>