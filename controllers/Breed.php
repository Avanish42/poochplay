<?php
/*
 * File Name: Breed.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Breed extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this -> load -> library('session');
        $this -> load -> helper('form');
        $this -> load -> helper('url');
        $this -> load -> database();
        $this -> load -> library('form_validation');
        //load the breed model
        $this -> load -> model('breed_model');
    }
   
    function index() {
        if (empty($this -> session -> userdata) || $this -> session -> userdata==null ||  $this -> session -> userdata['loginuser'] == FALSE) {
            redirect('login/index');
        }else{
            $data['breed'] = $this -> breed_model -> get_breed_record('all');
            $this -> load -> view('commons/header');
            $this -> load -> view('commons/topnav');
            $this -> load -> view('commons/sidebar');
            $this -> load -> view('breed_list_view', $data);
            $this -> load -> view('commons/footer.php');
        }
    }
   
    function add($breed_id = 0) {
        $data['breed_id'] = 0;
        $data['breedrecord'] = $this -> breed_model -> get_breed_record('all');
        //set validation rules
        $this -> form_validation -> set_rules('breedname', 'Breed Name', 'trim|required');
       
        if ($this -> form_validation -> run() == FALSE) {
            //fail validation
            $this -> load -> view('commons/header');
            $this -> load -> view('commons/topnav');
            $this -> load -> view('commons/sidebar');
         
             $this -> load -> view('breed_view', $data);
            
            $this -> load -> view('commons/footer.php');
        } else {
            //pass validation
            $active = false;
            if(!empty($this -> input -> post('active')) || $this -> input -> post('active') != null)
                $active = true;

            $breed_name = $this -> input -> post('breedname');
            $origin = $this -> input -> post('origin');
            $remark = $this -> input -> post('remark');

            $life_span = $this -> input -> post('lifespan');
            $weight_male = $this -> input -> post('weightmale');
            $weight_female = $this -> input -> post('weightfemale');
            $height_male = $this -> input -> post('heightmale');
            $height_female = $this -> input -> post('heightfemale');
            $temperament = $this -> input -> post('temperament');
            $target = $this -> input -> post('target');
            $manual = $this -> input -> post('manual');
            $breed = $this -> input -> post('breed');



            //create folder
            //server path
            $uploadPath = '/var/www/html/images/';       
            //local path
            //$uploadPath = '/opt/lampp/htdocs/pets/images/';       

            if (!is_dir($uploadPath)){
                mkdir($uploadPath, 0777, true);
            }
   
            $dir_exist = true; // flag for checking the directory exist or not

            if (!is_dir($uploadPath . 'breeds/')){
                mkdir($uploadPath . 'breeds/', 0777, true);
                $dir_exist = false; // dir not exist
            }

            $this->load->library('upload');

            $config['upload_path']          = $uploadPath . 'breeds/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['file_name']        = $breed_name;
   
            $this->upload->initialize($config);

            $updatedBreedPath=null;   
            if ( $this->upload->do_upload('image')){
               $updatedBreedPath='images/breeds/'.$this->upload->data('file_name');   
            }
		
            //updated breed info
	    if($updatedBreedPath==null)	
   	         $data = array('breed_name' => $breed_name, 'remark' => $remark, 'active_status' => $active,'origin'=>$origin,'life_span'=>$life_span,'weight_male'=>$weight_male,'weight_female'=>$weight_female,'height_male'=>$height_male,'height_female'=>$height_female,'temperament'=>$temperament,'target'=>$target ,'manual_activity'=>$manual,'breed_cat'=>$breed);
	    else
   	         $data = array('breed_name' => $breed_name, 'remark' => $remark, 'active_status' => $active,'origin'=>$origin,'life_span'=>$life_span,'weight_male'=>$weight_male,'weight_female'=>$weight_female,'height_male'=>$height_male,'height_female'=>$height_female,'temperament'=>$temperament,'image_path'=>$updatedBreedPath,'manual_activity'=>$manual,'breed_cat'=>$breed);
           
            //create user
            $this -> breed_model -> insert_breed($data);

            //display success message
            $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">Breed added !!!</div>');
           redirect('Breed/add');
        }

    }

    function update($breed_id) {

        $data['breed_id'] = $breed_id;
        //fetch user record for the given id
        $data['breedrecord'] = $this -> breed_model -> get_breed_record($breed_id);
        //set validation rules
        $this -> form_validation -> set_rules('breedname', 'Breed Name', 'trim|required');
       
        if ($this -> form_validation -> run()    == FALSE) {
            //fail validation
            $this -> load -> view('commons/header');
            $this -> load -> view('commons/topnav');
            $this -> load -> view('commons/sidebar');
            $this -> load -> view('breed_view', $data);
            $this -> load -> view('commons/footer.php');
        } else {

            $active = false;
            if(!empty($this -> input -> post('active')) || $this -> input -> post('active') != null)
            $active = true;

            $breed_name = $this -> input -> post('breedname');
            $origin = $this -> input -> post('origin');
            $remark = $this -> input -> post('remark');

            $life_span = $this -> input -> post('lifespan');
            $weight_male = $this -> input -> post('weightmale');
            $weight_female = $this -> input -> post('weightfemale');
            $height_male = $this -> input -> post('heightmale');
            $height_female = $this -> input -> post('heightfemale');
            $temperament = $this -> input -> post('temperament');
            $target = $this -> input -> post('target');
            $manual = $this -> input -> post('manual');
            $breed = $this -> input -> post('breed');



            //create folder
            //server path
            $uploadPath = '/var/www/html/images/';       
            //local path
            //$uploadPath = '/opt/lampp/htdocs/pets/images/';       

            if (!is_dir($uploadPath)){
                mkdir($uploadPath, 0777, true);
            }
   
            $dir_exist = true; // flag for checking the directory exist or not

            if (!is_dir($uploadPath . 'breeds/')){
                mkdir($uploadPath . 'breeds/', 0777, true);
                $dir_exist = false; // dir not exist
            }

            $this->load->library('upload');

            $config['upload_path']      = $uploadPath . 'breeds/';
            $config['allowed_types']    = 'gif|jpg|jpeg|png';
            $config['file_name']        = $breed_name;
   
            $this->upload->initialize($config);

            $updatedBreedPath=null;   
            if ( $this->upload->do_upload('image')){
               $updatedBreedPath='images/breeds/'.$this->upload->data('file_name');   
            }
		
            //updated breed info
	    if($updatedBreedPath==null)	
   	          $data = array('breed_name' => $breed_name, 'remark' => $remark, 'active_status' => $active,'origin'=>$origin,'life_span'=>$life_span,'weight_male'=>$weight_male,'weight_female'=>$weight_female,'height_male'=>$height_male,'height_female'=>$height_female,'temperament'=>$temperament,'target'=>$target ,'manual_activity'=>$manual,'breed_cat'=>$breed);
        else
             $data = array('breed_name' => $breed_name, 'remark' => $remark, 'active_status' => $active,'origin'=>$origin,'life_span'=>$life_span,'weight_male'=>$weight_male,'weight_female'=>$weight_female,'height_male'=>$height_male,'height_female'=>$height_female,'temperament'=>$temperament,'image_path'=>$updatedBreedPath,'manual_activity'=>$manual,'breed_cat'=>$breed);
		

            $this -> breed_model ->update_breed($breed_id,$data);

            //display success message
            $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">Breed updated !!!</div>');
            redirect("Breed/update/" . $breed_id);
        }
    }


	function import() {
	$this -> load -> view('commons/header');
        $this -> load -> view('commons/topnav');
        $this -> load -> view('commons/sidebar');
	$data = array('upload_data' => '');	
        $this -> load -> view('breed_import',$data);
        $this -> load -> view('commons/footer.php');
    }	

    //import breed
    function importsubmit() {
        
            //create folder
            //server path
            $uploadPath = '/var/www/html/images/';       
            //local path
            //$uploadPath = '/opt/lampp/htdocs/pets/images/';       

            if (!is_dir($uploadPath)){
                mkdir($uploadPath, 0777, true);
            }
   
            $dir_exist = true; // flag for checking the directory exist or not

            if (!is_dir($uploadPath . 'breeds/')){
                mkdir($uploadPath . 'breeds/', 0777, true);
                $dir_exist = false; // dir not exist
            }

            $this->load->library('upload');

            $config['upload_path']          = $uploadPath . 'breeds/';
            $config['allowed_types']        = 'csv';
	    $config['encrypt_name'] = FALSE;
	    $config['remove_spaces'] = TRUE;
            //$config['file_name']        = 'import';
   
            $this->upload->initialize($config);

            $updatedBreedPath=null;   
            if ( $this->upload->do_upload('file')){
               $updatedBreedPath='images/breeds/'.$this->upload->data('file_name');   
            }
		
	    $data = array();
            //updated breed info
	    if($updatedBreedPath==null){
		$data = array('upload_data' => $this->upload->display_errors());
	
		//display error message
            	$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">Please upload file...</div>');	
	    }else{
		$this->load->library('CSVReader');
		$csvData = $this->csvreader->parse_file($uploadPath.'breeds/'.$this->upload->data('file_name')); 
		//print_r($this->csvreader);
		//echo "** data ".$uploadPath.'breeds/'.$this->upload->data('file_name');
		
		foreach($csvData as $csv){
		    $breed_name = $csv['breed_name'];
		    $remark = $csv['remark'];
		    $temperament = $csv['temperament'];	
		    $temperament = str_replace("#", ",",$temperament);	
		    $active = true; 
		    $origin = $csv['origin'];
		    $life_span = $csv['life_span'];
		    $weight_male = $csv['weight_male'];
		    $weight_female = $csv['weight_female'];	
		    $height_male = $csv['height_male'];
		    $height_female = $csv['height_female'];
		    $target = $csv['target'];
		    $temperament = $csv['temperament'];	
		    $temperament = str_replace("#", ",",$temperament);
		
		    $data = array('breed_name' => $breed_name, 'remark' => $remark, 'active_status' => $active,'origin'=>$origin,'life_span'=>$life_span,'weight_male'=>$weight_male,'weight_female'=>$weight_female,'height_male'=>$height_male,'height_female'=>$height_female,'temperament'=>$temperament,'target'=>$target);
		
		    //create breed
            	    $this -> breed_model -> insert_breed($data);
		}
		
		//parse data and record it.   	         

		$data = array('upload_data' => $this->upload->data());
            	//display success message
            	$this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">Breed imported !!!</div>');	
	    }
            
            $this -> load -> view('commons/header');
            $this -> load -> view('commons/topnav');
            $this -> load -> view('commons/sidebar');
            $this -> load -> view('breed_import',$data);
            $this -> load -> view('commons/footer.php');
    }		

}

?>
