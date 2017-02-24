<?php
/**
 * Admin section for duplicate metadata cleaner
 */

elgg_load_js('dupe_metadata');

echo '<p class="elgg-content-thin">';
echo elgg_echo('dbvalidate:dupe_metadata:instructions');
echo '</p>';

$user_type = new StdClass();
$group_type = new StdClass();

$user_type->type = 'user';
$user_type->subtype = '';
$group_type->type = 'group';
$group_type->subtype = '';

$dbprefix = elgg_get_config('dbprefix');
$types_subtypes = get_data("SELECT * FROM {$dbprefix}entity_subtypes");

$types = array_merge([$user_type, $group_type], $types_subtypes);

foreach ($types as $obj) {
	
	$type = $obj->type;
	$subtype = $obj->subtype;
	
	$ts = $type;
	if ($subtype) {
		$ts .= ':' . $subtype;
	}
	
	$href = elgg_normalize_url("action/dbvalidate/identify_dupe_metadata?type={$type}&subtype={$subtype}");
	$button = elgg_view('output/url', array(
		'text' => elgg_echo('dbvalidate:validate'),
		'href' => '#',
		'data-href' => elgg_add_action_tokens_to_url($href),
		'is_action' => true,
		'is_trusted' => true,
		'class' => 'elgg-button elgg-button-submit dupe-metadata'
	));
	
	$spinner = elgg_view('graphics/ajax_loader', array(
		'class' => 'elgg-content-thin',
	));
	
	$results = $spinner . '<div class="results">' . $button . '</div>';
	echo elgg_view_module('main', $ts, $results);
}
