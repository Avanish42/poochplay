<?php
/*
 * File Name: Galimages_model.php
 */
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

class Galimages_model extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct ();
    }
   
    function getNewid() {
        $sql = "select max(id) as mid from pet_gallery";
        $query = $this -> db -> query($sql);
        if($query -> num_rows() > 0){
            $result = $query -> result();
            $maxid = $result[0] -> mid;
            return $maxid + 1;   
        }else{
            return 1;   
        }   
    }
   
    // add pet
    function addGallery($data) {
        $data['capture_date'] = date("Y-m-d H:i:s");
        $id = $this -> getNewid();
        $data['id'] = $id;
       
        //insert the form data into database
        $this -> db -> insert('pet_gallery', $data);
        return $id;
    }

    // update gallery
    function updateGallery($gallery_id,$data) {
        $this -> db -> where('id', $gallery_id);
        $this -> db -> update('pet_gallery', $data);
    }

    //get gallery by petid
    function getAllGalleryByPetid($pet_id) {
        $this -> db -> where('pet_id', $pet_id);
        $this -> db -> from('pet_gallery');
        $this -> db -> order_by("id", "asc");
        $query = $this -> db -> get();
        return $query -> result();
    }

    //delete gallery
    function deleteGallery($gallery_id) {
        $this -> db -> where('id', $gallery_id);
        $this -> db -> delete('pet_gallery');
    }
}
?>
