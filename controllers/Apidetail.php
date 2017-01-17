<?php

class Apidetail extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
        }

        public function index()
        {
                $this->load->view('api_detail', array('error' => ' ' ));
        }

	public function login(){
                $this->load->view('login', array('error' => ' ' ));
        }

	public function loginver1(){
                $this->load->view('loginver1', array('error' => ' ' ));
        }

	public function editprofile(){
                $this->load->view('editprofile', array('error' => ' ' ));
        }

	public function registration(){
	        $this->load->view('registration', array('error' => ' ' ));
	}

	public function forgetpassword(){
	        $this->load->view('forgetpassword', array('error' => ' ' ));
	}

	public function resetpassword(){
	        $this->load->view('resetpassword', array('error' => ' ' ));
	}

	public function addpet()
        {
                $this->load->view('add_pet', array('error' => ' ' ));
        }

	public function getpet()
        {
                $this->load->view('get_pet', array('error' => ' ' ));
        }

	public function updatepet(){
	        $this->load->view('updatepet', array('error' => ' ' ));
	}
	
	public function getallpet(){
            $this->load->view('getallpet', array('error' => ' ' ));
    	}

  	public function appointmentadd(){
            $this->load->view('/appointment/appointmentadd', array('error' => ' ' ));
    	}

    	public function appointmentupdate(){
            $this->load->view('/appointment/appointmentupdate', array('error' => ' ' ));
    	}
    
	public function appointmentdelete(){
            $this->load->view('/appointment/appointmentdelete', array('error' => ' ' ));
    	}
    
	public function appointmentiscomp(){
            $this->load->view('/appointment/appointmentiscomp', array('error' => ' ' ));
    	}

	public function appointmentget(){
            $this->load->view('/appointment/appointmentget', array('error' => ' ' ));
    	}

	public function sharepet(){
            $this->load->view('sharepet', array('error' => ' ' ));
    	}

    	public function galleryadd(){
            $this->load->view('/gallery/galleryadd', array('error' => ' ' ));
    	}
    	public function galleryupdate(){
            $this->load->view('/gallery/galleryupdate', array('error' => ' ' ));
    	}
    	public function gallerydelete(){
            $this->load->view('/gallery/gallerydelete', array('error' => ' ' ));
    	}
    	public function galleryget(){
            $this->load->view('/gallery/galleryget', array('error' => ' ' ));
    	}

	//care section starts
	public function addcare(){
	        $this->load->view('/care/addcare', array('error' => ' ' ));
	}
	public function getcare(){
	        $this->load->view('/care/getcare', array('error' => ' ' ));
	}
	public function updatecare(){
	        $this->load->view('/care/updatecare', array('error' => ' ' ));
	}
	public function deletecare(){
            $this->load->view('/care/deletecare', array('error' => ' ' ));
    	}
	public function iscompcare(){
            $this->load->view('/care/iscompcare', array('error' => ' ' ));
    	}
	//care section ends

	//mc section starts
	public function mcadd(){
	   $this->load->view('/mc/mcadd', array('error' => ' ' ));
	}

	public function mcupdate(){
	    $this->load->view('/mc/mcupdate', array('error' => ' ' ));
	}
	   
    	public function mcdelete(){
	    $this->load->view('/mc/mcdelete', array('error' => ' ' ));
	}
	   
	public function mcget(){
	    $this->load->view('/mc/mcget', array('error' => ' ' ));
	}
	//mc section ends
	
	//insurance section starts
	public function addins(){
	   $this->load->view('/ins/addins', array('error' => ' ' ));
	}

	public function updateins(){
	    $this->load->view('/ins/updateins', array('error' => ' ' ));
	}
	   
    	public function deleteins(){
	    $this->load->view('/ins/deleteins', array('error' => ' ' ));
	}
	   
	public function getins(){
	    $this->load->view('/ins/getins', array('error' => ' ' ));
	}
	//insurance section ends

	//vaccination section starts
	public function addvaccination(){
            $this->load->view('/vaccination/addvaccination', array('error' => ' ' ));
    	}
    	public function getvaccination(){
            $this->load->view('/vaccination/getvaccination', array('error' => ' ' ));
    	}
    	public function updatevaccination(){
            $this->load->view('/vaccination/updatevaccination', array('error' => ' ' ));
    	}
    	public function deletevaccination(){
            $this->load->view('/vaccination/deletevaccination', array('error' => ' ' ));
        }
    	//vaccination section ends

	//vaccination record/book section starts
    	public function addvaccinationrecord(){
            $this->load->view('/vaccinationrecord/addvaccinationrecord', array('error' => ' ' ));
    	}
    	public function getvaccinationrecord(){
            $this->load->view('/vaccinationrecord/getvaccinationrecord', array('error' => ' ' ));
    	}
    	public function updatevaccinationrecord(){
            $this->load->view('/vaccinationrecord/updatevaccinationrecord', array('error' => ' ' ));
    	}
    	public function deletevaccinationrecord(){
            $this->load->view('/vaccinationrecord/deletevaccinationrecord', array('error' => ' ' ));
    	}
	//vaccination record/book section

	//other vaccination section starts
    	public function addothervaccination(){
            $this->load->view('/othervaccination/addothervaccination', array('error' => ' ' ));
    	}
    	public function getothervaccination(){
            $this->load->view('/othervaccination/getothervaccination', array('error' => ' ' ));
    	}
    	public function updateothervaccination(){
            $this->load->view('/othervaccination/updateothervaccination', array('error' => ' ' ));
    	}
    	public function deleteothervaccination(){
            $this->load->view('/othervaccination/deleteothervaccination', array('error' => ' ' ));
        }
	//other vaccination section ends


	//worm section starts
	public function addworm(){
            $this->load->view('/worm/addworm', array('error' => ' ' ));
    	}
    	public function getworm(){
            $this->load->view('/worm/getworm', array('error' => ' ' ));
    	}
    	public function updateworm(){
            $this->load->view('/worm/updateworm', array('error' => ' ' ));
    	}
    	public function deleteworm(){
            $this->load->view('/worm/deleteworm', array('error' => ' ' ));
        }
    	//worm section ends

	 //other worm section starts
        public function addotherworm(){
            $this->load->view('/otherworm/addotherworm', array('error' => ' ' ));
        }
        public function getotherworm(){
            $this->load->view('/otherworm/getotherworm', array('error' => ' ' ));
        }
        public function updateotherworm(){
            $this->load->view('/otherworm/updateotherworm', array('error' => ' ' ));
        }
        public function deleteotherworm(){
            $this->load->view('/otherworm/deleteotherworm', array('error' => ' ' ));
        }
	//other worm section ends

	public function becomefoster(){
           $this->load->view('/becomefoster', array('error' => ' ' ));
        }

	public function getcarevacworm(){
           $this->load->view('/getcarevacworm', array('error' => ' ' ));
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
		
		
		// for activity tracker data
		
		
		public function addtrackerdata(){
                $this->load->view('add_tracker_data', array('error' => ' ' ));
        }
		
		public function gettrackerdata(){
                $this->load->view('get_tracker_data', array('error' => ' ' ));
        }
		
}
?>

