<html>
<head><title><?= $config['site_name'] ?></title></head>
<body>

<ul>
<?
for($i = 0; $i < count($page_display); $i++) {
	echo '<li><a href="' . $page_display[$i] . '">' . $page_display_names[$i] . '</a></li>';
}
?>
</ul>

<ul>
<?
for($i = 0; $i < count($side_display); $i++) {
	echo '<li><a href="' . $side_display[$i] . '">' . $side_display_names[$i] . '</a></li>';
}
?>
</ul>

<p>The time is <?= $timeString ?></p>

<?
if(isset($warning)) {
	echo "<p>" . $warning . "</p>";
}
if(isset($error)) {
	echo "<p>" . $error . "</p>";
}
if(isset($info)) {
	echo "<p>" . $info . "</p>";
}
if(isset($success)) {
	echo "<p>" . $success . "</p>";
}
if(isset($validation)) {
	echo "<p>" . $validation . "</p>";
}
?>
