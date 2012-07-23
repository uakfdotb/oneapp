<h1><?= $cat ?></h1>

<p><?= $config['root_cat_display'][$cat]['desc'] ?></p>

<?
	$root_display = $config['root_cat_display'][$cat]['links'];
	$root_display_names = $config['root_cat_display'][$cat]['names']; 
	$root_display_desc = $config['root_cat_display'][$cat]['link_desc']; 
	
?>

<table class="nav-container">			
			<tr><td>
<?	for($j = 0; $j < count($root_display); $j++) { ?>
				<a href="<?=$root_display[$j] ?>.php"><div class="nav-button <? if(($j %2 == 0 && $j %4 ==0) || ($j %2==1 && ($j+1) %4==0)) echo 'alternate'; ?> ">
					<img src="<?=$stylePath?>/images/root/<?=$root_display[$j] ?>.png" height="56" style="margin-left:-10px">
					<h2><?=$root_display_names[$j]?></h2>
					<ul><?=$root_display_desc[$j]?></ul>
				</div></a>
			<? if($j %2 == 0) {
					echo "</td><td>";
			   } else {
			   		echo "</td></tr><tr><td>";
			   } 
	} ?>
</td></tr>
</table>
