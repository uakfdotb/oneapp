<h1>Application preview</h1>

<?
page_advanced_include("category_manager", "admin", array("categories" => $categories));
?>

<table>
<?
if(count($questionList) == 0 ) {
	echo "<p>You don't have any questions in your application!</p>";
} else {
	foreach($questionList as $questionInfo) {
		writeField(0, 0, $questionInfo[0], $questionInfo[1], $questionInfo[2]);
	}
}
?>
</table>
