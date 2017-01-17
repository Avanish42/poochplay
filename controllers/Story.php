<?php
/*
 * File Name: Story.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Story extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this -> load -> library('session');
        $this -> load -> helper('form');
        $this -> load -> helper('url');
        $this -> load -> database();
        $this -> load -> library('form_validation');
        //load the story model
        $this -> load -> model('story_model');
    }
   
    function index() {
        if (empty($this -> session -> userdata) || $this -> session -> userdata==null ||  $this -> session -> userdata['loginuser'] == FALSE) {
            redirect('login/index');
        }else{
            $data['story'] = $this -> story_model -> get_story_record('all');
            $this -> load -> view('commons/header');
            $this -> load -> view('commons/topnav');
            $this -> load -> view('commons/sidebar');
            $this -> load -> view('story/story_list_view', $data);
            $this -> load -> view('commons/footer.php');
        }
    }
   
     function add($story_id = 0) {
        $data['story_id'] = 0;
        $data['storyrecord'] = $this -> story_model -> get_story_record('all');
        //set validation rules
        $this -> form_validation -> set_rules('storytitle', 'Story Title', 'trim|required');
       
        if ($this -> form_validation -> run() == FALSE) {
            //fail validation
            $this -> load -> view('commons/header');
            $this -> load -> view('commons/topnav');
            $this -> load -> view('commons/sidebar');
            $this -> load -> view('story/story_view', $data);
            $this -> load -> view('commons/footer.php');
        } else {
            //pass validation
            $active = false;
            if(!empty($this -> input -> post('active')) || $this -> input -> post('active') != null)
                $active = true;

            $storytitle = $this -> input -> post('storytitle');
            $storydescription = $this -> input -> post('storydescription');

            //create folder
            //server path
            $uploadPath = '/var/www/html/images/';       
            //local path
            //$uploadPath = '/opt/lampp/htdocs/pets/images/';       

            if (!is_dir($uploadPath)){
                mkdir($uploadPath, 0777, true);
            }
   
            $dir_exist = true; // flag for checking the directory exist or not

            if (!is_dir($uploadPath . 'stories/')){
                mkdir($uploadPath . 'stories/', 0777, true);
                $dir_exist = false; // dir not exist
            }

            $this->load->library('upload');

            $config['upload_path']          = $uploadPath . 'stories/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            //$config['file_name']        = $breed_name;
   
            $this->upload->initialize($config);

            $updatedStoryPath=null;   
            if ( $this->upload->do_upload('image')){
               $updatedStoryPath='images/stories/'.$this->upload->data('file_name');   
            }
		
            //updated story info
	    if($updatedStoryPath==null)	
   	         $data = array('title' => $storytitle, 'description' => $storydescription);
	    else
   	         $data = array('title' => $storytitle, 'description' => $storydescription,'image_path'=>$updatedStoryPath);
           
            //create story
            $this -> story_model -> insert_story($data);

            //display success message
            $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">Story added !!!</div>');
            redirect('Story/add');
        }

    }

    function update($story_id) {
        $data['story_id'] = $story_id;
        $data['storyrecord'] = $this -> story_model -> get_story_record($story_id);
        //set validation rules
        $this -> form_validation -> set_rules('storytitle', 'Story Title', 'trim|required');
       
        if ($this -> form_validation -> run() == FALSE) {
            //fail validation
            $this -> load -> view('commons/header');
            $this -> load -> view('commons/topnav');
            $this -> load -> view('commons/sidebar');
            $this -> load -> view('story/story_view', $data);
            $this -> load -> view('commons/footer.php');
        } else {
            //pass validation
            $active = false;
            if(!empty($this -> input -> post('active')) || $this -> input -> post('active') != null)
                $active = true;

            $storytitle = $this -> input -> post('storytitle');
            $storydescription = $this -> input -> post('storydescription');

            //create folder
            //server path
            $uploadPath = '/var/www/html/images/';       
            //local path
            //$uploadPath = '/opt/lampp/htdocs/pets/images/';       

            if (!is_dir($uploadPath)){
                mkdir($uploadPath, 0777, true);
            }
   
            $dir_exist = true; // flag for checking the directory exist or not

            if (!is_dir($uploadPath . 'stories/')){
                mkdir($uploadPath . 'stories/', 0777, true);
                $dir_exist = false; // dir not exist
            }

            $this->load->library('upload');

            $config['upload_path']          = $uploadPath . 'stories/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            //$config['file_name']        = $breed_name;
   
            $this->upload->initialize($config);

            $updatedStoryPath=null;   
            if ( $this->upload->do_upload('image')){
               $updatedStoryPath='images/stories/'.$this->upload->data('file_name');   
            }
		
            //updated story info
	    if($updatedStoryPath==null)	
   	         $data = array('title' => $storytitle, 'description' => $storydescription);
	    else
   	         $data = array('title' => $storytitle, 'description' => $storydescription,'image_path'=>$updatedStoryPath);
		

            $this -> story_model ->update_story($story_id,$data);

            //display success message
            $this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">Story updated !!!</div>');
            redirect("Story/update/" . $story_id);
        }
    }
}

?>
