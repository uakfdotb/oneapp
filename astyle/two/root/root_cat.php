<h1><?= $cat ?></h1>

<p><?= $config['root_cat_display'][$cat]['desc'] ?></p>

<ul>
<?
	$root_display = $config['root_cat_display'][$cat]['links'];
	$root_display_names = $config['root_cat_display'][$cat]['names']; 
	
	for($j = 0; $j < count($root_display); $j++) {
		echo '<li><a href=' . $root_display[$j] . '.php>' . $root_display_names[$j] . '</a></li>';	
	}
?>
</ul>
