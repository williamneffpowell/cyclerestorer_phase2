<?php
require 'includes/auth_check.inc.php';
if(!$is_logged_in)
{
echo "<h5>Not logged in</h5>";
}
?>
<script type="text/javascript">
top.window.location = '/login.php';
</script>
