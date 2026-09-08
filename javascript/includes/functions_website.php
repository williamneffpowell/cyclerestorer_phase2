<?php
/**
*
* @package STG
* @version $Id: functions_website.php 240 2008-01-04 01:35:39Z Highway of Life $
* @copyright (c) 2007 Star Trek Guide Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
    exit;
}

/**
 * Log Error
 * Error types are standard HTTP error codes (404, 403, 500 etc)
 *
 * @param int $error_type
 */
function log_error($error_type = 404)
{
    global $user, $phpbb_root_path;

    $error_timestamp = date('d-M-Y  H:i:s Z');
    $user_ip = $user->ip;
    $user_page = $user->page['page'];
    $referer = (isset($_SERVER['HTTP_REFERER'])) ? ' [Referer ' . $_SERVER['HTTP_REFERER'] . ']' : '';
    error_log("[$error_timestamp] [$error_type Error] [Client $user_ip] [File $user_page]$referer \n", 3, $phpbb_root_path . 'store/http_error.log');
}
?>