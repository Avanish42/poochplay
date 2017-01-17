<?php
/*
 * File Name: Worm_model.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Worm_model extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    

    function get_worm_record_by_petid($pet_id) {
        $this -> db -> where('pet_id', $pet_id);
        $this -> db -> from('pet_worm');
        $query = $this -> db -> get();
        return $query -> result();
    }

    function get_worm_record_by_id($id) {
        $this -> db -> where('id', $id);
        $this -> db -> from('pet_worm');
        $query = $this -> db -> get();
        return $query -> result();
    }

    function get_worm_record_by_category_petid($category,$pet_id) {
        $query = array("pet_id"=>$pet_id,'category'=>$category);    
        $this -> db -> where($query);
        $this -> db -> from('pet_worm');
        $query = $this -> db -> get();
        return $query -> result();
    }

    
    //insert worm
    function insert_worm($data) {
	$id = $this -> getNewid();        
	$data['id'] = $id;
        //insert the form data into database
        $this -> db -> insert('pet_worm', $data);
	return $id;
    }

    function getNewid() {
        $sql = "select max(id) as mid from pet_worm";
        $query = $this -> db -> query($sql);
        if($query -> num_rows() > 0){
            $result = $query -> result();
            $maxid = $result[0] -> mid;
            return $maxid + 1;    
        }else{
            return 1;    
        }        
        
    }
    //update worm
    function update_worm($id,$data) {
        $this -> db -> where('worm_id', $id);
        $this -> db -> update('pet_worm', $data);
    }
    
    //delete worm
    function delete_worm($id) {
        $this -> db -> where('worm_id', $id);
        $this -> db -> delete('pet_worm');
    }
}
