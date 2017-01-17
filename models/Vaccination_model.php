<?php
/*
 * File Name: Vaccination_model.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vaccination_model extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    

    function get_vaccination_record_by_petid($pet_id) {
        $this -> db -> where('pet_id', $pet_id);
        $this -> db -> from('pet_vaccination');
        $query = $this -> db -> get();
        return $query -> result();
    }

    function get_vaccination_record_by_id($id) {
        $this -> db -> where('id', $id);
        $this -> db -> from('pet_vaccination');
        $query = $this -> db -> get();
        return $query -> result();
    }

    function get_vaccination_record_by_category_petid($category,$pet_id) {
        $query = array("pet_id"=>$pet_id,'category'=>$category);    
        $this -> db -> where($query);
        $this -> db -> from('pet_vaccination');
        $query = $this -> db -> get();
        return $query -> result();
    }

    
    //insert vaccination
    function insert_vaccination($data) {
	$id = $this -> getNewid();        
	$data['id'] = $id;
        //insert the form data into database
        $this -> db -> insert('pet_vaccination', $data);
	return $id;
    }

    function getNewid() {
        $sql = "select max(id) as mid from pet_vaccination";
        $query = $this -> db -> query($sql);
        if($query -> num_rows() > 0){
            $result = $query -> result();
            $maxid = $result[0] -> mid;
            return $maxid + 1;    
        }else{
            return 1;    
        }        
        
    }
    //update vaccination
    function update_vaccination($id,$data) {
        $this -> db -> where('vacc_id', $id);
        $this -> db -> update('pet_vaccination', $data);
    }
    
    //delete vaccination
    function delete_vaccination($id) {
        $this -> db -> where('vacc_id', $id);
        $this -> db -> delete('pet_vaccination');
    }
}
