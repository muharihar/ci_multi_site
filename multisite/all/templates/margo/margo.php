<?php
$_waf_template_config = array(
    'name'        => 'margo',
    'desc'        => 'Margo',
    'version'     => '1.2',
    'init_before_view'  => array('header' => '_data_header', 'sidebar_left_menu' => '_data_sidebar_left_menu'),
    'init_after_view'   => array('footer' => '_data_footer')
);