<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
        <title>HMVC - MultiSite - Test View <?php echo strtoupper(MULTISITE_DOMAIN); ?>!</title>
</head>
<body>
    <div>
        <h1>"HMVC - MultiSite - Test View" <?php echo strtoupper(MULTISITE_DOMAIN); ?></h1>
        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
    </div>
</body>
</html>