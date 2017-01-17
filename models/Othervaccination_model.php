<?php
/*
 * File Name: Othervaccination_model.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Othervaccination_model extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    

    function get_vaccination_record_by_petid($pet_id) {
        $this -> db -> where('pet_id', $pet_id);
        $this -> db -> from('pet_vaccination_other');
        $query = $this -> db -> get();
        return $query -> result();
    }

    function get_vaccination_record_by_id($id) {
        $this -> db -> where('id', $id);
        $this -> db -> from('pet_vaccination_other');
        $query = $this -> db -> get();
        return $query -> result();
    }

    function get_vaccination_record_by_category_petid($category,$pet_id) {
        $query = array("pet_id"=>$pet_id,'category'=>$category);    
        $this -> db -> where($query);
        $this -> db -> from('pet_vaccination_other');
        $query = $this -> db -> get();
        return $query -> result();
    }

    
    //insert vaccination
    function insert_vaccination($data) {
	$id = $this -> getNewid();        
	$data['id'] = $id;
        //insert the form data into database
        $this -> db -> insert('pet_vaccination_other', $data);
	return $id;
    }

    function getNewid() {
        $sql = "select max(id) as mid from pet_vaccination_other";
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
        $this -> db -> update('pet_vaccination_other', $data);
    }
    
    //delete vaccination
    function delete_vaccination($id) {
        $this -> db -> where('vacc_id', $id);
        $this -> db -> delete('pet_vaccination_other');
    }

    //insert vaccination record
    function insert_vaccination_record($data) {
	$this -> db -> where('pet_id', $data['pet_id']);
        $this -> db -> from('pet_vaccination_recordbook');
        $query = $this -> db -> get();
        $result = $query -> result();
	if(!empty($result)){
	  //update
	  $this -> db -> where('pet_id', $data['pet_id']);
          $this -> db -> update('pet_vaccination_recordbook', $data);
	  return $result[0]->id;
	}else{
	  $id = $this -> getNewVacRecordid();        
	  $data['id'] = $id;
          //insert the form data into database
          $this -> db -> insert('pet_vaccination_recordbook', $data);
	  return $id;	
	}	
	
    }	

    //insert vaccination record
    function insert_vacc_record($data) {
	$id = $this -> getNewVacRecordid();        
	$data['id'] = $id;
        //insert the form data into database
        $this -> db -> insert('pet_vaccination_recordbook', $data);
	return $id;
    }

    function getNewVacRecordid() {
        $sql = "select max(id) as mid from pet_vaccination_recordbook";
        $query = $this -> db -> query($sql);
        if($query -> num_rows() > 0){
            $result = $query -> result();
            $maxid = $result[0] -> mid;
            return $maxid + 1;    
        }else{
            return 1;    
        }        
        
    }

function get_vaccination_recordbook_by_petid($pet_id) {
        $this -> db -> where('pet_id', $pet_id);
        $this -> db -> from('pet_vaccination_recordbook');
        $query = $this -> db -> get();
        return $query -> result();
    }

   //delete vaccination record
    function delete_vaccination_record($id) {
        $this -> db -> where('id', $id);
        $this -> db -> delete('pet_vaccination_recordbook');
    }

}
