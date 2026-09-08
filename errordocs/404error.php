<?php
/**
*
* @package phpBB3
* @version $Id: 404error.php 295 2008-01-14 15:28:34Z Highway of Life $
* @copyright (c) 2007 Star Trek Guide Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('IN_PHPBB', true);
define('ROOT_PATH', './../');
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include(ROOT_PATH . 'common.' . $phpEx);

// since we?re only using one language (en), I?ll just hardcode this...
// void page_header ([ $page_title = ''], [ $display_online_list = true])
page_header('404 Error - Not Found', false);

// this template file will be located in the custom templates directory
$template->set_filenames(array(
    'body' => 'errordocs/404_error.html'
));

// log the error
// void log_error ([ $error_type = 404])
log_error(404);

// void page_footer ([ $run_cron = true])
page_footer(false);

?>