<h1>Database Management</h1>

<p>This page lists the many features from which you may manage your database. Please click on one of the links below to access these features.</p>

<?
		$root_database_display = $config['root_database_display'];
		$root_database_display_names = $config['root_database_display_names']; 
?>

<table class="nav-container">			
			<tr><td>
<?	for($j = 0; $j < count($root_database_display); $j++) { ?>
				<a href="<?=$root_database_display[$j] ?>.php"><div class="nav-button <? if(($j %2 == 0 && $j %4 ==0) || ($j %2==1 && ($j+1) %4==0)) echo 'alternate'; ?> ">
					<img src="<?=$stylePath?>/images/root/<?=$root_database_display[$j] ?>.png" height="56" style="margin-left:-3px">
					<h2><?=$root_database_display_names[$j]?></h2>
				</div></a>
			<? if($j %2 == 0) {
					echo "</td><td>";
			   } else {
			   		echo "</td></tr><tr><td>";
			   } 
	} ?>
</td></tr>
</table>
