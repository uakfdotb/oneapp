<h1>Easy Question Adder</h1>

<p>This tool generates questions using a GUI. You will preview the question before you add it. First, select a type from the list.</p>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Plain Text</a></li>
		<li><a href="#tabs-2">Selection</a></li>
		<li><a href="#tabs-3">Short Answer</a></li>
		<li><a href="#tabs-4">Essay Response</a></li>
	</ul>
<div id="tabs-1">
	<form method="POST" action="easy_question.php">
	<input type="hidden" name="type" value="text" />
	<table width=100%>
	<tr><td width=40%><p class="name required">Question</p>
	</td><td><textarea name="name" style="width:100%;resize:vertical;min-height:50px"/></textarea></td></tr>
	<!-- description; required field -->
		<tr><td><p class="name required">Description</p></td>
		<td><textarea name="description" style="width:100%;resize:vertical;min-height:50px"></textarea></td></tr>
	<!-- status:optional,required; default is optional -->
	<!-- showchars:true,false; default is false --> 
	<!-- length:int; default is 10,000 -->
	<!-- method:single,multiple,dropdown; default is single -->
	<!-- size:medium,large,huge; default is medium -->
		<tr><td colspan="2"><input type="submit" name="done" value="Generate question" class="add right"/></td></tr>
	</table>
	</form>
</div>
<div id="tabs-2">
	<form method="POST" action="easy_question.php">
	<input type="hidden" name="type" value="select" />
	<table width=100%>
	<tr><td width=40%><p class="name required">Question</p>
	</td><td><textarea name="name" style="width:100%;resize:vertical;min-height:50px"/></textarea></td></tr>
	<!-- description; required field -->
		<tr><td><p class="name required">Description</p><p class="desc">Write response choices below, with each on a separate line. Do not use semicolons in the choices.</p></td><td>
		<textarea name="description" style="width:100%;resize:vertical;min-height:50px"></textarea></td></tr>
	<!-- status:optional,required; default is optional -->
		<tr><td><p class="name">Status</p></td><td>
		<p class="desc"><input type="checkbox" name="state" value="required" checked />Required (if checked, system will not allow submission if response blank)</p></td></tr>
	<!-- showchars:true,false; default is false --> 
	<!-- length:int; default is 10,000 -->
	<!-- method:single,multiple,dropdown; default is single -->
		<tr><td><p class="name">Selection type</p></td><td>
		<p class="desc"><input type="radio" name="method" value="single" checked/> Single selection</p>
		<p class="desc"><input type="radio" name="method" value="multiple" /> Multiple selection</p>
		<p class="desc"><input type="radio" name="method" value="dropdown" /> Dropdown selection</p>
		</td></tr>
	<!-- size:medium,large,huge; default is medium -->
	<tr><td colspan="2"><input type="submit" name="done" value="Generate question" class="add right"/></td></tr>
	</table>
	</form>
</div>
<div id="tabs-3">
	<form method="POST" action="easy_question.php">
	<input type="hidden" name="type" value="short" />
	<table width=100%>
	<tr><td width=40%><p class="name required">Question</p>
	</td><td><textarea name="name" style="width:100%;resize:vertical;min-height:50px"/></textarea></td></tr>
	<!-- description; required field -->
		<tr><td><p class="name required">Description</p></td>
		<td><textarea name="description" style="width:100%;resize:vertical;min-height:50px"></textarea></td></tr>
	<!-- status:optional,required; default is optional -->
		<tr><td><p class="name">Status</p></td><td>
		<p class="desc"><input type="checkbox" name="state" value="required" checked />Required (if checked, system will not allow submission if response blank)</p></td></tr>
	<!-- showchars:true,false; default is false --> 
		<tr><td><p class="name">Show characters remaining</p></td><td>
		<p class="desc"><input type="checkbox" name="showchars" value="true" /> Yes</p>
		</td></tr>
	<!-- length:int; default is 10,000 -->
		<tr><td><p class="name">Maximum number of characters</p></td><td>
		<input type="text" name="length" value="80" />
		</td></tr>
	<!-- method:single,multiple,dropdown; default is single -->
	<!-- size:medium,large,huge; default is medium -->
	<tr><td colspan="2"><input type="submit" name="done" value="Generate question" class="add right"/></td></tr>
	</table>
	</form>
</div>
<div id="tabs-4">
	<form method="POST" action="easy_question.php">
	<input type="hidden" name="type" value="essay" />
	<table width=100%>
	<tr><td width=40%><p class="name required">Question</p>
	</td><td><textarea name="name" style="width:100%;resize:vertical;min-height:50px"/></textarea></td></tr>
	<!-- description; required field -->
		<tr><td><p class="name required">Description</p></td>
		<td><textarea name="description" style="width:100%;resize:vertical;min-height:50px"></textarea></td></tr>
	<!-- status:optional,required; default is optional -->
		<tr><td><p class="name">Status</p></td><td>
		<p class="desc"><input type="checkbox" name="state" value="required" checked />Required (if checked, system will not allow submission if response blank)</p></td></tr>
	<!-- showchars:true,false; default is false --> 
		<tr><td><p class="name">Show characters remaining</p></td><td>
		<p class="desc"><input type="checkbox" name="showchars" value="true" /> Yes</p>
		</td></tr>
	<!-- length:int; default is 10,000 -->
		<tr><td><p class="name">Maximum number of characters</p></td><td>
		<input type="text" name="length" value="1000" />
		</td></tr>
	<!-- method:single,multiple,dropdown; default is single -->
	<!-- size:medium,large,huge; default is medium -->
		<tr><td><p class="name">Essay size</p><p class="desc">Determines size of text area</p></td><td>
		<p class="desc"><input type="radio" name="size" value="medium" checked/> Medium</p>
		<p class="desc"><input type="radio" name="size" value="large" /> Large</p>
		<p class="desc"><input type="radio" name="size" value="huge" /> Huge</p>
		</td></tr>
	<tr><td colspan="2"><input type="submit" name="done" value="Generate question" class="add right"/></td></tr>
	</table>
	</form>
</div>
</div>
<br />
