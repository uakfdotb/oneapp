<h1>Manage</h1>

<p>This page lists the many features from which you may view users, add admins, organizations, general application categories, and custom pages. Please click on one of the links below to access these features.</p>

<ul>
<?
	$root_manage_display = $config['root_manage_display'];
	$root_manage_display_names = $config['root_manage_display_names']; 
	for($j = 0; $j < count($root_manage_display); $j++) {
		echo '<li><a href=' . $root_manage_display[$j] . '.php>' . $root_manage_display_names[$j] . '</a></li>';	
	}
?>
</ul>
