<?php

/**
 * Validate and repair an Elgg database
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Cash Costello
 * @copyright Cash Costello 2010
 */

/**
 * Initialize plugin
 */
function dbvalidate_init() {
	register_page_handler('dbvalidate', 'dbvalidate_page_handler');
}

/**
 * Loads controller
 * @return boolean
 */
function dbvalidate_page_handler() {
	require dirname( __FILE__) . "/index.php";
	return true;
}

/**
 * Add admin menu item
 */
function dbvalidate_pagesetup() {
	if (get_context () == 'admin' && isadminloggedin ()) {
		global $CONFIG;
		add_submenu_item(elgg_echo('dbvalidate:title'), $CONFIG->wwwroot . 'pg/dbvalidate/');
	}
}

/**
 * Look for users without a username
 */
function dbvalidate_get_bad_users() {
	global $CONFIG;
	
	$query = "SELECT * from {$CONFIG->dbprefix}users_entity WHERE username=''";
	$users = get_data($query);
	return $users;
}

/**
 * Look for entities with an owner that cannot be loaded
 */
function dbvalidate_get_bad_entities() {
	global $ENTITY_SHOW_HIDDEN_OVERRIDE;
	global $CONFIG;

	$ENTITY_SHOW_HIDDEN_OVERRIDE = TRUE;
	$query = "SELECT COUNT(*) as total from {$CONFIG->dbprefix}entities WHERE type='object' OR type='group'";
	$result = get_data_row($query);
	$num_entities = $result->total;

	$bad_guids = array();

	// handle 1000 at time
	$count = 0;
	$step = 1000;
	while ($count < $num_entities) {
		$query = "SELECT guid, owner_guid from {$CONFIG->dbprefix}entities WHERE type='object' OR type='group' LIMIT $count, $step";
		$guids = get_data($query);
		$count = $count += $step;

		// looking for 0 owner or an owner that cannot be loaded
		foreach ($guids as $guid) {
			if ($guid->owner_guid == 0) {
				$bad_guids[] = $guid->guid;
			} else if (!get_entity($guid->owner_guid)) {
				$bad_guids[] = $guid->guid;
			}
		}

	}

	return $bad_guids;
}

register_elgg_event_handler('init', 'system', 'dbvalidate_init');
register_elgg_event_handler('pagesetup', 'system', 'dbvalidate_pagesetup');