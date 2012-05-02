<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link href="<?= $stylePath ?>/style.css" rel="stylesheet" type="text/css">
<link href="<?= $stylePath ?>/message.css" rel="stylesheet" type="text/css">
<link href="<?= $stylePath ?>/button.css" rel="stylesheet" type="text/css">
<script src="<?= $stylePath ?>/sorttable.js"></script>
<script src="<?= $stylePath ?>/jquery.simpletip-1.3.1.js"></script>
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

<! Show Hide button >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){	
    $('.example2').stop(true, true).hide().before('<a href="#" id="toggle-example2" class="button">Show/Hide Details</a>');
	$('a#toggle-example2').click(function() {
		$('.example2').stop(true, true).slideToggle(1000);
		return false;
	});
});
</script>
<! End show hide >

<title><?=$config['site_name'] ?></title>
</head>

<body>
<div id="container">
	<div id="topbar">
		<table width=100%>
			<tr>
				<td><a href="../index.php"><img src="<?= $stylePath ?>/images/logo.jpg" alt="logo" height="60" border="0" /></a></td>
				<td class="schooltop"><p><?= $config['organization_name'] ?></p></td>
			</tr>
		</table>
	</div>
	<div id="navbar">
		<table width=100%>
			<tr>
				<td><p id="clockbox"><?= $timeString ?></p></td>
				<td align="right">
					<a href="#">Help</a>
					<?
					for($i = 0; $i < count($page_display); $i++) {
						echo '<a href=' . $page_display[$i] . '.php>' . $page_display_names[$i] . '</a> ';
					}
					?>
				</td>
			</tr>
		</table>
	</div>
	<div><img src="<?= $stylePath ?>/images/top_rule.png" alt="logo" height="2px" width=100% border="0" /></div>
	<div id="col_holder">
		<div id="col_left">
			<div class="side_bar">
				<div class="userbox">
				<? if(isset($_SESSION['user_id'])) {?>
						<?$userInfo = getUserInformation($_SESSION['user_id']); $profile = getProfile($_SESSION['user_id']);?>
						<p class="box_name"><?
						//profile information
						foreach($profile as $item) {
							echo $item[1];
						}
						?></p>
						<p class="box_id"><?=$config['site_name'] ?> ID: <?= $_SESSION['user_id']?></p>
						<p class="box_date">Last Saved: $DATE$</p>
				<? } else if(isset($_SESSION['admin_id'])) {?>
						<?$adminInfo = getAdminInformation($_SESSION['admin_id']);?>
						<p class="box_name"><?= $adminInfo[0] ?></p>
						<p class="box_id"><?=$config['site_name'] ?> ID: <?= $_SESSION['admin_id']?></p>
						<p class="box_date"><?= $adminInfo[2]?></p>
				<? } else if(isset($_SESSION['root'])) {?>
						<p class="box_name">Root</p>
						<p class="box_id"><?=$config['site_name'] ?></p>
						<p class="box_date">$CONTACT EMAIL$</p>
				<? } ?>
				</div>
				<div class="sidemenu">
					<ul>
						<a href="#"><li class="topsidenav">Instructions</li></a>
					<?					
						for($i = 0; $i < count($side_display); $i++) {
							echo '<a href=' . $side_display[$i] . '.php>';
							if(isset($_SESSION['user_id']) && $i<2) echo '<li class="topsidenav">';
								else echo '<li class="sidenav">';
							echo  $side_display_names[$i] . '</li></a>';
	
							if($side_display[$i] == "supplement" && isset($_SESSION['user_id'])) {
								//display all the supplements this user is working on
								$styleClubsApplied = getUserClubsApplied($_SESSION['user_id']);
		
								echo "<ul>";
								foreach($styleClubsApplied as $styleItem) {
									$style_club_id = $styleItem[0];
									$style_club_name = $styleItem[1];
									echo "<a href=\"app.php?club_id=$style_club_id&action=view\">";
									echo "<li class=\"sidenav1\">";
									echo $style_club_name;
									echo "</li></a>";
								}
								echo "</ul>";
							} else if($side_display[$i] == "base" && isset($_SESSION['user_id'])) {
								//display the general application categories
								include_once($basePath . "/include/apply_submit.php");
								if(isApplicationStarted($_SESSION['user_id'], 0)) {
									$styleCategoryList = listCategories();
			
									echo "<ul>";
									foreach($styleCategoryList as $styleItem) {
										$style_cat_id = $styleItem[0];
										$style_cat_name = $styleItem[1];
										echo "<a href=\"app.php?club_id=0&cat_id=$style_cat_id&action=view\">";
										echo "<li class=\"sidenav1\">";
										echo $style_cat_name;
										echo "</li></a>";
									}
									echo "</ul>";
								}
							} else if($side_display[$i] == "manage" && isset($_SESSION['root'])) {
								//display manage options for root
								echo "<ul>";
								$root_manage_display = $config['root_manage_display'];
								$root_manage_display_names = $config['root_manage_display_names']; 
								for($j = 0; $j < count($root_manage_display); $j++) {
									echo '<a href=' . $root_manage_display[$j] . '.php><li class="sidenav1">' . $root_manage_display_names[$j] . '</li></a>';	
								}
								echo "</ul>";
							} else if($side_display[$i] == "clean" && isset($_SESSION['root'])) {
								//display manage options for root
								echo "<ul>";
								$root_clean_display = $config['root_clean_display'];
								$root_clean_display_names = $config['root_clean_display_names']; 
								for($j = 0; $j < count($root_clean_display); $j++) {
									echo '<a href=' . $root_clean_display[$j] . '.php><li class="sidenav1">' . $root_clean_display_names[$j] . '</li></a>';	
								}
								echo "</ul>";
							} else if($side_display[$i] == "database" && isset($_SESSION['root'])) {
								//display manage options for root
								echo "<ul>";
								$root_database_display = $config['root_database_display'];
								$root_database_display_names = $config['root_database_display_names']; 
								for($j = 0; $j < count($root_database_display); $j++) {
									echo '<a href=' . $root_database_display[$j] . '.php><li class="sidenav1">' . $root_database_display_names[$j] . '</li></a>';	
								}
								echo "</ul>";
							}
						}
						?>
						<li class="endsidenav"></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="col_right">
			<div class="message">
			<?
			if(isset($warning)) {
				echo "<div class=\"warning\">" . $warning . "</div>";
			}
			if(isset($error)) {
				echo "<div class=\"error\">" . $error . "</div>";
			}
			if(isset($info)) {
				echo "<div class=\"info\">" . $info . "</div>";
			}
			if(isset($success)) {
				echo "<div class=\"success\">" . $success . "</div>";
			}
			if(isset($validation)) {
				echo "<div class=\"validation\">" . $validation . "</div>";
			}
			?>
			</div>
			<div id="box">
