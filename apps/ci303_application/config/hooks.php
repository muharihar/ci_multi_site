<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$_site_config_hooks = _multisite_get_config('hooks');

include_once($_site_config_hooks);