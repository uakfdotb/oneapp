<html>
<head><title><?= $config['site_name'] ?></title></head>
<body>

<ul>
<?
for($i = 0; $i < count($page_display); $i++) {
	echo '<li><a href=' . $page_display[$i] . '.php>' . $page_display_names[$i] . '</a></li>';
}
?>
</ul>

<ul>
<?
for($i = 0; $i < count($side_display); $i++) {
	echo '<li><a href=' . $side_display[$i] . '.php>' . $side_display_names[$i] . '</a></li>';
}
?>
</ul>

<p>The time is <?= $timeString ?></p>
