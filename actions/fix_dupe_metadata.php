<?php

set_time_limit(0);

$dbprefix = elgg_get_config('dbprefix');

$type = sanitise_string(get_input('type'));
$subtype = sanitise_string(get_input('subtype'));

$md_name_id = elgg_get_metastring_id(get_input('md'));

$sql = "SELECT e.guid as guid FROM {$dbprefix}entities e ";
$sql .= "WHERE e.type = '{$type}' ";
if ($subtype) {
	$id = get_subtype_id($type, $subtype);
	$sql .= "AND e.subtype = $id ";
}
$sql .= "AND 1 < (SELECT COUNT(md.id) FROM {$dbprefix}metadata md WHERE md.name_id = {$md_name_id} and md.entity_guid = e.guid)";

$data = get_data($sql);

if (!$data) {
	echo elgg_echo('dbvalidate:dupe_metadata:success:nodupes');
	exit;
}

foreach ($data as $result) {
	
	// yeah this will work best for not triggering events and stuff
	// but damn it's slow!
	// keeping it here in case we want to reference or tinker with it in the future
//	$delete_sql = "DELETE md FROM {$dbprefix}metadata md ";
//	$delete_sql .= "JOIN (SELECT MAX(md2.id) as max_id, md2.entity_guid, md2.name_id FROM {$dbprefix}metadata md2 GROUP BY md2.entity_guid, md2.name_id HAVING COUNT(*) > 1) t ON t.entity_guid = md.entity_guid AND t.name_id = md.name_id AND t.max_id != md.id ";
//	$delete_sql .= "WHERE md.entity_guid = {$result->guid} AND md.name_id = {$md_name_id};";
//	delete_data($delete_sql);
	
	$md = elgg_get_metadata([
		'guid' => $result->guid,
		'metadata_names' => get_input('md'),
		'limit' => false
	]);
	
	if ($md && count($md) > 1) {
		foreach ($md as $key => $m) {
			if ($key == (count($md) - 1)) {
				// keep the last metadata row
				continue;
			}
			
			$m->delete();
		}
	}
} 

echo elgg_echo('done!');
exit;