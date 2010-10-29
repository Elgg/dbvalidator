<div class="contentWrapper">
<p>
<?php

$validate_url = "{$vars['url']}action/dbvalidate/validate";
$repair_url = "{$vars['url']}action/dbvalidate/repair";
$validate_url = elgg_add_action_tokens_to_url($validate_url);
$repair_url = elgg_add_action_tokens_to_url($repair_url);

echo elgg_echo('dbvalidate:instructions');

echo "<br />";

echo elgg_view('input/button', array(	'value' => elgg_echo('dbvalidate:validate'),
										'js' => 'onclick="dbvValidate()"' ));

echo "<br />";

echo elgg_view('input/button', array(	'value' => elgg_echo('dbvalidate:repair'),
										'js' => 'onclick="dbvRepair()"' ));


?>
</p>
<div id="dbv_ajax_spinner"><img src="<?php echo $vars['url']; ?>_graphics/ajax_loader.gif" alt="ajax spinner" /></div>
<div id="dbv_results"></div>
</div>

<script type="text/javascript">
$(document).ready(function($) {
	$("#dbv_ajax_spinner").hide();
});

function dbvValidate()
{
	$("#dbv_ajax_spinner").ajaxStart(function(){
		   $(this).show();
		 });

	$("#dbv_ajax_spinner").ajaxStop(function(){
		   $(this).hide();
		 });

	$("#dbv_results").html('');

	$.ajax({
		type: "GET",
		url: "<?php echo $validate_url; ?>",
		cache: false,
		success: function(data){
			$("#dbv_results").html(data);
		}
	});
}

function dbvRepair()
{
	$("#dbv_ajax_spinner").ajaxStart(function(){
		   $(this).show();
		 });

	$("#dbv_ajax_spinner").ajaxStop(function(){
		   $(this).hide();
		 });

	$("#dbv_results").html('');

	$.ajax({
		type: "GET",
		url: "<?php echo $repair_url; ?>",
		cache: false,
		success: function(data){
			$("#dbv_results").html(data);
		}
	});
}
</script>