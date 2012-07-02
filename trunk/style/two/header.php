<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link href="<?= $stylePath ?>/style/style.css" rel="stylesheet" type="text/css">
<script src="<?= $stylePath ?>/tinyfader.js"></script>
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

