<html>
<head>
<link href="<?= $stylePath ?>/style.css" rel="stylesheet" type="text/css">
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
			<td><a href="index.php"><img src="<?= $stylePath ?>/logo.jpg" alt="logo" height="60" border="0" /></td>
			<td VALIGN="BOTTOM"><p class="schooltop"><?= $config['organization_name'] ?></p></td>
			</tr>
		</table>
	</div>

<div id="navbar">
<?
for($i = 0; $i < count($page_display); $i++) {
	echo '<a href="' . $page_display[$i] . '">' . $page_display_names[$i] . '</a>';
}
?>
</div>

<div id ="main">
		<div id="box">

