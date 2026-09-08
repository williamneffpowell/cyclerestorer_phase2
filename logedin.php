<?php
// phpBB includes
define('IN_PHPBB', true);
// next one is the physical path to your forums root : CUSTOMIZE
$phpbb_root_path = '/phpBB3/';
//include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
// Start session
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
// From now on, we have user infos
if(!$user->data['is_registered'])
{
echo "<h5> User is Registered </H5>";
}
?>
<script type="text/javascript">
top.window.location = '/login.php';
</script>