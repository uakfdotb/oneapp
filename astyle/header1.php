<html>
<head>
<link href="<?= $basePath ?>/astyle/style1/style.css" rel="stylesheet" type="text/css">

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

<title>TAMSApp</title>
</head>

<body>
<div id="container">
	<div id="topbar" align="left">
		<table width=100% cellpadding="0" cellspacing="0" >
			<tr>
			<td><a href="../index.php"><img src="<?= $basePath ?>/astyle/style1/logo.jpg" alt="logo" height="60" border="0" /></a></td>
			<td VALIGN="BOTTOM"><p class="schooltop"><?= $config['organization_name'] ?></p></td>
			</tr>
		</table>
	</div>
	
	<div id="navbar"><table width=100% background-color="red"><tr><td><a id="clockbox"><?= $timeString ?></a></td><td align="right">
<?
for($i = 0; $i < count($page_display); $i++) {
	echo '<a href=' . $page_display[$i] . '.php>' . $page_display_names[$i] . '</a> ';
}
?>
   </td></tr></table>
	</div>
	<div id ="main">
	<div id ="col_holder">
		<div id="col_left">
			<div id="side_bar">
				<ul style="margin-left: 10px; padding-left: 0;">

<?
for($i = 0; $i < count($side_display); $i++) {
	echo '<li class="sidenav"><a href=' . $side_display[$i] . '.php>' . $side_display_names[$i] . '</a></li>';
	
	if($side_display[$i] == "supplement" && isset($_SESSION['user_id'])) {
		//display all the supplements this user is working on
		$clubsApplied = getUserClubsApplied($_SESSION['user_id']);
		
		echo "<ul>";
		foreach($clubsApplied as $item) {
			$club_id = $item[0];
			$club_name = $item[1];
			echo "<li class=\"sidenav1\">";
			echo "<a href=\"app.php?club_id=$club_id&action=view\">";
			echo $club_name;
			echo "</a></li>";
		}
		echo "</ul>";
	} else if($side_display[$i] == "base" && isset($_SESSION['user_id'])) {
		//display the general application categories
		include_once($basePath . "/include/apply_submit.php");
		if(isApplicationStarted($_SESSION['user_id'], 0)) {
			$categoryList = listCategories();
			
			echo "<ul>";
			foreach($categoryList as $item) {
				$cat_id = $item[0];
				$cat_name = $item[1];
				echo "<li class=\"sidenav1\">";
				echo "<a href=\"app.php?club_id=0&cat_id=$cat_id&action=view\">";
				echo $cat_name;
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
