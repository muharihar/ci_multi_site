<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$_site_config_memcached = _multisite_get_config('memcached');

include_once($_site_config_memcached);