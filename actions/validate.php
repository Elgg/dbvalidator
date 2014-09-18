<?php
/**
 * Validate and repair an Elgg database
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Cash Costello
 * @copyright Cash Costello 2010-2014
 */

set_time_limit(0);

echo "<h3>" . elgg_echo('dbvalidate:users') . "</h3>";

$users = dbvalidate_get_bad_users();

// write html for bad users
if ($users !== false && count($users) > 0) {
	echo elgg_echo('dbvalidate:badusernames');
	echo "<ul>";
	foreach ($users as $user) {
		echo "<li>";
		echo elgg_echo('dbvalidate:GUID') . $user->guid;
		echo "</li>";
	}
	echo "</ul>";
} else {
	echo elgg_echo('dbvalidate:nobadusernames');
	echo "<br />";
}

echo "<br />";

echo "<h3>" . elgg_echo('dbvalidate:entities') . "</h3>";

$bad_guids = dbvalidate_get_bad_entities();

// write html for bad entities
if (count($bad_guids) > 0) {
	echo elgg_echo('dbvalidate:badowners');
	echo "<ul>";
	foreach ($bad_guids as $guid) {
		echo "<li>";
		echo elgg_echo('dbvalidate:GUID') . $guid . ", " . elgg_echo('dbvalidate:type') . ': ' . dbvalidate_get_object_type($guid);
		echo "</li>";
	}
	echo "</ul>";
} else {
	echo elgg_echo('dbvalidate:nobadowners');
}

echo "<br />";

$incomplete_entities = dbvalidate_get_incomplete_entities();

// write html for incomplete entities
if ($incomplete_entities !== false && count($incomplete_entities) > 0) {
	echo elgg_echo('dbvalidate:incompleteentities');
	echo "<ul>";
	foreach ($incomplete_entities as $entity) {
		echo "<li>";
		echo elgg_echo('dbvalidate:GUID') . $entity->guid . ", " . elgg_echo('dbvalidate:type') . ": " .$entity->type;
		if ($subtype = get_subtype_from_id($entity->subtype)) {
			echo ":$subtype";
		}
		echo "</li>";
	}
	echo "</ul>";
} else {
	echo elgg_echo('dbvalidate:noincompleteentities');
	echo "<br />";
}

exit;