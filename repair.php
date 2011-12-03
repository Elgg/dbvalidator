<?php
/**
 * Attempt to repair out of memory errors due to too many enabled_plugin metadata
 */

// Get DB settings
require_once(dirname(dirname(dirname(__FILE__))). '/engine/settings.php');

global $CONFIG;

$mysql_dblink = mysql_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, true);
if (!$mysql_dblink) {
	echo 'unable to connect to the database server';
	exit;
}


$result = mysql_select_db($CONFIG->dbname, $mysql_dblink);
if (!$result) {
	echo 'unable to the Elgg database';
	exit;
}

// get the 'enabled_plugins' metastring id
$result = mysql_query("SELECT id FROM {$CONFIG->dbprefix}metastrings WHERE string = 'enabled_plugins'", $mysql_dblink);
if (!$result) {
	echo 'odd problem - unable to find the enabled_plugins string';
	exit;
}
$row = mysql_fetch_object($result);
if (!$row) {
	echo 'failed to get the db result';
	exit;
}
$id = $row->id;

// count how many 'enabled_plugins'
$result = mysql_query("SELECT COUNT(*) as total FROM {$CONFIG->dbprefix}metadata WHERE name_id = $id", $mysql_dblink);
if (!$result) {
	echo 'No enabled plugins so we are quiting';
	exit;
}
$row = mysql_fetch_object($result);
if (!$row) {
	echo 'failed to get the db result';
	exit;
}
$total = $row->total;
echo "<p>There are $total entries.</p>";

// more than 250 probably means corruption
if ($total > 250) {
	echo "<p>Deleting plugin entries.</p>";
	$result = mysql_query("DELETE FROM {$CONFIG->dbprefix}metadata WHERE name_id = $id", $mysql_dblink);
	if (!$result) {
		echo 'Failed to delete plugin entries';
		exit;
	}
} else {
	echo "<p>Not enough plugin entries to justify deleting them.</p>";
	exit;
}

echo "<p>Succeeded in deleting the plugin entries.</p>";

mysql_close($mysql_dblink);
