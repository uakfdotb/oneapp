<h1>Easy Question Adder</h1>

<p>This tool generates questions in the three-line format. You can then copy and paste the generated content into the multi-add form in your question manager. First, select a type from the list.</p>

<ul>
<li><a href="easy_question.php?type=text&<?= $t_get ?>">Plain text (this does not have any answer choices)</a></li>
<li><a href="easy_question.php?type=select&<?= $t_get ?>">Selection (checkbox, radio button, or dropdown)</a></li>
<li><a href="easy_question.php?type=short&<?= $t_get ?>">Short answer (single line)</a></li>
<li><a href="easy_question.php?type=essay&<?= $t_get ?>">Essay response (multiple lines)</a></li>
</ul>
