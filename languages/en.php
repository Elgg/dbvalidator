<?php

$english = array(

	'dbvalidate:title' => "Database utility",
	'dbvalidate:validate' => "Validate",
	'dbvalidate:repair' => "Repair",
	'dbvalidate:instructions' => "Validate checks for users without usernames and entities with bad owners. Repair fixes these problems. The users are assigned usernames of the form \"userxx\" and entities with bad owners are assigned to you. Please backup your database before using the repair option.",
	'dbvalidate:badusernames' => "Users with no usernames",
	'dbvalidate:nobadusernames' => "No bad usernames",
	'dbvalidate:fixbadusernames' => "Fixing users with no usernames",
	'dbvalidate:badowners' => "Entities with bad owners",
	'dbvalidate:nobadowners' => "No bad owners",
	'dbvalidate:fixbadowners' => "Fixing entities with bad owners",
	'dbvalidate:newowner' => "you are now owner",
	'dbvalidate:failowner' => "failed to set owner",
	'dbvalidate:done' => "Done!",


);

add_translation("en",$english);

?>