<?php
/*
 * File Name: Foster.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Foster extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this -> load -> library('session');
        $this -> load -> helper('form');
        $this -> load -> helper('url');
        $this -> load -> database();
        $this -> load -> library('form_validation');
        //load the foster model
        $this -> load -> model('foster_model');
    }

    function index() {
        if (empty($this -> session -> userdata) || $this -> session ->
userdata==null ||  $this -> session -> userdata['loginuser'] == FALSE) {
            redirect('login/index');
        }else{
            $data['foster'] = $this -> foster_model ->
get_foster_record('all');
            $this -> load -> view('commons/header');
            $this -> load -> view('commons/topnav');
            $this -> load -> view('commons/sidebar');
            $this -> load -> view('foster_list_view', $data);
            $this -> load -> view('commons/footer.php');
        }
    }

}

?>

