<?php
/*
 * File Name: Foster_model.php
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Foster_model extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_foster_record($foster_id) {
        if ($foster_id != 'all')
            $this -> db -> where('id', $foster_id);
        $this -> db -> from('pet_foster');
        $this -> db -> order_by("id", "asc");
        $query = $this -> db -> get();
        return $query -> result();
    }

    //insert foster
    function insert_foster($data) {
        $data['id'] = $this -> getNewid();
        //insert the form data into database
        $this -> db -> insert('pet_foster', $data);
    }

    //update foster
    function update_foster($foster_id,$data) {
        //insert the form data into database
        $this -> db -> where('id', $foster_id);
        $this -> db -> update('pet_foster', $data);
    }


    function getNewid() {
        $sql = "select max(id) as mid from pet_foster";
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