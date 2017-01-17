<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class WebService extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> library('session');
		$this -> load -> database();
		$this -> load -> library('form_validation');
		//load the all model
		$this -> load -> model('login_model');
		$this -> load -> model('user_model');
		$this -> load -> model('breed_model');
		$this -> load -> model('pet_model');
		$this -> load -> model('appointment_model');
		$this -> load -> model('galimages_model');
		$this -> load -> model('notificationandroid_model');
		$this -> load -> model('notificationios_model');
		$this -> load -> model('care_model');
		$this -> load -> model('mc_model');
		$this -> load -> model('ins_model');
		$this -> load -> model('story_model');
		$this -> load -> model('foster_model');
		$this -> load -> model('vaccination_model');	
		$this -> load -> model('othervaccination_model');
		$this -> load -> model('worm_model');
	    $this -> load -> model('otherworm_model');
		$this -> load -> model('tracker_model');
		$this -> load -> model('cron_model');
	}

	public function login() {
		//get the posted values
		$username = $this -> input -> post('username', TRUE);
		$password = $this -> input -> post('password', TRUE);
		$os_type = $this -> input -> post('os_type', TRUE);
		$device_id = $this -> input -> post('device_id', TRUE);

		$postdata = array('username' => $username, 'password' => $password,'os_type' => $os_type, 'device_id' => $device_id);
		//set data for validation
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules("username", "Username", "trim|required");
		$this -> form_validation -> set_rules("password", "Password", "trim|required");
		$this -> form_validation -> set_rules("os_type", "os type", "trim|required");
		$this -> form_validation -> set_rules("device_id", "device id", "trim|required");
	       
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
		    //validation succeeds
		    //check if username and password is correct
		    $usr_result = $this -> login_model -> get_user($username, $password, 2);
		    if ($usr_result > 0)//active user record is present
		    {
		        //set the session variables
		        $sessiondata = array('username' => $username, 'loginuser' => TRUE);
		        $this -> session -> set_userdata($sessiondata);
			
			$this ->user_model->update_user($username,array('os_type' => $os_type, 'device_id' => $device_id));

		        //echo "user logged in ";
		        $arr = array('error' => 'false', 'message' => 'User Login Successfully.', 'pets' =>$this -> getallpetinternally($username), 'userdetail' => $this -> getUserDetailArrayFromEmail($username));
		    } else {
		        //echo "user not found";
		        $arr = array('error' => 'true', 'message' => 'Email or Password is wrong.');
		    }

		}

		//add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
	    }


	//reset password
	public function resetpassword() {
		//get the posted values
		$email = $this -> input -> post('email', TRUE);
		$oldpassword = $this -> input -> post('oldpassword', TRUE);
		$newpassword = $this -> input -> post('newpassword', TRUE);

		$postdata = array('email' => $email, 'oldpassword' => $oldpassword,'newpassword' => $newpassword);
		//set data for validation
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules("email", "email", "trim|required");
		$this -> form_validation -> set_rules("oldpassword", "oldpassword", "trim|required");
		$this -> form_validation -> set_rules("newpassword", "newpassword", "trim|required");
	       
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
		    //validation succeeds
		    //check if username and password is correct
		    $usr_result = $this -> login_model -> get_user($email, $oldpassword, 2);
		    if ($usr_result > 0)//active user record is present
		    {
		        			
			$this ->user_model->update_password($newpassword,$email);

		        //echo "user logged in ";
		        $arr = array('error' => 'false', 'message' => 'Password Updated Successfully.');
		    } else {
		        //echo "user not found";
		        $arr = array('error' => 'true', 'message' => 'Your old password did not match.');
		    }

		}

		//add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
	    }

	public function getUserDetailArrayFromEmail($email){
		$userObj = $this->user_model->get_user_record_by_email($email);
		$userdetail = array();		
		if(!empty($userObj)){			
			$userdetail['id'] = $userObj[0]->id;
			$userdetail['first_name'] = $userObj[0]->first_name;
			$userdetail['last_name'] = $userObj[0]->last_name;
			$userdetail['email'] = $userObj[0]->email;
			$userdetail['mobileno'] = $userObj[0]->mobileno;
			$userdetail['city'] = $userObj[0]->city;
			$userdetail['state'] = $userObj[0]->state;
			$userdetail['postcode'] = $userObj[0]->postcode;
			$userdetail['country'] = $userObj[0]->country;

			$notification = $userObj[0]->notification ? 'true' : 'false';
			if($userObj[0]->notification =='t')
				$notification = 'true';
			else
				$notification = 'false';		
			$userdetail['notification']= $notification; 

			$userdetail['door'] = $userObj[0]->door;
			if($userObj[0]->profile_pic != null)	
				$userdetail['profile_pic']= $this->config->base_url().$userObj[0]->profile_pic; 
			else	
				$userdetail['profile_pic']= null; 
		}
		return $userdetail;
	}

	public function register() {
		//get the posted values
		$firstname = $this -> input -> post('firstname', TRUE);
		$lastname = $this -> input -> post('lastname', TRUE);
		$email = $this -> input -> post('email', TRUE);
		$password = $this -> input -> post('password', TRUE);
		$os_type = $this -> input -> post('os_type', TRUE);
		$device_id = $this -> input -> post('device_id', TRUE);
		$maxid = $this -> user_model -> getNewid();


		$postdata = array('password' => $password, 'first_name' => $firstname, 'last_name' => $lastname, 'email' => $email, 'role_id' => 2,'os_type' => $os_type, 'device_id' => $device_id);

		//set data for validation
		$this -> form_validation -> set_data($postdata);

		//set validations
		//$this -> form_validation -> set_rules('first_name', 'First Name', 'trim|required');
		//$this -> form_validation -> set_rules('last_name', 'Last Name', 'trim|required');
		$this -> form_validation -> set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
		$this -> form_validation -> set_rules('password', 'Password', 'required');

		$this -> form_validation -> set_message('is_unique', 'The %s is already exits');

		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
		    //validation succeeds
		    //create user
		    $this->user_model->create_user($postdata);
		    $arr = array('error' => 'false', 'message' => 'Registered Successfully...');
		}

		//add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
	    }

	function forgotpassword(){
		//
		$email = $this -> input -> post('email', TRUE);
		$postdata = array('email' => $email);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('email', 'Email', 'trim|required');

		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
		    $userObj = $this->user_model->get_user_record_by_email($email);	
		    if(empty($userObj)){
			$arr = array('error' => 'true', 'message' => 'Email not found');
		    }else{
			//reset password
		    	$newpassword = $this->user_model->reset_password($email);
		    	$arr = array('error' => 'false', 'message' => "Password  $newpassword sent to registered email");
		    }		
		    
		}
		//add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
	    }	
	
	//get breed
	function getbreed(){
		$breed_list = $this->breed_model->get_breed_record('all');
		//print_r($breed_list);
		$arr = array('error' => 'true', 'message' => 'No Breed Found');
		if(!empty($breed_list)){
			$breedList = array();	
			foreach ($breed_list as $breed){
				$singlebreed = array();
				$singlebreed['id']=$breed->id;
				$singlebreed['breed_name']=$breed->breed_name;
				$singlebreed['active_status']=$breed->active_status;
				$singlebreed['origin']=$breed->origin;
				$singlebreed['life_span']=$breed->life_span;
				$singlebreed['weight_male']=$breed->weight_male;
				$singlebreed['weight_female']=$breed->weight_female;
				$singlebreed['height_male']=$breed->height_male;
				$singlebreed['height_female']=$breed->height_female;
				$singlebreed['temperament']=$breed->temperament;
				$singlebreed['target']=$breed->target;
				if($breed->image_path != null)
					$singlebreed['image_path']=$this->config->base_url().$breed->image_path;
				else
					$singlebreed['image_path']=null;
				array_push($breedList,$singlebreed);
			}
			$arr = array('error' => 'false', 'message' => 'Breed Found','breed' => $breedList);
		}
		//add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
	}
	
	//add pet
	function addpet(){
		//Fields inside users - owner_name, country, city, postcode, user_email
		//Fields inside pet - petname, breed_id, sex, fathers_breed_id, mothers_breed, dob(in long), current_weight, current_height,  
		//microchip_id, pet_type, lifestyle, trained, neutred, swimmer, temparement_ok_dog, temparement_ok_cat, temparement_ok_people, temparement_ok_child		

		//get the posted values
		//update first user related values 

		//get the posted values
		$email = $this -> input -> post('user_email', TRUE);
		$petname = $this -> input -> post('petname', TRUE);
		$breed_id = $this -> input -> post('breed_id', TRUE);

		$postdata = array('email' => $email,'petname'=>$petname,'breed_id'=>$breed_id);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('petname', 'Pet Name', 'trim|required');
		$this -> form_validation -> set_rules('breed_id', 'Breed Id', 'trim|required');


		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {

			$owner_name = $this -> input -> post('owner_name', TRUE);
			$first_name = $owner_name;
			$last_name = "";
			$pieces = explode(" ", $owner_name);
			if(!empty($pieces[0]) && !empty($pieces[1])){
				$first_name = $pieces[0];
				$last_name = $pieces[1]; 
			}
			$country = $this -> input -> post('country', TRUE);
			$city = $this -> input -> post('city', TRUE);
			$postcode = $this -> input -> post('postcode', TRUE);
			$door = $this -> input -> post('door', TRUE);
			$postdata = array('first_name' => $first_name, 'last_name' => $last_name, 'postcode' => $postcode, 'country' => $country, 'city' => $city, 'door' => $door);
			$this->user_model->update_user($email,$postdata);		
			
			$sex = $this -> input -> post('sex', TRUE);
			$fathers_breed_id = $this -> input -> post('fathers_breed_id', TRUE);
			$fathers_breed_id = (int)$fathers_breed_id;
			$mothers_breed_id = $this -> input -> post('mothers_breed_id', TRUE);
			$mothers_breed_id = (int)$mothers_breed_id;
			//convert long to sql date 
			$dob = $this -> input -> post('dob', TRUE);
		
			$current_weight = $this -> input -> post('current_weight', TRUE);
			$current_height = $this -> input -> post('current_height', TRUE);
		
			$microchip_id = $this -> input -> post('microchip_id', TRUE);
			$pet_type = $this -> input -> post('pet_type', TRUE); 
			$lifestyle = $this -> input -> post('lifestyle', TRUE); 
			$trained = $this -> input -> post('trained', TRUE); 
			$neutred = $this -> input -> post('neutred', TRUE); 
			$swimmer = $this -> input -> post('swimmer', TRUE); 
			$temparement_ok_dog = $this -> input -> post('temparement_ok_dog', TRUE); 
			$temparement_ok_cat = $this -> input -> post('temparement_ok_cat', TRUE);
			$temparement_ok_people = $this -> input -> post('temparement_ok_people', TRUE); 
			$temparement_ok_child = $this -> input -> post('temparement_ok_child', TRUE);
		
			$adoption_date = $this -> input -> post('adoption_date', TRUE);
			$spayed = $this -> input -> post('spayed', TRUE); 
			$allergies = $this -> input -> post('allergies', TRUE); 
			$medical_conditions = $this -> input -> post('medical_conditions', TRUE); 
			$medicines = $this -> input -> post('medicines', TRUE); 
			$likes = $this -> input -> post('likes', TRUE); 
			$dislikes = $this -> input -> post('dislikes', TRUE);
			$incidents = $this -> input -> post('incidents', TRUE); 
			
			/*$ins_provider = $this -> input -> post('ins_provider', TRUE); 
			$ins_policy_no = $this -> input -> post('ins_policy_no', TRUE); 
			$ins_renewal_date = $this -> input -> post('ins_renewal_date', TRUE); 
	 		*/
		
			$postdata = array('name' => $petname,'breed_id'=>$breed_id, 'sex' => $sex, 'birth_date'=>$dob,'current_weight'=>$current_weight,'current_height'=>$current_height,'fathers_breed'=>$fathers_breed_id,'mothers_breed'=>$mothers_breed_id,'microchip_id'=>$microchip_id,'pet_type'=>$pet_type,'lifestyle'=>$lifestyle,'neutered'=>$neutred,'trained'=>$trained,'swimmer'=>$swimmer,'temparement_ok_dog'=>$temparement_ok_dog,'temparement_ok_cat'=>$temparement_ok_cat,'temparement_ok_people'=>$temparement_ok_people,'temparement_ok_child'=>$temparement_ok_child,'adoption_date'=>$adoption_date,'spayed'=>$spayed,'allergies'=>$allergies,'medical_conditions'=>$medical_conditions,'medicines'=>$medicines,'likes'=>$likes,'dislikes'=>$dislikes,'incidents'=>$incidents);
		
			//create pet
			$petid = $this->pet_model->addPet($postdata);
		
			//create mapping of pet and user
			$this->pet_model->addPetUserMapping($petid,$email);
		
			//create folder 
			//server path
			$uploadPath = '/var/www/html/images/';		
			//local path
			//$uploadPath = '/opt/lampp/htdocs/pets/images/';		

			if (!is_dir($uploadPath)){
				mkdir($uploadPath, 0777, true);
			}
	
			$dir_exist = true; // flag for checking the directory exist or not

			if (!is_dir($uploadPath . $petid)){
				mkdir($uploadPath . $petid, 0777, true);
				$dir_exist = false; // dir not exist
			}

			$this->load->library('upload');

			$config['upload_path']          = $uploadPath . $petid ;
		        $config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['file_name']        = 'petpic';
		
		        //$config['max_size']             = 100;
		        //$config['max_width']            = 1024;
		        //$config['max_height']           = 768;

			$this->upload->initialize($config);

			$petpic = "";	
			$updatedPicPath=null;	
		        if ( $this->upload->do_upload('petpic')){
				//rmdir 
				//rmdir('./uploads/' . $album);
				//, 'petpic'=>
				$petpic = $this->config->base_url().'images/'.$petid.'/'.$this->upload->data('file_name');
				$updatedPicPath='images/'.$petid.'/'.$this->upload->data('file_name');	
			
				//ins_upload
				$config['upload_path']          = $uploadPath . $petid ;
				$config['file_name']        = 'petinsurance';
			       	$this->upload->initialize($config);

				/*$petins = "";	
				$updatedPicIns=null;	
				if ( $this->upload->do_upload('ins_upload')){
					//rmdir 
					//rmdir('./uploads/' . $album);
					//, 'petpic'=>
					$petins = $this->config->base_url().'images/'.$petid.'/'.$this->upload->data('file_name');
					$updatedPicIns = 'images/'.$petid.'/'.$this->upload->data('file_name');
			
				}*/
				
			
		        } 

			//update pet image path
			if($updatedPicPath != null){
				$postdata = array('pet_img_path' => $updatedPicPath);
				$this->pet_model->updatePet($petid,$postdata);
			}
			$arr = array('error' => 'false', 'message' => 'Pet Added Successfully.', 'petid' => $petid ,'petpic' => $petpic);		
		        
			
	}
		//add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
	} 


	//update pet need petid
	function updatepet(){
		//get the posted values
		$email = $this -> input -> post('user_email', TRUE);
		$petname = $this -> input -> post('petname', TRUE);
		$petid = $this -> input -> post('petid', TRUE);
		$breed_id = $this -> input -> post('breed_id', TRUE);

		$postdata = array('email' => $email,'petname'=>$petname,'petid'=>$petid,'breed_id'=>$breed_id);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('petname', 'Pet Name', 'trim|required');
		$this -> form_validation -> set_rules('petid', 'Pet Id', 'trim|required');

		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {

			$owner_name = $this -> input -> post('owner_name', TRUE);
			$first_name = $owner_name;
			$last_name = "";
			$pieces = explode(" ", $owner_name);
			if(!empty($pieces[0]) && !empty($pieces[1])){
				$first_name = $pieces[0];
				$last_name = $pieces[1]; 
			}
			$country = $this -> input -> post('country', TRUE);
			$city = $this -> input -> post('city', TRUE);
			$postcode = $this -> input -> post('postcode', TRUE);
			$door = $this -> input -> post('door', TRUE);
			$postdata = array('first_name' => $first_name, 'last_name' => $last_name, 'postcode' => $postcode, 'country' => $country, 'city' => $city, 'door' => $door);
			$this->user_model->update_user($email,$postdata);
		

			$sex = $this -> input -> post('sex', TRUE);
			$fathers_breed_id = $this -> input -> post('fathers_breed_id', TRUE);
			$fathers_breed_id = (int)$fathers_breed_id;
			$mothers_breed_id = $this -> input -> post('mothers_breed_id', TRUE);
			$mothers_breed_id = (int)$mothers_breed_id;
			//convert long to sql date 
			$dob = $this -> input -> post('dob', TRUE);
		
			$current_weight = $this -> input -> post('current_weight', TRUE);
			$current_height = $this -> input -> post('current_height', TRUE);
		
			$microchip_id = $this -> input -> post('microchip_id', TRUE);
			$pet_type = $this -> input -> post('pet_type', TRUE); 
			$lifestyle = $this -> input -> post('lifestyle', TRUE); 
			$trained = $this -> input -> post('trained', TRUE); 
			$neutred = $this -> input -> post('neutred', TRUE); 
			$swimmer = $this -> input -> post('swimmer', TRUE); 
			$temparement_ok_dog = $this -> input -> post('temparement_ok_dog', TRUE); 
			$temparement_ok_cat = $this -> input -> post('temparement_ok_cat', TRUE);
			$temparement_ok_people = $this -> input -> post('temparement_ok_people', TRUE); 
			$temparement_ok_child = $this -> input -> post('temparement_ok_child', TRUE);
		
			$adoption_date = $this -> input -> post('adoption_date', TRUE);
			$spayed = $this -> input -> post('spayed', TRUE); 
			$allergies = $this -> input -> post('allergies', TRUE); 
			$medical_conditions = $this -> input -> post('medical_conditions', TRUE); 
			$medicines = $this -> input -> post('medicines', TRUE); 
			$likes = $this -> input -> post('likes', TRUE); 
			$dislikes = $this -> input -> post('dislikes', TRUE);
			$incidents = $this -> input -> post('incidents', TRUE); 
			
			/*$ins_provider = $this -> input -> post('ins_provider', TRUE); 
			$ins_policy_no = $this -> input -> post('ins_policy_no', TRUE); 
			$ins_renewal_date = $this -> input -> post('ins_renewal_date', TRUE); */
	 
		
			$postdata = array('name' => $petname,'breed_id'=>$breed_id, 'sex' => $sex, 'birth_date'=>$dob,'current_weight'=>$current_weight,'current_height'=>$current_height,'fathers_breed'=>$fathers_breed_id,'mothers_breed'=>$mothers_breed_id,'microchip_id'=>$microchip_id,'pet_type'=>$pet_type,'lifestyle'=>$lifestyle,'neutered'=>$neutred,'trained'=>$trained,'swimmer'=>$swimmer,'temparement_ok_dog'=>$temparement_ok_dog,'temparement_ok_cat'=>$temparement_ok_cat,'temparement_ok_people'=>$temparement_ok_people,'temparement_ok_child'=>$temparement_ok_child,'adoption_date'=>$adoption_date,'spayed'=>$spayed,'allergies'=>$allergies,'medical_conditions'=>$medical_conditions,'medicines'=>$medicines,'likes'=>$likes,'dislikes'=>$dislikes,'incidents'=>$incidents);
		
			//create pet
			//$petid = $this->pet_model->addPet($postdata);
		
			//create mapping of pet and user
			//$this->pet_model->addPetUserMapping($petid,$email);
		
			//create folder 
			//server path
			$uploadPath = '/var/www/html/images/';		
			//local path
			//$uploadPath = '/opt/lampp/htdocs/pets/images/';		

			if (!is_dir($uploadPath)){
				mkdir($uploadPath, 0777, true);
			}
	
			$dir_exist = true; // flag for checking the directory exist or not

			if (!is_dir($uploadPath . $petid)){
				mkdir($uploadPath . $petid, 0777, true);
				$dir_exist = false; // dir not exist
			}

			$this->load->library('upload');

			$config['upload_path']          = $uploadPath . $petid ;
		        $config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['file_name']        = 'petpic';
		
		        //$config['max_size']             = 100;
		        //$config['max_width']            = 1024;
		        //$config['max_height']           = 768;

			$this->upload->initialize($config);

			$petpic = "";	
			$updatedPicPath=null;	
		        if ( $this->upload->do_upload('petpic')){
				//rmdir 
				//rmdir('./uploads/' . $album);
				//, 'petpic'=>
				$petpic = $this->config->base_url().'images/'.$petid.'/'.$this->upload->data('file_name');
				$updatedPicPath='images/'.$petid.'/'.$this->upload->data('file_name');	
				//ins_upload
				$config['upload_path']          = $uploadPath . $petid ;
				$config['file_name']        = 'petinsurance';
			       	$this->upload->initialize($config);

				/*$petins = "";	
				$updatedPicIns=null;	
				if ( $this->upload->do_upload('ins_upload')){
					//rmdir 
					//rmdir('./uploads/' . $album);
					//, 'petpic'=>
					$petins = $this->config->base_url().'images/'.$petid.'/'.$this->upload->data('file_name');
					$updatedPicIns = 'images/'.$petid.'/'.$this->upload->data('file_name');
			
				}*/

				//update pet image path
				if($updatedPicPath != null){
					$postdata['pet_img_path'] = $updatedPicPath;
					//$postdata['pet_ins_path'] = $updatedPicIns;				
				}
				$this->pet_model->updatePet($petid,$postdata);
	
				$petObj = $this->pet_model->getPet($petid);
				$petImg = null;
				$petIns = null;
				if($petObj[0]->pet_img_path != null && !empty($petObj[0]->pet_img_path))
		  	          $petImg = $this->config->base_url().$petObj[0]->pet_img_path;
			
				/*if($petObj[0]->pet_ins_path != null && !empty($petObj[0]->pet_ins_path))
				  $petIns = $this->config->base_url().$petObj[0]->pet_ins_path;*/

				$arr = array('error' => 'false', 'petid' => $petid ,'message' => 'pet updated successfully','petpic' => $petImg);	
		        }

				//update pet image path
				if($updatedPicPath != null){
					$postdata['pet_img_path'] = $updatedPicPath;
					//$postdata['pet_ins_path'] = $updatedPicIns;				
				}
				$this->pet_model->updatePet($petid,$postdata);
	
				$petObj = $this->pet_model->getPet($petid);
				$petImg = null;
				$petIns = null;
				if($petObj[0]->pet_img_path != null && !empty($petObj[0]->pet_img_path))
		  	          $petImg = $this->config->base_url().$petObj[0]->pet_img_path;
			
				/*if($petObj[0]->pet_ins_path != null && !empty($petObj[0]->pet_ins_path))
				  $petIns = $this->config->base_url().$petObj[0]->pet_ins_path;*/

				$arr = array('error' => 'false', 'petid' => $petid ,'message' => 'Pet updated successfully','petpic' => $petImg);		
		        
				
	}
		//add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
	}

	//get pet need petid
    function getpet(){
        $petid = $this -> input -> post('petid', TRUE);
        $email = $this -> input -> post('email', TRUE);
       
        $postdata = array('email' => $email,'petid'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('petid', 'Pet Id', 'trim|required');

        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
            $petObj = $this->pet_model->getPet($petid);
            if($petObj[0] != null){
                $petdetail = array();
                $petdetail['id'] = $petObj[0]->id;
                $petdetail['name'] = $petObj[0]->name;
                $petdetail['sex'] = $petObj[0]->sex;
                $petdetail['age'] = $petObj[0]->age;//need auto calcualtion here
                $petdetail['breed_id'] = $petObj[0]->breed_id;
                $petdetail['fathers_breed'] = $petObj[0]->fathers_breed;
                $petdetail['mothers_breed'] = $petObj[0]->mothers_breed;
                $petdetail['current_height'] = $petObj[0]->current_height;
                $petdetail['current_weight'] = $petObj[0]->current_weight;
                $petdetail['microchip_id'] = $petObj[0]->microchip_id;
                $petdetail['pet_type'] = $petObj[0]->pet_type;
                $petdetail['lifestyle'] = $petObj[0]->lifestyle;
                $petdetail['neutered'] = $petObj[0]->neutered;
                $petdetail['trained'] = $petObj[0]->trained;
                $petdetail['temparement_ok_dog'] = $petObj[0]->temparement_ok_dog;
                $petdetail['temparement_ok_cat'] = $petObj[0]->temparement_ok_cat;
                $petdetail['temparement_ok_people'] = $petObj[0]->temparement_ok_people;
                $petdetail['temparement_ok_child'] = $petObj[0]->temparement_ok_child;
                /*$petdetail['ins_provider'] = $petObj[0]->ins_provider;
                //$petdetail['ins_policy_no'] = $petObj[0]->ins_policy_no;
                //$petdetail['ins_renewal_date'] = $petObj[0]->ins_renewal_date;
                $petdetail['mc_start_date'] = $petObj[0]->mc_start_date;
                $petdetail['mc_end_date'] = $petObj[0]->mc_end_date;
                $petdetail['expected_mc_date'] = $petObj[0]->expected_mc_date;
                $petdetail['mc_notes'] = $petObj[0]->mc_notes;*/
                $petdetail['swimmer'] = $petObj[0]->swimmer;
                $petdetail['birth_date'] = $petObj[0]->birth_date;
                $petdetail['adoption_date'] = $petObj[0]->adoption_date;   
                $petdetail['allergies'] = $petObj[0]->allergies;
                $petdetail['medical_conditions'] = $petObj[0]->medical_conditions;
                $petdetail['medicines'] = $petObj[0]->medicines;
                $petdetail['likes'] = $petObj[0]->likes;
                $petdetail['dislikes'] = $petObj[0]->dislikes;
                $petdetail['incidents'] = $petObj[0]->incidents;
                $petdetail['spayed'] = $petObj[0]->spayed;
               
		if($petObj[0]->pet_img_path != null && !empty($petObj[0]->pet_img_path))
  	          $petdetail['pet_img_path'] = $this->config->base_url().$petObj[0]->pet_img_path;
		else
		  $petdetail['pet_img_path'] = null;

		/*if($petObj[0]->pet_ins_path != null && !empty($petObj[0]->pet_ins_path))
		  $petdetail['pet_ins_path'] = $this->config->base_url().$petObj[0]->pet_ins_path;
		else
		  $petdetail['pet_ins_path'] = null;*/  
             
		//return pet's original owner email
		$userid = $this->pet_model->getPetsOwnerUserId($petObj[0]->id);
		$userObj = $this -> user_model -> get_user_record($userid);
		if(!empty($userObj)){
			$petdetail['owner_email'] =$userObj[0]->email;	
		}	
	
                //return user specific data
                $userObj = $this -> user_model -> get_user_record_by_email($email);
                if(!empty($userObj[0]) && $userObj[0] != null){
                    if(!empty($userObj[0]->first_name) && !empty($userObj[0]->last_name))
                        $petdetail['owner_name'] = $userObj[0]->first_name.' '.$userObj[0]->last_name;
                    else if(!empty($userObj[0]->first_name))   
                        $petdetail['owner_name'] = $userObj[0]->first_name;
   
                    $petdetail['postcode'] = $userObj[0]->postcode;
                    $petdetail['country'] = $userObj[0]->country;
                    $petdetail['city'] = $userObj[0]->city;
                    $petdetail['door'] = $userObj[0]->door;
                }

                   $arr = array('error' => 'false', 'message' => 'Pet Found.', 'petdetail' => $petdetail);
            }else{
                $arr = array('error' => 'true', 'message' => 'petid is not valid.');
            }
        }
        //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

	//get all pet need useremail
    function getallpet(){
        $email = $this -> input -> post('email', TRUE);
       
        $postdata = array('email' => $email);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('email', 'Email', 'trim|required');

        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
   	    $arr = $this -> getallpetinternally($email);
	}
	    
        //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
	
    function getallpetinternally($email){	
	$userObj = $this -> user_model -> get_user_record_by_email($email);
	$petList = array();	 
	    if(!empty($userObj[0]) && $userObj[0] != null){	
  		    $petMapObj = $this->pet_model->getAllPetByUserId($userObj[0]->id);
		    foreach($petMapObj as $petMap){	
			    //print_r($petMap->pet_id);	
			    $petObj = $this->pet_model->getPet($petMap->pet_id);
			    //
			    if($petObj!=null){	
				$petdetail = array();
				$petdetail['id'] = $petObj[0]->id;
				$petdetail['name'] = $petObj[0]->name;
				$petdetail['sex'] = $petObj[0]->sex;
				$petdetail['age'] = $petObj[0]->age;//need auto calcualtion here
				$petdetail['breed_id'] = $petObj[0]->breed_id;
				$petdetail['fathers_breed'] = $petObj[0]->fathers_breed;
				$petdetail['mothers_breed'] = $petObj[0]->mothers_breed;
				$petdetail['current_height'] = $petObj[0]->current_height;
				$petdetail['current_weight'] = $petObj[0]->current_weight;
				$petdetail['microchip_id'] = $petObj[0]->microchip_id;
				$petdetail['pet_type'] = $petObj[0]->pet_type;
				$petdetail['lifestyle'] = $petObj[0]->lifestyle;
				$petdetail['neutered'] = $petObj[0]->neutered;
				$petdetail['trained'] = $petObj[0]->trained;
				$petdetail['temparement_ok_dog'] = $petObj[0]->temparement_ok_dog;
				$petdetail['temparement_ok_cat'] = $petObj[0]->temparement_ok_cat;
				$petdetail['temparement_ok_people'] = $petObj[0]->temparement_ok_people;
				$petdetail['temparement_ok_child'] = $petObj[0]->temparement_ok_child;
				/*$petdetail['ins_provider'] = $petObj[0]->ins_provider;
				$petdetail['ins_policy_no'] = $petObj[0]->ins_policy_no;
				$petdetail['mc_start_date'] = $petObj[0]->mc_start_date;
				$petdetail['mc_end_date'] = $petObj[0]->mc_end_date;
				$petdetail['ins_renewal_date'] = $petObj[0]->ins_renewal_date;
				$petdetail['expected_mc_date'] = $petObj[0]->expected_mc_date;
				$petdetail['mc_notes'] = $petObj[0]->mc_notes;*/
				$petdetail['swimmer'] = $petObj[0]->swimmer;
				$petdetail['birth_date'] = $petObj[0]->birth_date;
				$petdetail['adoption_date'] = $petObj[0]->adoption_date;   
				$petdetail['allergies'] = $petObj[0]->allergies;
				$petdetail['medical_conditions'] = $petObj[0]->medical_conditions;
				$petdetail['medicines'] = $petObj[0]->medicines;
				$petdetail['likes'] = $petObj[0]->likes;
				$petdetail['dislikes'] = $petObj[0]->dislikes;
				$petdetail['incidents'] = $petObj[0]->incidents;
				$petdetail['spayed'] = $petObj[0]->spayed;
				if($petObj[0]->pet_img_path != null && !empty($petObj[0]->pet_img_path))
		  	          $petdetail['pet_img_path'] = $this->config->base_url().$petObj[0]->pet_img_path;
				else
				  $petdetail['pet_img_path'] = null;

				if($petObj[0]->pet_ins_path != null && !empty($petObj[0]->pet_ins_path))
				  $petdetail['pet_ins_path'] = $this->config->base_url().$petObj[0]->pet_ins_path;
				else
				  $petdetail['pet_ins_path'] = null;          
			     
				//return pet's original owner email
				$userid = $this->pet_model->getPetsOwnerUserId($petObj[0]->id);
				$userObj = $this -> user_model -> get_user_record($userid);
				if(!empty($userObj)){
					$petdetail['owner_email'] =$userObj[0]->email;	
				}

				//return user specific data
				
				if(!empty($userObj[0]) && $userObj[0] != null){
		     
				    if(!empty($userObj[0]->first_name) && !empty($userObj[0]->last_name))
				        $petdetail['owner_name'] = $userObj[0]->first_name.' '.$userObj[0]->last_name;
				    else if(!empty($userObj[0]->first_name))   
				        $petdetail['owner_name'] = $userObj[0]->first_name;
		   
				    $petdetail['postcode'] = $userObj[0]->postcode;
				    $petdetail['country'] = $userObj[0]->country;
				    $petdetail['city'] = $userObj[0]->city;
				    $petdetail['door'] = $userObj[0]->door;
				}
				array_push($petList, $petdetail); 				   
			    }
		     }	
		  $arr = array('error' => 'false', 'message' => 'All pets are loaded Successfully.', 'petdetail' => $petList);
	  }else{
		$arr = array('error' => 'true', 'message' => 'user email is not valid.');
	  }
	return $arr;
    }

	//add appointment
    function appointmentadd(){
        $appointment_id = $this -> input -> post('appointment_id', TRUE);
        $appointment_title = $this -> input -> post('appointment_title', TRUE);
        $appointment_time = $this -> input -> post('appointment_time', TRUE);
        $appointment_date = $this -> input -> post('appointment_date', TRUE);
        $appointment_loc = $this -> input -> post('appointment_loc', TRUE);
        $is_done = $this -> input -> post('is_done', TRUE);
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

        $postdata = array('appointment_id'=> $appointment_id,'appointment_title' => $appointment_title,'appointment_time'=>$appointment_time, 'appointment_date' => $appointment_date,'appointment_loc'=>$appointment_loc, 'user_email' => $email,'pet_id'=>$petid,'is_done'=>$is_done); 
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('appointment_id', 'Appointment Id', 'trim|required');
        $this -> form_validation -> set_rules('appointment_title', 'Appointment Title', 'trim|required');
        $this -> form_validation -> set_rules('appointment_time', 'Appointment Time', 'trim|required');
        $this -> form_validation -> set_rules('appointment_date', 'Appointment Date', 'trim|required');
        $this -> form_validation -> set_rules('appointment_loc', 'Appointment Location', 'trim|required');
        $this -> form_validation -> set_rules('is_done', 'Appointment is done', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
	    //create appointment
	    $this->appointment_model->insert_appointment($postdata);
	    $arr = array('error' => 'false', 'message' => 'Apointment added Successfully...');		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    //update appointment
    function appointmentupdate(){
        $appointment_id = $this -> input -> post('appointment_id', TRUE);
        $appointment_title = $this -> input -> post('appointment_title', TRUE);
        $appointment_time = $this -> input -> post('appointment_time', TRUE);
        $appointment_date = $this -> input -> post('appointment_date', TRUE);
        $appointment_loc = $this -> input -> post('appointment_loc', TRUE);
        $is_done = $this -> input -> post('is_done', TRUE);
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

        $postdata = array('appointment_title' => $appointment_title,'appointment_time'=>$appointment_time, 'appointment_date' => $appointment_date,'appointment_loc'=>$appointment_loc, 'user_email' => $email,'pet_id'=>$petid,'is_done'=>$is_done,'appointment_id'=> $appointment_id);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('appointment_id', 'Appointment Id', 'trim|required');
        $this -> form_validation -> set_rules('appointment_title', 'Appointment Title', 'trim|required');
        $this -> form_validation -> set_rules('appointment_time', 'Appointment Time', 'trim|required');
        $this -> form_validation -> set_rules('appointment_date', 'Appointment Date', 'trim|required');
        $this -> form_validation -> set_rules('appointment_loc', 'Appointment Location', 'trim|required');
        $this -> form_validation -> set_rules('is_done', 'Appointment is done', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
	    //update appointment
	    $this->appointment_model->update_appointment($appointment_id,$postdata);
	    $arr = array('error' => 'false', 'message' => 'Appointment updated Successfully...');		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    //delete appointment
    function appointmentdelete(){
        $appointment_id = $this -> input -> post('appointment_id', TRUE);
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

        $postdata = array('appointment_id'=> $appointment_id, 'user_email' => $email,'pet_id'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('appointment_id', 'Appointment Id', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
		
 	    //delete appointment
	    $this->appointment_model->delete_appointment($appointment_id);
	    $arr = array('error' => 'false', 'message' => 'Appointment deleted Successfully...');			
        }

	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);

    }

    //iscomp appointment
    function appointmentiscomp(){
        $appointment_id = $this -> input -> post('appointment_id', TRUE);
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
        $is_done = $this -> input -> post('is_done', TRUE);

        $postdata = array('appointment_id'=> $appointment_id, 'user_email' => $email,'pet_id'=>$petid,'is_done'=>$is_done);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('appointment_id', 'Appointment Id', 'trim|required');
        $is_done = $this -> input -> post('is_done', TRUE);
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
	    //update appointment
	    $this->appointment_model->update_appointment($appointment_id,array('is_done'=>$is_done));
	    $arr = array('error' => 'false', 'message' => 'Appointment updated Successfully...');		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


     //get appointment
    function appointmentget(){
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

	$postdata = array('user_email' => $email,'pet_id'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {

		//get appointment
		$appoint = $this->appointment_model->get_appointment_record_by_petid($petid);
		$appointArray = array();
		foreach($appoint as $appt){
			$appointArr = array();
			$appointArr['appointment_title']=$appt->appointment_title;
			$appointArr['appointment_id']=$appt->appointment_id;
			$appointArr['user_email']=$appt->user_email;
			$appointArr['pet_id']=$appt->pet_id;
			$is_doneass = $appt->is_done ? 'true' : 'false';
			if($appt->is_done =='t')
				$is_doneass = 'true';
			else
				$is_doneass = 'false';		
			$appointArr['is_done']= $is_doneass; 
			$appointArr['appointment_time']=$appt->appointment_time;
			$appointArr['appointment_date']=$appt->appointment_date;
			$appointArr['appointment_loc']=$appt->appointment_loc;		
			array_push($appointArray, $appointArr);
		}
		$arr = array('error' => 'false','message' => 'Appointment Loaded Successfully.', 'appointment' => $appointArray);		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
    
     //function to get device token using emailid
	public function getDeviceTokenOSType($email) {
		$userExists = $this->user_model->get_user_record_by_email($email);
		if(!empty($userExists)){
			return array('device_id'=>$userExists[0]->device_id,'os_type'=>$userExists[0]->os_type);
		}else{
			return null;
		}
	}

     //Share Pet
	public function sharepet() {
		//get the posted values
		$owner_email = $this -> input -> post('owner_email', TRUE);
		$shared_email = $this -> input -> post('shared_email', TRUE);
		$pet_id = $this -> input -> post('pet_id', TRUE);

		$postdata = array('owner_email' => $owner_email, 'shared_email' => $shared_email, 'pet_id' => $pet_id);

		//set data for validation
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('owner_email', 'owner email', 'trim|required');
		$this -> form_validation -> set_rules('shared_email', 'shared email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'pet id', 'trim|required');

		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
		    //validation succeeds
		    //check shared email exists
  		    $userExists = $this->user_model->get_user_record_by_email($shared_email);	
		    if(!empty($userExists)){
			//check pet already shared
			if(!$this->pet_model->isPetShared($pet_id)){
			   //insert in to share table			   	
			   $code = $this->pet_model->share_pet($pet_id,$userExists[0]->id,$owner_email);			
			   $acceptsUrl = $this->config->base_url()."share?action=accept&code=".$code;
			   $denyUrl = $this->config->base_url()."share?action=deny&code=".$code;
	
			   $arr = array('error' => 'false', 'message' => 'Pet Shared Successfully...','accepturl'=> $acceptsUrl,'denyurl'=>$denyUrl);

			  //code to send notification
			  /*if($userExists[0]->os_type == 'android'){
				$this->notificationandroid_model->sendShareNotification($acceptsUrl,$denyUrl,$userExists[0]->device_id);
			  }else{
				$this->notificationios_model->sendShareNotification($acceptsUrl,$denyUrl,$userExists[0]->device_id);
			 }*/

			}else{
 			  $arr = array('error' => 'true', 'message' =>'Pet already shared.');	
			}
		    }else{
			$arr = array('error' => 'true', 'message' =>'Shared email not registered.');
		    }		
		    
		}

		//add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
	    }	



//add gallery
    function galleryadd(){
        $user_email = $this -> input -> post('user_email', TRUE);
        $pet_id = $this -> input -> post('pet_id', TRUE);
        //$petpic = $this->upload->do_upload('petpic');//$this -> input -> post('petpic', TRUE);
	//print_r($petpic);
        $title = $this -> input -> post('title', TRUE);
        $description = $this -> input -> post('description', TRUE);

        $postdata = array(/*'petpic'=> $petpic, */'title' => $title,'description'=>$description,'user_email' => $user_email,'pet_id'=>$pet_id);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        //$this -> form_validation -> set_rules('petpic', 'pet pic', 'trim|required');
        $this -> form_validation -> set_rules('title', 'Title', 'trim|required');
        $this -> form_validation -> set_rules('description', 'Description', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
            //create gallery data
            $userObj = $this -> user_model -> get_user_record_by_email($user_email);    
            $user_id = null;
            if(!empty($userObj[0]) && $userObj[0] != null){    
            $user_id =$userObj[0]->id;
            }    
            $gallery_id = $this-> galimages_model-> addGallery(array('title' => $title,'description'=>$description,'upload_userid' => $user_id,'pet_id'=>$pet_id));

            //create mapping of pet and user
            //$this->pet_model->addPetUserMapping($petid,$email);
        
            //create folder
            //server path
            $uploadPath = '/var/www/html/images/';        
            //local path
            //$uploadPath = '/opt/lampp/htdocs/pets/images/';        

            if (!is_dir($uploadPath)){
                mkdir($uploadPath, 0777, true);
            }
    
            $dir_exist = true; // flag for checking the directory exist or not

            if (!is_dir($uploadPath . $pet_id."/gallery/")){
                mkdir($uploadPath . $pet_id."/gallery/" , 0777, true);
                $dir_exist = false; // dir not exist
            }

            $this->load->library('upload');

            $config['upload_path']          = $uploadPath . $pet_id."/gallery/";
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['file_name']        = $gallery_id;
	    //$config['max_size'] = '2048';	
        
            $this->upload->initialize($config);

            $petpic = "";    
            $updatedPicPath=null;    
                if ( $this->upload->do_upload('petpic')){
                //rmdir
                //rmdir('./uploads/' . $album);
                //, 'petpic'=>
                $updatedPicPath='images/'.$pet_id.'/gallery/'.$this->upload->data('file_name');   
                $petpic = $this->config->base_url().'images/'.$pet_id.'/gallery/'.$this->upload->data('file_name');
		$this-> galimages_model-> updateGallery($gallery_id,array('image_path'=>$updatedPicPath));
             
             $arr = array('error' => 'false', 'message' => 'Image Added Successfully in gallery...','image_url'=>$petpic, 'gallery_id'=>$gallery_id,'user_profile_pic'=>$this->config->base_url().'/images/user_dummy_icon.jpg');
            
                }else{
			 $arr = array('error' => 'true', 'message' => $this->upload->display_errors());
		}
            
        }
        //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    //get gallery
    function galleryget(){
        $user_email = $this -> input -> post('user_email', TRUE);
        $pet_id = $this -> input -> post('pet_id', TRUE);
        
        $postdata = array('user_email' => $user_email,'pet_id'=>$pet_id);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
            //get gallery data
            $galleryList = $this->galimages_model->getAllGalleryByPetid($pet_id);
            if(!empty($galleryList)){
            $galList = array();    
            foreach ($galleryList as $gal){
                $singlegal = array();
                $singlegal['gallery_id']=$gal->id;
                $singlegal['title']=$gal->title;
                $singlegal['description']=$gal->description;
		if(!empty($gal->image_path))
                	$singlegal['image_path']= $this->config->base_url().$gal->image_path;
		else	
                	$singlegal['image_path']= null;

		$userObj = $this -> user_model -> get_user_record_by_email($user_email);    
        	$user_pic = null;
        	if(!empty($userObj[0]) && $userObj[0] != null){    
			$singlegal['user_profile_pic']=$this->config->base_url().$userObj[0]->profile_pic;

        	}else{
			$singlegal['user_profile_pic']=null;
		}
                array_push($galList,$singlegal);
            }
            $arr = array('error' => 'false', 'message' =>'Gallery List Loaded Successfully','gallery' => $galList);
            }
        }
        //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    //update gallery
    function galleryupdate(){
        $user_email = $this -> input -> post('user_email', TRUE);
        $pet_id = $this -> input -> post('pet_id', TRUE);
        $gallery_id = $this -> input -> post('gallery_id', TRUE);
        $title = $this -> input -> post('title', TRUE);
        $description = $this -> input -> post('description', TRUE);

	$userObj = $this -> user_model -> get_user_record_by_email($user_email);    
        $user_id = null;
        if(!empty($userObj[0]) && $userObj[0] != null){    
          $user_id =$userObj[0]->id;
        } 
        $postdata = array('gallery_id'=> $gallery_id,'user_email' => $user_email,'pet_id'=>$pet_id,'title'=>$title,'description'=>$description);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('gallery_id', 'gallery id', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
            //delete gallery
	    $postdata1 = array('pet_id'=>$pet_id,'title'=>$title,'description'=>$description,'upload_userid' => $user_id);	
            $this->galimages_model->updateGallery($gallery_id,$postdata1);
            $arr = array('error' => 'false', 'message' => 'Gallery updated Successfully...');
        }
        //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    //delete gallery
    function gallerydelete(){
        $user_email = $this -> input -> post('user_email', TRUE);
        $pet_id = $this -> input -> post('pet_id', TRUE);
        $gallery_id = $this -> input -> post('gallery_id', TRUE);

        $postdata = array('gallery_id'=> $gallery_id,'user_email' => $user_email,'pet_id'=>$pet_id);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('gallery_id', 'gallery id', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
            //delete gallery
            $this->galimages_model->deleteGallery($gallery_id);
            $arr = array('error' => 'false', 'message' => 'Gallery deleted Successfully...');
        }
        //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


	//care add
    function addcare(){
        $timer_id = $this -> input -> post('timer_id', TRUE);
        $title = $this -> input -> post('title', TRUE);
	$is_none = null;
	if(!empty($this -> input -> post('is_none', TRUE)) && $this -> input -> post('is_none', TRUE) !="")
        	$is_none = $this -> input -> post('is_none', TRUE);

	$is_comp = null;
	if(!empty($this -> input -> post('is_comp', TRUE)) && $this -> input -> post('is_comp', TRUE) !="")
        	$is_comp = $this -> input -> post('is_comp', TRUE);

	$date = null;
	if(!empty($this -> input -> post('date', TRUE)) && $this -> input -> post('date', TRUE) !="")
        	$date = $this -> input -> post('date', TRUE);

	$time = null;
	if(!empty($this -> input -> post('time', TRUE)) && $this -> input -> post('time', TRUE) !="")
        	$time = $this -> input -> post('time', TRUE);

	$long = null;
	if(!empty($this -> input -> post('long', TRUE)) && $this -> input -> post('long', TRUE) !="")
        	$long = $this -> input -> post('long', TRUE);

	$interval = null;
	if(!empty($this -> input -> post('interval', TRUE)) && $this -> input -> post('interval', TRUE) !="")
        	$interval = $this -> input -> post('interval', TRUE);

        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
        $category = $this -> input -> post('category', TRUE);

        $postdata = array('timer_id'=> $timer_id,'user_email' => $email,'pet_id'=>$petid,'category'=>$category); 
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('timer_id', 'Timer Id', 'trim|required');
        $this -> form_validation -> set_rules('category', 'Category', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
	    //add care
	    $postdata['is_none']=$is_none;
	    $postdata['is_comp']=$is_comp;
	    $postdata['time']=$time;
	    $postdata['long']=$long;
	    $postdata['interval']=$interval;
	    $postdata['date']=$date;
	    $postdata['title']=$title;	
	    $this->care_model->insert_care($postdata);
	    $arr = array('error' => 'false', 'message' => 'Care added Successfully...');		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    //get care
    function getcare(){
        $category = $this -> input -> post('category', TRUE);
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

	$postdata = array('user_email' => $email,'pet_id'=>$petid,'category' => $category);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('category', 'category', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {

		//get appointment
		$cares = $this->care_model->get_care_record_by_category_petid($category,$petid);
		$careArray = array();
		foreach($cares as $care){
			$careArr = array();
			$careArr['timer_id']=$care->timer_id;
			$careArr['user_email']=$care->user_email;
			$careArr['pet_id']=$care->pet_id;
			$careArr['is_comp']= $care->is_comp; 
			$careArr['is_none']= $care->is_none;
			$careArr['long']=$care->long;
			$careArr['date']=$care->date;
			$careArr['interval']=$care->interval;
			$careArr['time']=$care->time;
			$careArr['category']=$care->category;
			$careArr['title']=$care->title;	
		
			//return pet's original owner email
			$userid = $this->pet_model->getPetsOwnerUserId($care->pet_id);
			$userObj = $this -> user_model -> get_user_record($userid);
			if(!empty($userObj)){
				$careArr['owner_email'] =$userObj[0]->email;	
			}	
			array_push($careArray, $careArr);
		}
		$arr = array('error' => 'false','message' => 'All Cares Loaded Successfully.', 'care' => $careArray);		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


    //care update
    function updatecare(){
        $timer_id = $this -> input -> post('timer_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);
        $title = $this -> input -> post('title', TRUE);

		$postdata = array('timer_id'=> $timer_id,'user_email' => $email,'pet_id'=>$petid);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('timer_id', 'Timer Id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
			$is_none = null;
			if(!empty($this -> input -> post('is_none', TRUE)) && $this -> input -> post('is_none', TRUE) !="")
				$is_none = $this -> input -> post('is_none', TRUE);

			$is_comp = null;
			if(!empty($this -> input -> post('is_comp', TRUE)) && $this -> input -> post('is_comp', TRUE) !="")
				$is_comp = $this -> input -> post('is_comp', TRUE);

			$date = null;
			if(!empty($this -> input -> post('date', TRUE)) && $this -> input -> post('date', TRUE) !="")
				$date = $this -> input -> post('date', TRUE);

			$time = null;
			if(!empty($this -> input -> post('time', TRUE)) && $this -> input -> post('time', TRUE) !="")
				$time = $this -> input -> post('time', TRUE);

			$long = null;
			if(!empty($this -> input -> post('long', TRUE)) && $this -> input -> post('long', TRUE) !="")
				$long = $this -> input -> post('long', TRUE);

			$interval = null;
			if(!empty($this -> input -> post('interval', TRUE)) && $this -> input -> post('interval', TRUE) !="")
				$interval = $this -> input -> post('interval', TRUE);

		//update care		
		    $postdata['is_none']=$is_none;
	    	$postdata['is_comp']=$is_comp;
		    $postdata['time']=$time;
		    $postdata['long']=$long;
		    $postdata['interval']=$interval;
		    $postdata['date']=$date;
		    $postdata['title']=$title;	
		    $this->care_model->update_care($timer_id ,$postdata);
		    $arr = array('error' => 'false', 'message' => 'Care updated Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }

    //care delete
    function deletecare(){
        	$timer_id = $this -> input -> post('timer_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);

		$postdata = array('timer_id'=> $timer_id,'user_email' => $email,'pet_id'=>$petid);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('timer_id', 'Timer Id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
			
		    //delete care		
		    $this->care_model->delete_care($timer_id);
		    $arr = array('error' => 'false', 'message' => 'Care deleted Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }

   //iscomp care
   function iscompcare(){
        	$timer_id = $this -> input -> post('timer_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);
        	$is_comp = $this -> input -> post('is_comp', TRUE);

		$postdata = array('timer_id'=> $timer_id,'user_email' => $email,'pet_id'=>$petid);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('timer_id', 'Timer Id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
			
		    //delete care		
		    $this->care_model->update_care($timer_id ,array('is_comp'=>$is_comp));
		    $arr = array('error' => 'false', 'message' => 'Care completed Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
   }	


	//mc add
    function addmc(){
        	
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

        $postdata = array('user_email' => $email,'pet_id'=>$petid); 
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
	    $start_date_id = $this -> input -> post('start_date_id', TRUE);
            $start_date_long = $this -> input -> post('start_date_long', TRUE);	
	    $end_date_id = $this -> input -> post('end_date_id', TRUE);
            $end_date_long = $this -> input -> post('end_date_long', TRUE);	
	    $expected_date_id = $this -> input -> post('expected_date_id', TRUE);
            $expected_date_long = $this -> input -> post('expected_date_long', TRUE);	
            $notes = $this -> input -> post('notes', TRUE);	

	    //add mc
	    $postdata['start_date_id']=$start_date_id;
	    $postdata['start_date_long']=$start_date_long;
	    $postdata['end_date_id']=$end_date_id;
	    $postdata['end_date_long']=$end_date_long;
	    $postdata['expected_date_id']=$expected_date_id;
	    $postdata['expected_date_long']=$expected_date_long;
	    $postdata['notes']=$notes;	
	    $this->mc_model->insert_mc($postdata);
	    $arr = array('error' => 'false', 'message' => 'Menstrual Cycle added Successfully...');		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    //get mc
    function getmc(){
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

	$postdata = array('user_email' => $email,'pet_id'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {

		//get mc
		$mcs = $this->mc_model->get_mc_by_petid($petid);
		$mcArr = array();
		foreach($mcs as $mc){
			$mcArr['start_date_id']=$mc->start_date_id;
			$mcArr['start_date_long']=$mc->start_date_long;
			$mcArr['end_date_id']=$mc->end_date_id;
			$mcArr['end_date_long']= $mc->end_date_long; 
			$mcArr['expected_date_id']= $mc->expected_date_id;
			$mcArr['expected_date_long']=$mc->expected_date_long;
			$mcArr['notes']=$mc->notes;
			$mcArr['user_email']=$mc->user_email;
			$mcArr['pet_id']=$mc->pet_id;
		
			//return pet's original owner email
			$userid = $this->pet_model->getPetsOwnerUserId($mc->pet_id);
			$userObj = $this -> user_model -> get_user_record($userid);
			if(!empty($userObj)){
				$mcArr['owner_email'] =$userObj[0]->email;	
			}				
		}
		$arr = array('error' => 'false','message' => 'All Menstrual Cycles are loaded Successfully.', 'mc' => $mcArr);		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


    //mc update
    function updatemc(){
        $pet_id = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

        $postdata = array('user_email' => $email,'pet_id'=>$pet_id); 
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
	    $start_date_id = $this -> input -> post('start_date_id', TRUE);
            $start_date_long = $this -> input -> post('start_date_long', TRUE);	
	    $end_date_id = $this -> input -> post('end_date_id', TRUE);
            $end_date_long = $this -> input -> post('end_date_long', TRUE);	
	    $expected_date_id = $this -> input -> post('expected_date_id', TRUE);
            $expected_date_long = $this -> input -> post('expected_date_long', TRUE);	
            $notes = $this -> input -> post('notes', TRUE);	

	    //update mc
	    $postdata['start_date_id']=$start_date_id;
	    $postdata['start_date_long']=$start_date_long;
	    $postdata['end_date_id']=$end_date_id;
	    $postdata['end_date_long']=$end_date_long;
	    $postdata['expected_date_id']=$expected_date_id;
	    $postdata['expected_date_long']=$expected_date_long;
	    $postdata['notes']=$notes;	
	    $this->mc_model->update_mc($pet_id,$postdata);
	    $arr = array('error' => 'false', 'message' => 'Menstrual Cycle updated Successfully...');		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    //mc delete
    function deletemc(){
		$pet_id = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);

		$postdata = array('user_email' => $email,'pet_id'=>$pet_id);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
			
		    //delete mc		
		    $this->mc_model->delete_mc($pet_id);
		    $arr = array('error' => 'false', 'message' => 'Menstrual Cycle deleted Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }


	//ins add
    function addins(){
        	
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
        $ins_provider = $this -> input -> post('ins_provider', TRUE);
        $ins_policy_no = $this -> input -> post('ins_policy_no', TRUE);
	$ins_renewal_date = $this -> input -> post('ins_renewal_date', TRUE);
        $ins_id = $this -> input -> post('ins_id', TRUE);
	$long_value = $this -> input -> post('long_value', TRUE);

        $postdata = array('user_email' => $email,'pet_id'=>$petid,'ins_provider'=>$ins_provider,'ins_policy_no'=>$ins_policy_no,'ins_id'=>$ins_id,'long_value'=>$long_value); 
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('ins_provider', 'Insurance Provider', 'trim|required');
        $this -> form_validation -> set_rules('ins_policy_no', 'Policy No', 'trim|required');
        $this -> form_validation -> set_rules('ins_id', 'Insurance Id', 'trim|required');
        $this -> form_validation -> set_rules('long_value', 'Long Value', 'trim|required');


        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
	    
	    	//add ins
	    	//create folder 
	    	//server path
		$uploadPath = '/var/www/html/images/';		
		//local path
		//$uploadPath = '/opt/lampp/htdocs/pets/images/';		

		if (!is_dir($uploadPath)){
			mkdir($uploadPath, 0777, true);
		}
	
		$dir_exist = true; // flag for checking the directory exist or not

		if (!is_dir($uploadPath . $petid)){
			mkdir($uploadPath . $petid, 0777, true);
			$dir_exist = false; // dir not exist
		}

		$this->load->library('upload');

		$config['upload_path']          = $uploadPath . $petid ;
	        $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
		$config['file_name']        = 'petinsurance';
		
		$this->upload->initialize($config);

		$petins = "";	
		$updatedPicIns=null;	
		if ( $this->upload->do_upload('ins_upload')){
			$updatedPicIns = 'images/'.$petid.'/'.$this->upload->data('file_name');
		}
		        
	    $insdata = array('ins_user_email' => $email,'ins_provider'=>$ins_provider,'ins_policy_no'=>$ins_policy_no,'ins_renewal_date'=>$ins_renewal_date,'pet_ins_path'=>$updatedPicIns,'ins_id'=>$ins_id,'long_value'=>$long_value); 
	    $petObj = $this->ins_model->update_ins($petid,$insdata);
	    $petins = null;
	    if($petObj[0]->pet_ins_path != null)	
		$petins = $this->config->base_url().$petObj[0]->pet_ins_path;
	    $arr = array('error' => 'false', 'message' => 'Insurance added Successfully...','petins'=>$petins);		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    //get ins
    function getins(){
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

	$postdata = array('user_email' => $email,'pet_id'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {

		//get mc
		$ins = $this->ins_model->get_pet_by_petid($petid);
		$inArr = array();
		foreach($ins as $in){
			$inArr['ins_provider']=$in->ins_provider;
			$inArr['ins_policy_no']=$in->ins_policy_no;
			$inArr['ins_renewal_date']=$in->ins_renewal_date;
			$inArr['ins_id']=$in->ins_id;
			$inArr['long_value']=$in->long_value;
			if($in->pet_ins_path != null)	
				$inArr['pet_ins_path']= $this->config->base_url().$in->pet_ins_path; 
			else	
				$inArr['pet_ins_path']= null; 
			$inArr['user_email']=$in->ins_user_email;
			$inArr['pet_id']=$in->id;
		
			//return pet's original owner email
			$userid = $this->pet_model->getPetsOwnerUserId($in->id);
			$userObj = $this -> user_model -> get_user_record($userid);
			if(!empty($userObj)){
				$mcArr['owner_email'] =$userObj[0]->email;	
			}				
		}
		$arr = array('error' => 'false','message' => 'Insurance Loaded Successfully.', 'ins' => $inArr);		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


    //ins update
    /*function updateins(){
        $pet_id = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

        $postdata = array('user_email' => $email,'pet_id'=>$pet_id); 
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
	    $start_date_id = $this -> input -> post('start_date_id', TRUE);
            $start_date_long = $this -> input -> post('start_date_long', TRUE);	
	    $end_date_id = $this -> input -> post('end_date_id', TRUE);
            $end_date_long = $this -> input -> post('end_date_long', TRUE);	
	    $expected_date_id = $this -> input -> post('expected_date_id', TRUE);
            $expected_date_long = $this -> input -> post('expected_date_long', TRUE);	
            $notes = $this -> input -> post('notes', TRUE);	

	    //update mc
	    $postdata['start_date_id']=$start_date_id;
	    $postdata['start_date_long']=$start_date_long;
	    $postdata['end_date_id']=$end_date_id;
	    $postdata['end_date_long']=$end_date_long;
	    $postdata['expected_date_id']=$expected_date_id;
	    $postdata['expected_date_long']=$expected_date_long;
	    $postdata['notes']=$notes;	
	    $this->mc_model->update_mc($pet_id,$postdata);
	    $arr = array('error' => 'false', 'message' => 'Menstrual Cycle updated Successfully...');		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }*/

    //ins delete
    function deleteins(){
		$pet_id = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);

		$postdata = array('user_email' => $email,'pet_id'=>$pet_id);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
			
		    //delete mc		
		    $this->ins_model->delete_ins($pet_id);
		    $arr = array('error' => 'false', 'message' => 'Insurance deleted Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }

   //get story
    function getstory(){
        $story_list = $this->story_model->get_story_record('all');
        //print_r($story_list);
        $arr = array('error' => 'true', 'message' => 'No Story Found');
        if(!empty($story_list)){
            $storyList = array();   
            foreach ($story_list as $story){
                $singlestory = array();
                $singlestory['id']=$story->id;
                $singlestory['title']=$story->title;
                $singlestory['description']=$story->description;
                if($story->image_path != null)
                    $singlestory['image']=$this->config->base_url().$story->image_path;
                else
                    $singlestory['image']=null;
                array_push($storyList,$singlestory);
            }
            $arr = array('error' => 'false','message' => 'All Stories Loaded Successfully.', 'story' => $storyList);
        }
        //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

//become foster
    function becomefoster(){

        $email = $this -> input -> post('user_email', TRUE);

        $postdata = array('email' => $email);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('email', 'Email',
'trim|required');

        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this ->
form_validation -> error_string());
        } else {

        //add foster
        $postdata['created_stamp']=date("Y-m-d H:i:s");

        $this->foster_model->insert_foster($postdata);
        $arr = array('error' => 'false', 'message' => 'Thanks for registering with us, we will contact you soon..');
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


    //social login
    public function loginver1() {
        //get the posted values
        $username = $this -> input -> post('username', TRUE);
        $social_type = $this -> input -> post('social_type', TRUE);
        $os_type = $this -> input -> post('os_type', TRUE);
        $device_id = $this -> input -> post('device_id', TRUE);

        $postdata = array('username' => $username, 'social_type' => $social_type,'os_type' => $os_type, 'device_id' => $device_id);
        //set data for validation
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules("username", "Username", "trim|required");
        $this -> form_validation -> set_rules("social_type", "social type", "trim|required");
        $this -> form_validation -> set_rules("os_type", "os type", "trim|required");
        $this -> form_validation -> set_rules("device_id", "device id", "trim|required");
          
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
            $usr_result = $userObj = $this->user_model->get_user_record_by_email($username);
            if(!empty($usr_result[0]) && $usr_result[0] != null){               
                //set the session variables
                $sessiondata = array('username' => $username, 'loginuser' => TRUE);
                $this -> session -> set_userdata($sessiondata);
           
            $this ->user_model->update_user($username,array('os_type' => $os_type, 'device_id' => $device_id));

            } else {
                //user register as a social type
                $this->social_register($username,$social_type,$os_type,$device_id);
            }
   
                $arr = array('error' => 'false', 'message' => 'user found', 'pets' =>$this -> getallpetinternally($username), 'userdetail' => $this -> getUserDetailArrayFromEmail($username));

        }

        //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
        }

    public function social_register($email,$social_type,$os_type,$device_id) {
        $password = 'S0cia!Pass@1&*';
       
        $postdata = array('password' => $password, 'type' => $social_type, 'social' => true, 'email' => $email, 'role_id' => 2,'os_type' => $os_type, 'device_id' => $device_id);

        //create user
            $this->user_model->create_user($postdata);
        }


    //Edit Profile
    public function editprofile() {
        //get the posted values
        $user_email = $this -> input -> post('user_email', TRUE);

        $postdata = array('user_email' => $user_email);
        //set data for validation
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules("user_email", "user_email", "trim|required");
          
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {

	    $userObj = $this->user_model->get_user_record_by_email($user_email);
 	    if(!empty($userObj[0]) && $userObj[0] != null){
               $user_id =  $userObj[0]->id;
	       $mobileno = $this -> input -> post('mobileno', TRUE);
	       $first_name = $this -> input -> post('first_name', TRUE);
               $last_name = $this -> input -> post('last_name', TRUE);
               $city = $this -> input -> post('city', TRUE);
               $state = $this -> input -> post('state', TRUE);
	       $postcode = $this -> input -> post('postcode', TRUE);
               $country = $this -> input -> post('country', TRUE);
               $notification = $this -> input -> post('notification', TRUE);
               $door = $this -> input -> post('door', TRUE);
	    
            //create folder
            //server path
            $uploadPath = '/var/www/html/images/';       
            //local path
            //$uploadPath = '/opt/lampp/htdocs/pets/images/';       

            if (!is_dir($uploadPath)){
                mkdir($uploadPath, 0777, true);
            }
   
            $dir_exist = true; // flag for checking the directory exist or not

            if (!is_dir($uploadPath . 'users/')){
                mkdir($uploadPath . 'users/', 0777, true);
                $dir_exist = false; // dir not exist
            }

            $this->load->library('upload');

            $config['upload_path']          = $uploadPath . 'users/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['file_name']        = $user_id;
   
            $this->upload->initialize($config);

            $updatedStoryPath=null;   
            if ( $this->upload->do_upload('profile_pic')){
               $updatedStoryPath='images/users/'.$this->upload->data('file_name');   
            }
		
            //updated story info
	    if($updatedStoryPath==null)	
   	         $data = array('first_name' => $first_name, 'mobileno' => $mobileno,'last_name'=>$last_name,'city'=>$city,'state' => $state, 'postcode' => $postcode,'country'=>$country,'notification'=>$notification,'door'=>$door);
	    else
   	         $data = array('first_name' => $first_name, 'mobileno' => $mobileno,'last_name'=>$last_name,'city'=>$city,'state' => $state, 'postcode' => $postcode,'country'=>$country,'notification'=>$notification,'door'=>$door,'profile_pic'=>$updatedStoryPath);
		
                $this ->user_model ->update_user($user_email,$data);
           
                $arr = array('error' => 'false', 'message' => 'Profile Updated Successfully','userdetail' => $this -> getUserDetailArrayFromEmail($user_email));
	    }else{  
		$arr = array('error' => 'true', 'message' => 'user not found');
	    }	

        }

        //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
        }

//add vaccination
    function addvaccination(){
        //$timer_id = $this -> input -> post('timer_id', TRUE);
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
        $category = $this -> input -> post('category', TRUE);
	$vacc_id = $this -> input -> post('vacc_id', TRUE);
        //$postdata = array('timer_id'=> $timer_id,'user_email' => $email,'pet_id'=>$petid,'category'=>$category);
        $postdata = array('user_email' => $email,'pet_id'=>$petid,'category'=>$category,'vacc_id'=>$vacc_id);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('vacc_id', 'Vaccination Id', 'trim|required');
        $this -> form_validation -> set_rules('category', 'Category', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
         $last_done = $this -> input -> post('last_done', TRUE);
         $due_date = $this -> input -> post('due_date', TRUE);
         $frequency = $this -> input -> post('frequency', TRUE);
        
        //add vaccination
        $postdata['last_done']=$last_done;
        $postdata['due_date']=$due_date;
        $postdata['frequency']=$frequency;
        $id = $this->vaccination_model->insert_vaccination($postdata);
        $arr = array('error' => 'false', 'message' => 'Vaccination added Successfully...','vacc'=>$vacc_id);        
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
    

    //get vaccination
    function getvaccination(){
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
 
        $postdata = array('user_email' => $email,'pet_id'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('user_email', 'user_email', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {


        //get vaccination
        $vaccinations = $this->vaccination_model->get_vaccination_record_by_petid($petid);
        $vaccinationArray = array();
        foreach($vaccinations as $vaccination){
            $vaccinationArr = array();
            $vaccinationArr['vacc_id']=$vaccination->vacc_id;
            $vaccinationArr['user_email']=$vaccination->user_email;
            $vaccinationArr['pet_id']=$vaccination->pet_id;
            $vaccinationArr['last_done']= $vaccination->last_done;
            $vaccinationArr['due_date']= $vaccination->due_date;
            $vaccinationArr['category']=$vaccination->category;
            $vaccinationArr['frequency']=$vaccination->frequency;
        
            //return pet's original owner email
            $userid = $this->pet_model->getPetsOwnerUserId($vaccination->pet_id);
            $userObj = $this -> user_model -> get_user_record($userid);
            if(!empty($userObj)){
                $vaccinationArr['owner_email'] =$userObj[0]->email;    
            }    
            array_push($vaccinationArray, $vaccinationArr);
        }
        $arr = array('error' => 'false','message' => 'Vaccinations Loaded Successfully.', 'vaccination' => $vaccinationArray);        
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


   //update vaccination
    function updatevaccination(){
        	$vacc_id = $this -> input -> post('vacc_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);

		$postdata = array('vacc_id'=> $vacc_id,'user_email' => $email,'pet_id'=>$petid);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('vacc_id', 'Vaccination id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
		         $last_done = $this -> input -> post('last_done', TRUE);
		         $due_date = $this -> input -> post('due_date', TRUE);
		         $frequency = $this -> input -> post('frequency', TRUE);
        		$postdataArr = array('user_email' => $email,'pet_id'=>$petid,'last_done'=>$last_done,'due_date'=>$due_date,'frequency'=>$frequency);

		    $this->vaccination_model->update_vaccination($vacc_id ,$postdataArr);
		    $arr = array('error' => 'false', 'message' => 'Vaccination updated Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }	



    //vaccination delete
    function deletevaccination(){
        	$vacc_id = $this -> input -> post('vacc_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);

		$postdata = array('vacc_id'=> $vacc_id,'user_email' => $email,'pet_id'=>$petid);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('vacc_id', 'Vaccination id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
			
		    //delete vaccination		
		    $this->vaccination_model->delete_vaccination($vacc_id);
		    $arr = array('error' => 'false', 'message' => 'Vaccination deleted Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }


    //add other vaccination
    function addothervaccination(){
	$vacc_id = $this -> input -> post('vacc_id', TRUE);        
	$petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
        $vaccination_name = $this -> input -> post('vaccination_name', TRUE);

        $postdata = array('vacc_id'=>$vacc_id,'user_email' => $email,'pet_id'=>$petid,'vaccination_name'=>$vaccination_name);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('vacc_id', 'Vacc Id', 'trim|required');
        $this -> form_validation -> set_rules('vaccination_name', 'Vaccination Name', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
         $last_done = $this -> input -> post('last_done', TRUE);
         $due_date = $this -> input -> post('due_date', TRUE);
         $frequency = $this -> input -> post('frequency', TRUE);
        
        //add vaccination
        $postdata['last_done']=$last_done;
        $postdata['due_date']=$due_date;
        $postdata['frequency']=$frequency;
        $this->othervaccination_model->insert_vaccination($postdata);
        $arr = array('error' => 'false', 'message' => 'Vaccination added Successfully...');        
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


    //get vaccination
    function getothervaccination(){
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
 
        $postdata = array('user_email' => $email,'pet_id'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('user_email', 'user_email', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {


        //get vaccination
        $vaccinations = $this->othervaccination_model->get_vaccination_record_by_petid($petid);
        $vaccinationArray = array();
        foreach($vaccinations as $vaccination){
            $vaccinationArr = array();
            $vaccinationArr['vacc_id']=$vaccination->vacc_id;
            $vaccinationArr['user_email']=$vaccination->user_email;
            $vaccinationArr['pet_id']=$vaccination->pet_id;
            $vaccinationArr['last_done']= $vaccination->last_done;
            $vaccinationArr['due_date']= $vaccination->due_date;
            $vaccinationArr['category']=$vaccination->category;
            $vaccinationArr['frequency']=$vaccination->frequency;
            $vaccinationArr['vaccination_name']=$vaccination->vaccination_name;
        
            //return pet's original owner email
            $userid = $this->pet_model->getPetsOwnerUserId($vaccination->pet_id);
            $userObj = $this -> user_model -> get_user_record($userid);
            if(!empty($userObj)){
                $vaccinationArr['owner_email'] =$userObj[0]->email;    
            }    
            array_push($vaccinationArray, $vaccinationArr);
        }
        $arr = array('error' => 'false','message' => 'Others Vaccination Loaded Successfully.', 'vaccination' => $vaccinationArray);        
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

   //update vaccination
    function updateothervaccination(){
        	$vacc_id = $this -> input -> post('vacc_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);
		$vaccination_name = $this -> input -> post('vaccination_name', TRUE);

		$postdata = array('vacc_id'=> $vacc_id,'user_email' => $email,'pet_id'=>$petid,'vaccination_name'=>$vaccination_name);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('vacc_id', 'Vacc Id', 'trim|required');
		$this -> form_validation -> set_rules('vaccination_name', 'Vaccination Name', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
		         $last_done = $this -> input -> post('last_done', TRUE);
		         $due_date = $this -> input -> post('due_date', TRUE);
		         $frequency = $this -> input -> post('frequency', TRUE);
        		$postdataArr = array('user_email' => $email,'pet_id'=>$petid,'last_done'=>$last_done,'due_date'=>$due_date,'frequency'=>$frequency,'vaccination_name'=>$vaccination_name);

		    $this->othervaccination_model->update_vaccination($vacc_id ,$postdataArr);
		    $arr = array('error' => 'false', 'message' => 'Vaccination updated Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }	



    //vaccination delete
    function deleteothervaccination(){
        	$vacc_id = $this -> input -> post('vacc_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);

		$postdata = array('vacc_id'=> $vacc_id,'user_email' => $email,'pet_id'=>$petid);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('vacc_id', 'Vacc Id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
			
		    //delete vaccination		
		    $this->othervaccination_model->delete_vaccination($vacc_id);
		    $arr = array('error' => 'false', 'message' => 'Vaccination deleted Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }


    //add worm
    function addworm(){
        //$timer_id = $this -> input -> post('timer_id', TRUE);
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
        $category = $this -> input -> post('category', TRUE);
	$worm_id = $this -> input -> post('worm_id', TRUE);
        //$postdata = array('timer_id'=> $timer_id,'user_email' => $email,'pet_id'=>$petid,'category'=>$category);
        $postdata = array('user_email' => $email,'pet_id'=>$petid,'category'=>$category,'worm_id'=>$worm_id);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('worm_id', 'Worm Id', 'trim|required');
        $this -> form_validation -> set_rules('category', 'Category', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
         $last_done = $this -> input -> post('last_done', TRUE);
         $due_date = $this -> input -> post('due_date', TRUE);
         $frequency = $this -> input -> post('frequency', TRUE);
        
        //add vaccination
        $postdata['last_done']=$last_done;
        $postdata['due_date']=$due_date;
        $postdata['frequency']=$frequency;
        $id = $this->worm_model->insert_worm($postdata);
        $arr = array('error' => 'false', 'message' => 'Worm added Successfully...','worm_id'=>$worm_id);        
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
    

    //get worm
    function getworm(){
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
 
        $postdata = array('user_email' => $email,'pet_id'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('user_email', 'user_email', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {


        //get vaccination
        $vaccinations = $this->worm_model->get_worm_record_by_petid($petid);
        $vaccinationArray = array();
        foreach($vaccinations as $vaccination){
            $vaccinationArr = array();
            $vaccinationArr['worm_id']=$vaccination->worm_id;
            $vaccinationArr['user_email']=$vaccination->user_email;
            $vaccinationArr['pet_id']=$vaccination->pet_id;
            $vaccinationArr['last_done']= $vaccination->last_done;
            $vaccinationArr['due_date']= $vaccination->due_date;
            $vaccinationArr['category']=$vaccination->category;
            $vaccinationArr['frequency']=$vaccination->frequency;
        
            //return pet's original owner email
            $userid = $this->pet_model->getPetsOwnerUserId($vaccination->pet_id);
            $userObj = $this -> user_model -> get_user_record($userid);
            if(!empty($userObj)){
                $vaccinationArr['owner_email'] =$userObj[0]->email;    
            }    
            array_push($vaccinationArray, $vaccinationArr);
        }
        $arr = array('error' => 'false', 'message' => 'Worm Loaded Successfully.','worm' => $vaccinationArray);        
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


   //update worm
    function updateworm(){
        	$worm_id = $this -> input -> post('worm_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);

		$postdata = array('worm_id'=> $worm_id,'user_email' => $email,'pet_id'=>$petid);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('worm_id', 'Worm Id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
		         $last_done = $this -> input -> post('last_done', TRUE);
		         $due_date = $this -> input -> post('due_date', TRUE);
		         $frequency = $this -> input -> post('frequency', TRUE);
        		$postdataArr = array('user_email' => $email,'pet_id'=>$petid,'last_done'=>$last_done,'due_date'=>$due_date,'frequency'=>$frequency);

		    $this->worm_model->update_worm($worm_id ,$postdataArr);
		    $arr = array('error' => 'false', 'message' => 'Worm updated Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }	



    //worm delete
    function deleteworm(){
        	$worm_id = $this -> input -> post('worm_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);

		$postdata = array('worm_id'=> $worm_id,'user_email' => $email,'pet_id'=>$petid);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('worm_id', 'Worm Id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
			
		    //delete worm		
		    $this->worm_model->delete_worm($worm_id);
		    $arr = array('error' => 'false', 'message' => 'Worm deleted Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }


    //add vaccination record
    function addvaccinationrecord(){
        $pet_id = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
	
        $postdata = array('user_email' => $email,'pet_id'=>$pet_id);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {

            //create mapping of pet and user
            //$this->pet_model->addPetUserMapping($petid,$email);
        
            //create folder
            //server path
            $uploadPath = '/var/www/html/images/';        
            //local path
            //$uploadPath = '/opt/lampp/htdocs/pets/images/';        

            if (!is_dir($uploadPath)){
                mkdir($uploadPath, 0777, true);
            }
    
            $dir_exist = true; // flag for checking the directory exist or not

            if (!is_dir($uploadPath . $pet_id."/vaccrecord/")){
                mkdir($uploadPath . $pet_id."/vaccrecord/" , 0777, true);
                $dir_exist = false; // dir not exist
            }

            $this->load->library('upload');

            $config['upload_path']          = $uploadPath . $pet_id."/vaccrecord/";
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['file_name']        = 'vaccrecord';
        
            $this->upload->initialize($config);

            $petpic = "";    
            $updatedPicPath=null;    
                if ( $this->upload->do_upload('image_path')){
                //rmdir
                //rmdir('./uploads/' . $album);
                //, 'petpic'=>
                $petpic = $this->config->base_url().'images/'.$pet_id.'/vaccrecord/'.$this->upload->data('file_name');
                $updatedPicPath='images/'.$pet_id.'/vaccrecord/'.$this->upload->data('file_name');		
		$postdata['image_path']=$updatedPicPath;	
		$vacci_id = $this-> othervaccination_model-> insert_vacc_record($postdata);
             
             $arr = array('error' => 'false', 'message' => 'Image Added Successfully','image_url'=>$petpic,'vacc_id'=>$vacci_id);
   	     
                }else{
			 $arr = array('error' => 'true', 'message' => $this->upload->display_errors());
		}                
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


   //get vaccination record book
    function getvaccinationrecord(){
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
 
        $postdata = array('user_email' => $email,'pet_id'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('user_email', 'user_email', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {


        //get vaccination
        $vaccinations = $this->othervaccination_model->get_vaccination_recordbook_by_petid($petid);
        $vaccinationArray = array();
        foreach($vaccinations as $vaccination){
            $vaccinationArr = array();
            $vaccinationArr['vacc_id']=$vaccination->id;
            $vaccinationArr['user_email']=$vaccination->user_email;
            $vaccinationArr['pet_id']=$vaccination->pet_id;
            if($vaccination->image_path != null)
               $vaccinationArr['image_path']=$this->config->base_url().$vaccination->image_path;
            else
               $vaccinationArr['image_path']=null;
        
            //return pet's original owner email
            $userid = $this->pet_model->getPetsOwnerUserId($vaccination->pet_id);
            $userObj = $this -> user_model -> get_user_record($userid);
            if(!empty($userObj)){
                $vaccinationArr['owner_email'] =$userObj[0]->email;    
            }    
            array_push($vaccinationArray, $vaccinationArr);
        }
        $arr = array('error' => 'false','message' => 'Vaccinations Loaded Successfully', 'vaccination' => $vaccinationArray);        
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


    //vaccination deleterecord
    function deletevaccinationrecord(){
        	$vacc_id = $this -> input -> post('vacc_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);

		$postdata = array('vacc_id'=> $vacc_id,'user_email' => $email,'pet_id'=>$petid);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('vacc_id', 'Vacc Id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
			
		    //delete vacc record		
		    $this->othervaccination_model->delete_vaccination_record($vacc_id);
		    $arr = array('error' => 'false', 'message' => 'Vaccination deleted Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }


    //add other worm
    function addotherworm(){
	$vacc_id = $this -> input -> post('vacc_id', TRUE);        
	$petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
        $vaccination_name = $this -> input -> post('vaccination_name', TRUE);

        $postdata = array('vacc_id'=>$vacc_id,'user_email' => $email,'pet_id'=>$petid,'vaccination_name'=>$vaccination_name);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('vacc_id', 'Vacc Id', 'trim|required');
        $this -> form_validation -> set_rules('vaccination_name', 'Vaccination Name', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
         $last_done = $this -> input -> post('last_done', TRUE);
         $due_date = $this -> input -> post('due_date', TRUE);
         $frequency = $this -> input -> post('frequency', TRUE);
        
        //add worm
        $postdata['last_done']=$last_done;
        $postdata['due_date']=$due_date;
        $postdata['frequency']=$frequency;
        $this->otherworm_model->insert_worm($postdata);
        $arr = array('error' => 'false', 'message' => 'Worm added Successfully...');        
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


    //get worm
    function getotherworm(){
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);
 
        $postdata = array('user_email' => $email,'pet_id'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('user_email', 'user_email', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {


        //get vaccination
        $vaccinations = $this->otherworm_model->get_worm_record_by_petid($petid);
        $vaccinationArray = array();
        foreach($vaccinations as $vaccination){
            $vaccinationArr = array();
            $vaccinationArr['vacc_id']=$vaccination->vacc_id;
            $vaccinationArr['user_email']=$vaccination->user_email;
            $vaccinationArr['pet_id']=$vaccination->pet_id;
            $vaccinationArr['last_done']= $vaccination->last_done;
            $vaccinationArr['due_date']= $vaccination->due_date;
            $vaccinationArr['frequency']=$vaccination->frequency;
            $vaccinationArr['vaccination_name']=$vaccination->vaccination_name;
        
            //return pet's original owner email
            $userid = $this->pet_model->getPetsOwnerUserId($vaccination->pet_id);
            $userObj = $this -> user_model -> get_user_record($userid);
            if(!empty($userObj)){
                $vaccinationArr['owner_email'] =$userObj[0]->email;    
            }    
            array_push($vaccinationArray, $vaccinationArr);
        }
        $arr = array('error' => 'false', 'message' => 'Worm Loaded Successfully.', 'worm' => $vaccinationArray);        
        }
    //add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

   //update worm
    function updateotherworm(){
        	$vacc_id = $this -> input -> post('vacc_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);
		$vaccination_name = $this -> input -> post('vaccination_name', TRUE);

		$postdata = array('vacc_id'=> $vacc_id,'user_email' => $email,'pet_id'=>$petid,'vaccination_name'=>$vaccination_name);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('vacc_id', 'Vacc Id', 'trim|required');
		$this -> form_validation -> set_rules('vaccination_name', 'Vaccination Name', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
		         $last_done = $this -> input -> post('last_done', TRUE);
		         $due_date = $this -> input -> post('due_date', TRUE);
		         $frequency = $this -> input -> post('frequency', TRUE);
        		$postdataArr = array('user_email' => $email,'pet_id'=>$petid,'last_done'=>$last_done,'due_date'=>$due_date,'frequency'=>$frequency,'vaccination_name'=>$vaccination_name);

		    $this->otherworm_model->update_worm($vacc_id ,$postdataArr);
		    $arr = array('error' => 'false', 'message' => 'Worm updated Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }	



    //vaccination worm
    function deleteotherworm(){
        	$vacc_id = $this -> input -> post('vacc_id', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
		$email = $this -> input -> post('user_email', TRUE);

		$postdata = array('vacc_id'=> $vacc_id,'user_email' => $email,'pet_id'=>$petid);
		$this -> form_validation -> set_data($postdata);

		//set validations
		$this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
		$this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
		$this -> form_validation -> set_rules('vacc_id', 'Vacc Id', 'trim|required');
	   
		if ($this -> form_validation -> run() == FALSE) {
		    //echo "Validation Failed";
		    $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
		} else {
			
		    //delete worm		
		    $this->otherworm_model->delete_worm($vacc_id);
		    $arr = array('error' => 'false', 'message' => 'Worm deleted Successfully...');     
		}
	    //add the header here
		header('Content-Type: application/json');
		echo json_encode($arr);
    }



    //get care,vaccination,worm
    function getcarevacworm(){
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('email', TRUE);

	$postdata = array('email' => $email,'pet_id'=>$petid);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {

		//get appointment
		$cares = $this->care_model->get_care_record_by_petid($petid);
		$careArray = array();
		foreach($cares as $care){
			$careArr = array();
			$careArr['timer_id']=$care->timer_id;
			$careArr['user_email']=$care->user_email;
			$careArr['pet_id']=$care->pet_id;
			$careArr['is_comp']= $care->is_comp; 
			$careArr['is_none']= $care->is_none;
			$careArr['long']=$care->long;
			$careArr['date']=$care->date;
			$careArr['interval']=$care->interval;
			$careArr['time']=$care->time;
			$careArr['category']=$care->category;
			$careArr['title']=$care->title;	
		
			//return pet's original owner email
			$userid = $this->pet_model->getPetsOwnerUserId($care->pet_id);
			$userObj = $this -> user_model -> get_user_record($userid);
			if(!empty($userObj)){
				$careArr['owner_email'] =$userObj[0]->email;	
			}	
			array_push($careArray, $careArr);
		}

		//get vaccination
		$vaccinations = $this->vaccination_model->get_vaccination_record_by_petid($petid);
		$vaccinationArray = array();
		foreach($vaccinations as $vaccination){
		    $vaccinationArr = array();
		    $vaccinationArr['vacc_id']=$vaccination->vacc_id;
		    $vaccinationArr['user_email']=$vaccination->user_email;
		    $vaccinationArr['pet_id']=$vaccination->pet_id;
		    $vaccinationArr['last_done']= $vaccination->last_done;
		    $vaccinationArr['due_date']= $vaccination->due_date;
		    $vaccinationArr['category']=$vaccination->category;
		    $vaccinationArr['frequency']=$vaccination->frequency;
		
		    //return pet's original owner email
		    $userid = $this->pet_model->getPetsOwnerUserId($vaccination->pet_id);
		    $userObj = $this -> user_model -> get_user_record($userid);
		    if(!empty($userObj)){
		        $vaccinationArr['owner_email'] =$userObj[0]->email;    
		    }    
		    array_push($vaccinationArray, $vaccinationArr);
		}


		//get worm
		$worms = $this->worm_model->get_worm_record_by_petid($petid);
		$wormArray = array();
		foreach($worms as $worm){
		    $wormArr = array();
		    $wormArr['worm_id']=$worm->worm_id;
		    $wormArr['user_email']=$worm->user_email;
		    $wormArr['pet_id']=$worm->pet_id;
		    $wormArr['last_done']= $worm->last_done;
		    $wormArr['due_date']= $worm->due_date;
		    $wormArr['category']=$worm->category;
		    $wormArr['frequency']=$worm->frequency;
		
		    //return pet's original owner email
		    $userid = $this->pet_model->getPetsOwnerUserId($worm->pet_id);
		    $userObj = $this -> user_model -> get_user_record($userid);
		    if(!empty($userObj)){
		        $wormArr['owner_email'] =$userObj[0]->email;    
		    }    
		    array_push($wormArray, $wormArr);
		}

		$arr = array('error' => 'false','message' => 'Care , Vaccination and Worm Loaded Successfully.', 'care' => $careArray,'vaccination' => $vaccinationArray,'worm' => $wormArray);		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
	
	
	// add tracker data
    function addtrackerdata(){
	
		$trackerdata = $this -> input -> post('tracker_data_json', TRUE);
		$email = $this -> input -> post('user_email', TRUE);
		$petid = $this -> input -> post('pet_id', TRUE);
	
		$trackerdata = json_decode($trackerdata); 


		foreach($trackerdata->data as $item){
			$deviceid=$item->deviceid;
			$datetime=$item->datetime;
			$steps=$item->steps;
			$totalsteps=$item->totalsteps;
			
		$postdata = array('datetime'=> $datetime,'steps'=>$steps,'totalsteps'=>$totalsteps,'user_email' => $email,'pet_id'=>$petid,'deviceid'=>$deviceid); 
			
		$this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('datetime', 'Date Time', 'trim|required');
        $this -> form_validation -> set_rules('steps', 'Steps', 'trim|required');
		$this -> form_validation -> set_rules('totalsteps', 'Total Steps', 'trim|required');
        $this -> form_validation -> set_rules('deviceid', 'Device Id', 'trim|required');
    
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {
			
		$cnt=$this->tracker_model->check_tracker_data($email,$petid,$datetime,$deviceid);
		
		if($cnt>0){
			//echo "Record exists";
		}else{		
			$this->tracker_model->insert_tracker($postdata);
		}
        }
		
		}
		
		$arr = array('error' => 'false', 'message' => 'Activity Tracker Data added Successfully...');		
		header('Content-Type: application/json');
		echo json_encode($arr);
    }
	
	
	    //get care
    function gettrackerdata(){
        $strdate = $this -> input -> post('strdate', TRUE);
		$enddate = $this -> input -> post('enddate', TRUE);
        $petid = $this -> input -> post('pet_id', TRUE);
        $email = $this -> input -> post('user_email', TRUE);

		$postdata = array('user_email' => $email,'pet_id'=>$petid,'strdate' => $strdate,'enddate' => $enddate);
        $this -> form_validation -> set_data($postdata);

        //set validations
        $this -> form_validation -> set_rules('user_email', 'Email', 'trim|required');
        $this -> form_validation -> set_rules('pet_id', 'Pet Id', 'trim|required');
        $this -> form_validation -> set_rules('strdate', 'Start Date', 'trim|required');
		$this -> form_validation -> set_rules('enddate', 'End Date', 'trim|required');
        
        if ($this -> form_validation -> run() == FALSE) {
            //echo "Validation Failed";
            $arr = array('error' => 'true', 'message' => $this -> form_validation -> error_string());
        } else {

		//get appointment
		$trackerdata = $this->tracker_model->get_tracker_data($email,$petid,$strdate,$enddate);
		$trackerArray = array();
		foreach($trackerdata as $tracker){
			$trackerArr = array();
			$trackerArr['id']= $tracker->id;
			$trackerArr['deviceid']= $tracker->deviceid; 
			$trackerArr['datetime']= $tracker->datetime;
			$trackerArr['steps']=$tracker->steps;
			$trackerArr['totalsteps']=$tracker->totalsteps;
			
			array_push($trackerArray, $trackerArr);
		}
		$arr = array('error' => 'false','message'=>'Tracker Data Loaded Successfully.','user_email'=>$email,'pet_id'=>$petid, 'trackerdata' => $trackerArray);		
        }
	//add the header here
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
	
	//cron job of setting iscomp none
	function setIsCompNone(){
		$cares = $this->cron_model->get_care_record_by_isComp();
		// http://164.132.170.155/WebService/setIsCompNone
		
		foreach($cares as $care){
			$postdata = array();
			$postdata['is_comp']= "None";
			$this->cron_model->update_care($care->id ,$postdata);
		}
	}
}
?>