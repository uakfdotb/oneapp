<h1>Clean System</h1>

<p>This page lists the many ways you can clean your system to help us conserve database usage. To clean your system easily, please use <a href="http://demo.one-app.org/root/full_clean.php">Full Database Cleaner</a>. Please click on one of the links below to access these features.</p>

<table class="nav-container">
		<tr><td>
<?
		$root_clean_display = $config['root_clean_display'];
		$root_clean_display_names = $config['root_clean_display_names']; 
		for($j = 0; $j < count($root_clean_display); $j++) {
			echo '<a href=' . $root_clean_display[$j] . '.php><div class="nav-button ';
			if(($j % 2 == 0) && (($j+2)%4 ==0)) echo "alternate";
			if(($j % 2 == 1) && (($j+3)%4 ==0)) echo "alternate";
			echo '"><image src"' . $stylePath . '/images/' . $root_clean_display[$j] . '.png" width="39px" style="margin-left:-3px"><h2>' . $root_clean_display_names[$j] . '</h2></div></a>';
			if($j % 2 == 0) echo "</td><td>";
			else echo "</td></tr><tr><td>";	
		}
?>
	</td></tr>
</table>
