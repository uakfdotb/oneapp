<h1>Application submission</h1>
<p>Please review the errors with your application below before proceeding further.</p>
<br />
<h3>General application</h3>
<br />
<? if(count($genCheck)>0){ ?>
	<div class="validation">
	<ul>
	<?
	foreach($genCheck as $warning) {
		echo  $warning ;
	}
	?>
	</ul>
	</div>
<? } else { ?>
	<div class="success">
	All required fields are complete!
	</div>
<? } ?>
<br />

<h3>Supplement</h3>
<br />
<? if(count($appCheck)>0){ ?>
	<div class="validation">
	<ul>
	<?
	foreach($appCheck as $warning) {
		echo "<ul><li><p>" . $warning . "</p></li></ul>";
	}
	?>
	</ul>
	</div>
<? } else { ?>
	<div class="success">
	All required fields are complete!
	</div>
<? } ?>
