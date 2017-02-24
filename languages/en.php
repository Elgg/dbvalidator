<?php
/**
 * English language file for database validator
 */

return array(

	'admin:administer_utilities:dbvalidate' => "Database cleaner",
	'admin:administer_utilities:dupe_metadata' => "Duplicate Metadata Cleaner",
	'dbvalidate:badusers:count' => "There are %s users without usernames",
	'dbvalidate:badentities:count' => "There are %s bad entities without owners",
	'dbvalidate:incomplete_entities:count' => "There are %s incomplete entities",

	'dbvalidate:title' => "Database utility",
	'dbvalidate:validate' => "Validate",
	'dbvalidate:repair' => "Repair",
	'dbvalidate:instructions' => "\"Validate\" checks for users without usernames, entities with bad owners, and incomplete entities. \"Repair\" fixes these problems. The users are assigned usernames of the form \"userxx\". Entities with bad owners are assigned to you and incomplete entities are removed.",
	'dbvalidate:dupe_metadata:instructions' => "Validate checks for ElggEntity type-subtype pairs that have duplicate metadata.  In some cases duplicate metadata is ok, in other cases it can be introduced accidentally - see: https://github.com/Elgg/Elgg/issues/4268 and can cause issues (eg. a file with duplicate filestore::filestore metadata will cause fatal errors).  Once identified these can be fixed.  Changes made in here are permanent and cannot be undone.  Make sure you back up your database before doing anything else.",
	'dbvalidate:md:make_singular' => "Make Singular",
	'dbvalidate:md:make_singular:confirm' => "This will remove all duplicate entries for this metadata name on this type/subtype of entity, keeping only the last value.  Only do this for metadata you are SURE should only be singular.  This process could take a while on large databases.  Do you want to continue?",
	'dbvalidate:md:dupe:none' => "No duplicate metadata was found",
	
	'dbvalidate:users' => 'Users',
	'dbvalidate:entities' => 'Entities',
	'dbvalidate:GUID' => 'GUID: ',
	'dbvalidate:USERNAME' => 'USERNAME: ',

	'dbvalidate:badusernames' => "Users with no usernames",
	'dbvalidate:nobadusernames' => "No bad usernames.",
	'dbvalidate:fixbadusernames' => "Fixing users with no usernames",
	'dbvalidate:badowners' => "Entities with bad owners",
	'dbvalidate:nobadowners' => "No bad owners.",
	'dbvalidate:fixbadowners' => "Fixing entities with bad owners",
	'dbvalidate:newowner' => "You are now owner.",
	'dbvalidate:failowner' => "Failed to set owner.",
	'dbvalidate:done' => "Done!",
	'dbvalidate:type' => "Object type",
	'dbvalidate:incompleteentities' => 'Incomplete entities',
	'dbvalidate:noincompleteentities' => 'No incomplete entities.',
	'dbvalidate:fixincompleteentities' => 'Removing incomplete entities',
	'dbvalidate:removed' => 'Removed.'
);
