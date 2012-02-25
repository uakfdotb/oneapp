<h1>Clean System</h1>

<p>This page lists the many ways you can clean your system to help us conserve database usage. To clean your system easily, please use <a href="http://demo.one-app.org/root/full_clean.php">Full Database Cleaner</a>. Please click on one of the links below to access these features.</p>

<ul>
<?
	$root_clean_display = $config['root_clean_display'];
	$root_clean_display_names = $config['root_clean_display_names']; 
	for($j = 0; $j < count($root_clean_display); $j++) {
		echo '<li><a href=' . $root_clean_display[$j] . '.php>' . $root_clean_display_names[$j] . '</a></li>';	
	}
?>
</ul>
