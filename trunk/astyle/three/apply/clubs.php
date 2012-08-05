<h2 class="separate">Clubs</h2>

<p>Applications are available between the open time and start time.</p>

<div width=100% align="center">
<form method="GET" action="addClub.php">
<button value="Add club application" class="add">Add club application</button>
</form>
<br />

<script>
	// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	$(function() {
		$( "#dialog-confirm" ).dialog({
			autoOpen: false,
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Continue": function() {
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
	function confimer() {
		$( "#dialog-confirm" ).dialog( "open" );
		return false;
	}
</script>


<div id="dialog-confirm" title="Delete Applicatoin?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>All information regarding this application will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>

</div>
<? if(count($clubs)>0) { ?>
		<div id="accordion">
		<? foreach($clubs as $clubid => $club) {
			$club_id = $clubid;
			$club_name = $club[3][0];
			$club_desc = $club[3][1];
			$start_time = $club[3][2];
			$close_time = $club[3][3];
			$recs = $club[3][4];
			$state = $club[1];
			
			$subscribedString = $club[0] ? '<button name="sub" value="on" class="accept">Yes</button>' : '<button name="sub" value="off" class="reject">No</button>';
			
			$due_time = uid(20);
			?>
				<style type="text/css">
					#<?= $due_time ?> {min-height:10px};
				</style>
			<?
			$applyString = '<button name="app" value="off" class="reject">No</button>';
			if($state === 0) {
				$applyString = '<button name="app" value="on" class="accept" onclick="confimer()">Yes</button>';	
				$due_date = clubdue($club_id);
				$now = getdate();
			?>
				<script type="text/javascript">
				$(function () {
					$('#<?= $due_time ?>').countdown({until: '+<?= $due_date - $now[0] ?>s', 
					layout: '<font style="font-weight:bold;font-size:14px;color:blue;font-variant:small-caps">Time Remaining:</font> <b>{d<}{dn} d {d>}{h<}{hnn} h {h>}{m<}{mnn} m {m>}{s<}{snn} s{s>}</b>',    expiryText: '<font style="font-weight:bold;font-size:14px;color:red;font-variant:small-caps">late</font>'}); 
				});
				</script>
			<? } else if($state == -1) {
				$applyString='<font style="font-weight:bold;font-size:14px;color:green;font-variant:small-caps">submitted</font>';
			} else if($state == -3) {
				$applyString='<font style="font-weight:bold;font-size:14px;color:red;font-variant:small-caps">late</font>';
			?>
				<script type="text/javascript">
				$(function () {
					$('#<?= $due_time ?>').countdown({until: '+0s', significant: 2, 
					layout: '<font style="font-weight:bold;font-size:14px;color:red;font-variant:small-caps">late</font>'}); 
				});
				</script>
			<? }
		?>
			<div>
				<h3><a href="#"><?= $club_name ?></a></h3>
				<div>
					<form method="post">
						<input name="club_id" type="hidden" value="<?= $club_id ?>" />
					<table width=100%>
						<tr><td colspan="2" style="padding-bottom:10px;text-align:right"><div id="<?=$due_time?>" ></div></td></tr>
						<tr><td width=40%>Application Open</td><td><?=  $start_time ?></td></tr>
						<tr><td>Application Due</td><td><?= $close_time ?></td></tr>
						<tr><td>Number of Recommedations</td><td><?= $recs ?></td></tr>
						<tr><td>Subscribed</td><td><?= $subscribedString?></td></tr>
						<tr><td>Applying</td><td><?= $applyString?></td></tr>
						<tr><td>Description</td><td><?= $club_desc ?></td></tr>
						<tr><td colspan="2" style="padding-bottom:10px"></tr>
					</table>
					</form>
				</div>
			</div>
		<? } ?>
		</div>
<? } else { ?>
	<p align="center"><b>You have no organizations added!</b></p>
<? } ?>


