<h1>Application preview</h1>

<?
page_advanced_include("category_manager", $context, array("categories" => $categories));
?>

<table>
<tr><td width="60%"></td><td></td></tr>
<?
foreach($questionList as $questionInfo) {
	writeField(0, 0, $questionInfo[0], $questionInfo[1], $questionInfo[2]);
}
?>
</table>
