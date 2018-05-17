<?php
include('smarty3/Smarty.class.php');


/* Location of the individual page templates  */

if (!isset($SMARTY_TEMPLATE_DIR)) {
	$SMARTY_TEMPLATE_DIR = array("./templates");
}

$SMARTY_TEMPLATE_C_DIR = "./templates_c";

$smarty = new Smarty;
$smarty->template_dir = $SMARTY_TEMPLATE_DIR;
$smarty->compile_dir = $SMARTY_TEMPLATE_C_DIR;
$smarty->error_reporting = 0;
$smarty->assign('BASE_DIR', '/');

/* Some default smarty includes (which can be over-ridden in any specific script
	by setting the variable name as per below. These are set in 'config/display.conf.php' */
if (!isset($includes)) {
	$includes = array(
	);
}

if (!isset($page_defaults)) {
  $page_defaults = array(
	'inc_css',				// CSS includes
	'inc_js',				// Javascript includes and libraries
	'inc_meta',				// html meta
	'inc_footer',			// page footer
	'inc_menu_horizontal',				// horizontal menu
	'inc_menu_left',				// left-panel vertical navigation
	'inc_banner',			// page banner
	'left_menu_visible',	// turn left panel on or off (default on)
	'horizontal_menu_visible',	// turn horizontal menu on or off (default on)
	'page_banner_visible',			// page banner on or off (default on)
	'page_footer_visible',			// page footer on or off (default on)
	'allow_analytics',				// turn web anaylitcs sub-template on | off
	'left_nav_bgcolour',
	'left_nav_link_colour',
	'left_nav_link_hover',
	'left_nav_item_border_top',
	'left_nav_item_border_bottom',
	'horizontal_menu_bgcolour',
	'horizontal_menu_item_colour',
	'horizontal_menu_item_hover',
	'ROW_ODD_BGCOLOUR',
	'ROW_EVEN_BGCOLOUR',
	'MHL',
	'GOVT_DEPT',
	'GOVT_ABBR'
	);
}


// For each of the following assign to Smarty. These are typically default settings and do
// no change unless there is a rason to override a default
// If it is not set from a scipt already use a  pre-defined constant value.
for ($i = 0; $i < count($includes); $i++ ) {
	$var = $includes[$i];
	if (!isset($$var)) {
		$smarty->assign("{$var}", MASTERTEMPLATE_DIR . '/' . constant($var));
	} else {
		$smarty->assign("{$var}", $var);
	}
}
for ($i = 0; $i < count($page_defaults); $i++ ) {
	$var = $page_defaults[$i];

	// DEBUG print "$var = " . constant($var) . "<br/>";
	if (!isset($$var)) {
		$smarty->assign("{$var}", constant($var));
	} else {
		$smarty->assign("{$var}", $var);
	}
}

define('MASTER_TEMPLATE_DIR', 'mastertemplates/');
define('master_template_dir', 'mastertemplates/');
define('MASTERTEMPLATE', MASTER_TEMPLATE_DIR . 'master.tpl');
define('MHLFITMASTER', MASTER_TEMPLATE_DIR . 'mhlfit.master.tpl');

$smarty->assign('LINK_PREFIX', '&#187;&#187;');
$smarty->assign('MASTER_TEMPLATE_DIR', MASTER_TEMPLATE_DIR);
?>
