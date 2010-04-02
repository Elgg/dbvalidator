<?php
/**
 * Validate and repair an Elgg database
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Cash Costello
 * @copyright Cash Costello 2010
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

set_context('admin');
admin_gatekeeper();

$title = elgg_echo('dbvalidate:title');

$content = elgg_view_title($title);

$content .= elgg_view('dbvalidate/main');

$body = elgg_view_layout("two_column_left_sidebar", '', $content);

page_draw($title, $body);
