<html>
<head>
<link href="style/style1/style1.css" rel="stylesheet" type="text/css">
<title><?= $config['site_name'] ?></title>
<?
if(isset($redirect)) {
	echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=' . $redirect . '">';	
}
?>
</head>
<body>
<div id="container">
	<div id="topbar" align="left">
		<table width=100% cellpadding="0" cellspacing="0" >
			<tr>
			<td><img src="images/logo.jpg" alt="logo" height="60" /></td>
			<td VALIGN="BOTTOM"><p class="schooltop">SCHOOL NAME<p align="right">Not your school? <a href="#">Click Here</a></p></p></td>
			</tr>
		</table>
	</div>

<div id="navbar">
<?
for($i = 0; $i < count($page_display); $i++) {
	echo '<a href=' . $page_display[$i] . '.php>' . $page_display_names[$i] . '</a>';
}
?>
</div>

<div id ="main">
		<div id="box">
