<div id="imgmain">
<script type="text/javascript" src="<?=$stylePath?>/tinyfader.js"></script>
<div id="wrapper">
     <div>
	<div id="slideshow">
		<div id="slides">
			<div id="content">
			    <img src="<?=$stylePath?>/logo.jpg" width=100%>
			</div>
<?
$imgcounter=0;
//retrieve other slides from files.txt
$style_fh = fopen($stylePath . "/file.txt", 'r');

while (($style_buffer = fgets($style_fh)) !== false) {
	$style_buffer = trim($style_buffer);
	echo '<div id="content" style="display:none">';
	echo "<img src=\"$style_buffer\"/>";
	echo '</div>';
	$imgcounter=$imgcounter+1;
}
?>
		</div>
	</div>
    </div>
    <div id="pagination" class="pagination">
        <div onclick="slideshow.pos(0)"></div>
<?
$counter=1;
while($counter<=$imgcounter){
	echo '<div onclick="slideshow.pos($counter)"></div>';
	$counter=$counter+1;
}
?>
    </div>
</div>

<script type="text/javascript">
var slideshow=new TINY.fader.fade('slideshow',{
    id:'slides',
    auto:3,
    resume:true,
    navid:'pagination',
    activeclass:'current',
    visible:true,
    position:0
});

</script>
</div>


<div id="schoolname">
	<h4><?= $config['organization_name'] ?></h4>
</div>

<div class="spacer"></div>

	<div id="col_mid" class="borderon" align="center">
		<div class="center">
			<table cellpadding="0" cellspacing="0" width=100%>
			<tr bgcolor=#1A3E5B><td class="center"><h2>Log In</h2></td></tr>
			<tr bgcolor=#F2F5F7><td>
			<form action="login.php" method="POST">
			<table width=100%>
			<tr>
			<td><p align="right">Username:</p></td>
			<td><input type="text" name="username" style="width:100%" /></td>
			</tr>
			<tr>
			<td cellspacing="0" cellmargin="0"><p align="right">Password:</p></td>
			<td><input type="password" name="password" style="width:100%" /></td>
			</tr>
			<tr>
			<td colspan="2" align="right"><input type="submit" value="Log In" align="center"/></td>
			</tr>
			</table>
			</form>

			</td>
			</tr>
			<tr bgcolor=#DEDEDE><td>
			<p class="test">Not Registered? <a href="register.php">Click Here</a></p>
			<p class="test">Forgot Password? <a href="reset.php">Click Here</a></p>
			<p class="test">Forgot Username? <a href="forgotusername.php">Click Here</a></p>
			</td>
			</tr>
			</table>
		</div>
	</div>
