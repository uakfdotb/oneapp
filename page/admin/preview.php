<?
page_advanced_include("category_manager", $context, array("categories" => $categories));
?>

<table>
<?
foreach($questionList as $questionInfo) {
	writeField(0, 0, $questionInfo[0], $questionInfo[1], $questionInfo[2]);
}
?>
</table>
