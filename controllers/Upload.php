<?php

class Upload extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
        }

        public function index()
        {
                $this->load->view('upload_form', array('error' => ' ' ));
        }

        public function do_upload()
        {
                $config['upload_path']          = '/var/www/upload/';
                $config['allowed_types']        = 'gif|jpg|png';
                //$config['max_size']             = 100;
                //$config['max_width']            = 1024;
                //$config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => '1', 'error' => $this->upload->display_errors());
	                //add the header here
			header('Content-Type: application/json');
			echo json_encode($error);
                }
                else
                {
                        //$data = array('upload_data' => $this->upload->data(),'petname'=>$this -> input -> post('petname', TRUE));
			$data = array('error' => '0','petname'=>$this -> input -> post('petname', TRUE),'upload_data' => $this->upload->data());
                        //add the header here
			header('Content-Type: application/json');
			echo json_encode($data);
                }
        }
}
?>

