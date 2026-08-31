<?php
require_once dirname(__DIR__) . '/app/includes/init.php';
require_login();
redirect(tf_role_home());
?>
