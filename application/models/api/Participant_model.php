<?php

class Participant_model extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_participants($id=''){

    $this->db->select("*");
    $this->db->from("tbl_participants");
    if($id != ''){
      $this->db->where("id", $id);
    }
    $query = $this->db->get();

    return $query->result();
  }

  public function insert_participant($data = array()){

     return $this->db->insert("tbl_participants", $data);
  }

  public function update_participant_information($id, $informations){

    $this->db->where("id", $id);
    return $this->db->update("tbl_participants", $informations);
  }
}

?>