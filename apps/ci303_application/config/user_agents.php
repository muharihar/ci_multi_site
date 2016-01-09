<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$_site_config_user_agents = _multisite_get_config('user_agents');

include_once($_site_config_user_agents);