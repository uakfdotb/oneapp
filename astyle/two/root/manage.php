<h1>Manage</h1>

<p>This page lists the many features from which you may view users, add admins, organizations, general application categories, and custom pages. Please click on one of the links below to access these features.</p>

<ul>
<?
		$root_manage_display = $config['root_manage_display'];
		$root_manage_display_names = $config['root_manage_display_names']; 
		for($j = 0; $j < count($root_manage_display); $j++) {
			echo '<li><a href=' . $root_manage_display[$j] . '.php>' . $root_manage_display_names[$j] . '</a></li>';	
		}
?>
</ul>

<table class="nav-container">			
			<tr><td>
<?	for($j = 0; $j < count($root_manage_display); $j++) { ?>
				<a href="<?=$root_manage_display[$j] ?>.php"><div class="nav-button <? if($j %2 == 0) echo 'alternate'; ?> ">
					<img src="<?=$stylePath?>/images/<?=$root_manage_display[$j] ?>.png" width="39" style="margin-left:-3px">
					<h2><?=$root_manage_display_names?></h2>
				</div></a>
			<? if($j %2 == 0) {
					echo "</td><td>";
			   } else {
			   		echo "</td></tr><tr><td>";
			   } 
	} ?>
</td></tr>
</table>
