<html>
<head>
<link href="<?= $base_path ?>astyle/style1/style.css" rel="stylesheet" type="text/css">
<title>TAMSApp</title>
</head>

<body>
<div id="container">
	<div id="topbar" align="left">
		<table width=100% cellpadding="0" cellspacing="0" >
			<tr>
			<td><img src="<?= $base_path ?>astyle/style1/logo.jpg" alt="logo" height="60" /></td>
			<td VALIGN="BOTTOM"><p class="schooltop">SCHOOL NAME<p align="right">Not your school? <a href="#">Click Here</a></p></p></td>
			</tr>
		</table>
	</div>
	
	<div id="navbar">
<?
for($i = 0; $i < count($page_display); $i++) {
	echo '<a href=' . $page_display[$i] . '.php>' . $page_display_names[$i] . '</a> ';
}
?>
	</div>
	<div id ="main">
	<div id ="col_holder">
		<div id="col_left">
			<div id="side_bar">
				<ul style="margin-left: 10px; padding-left: 0;">

<?
for($i = 0; $i < count($side_display); $i++) {
	echo '<li class="sidenav"><a id="asidenav" href=' . $side_display[$i] . '.php>' . $side_display_names[$i] . '</a></li>';
}
?>
				</ul>
		</div>
	</div>
	<div id="col_right">
		<div id="box">
