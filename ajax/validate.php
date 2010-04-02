<?php
/**
 * Validate and repair an Elgg database
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Cash Costello
 * @copyright Cash Costello 2010
 */

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

admin_gatekeeper();


$users = dbvalidate_get_bad_users();

// write html for bad users
if ($users !== false && count($users) > 0) {
	echo elgg_echo('dbvalidate:badusernames');
	echo "<ul>";
	foreach ($users as $user) {
		echo "<li>";
		echo "GUID: {$user->guid}";
		echo "</li>";
	}
	echo "</ul>";
} else {
	echo elgg_echo('dbvalidate:nobadusernames');
	echo "<br />";
}

echo "<br />";


$bad_guids = dbvalidate_get_bad_entities();

// write html for bad entities
if (count($bad_guids) > 0) {
	echo elgg_echo('dbvalidate:badowners');
	echo "<ul>";
	foreach ($bad_guids as $guid) {
		echo "<li>";
		echo "GUID: {$guid} - " . elgg_echo('dbvalidate:type') . ': ' . dbvalidate_get_object_type($guid);
		echo "</li>";
	}
	echo "</ul>";
} else {
	echo elgg_echo('dbvalidate:nobadowners');
}

exit;