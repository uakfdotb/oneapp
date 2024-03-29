<html>
<head>
<link href="<?= $stylePath ?>/style.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
tday  =new Array("Sun","Mon","Tue","Wed","Thur","Fri","Sat");
tmonth=new Array("Jan","Feb","Mar","April","May","June","July","Aug","Sept","Oct","Nov","Dec");

function GetClock(){
d = new Date();
nday   = d.getDay();
nmonth = d.getMonth();
ndate  = d.getDate();
nyear = d.getYear();
nhour  = d.getHours();
nmin   = d.getMinutes();
nsec   = d.getSeconds();

if(nyear<1000) nyear=nyear+1900;

     if(nhour ==  0) {ap = " AM";nhour = 12;} 
else if(nhour <= 11) {ap = " AM";} 
else if(nhour == 12) {ap = " PM";} 
else if(nhour >= 13) {ap = " PM";nhour -= 12;}

if(nmin <= 9) {nmin = "0" +nmin;}
if(nsec <= 9) {nsec = "0" +nsec;}


document.getElementById('clockbox').innerHTML=""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+", "+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"";
setTimeout("GetClock()", 1000);
}
window.onload=GetClock;
</script>

<title><?=$config['site_name'] ?></title>
</head>

<body>
<div id="container">
	<div id="topbar" align="left">
		<table width=100% cellpadding="0" cellspacing="0" >
			<tr>
			<td><a href="../index.php"><img src="<?= $stylePath ?>/logo.jpg" alt="logo" height="60" border="0" /></a></td>
			<td VALIGN="BOTTOM"><p class="schooltop"><?= $config['organization_name'] ?></p></td>
			</tr>
		</table>
	</div>
	
	<div id="navbar"><table width=100% background-color="red"><tr><td><a id="clockbox"><?= $timeString ?></a></td><td align="right">
<?
for($i = 0; $i < count($page_display); $i++) {
	echo '<a href="' . $page_display[$i] . '">' . $page_display_names[$i] . '</a> ';
}
?>
   </td></tr></table>
	</div>
	<div id ="main">
	<div id ="col_holder">
		<div id="col_left">
			<div id="side_bar">
				<ul style="margin-left: 10px; padding-left: 0; margin-right:5px">

<?
for($i = 0; $i < count($side_display); $i++) {
	echo '<li class="sidenav"><a href="' . $side_display[$i] . '">' . $side_display_names[$i] . '</a></li>';
	
	if(substr($side_display[$i], 0, 10) == "supplement" && isset($_SESSION['user_id'])) {
		//display all the supplements this user is working on
		$styleClubsApplied = getUserClubsApplied($_SESSION['user_id']);
		
		echo "<ul>";
		foreach($styleClubsApplied as $styleItem) {
			$style_club_id = $styleItem[0];
			$style_club_name = $styleItem[1];
			echo "<li class=\"sidenav1\">";
			echo "<a href=\"app.php?club_id=$style_club_id&action=view\">";
			echo $style_club_name;
			echo "</a></li>";
		}
		echo "</ul>";
	} else if(substr($side_display[$i], 0, 4) == "base" && isset($_SESSION['user_id'])) {
		//display the general application categories
		include_once($basePath . "/include/apply_submit.php");
		if(isApplicationStarted($_SESSION['user_id'], 0)) {
			$styleCategoryList = listCategories();
			
			echo "<ul>";
			foreach($styleCategoryList as $styleItem) {
				$style_cat_id = $styleItem[0];
				$style_cat_name = $styleItem[1];
				echo "<li class=\"sidenav1\">";
				echo "<a href=\"app.php?club_id=0&cat_id=$style_cat_id&action=view\">";
				echo $style_cat_name;
				echo "</a></li>";
			}
			echo "</ul>";
		}
	}
}
?>
				</ul>
		</div>
	</div>
	<div id="col_right">
		<div id="box">
