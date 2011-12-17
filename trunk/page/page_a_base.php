<h1>General Application</h1>

<p>Click on one of the categories below to work on your general application. You may also be required to request peer recommendations as part of your application.</p>

<ul>
<?
foreach($categories as $item) {
	$cat_id = $item[0];
	$cat_name = $item[1];
	echo "<li><a href=\"app.php?club_id=0&cat_id=$cat_id&action=view\">$cat_name</a></li>";
}
?>
</ul>
