<?php

set_time_limit(0);

$dbprefix = elgg_get_config('dbprefix');

$type = sanitise_string(get_input('type'));
$subtype = sanitise_string(get_input('subtype'));

$sql = "SELECT DISTINCT ms.string as string from {$dbprefix}metadata md ";
$sql .= "JOIN {$dbprefix}entities e on md.entity_guid = e.guid ";
$sql .= "JOIN {$dbprefix}metastrings ms on ms.id = md.name_id ";
$sql .= "WHERE e.type = '{$type}' ";

if ($subtype) {
	$id = get_subtype_id(get_input('type'), get_input('subtype'));
	$sql .= "AND e.subtype = {$id} ";
}

$sql .= "GROUP BY md.entity_guid, md.name_id HAVING COUNT(*) > 1 ";
$sql .= "ORDER BY ms.string ASC";

$data = get_data($sql);

$output = '';
foreach ($data as $result) {
	$href = elgg_http_add_url_query_elements('action/dbvalidate/fix_dupe_metadata', [
		'md' => $result->string,
		'type' => $type,
		'subtype' => $subtype
	]);
	
	$output .= '<div class="clearfloat clearfix elgg-divide-bottom" style="padding-top: 10px">';
	$output .= $result->string;
	$output .= elgg_view('output/url', [
		'text' => elgg_echo('dbvalidate:md:make_singular'),
		'href' => '#',
		'data-href' => elgg_add_action_tokens_to_url(elgg_normalize_url($href)),
		'data-confirmText' => elgg_echo('dbvalidate:md:make_singular:confirm'),
		'class' => 'elgg-button elgg-button-action float-alt dupe-metadata-fix'
	]);
	$output .= '</div>';
}

if (!$output) {
	$output = elgg_echo('dbvalidate:md:dupe:none');
}

echo $output;
exit;