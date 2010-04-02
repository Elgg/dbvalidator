<?php
/**
 * Validate and repair an Elgg database
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Cash Costello
 * @copyright Cash Costello 2010
 */

function dbv_test_username_avail($username) {
	if (get_user_by_username($username)) {
		return FALSE;
	}

	return TRUE;
}

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

admin_gatekeeper();


$users = dbvalidate_get_bad_users();

// repair bad users
if ($users !== false && count($users) > 0) {
	$user_count = 1;
	echo elgg_echo('dbvalidate:fixbadusernames');
	echo "<ul>";
	foreach ($users as $user) {
		// create new username
		$new_username = 'user' . $user_count;
		$user_count = $user_count + 1;
		while (!dbv_test_username_avail($new_username)) {
			$new_username = 'user' . $user_count;
			$user_count = $user_count + 1;
		}
		$entity = get_user($user->guid);
		$entity->username = $new_username;
		$entity->save();
		echo "<li>GUID: $entity->guid  USERNAME: $entity->username </li>";
	}
	echo "</ul>";
}

echo "<br />";


$bad_guids = dbvalidate_get_bad_entities();

// write html for bad entities
if (count($bad_guids) > 0) {
	$new_guid = get_loggedin_userid();
	echo elgg_echo('dbvalidate:fixbadowners');
	echo "<ul>";
	foreach ($bad_guids as $guid) {
		$query = "UPDATE {$CONFIG->dbprefix}entities set owner_guid={$new_guid} WHERE guid={$guid}";
		$ret = update_data($query);
		echo "<li>";
		if ($ret) {
			echo "GUID: {$guid} - " . elgg_echo('dbvalidate:newowner');
		} else {
			echo "GUID: {$guid} - " . elgg_echo('dbvalidate:failowner');
		}
		echo "</li>";
	}
	echo "</ul>";
}

echo "<br />";

echo elgg_echo('dbvalidate:done');

exit;