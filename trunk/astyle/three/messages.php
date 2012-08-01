<div class="messages">
	<? $inform_counter = 1; ?>
	<? if(isset($inform['info'])) { ?>
		<div class="msg msgInfo location<?=$inform_counter?>" title="Click to close">
			<? 
				echo $inform['info'];
				$inform_counter++; 
			?>
		</div>
	<? } ?>
	<? if(isset($inform['warn'])) { ?>
		<div class="msg msgWarn location<?=$inform_counter?>" title="Click to close">
			<? 
				echo $inform['warn'];
				$inform_counter++; 
			?>
		</div>
	<? } ?>
	<? if(isset($inform['error'])) { ?>
		<div class="msg msgError location<?=$inform_counter?>" title="Click to close">
			<? 
				echo $inform['error'];
				$inform_counter++; 
			?>
		</div>
	<? } ?>
	<? if(isset($inform['success'])) { ?>
		<div class="msg msgOK location<?=$inform_counter?>" title="Click to close">
			<? 
				echo $inform['success'];
				$inform_counter++; 
			?>
		</div>
	<? } ?>
</div>
