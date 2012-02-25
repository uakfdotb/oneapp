<h1>Database Management</h1>

<p>This page lists the many features from which you may manage your database. Please click on one of the links below to access these features.</p>

<ul>
<?
	$root_database_display = $config['root_database_display'];
	$root_database_display_names = $config['root_database_display_names']; 
	for($j = 0; $j < count($root_database_display); $j++) {
		echo '<li><a href=' . $root_database_display[$j] . '.php>' . $root_database_display_names[$j] . '</a></li>';	
	}
?>
</ul>
