<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->set_template('margo');
    }

    public function index() {
        $this->load_view('Hmvc_welcome_test');
    }

}
