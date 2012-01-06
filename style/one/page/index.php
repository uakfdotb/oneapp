<div id="imgmain" >
	<img src="<?= $stylePath ?>/logo.jpg" alt="logo" width="680"/>
</div>
<div id="schoolname">
	<h4><?= $config['organization_name'] ?></h4>
</div>

<div class="spacer"></div>

<div id="logbox">
	<div id="col_left">
		<div class="borderonlow">
			<table cellpadding="0" cellspacing="0" width=100% height=100%>
			<tr bgcolor=#1A3E5B><td class="center"><h2>Javascript #1</h2></td></tr>
			<tr style="height:100%;" bgcolor=#F2F5F7><td>
			</td>
			</tr>
			</table>
		</div>
	</div>
	<div id="col_mid" class="borderon">
		<div class="center">
			<table cellpadding="0" cellspacing="0" width=100% height=100%>
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
	<div id="col_right">
		<div class="borderonlow">
			<table cellpadding="0" cellspacing="0" width=100% height=100%>
			<tr bgcolor=#1A3E5B><td class="center"><h2>Javascript #2</h2></td></tr>
			<tr style="height:100%;" bgcolor=#F2F5F7><td>
			</td>
			</tr>
			</table>
		</div>
	</div>
</div>
<br />
