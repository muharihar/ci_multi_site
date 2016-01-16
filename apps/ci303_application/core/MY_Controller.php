<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class My_Controller extends CI_Controller {

    protected $_site_template = NULL;
    protected $_site_template_page = NULL; 
    protected $_site_template_config = NULL;
    
    protected $_site_template_html_title = NULL;
    protected $_site_template_html_header = array();
    protected $_site_template_html_footer = array();
    
    function __construct() {
        parent::__construct();
    }

    function set_template($p_value){
        $this->_site_template = $p_value;
        $this->_site_template_page = '';
        
        if (($_temp = strpos($p_value, '/')) != FALSE){
            $this->_site_template_page = substr($p_value, $_temp + 1);
            $this->_site_template = substr($p_value, 0, $_temp);
        }
        
        if ($this->_site_template_page == ''){
            $_config_template = MULTISITE_PATH . 'all/templates/' . $this->_site_template . '/' . $this->_site_template . EXT;
        } else {
            $_config_template = MULTISITE_PATH . 'all/templates/' . $this->_site_template . '/' . $this->_site_template . '_' . $this->_site_template_page . EXT;
        }
        
        if (!file_exists($_config_template)){
            show_error("MULTISITE_ERROR:: Template Configuration [$p_value] Doesnot Exist!");
        }
        
        $this->_site_template_config = $_config_template;
        
        return $this->_site_template_config;
    }
    
    protected function set_template_html_title($p_value = NULL){
        if ($p_value){
            $this->_site_template_html_title = $p_value;
        }
    }
    
    protected function add_template_html_header($p_value){
        $_x = count($this->_site_template_html_header);
        if (!empty($p_value)){
            $this->_site_template_html_header[$_x+1] = $p_value;
        }
    }
    
    protected function add_template_html_footer($p_value){
        $_x = count($this->_site_template_html_footer);
        if (!empty($p_value)){
            $this->_site_template_html_footer[$_x+1] = $p_value;
        }
    }

    function load_view($p_view, $p_data = array()){
        require_once $this->_site_template_config;
        
        /* adding html title */
        $_return_views['_site_template_html_title'] = $this->_site_template_html_title;
        
        /* adding html header variable if exist */
        if (count($this->_site_template_html_header)>0){
            foreach ($this->_site_template_html_header as $_key => $_value){
                $_return_views['_site_template_html_header'][$_key] = $_value;
            }
        }
        
        /* this variable comes from $this->_site_template_config file*/
        $_site_template_config = $_site_template_config;
        
        if (array_key_exists('init_before_view', $_site_template_config)){
            foreach ($_site_template_config['init_before_view'] as $_key => $_value){
                $_temp_data[$_value] = $_key; 
                if (array_key_exists($_value, $p_data)){
                    $_temp_data[$_value] = $p_data[$_value];
                }                
                if ($this->_site_template_page ==''){
                    $_return_views['_site_template_before'][$_key] = $this->load->view($this->_site_template.'/'.$_key, $_temp_data, true); 
                } else {
                    $_return_views['_site_template_before'][$_key] = $this->load->view($this->_site_template.'/'. $_site_template_config['page'] .'/'.$_key, $_temp_data, true);
                }
            }
        }
        
        $_return_views['_site_template_content'] = $this->load->view($p_view, $p_data, true);
        
        if (array_key_exists('init_after_view', $_site_template_config)){
            foreach ($_site_template_config['init_after_view'] as $_key => $_value){
                $_temp_data[$_value] = $_key; 
                if (array_key_exists($_value, $p_data)){
                    $_temp_data[$_value] = $p_data[$_value];
                }
                if ($this->_site_template_page ==''){
                    $_return_views['_site_template_after'][$_key] = $this->load->view($this->_site_template.'/'.$_key, $_temp_data, true);
                } else {
                    $_return_views['_site_template_after'][$_key] = $this->load->view($this->_site_template.'/'.$_site_template_config['page'] .'/'.$_key, $_temp_data, true);
                }
            }
        }
        
        /* adding html footer variable if exist */
        if (count($this->_site_template_html_footer)>0){
            foreach ($this->_site_template_html_footer as $_key => $_value){
                $_return_views['_site_template_html_footer'][$_key] = $_value;
            }
        }
        
        if ($this->_site_template_page ==''){
            $this->load->view($this->_site_template . '/template', $_return_views);
        } else {
            $this->load->view($this->_site_template . '/' . $_site_template_config['page'] .'/template', $_return_views);
        }
    }
    
    
    final function make_uri_string($p_data = array(), $p_exclude = array('per_page'=>'')) {
        $v_return = base_url() . uri_string() . '?';
        if (count($p_data) > 0) {
            foreach ($p_data as $key => $value) {

                if (count($p_exclude) > 0) {
                    if (array_key_exists($key, $p_exclude)) {
                        continue;
                    } else {
                        $v_return .= '&' . $key . '=' . $value;
                    }
                }
            }
        }

        return $v_return;
    }
    
    final function init_pagination($base_url, $total_rows, $page_query_string=TRUE, $per_page=10, $uri_segment=4){
        $this->load->library('pagination');
        $config['base_url'] = $base_url;//site_url('people/lectures/index');//set the base url for pagination        
        $config['total_rows'] = $total_rows; //total rows
        $config['uri_segment'] = $uri_segment; //see from base_url. 3 for this case        
        $config['per_page'] = $per_page; //the number of per page for pagination        
        $config['page_query_string'] = $page_query_string;
        $config['use_page_numbers']= TRUE;
        $config['display_pages']=TRUE;
        
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] ="<li>";
        $config['num_tag_close'] ="</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] ="</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = '<li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $this->pagination->initialize($config); //initialize pagination*/
    }
}
