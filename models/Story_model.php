<?php
/*
 * File Name: Story_model.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Story_model extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
   
    function get_story_record($story_id) {
        if ($story_id != 'all')
            $this -> db -> where('id', $story_id);
        $this -> db -> from('story');
        $this -> db -> order_by("id", "asc");
        $query = $this -> db -> get();
        return $query -> result();
    }
   
    //insert story
    function insert_story($data) {
        $data['id'] = $this -> getNewid();
        //insert the form data into database
        $this -> db -> insert('story', $data);
    }

    //update story
    function update_story($story_id,$data) {
        //insert the form data into database
        $this -> db -> where('id', $story_id);
        $this -> db -> update('story', $data);
    }
           

    function getNewid() {
        $sql = "select max(id) as mid from story";
        $query = $this -> db -> query($sql);
        if($query -> num_rows() > 0){
            $result = $query -> result();
            $maxid = $result[0] -> mid;
            return $maxid + 1;   
        }else{
            return 1;   
        }       
       
    }
}
