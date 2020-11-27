<?php

require APPPATH.'libraries/REST_Controller.php';

class Participant extends REST_Controller{

	public function __construct(){

    parent::__construct();
    //load database
    $this->load->database();
    $this->load->model(array("api/participant_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  // POST: http://localhost/eduvanz/api/participant/participants
  public function participants_get(){
    
  	// list data method
    
    $participants = $this->participant_model->get_participants();

    //print_r($participants);

    if(count($participants) > 0){

      $this->response(array(
        "status" => 1,
        "message" => "Record found",
        "data" => $participants
      ), REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        "status" => 0,
        "message" => "No Record found",
        "data" => $participants
      ), REST_Controller::HTTP_NOT_FOUND);
    }
  }


  // POST: http://localhost/eduvanz/api/participant/participants
  public function participants_post(){

    // insert data method

    //print_r($this->input->post());die;

    // collecting form data inputs
    $name = $this->security->xss_clean($this->input->post("name"));
    $age = $this->security->xss_clean($this->input->post("age"));
    $dob = $this->security->xss_clean($this->input->post("dob"));
    $profession = $this->security->xss_clean($this->input->post("profession"));
    $locality = $this->security->xss_clean($this->input->post("locality"));
    $no_of_guests = $this->security->xss_clean($this->input->post("no_of_guests"));
    $address = $this->security->xss_clean($this->input->post("address"));


    // form validation for inputs
    $this->form_validation->set_rules("name", "Name", "required|min_length[1]|max_length[50]");
    $this->form_validation->set_rules("age", "Age", "required");
    $this->form_validation->set_rules("dob", "DOB", "required");
    $this->form_validation->set_rules("profession", "Profession", "required|min_length[1]|max_length[100]");
    $this->form_validation->set_rules("locality", "Locality", "required|min_length[1]|max_length[100]");
    $this->form_validation->set_rules("no_of_guests", "Guests", "required");
    $this->form_validation->set_rules("address", "Address", "required");

    $profession_array = ['employed', 'student'];

    // checking form submittion have any error or not
    if($this->form_validation->run() === FALSE){

      // we have some errors
      $this->response(array(
        "status" => 0,
        "message" => "All fields are needed"
      ) , REST_Controller::HTTP_NOT_FOUND);
    }else{

      if(!empty($name) && !empty($age) && !empty($dob) && !empty($profession) && !empty($locality) && !empty($no_of_guests) && !empty($address)){

  		//custom validation 1
        if($no_of_guests < 0 || $no_of_guests >2){

        	$this->response(array(
	          "status" => 0,
	          "message" => "No of guests should not be more than 2."
	        ), REST_Controller::HTTP_NOT_FOUND);

        }elseif(!in_array(strtolower($profession), $profession_array)){ //custom validation 2

        	$this->response(array(
	          "status" => 0,
	          "message" => "Profession should be Employed/Student."
	        ), REST_Controller::HTTP_NOT_FOUND);

        }else{

        	// all values are available

        	$date = str_replace('/', '-', $dob);
        	$birth_date = date("Y-m-d", strtotime($date));

	        $participants = array(
	          "name" => $name,
	          "age" => $age,
	          "dob" => $birth_date,
	          "profession" => $profession,
	          "locality" => $locality,
	          "no_of_guests" => $no_of_guests,
	          "address" => $address
	        );

	        if($this->participant_model->insert_participant($participants)){

	          $this->response(array(
	            "status" => 1,
	            "message" => "Record has been created"
	          ), REST_Controller::HTTP_OK);
	        }else{

	          $this->response(array(
	            "status" => 0,
	            "message" => "Failed to create Record"
	          ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
	        }
	    }

      }else{
        // we have some empty field
        $this->response(array(
          "status" => 0,
          "message" => "All fields are needed"
        ), REST_Controller::HTTP_NOT_FOUND);
      }
    }
  }

  // POST: http://localhost/eduvanz/api/participant/participants
  public function participants_put(){

    // update data method
  	$data = json_decode(file_get_contents("php://input"));
    //echo "<pre>";print_r($data);die;  	

    if(isset($data->id)){

    	$participants = $this->participant_model->get_participants($data->id);
  		//echo "<pre>";print_r($participants);die;

  		if(count($participants) > 0){

  			if(isset($data->name)){
	        	$name = $data->name;
	    	}else{
	    		$name = $participants[0]->name;
	    	}

	    	if(isset($data->age)){
	        	$age = $data->age;
	    	}else{
	    		$age = $participants[0]->age;
	    	}

	  		if(isset($data->dob)){
				$date = str_replace('/', '-', $data->dob);
	        	$birth_date = date("Y-m-d", strtotime($date));
	    	}else{
	    		$birth_date = $participants[0]->dob;
	    	}

	    	if(isset($data->profession)){

	    		$profession_array = ['employed', 'student'];

	    		if(!in_array(strtolower($data->profession), $profession_array)){ //custom validation 2

		        	$this->response(array(
			          "status" => 0,
			          "message" => "Profession should be Employed/Student."
			        ), REST_Controller::HTTP_NOT_FOUND);

		        }else{
	        		$profession = $data->profession;
	        	}
	    	}else{
	    		$profession = $participants[0]->profession;
	    	}

	    	if(isset($data->locality)){
	        	$locality = $data->locality;
	    	}else{
	    		$locality = $participants[0]->locality;
	    	}

	    	if(isset($data->no_of_guests)){

	    		if($data->no_of_guests < 0 || $data->no_of_guests >2){

		        	$this->response(array(
			          "status" => 0,
			          "message" => "No of guests should not be more than 2."
			        ), REST_Controller::HTTP_NOT_FOUND);
		        }else{
		        	$no_of_guests = $data->no_of_guests;
		        }	        	
	    	}else{
	    		$no_of_guests = $participants[0]->no_of_guests;
	    	}

	    	if(isset($data->address)){
	        	$address = $data->address;
	    	}else{
	    		$address = $participants[0]->address;
	    	}

	      	$participant_id = $data->id;
	      	$participants_info = array(
		      "name" => $name,
		      "age" => $age,
		      "dob" => $birth_date,
		      "profession" => $profession,
		      "locality" => $locality,
		      "no_of_guests" => $no_of_guests,
		      "address" => $address
		    );

	      	if($this->participant_model->update_participant_information($participant_id, $participants_info)){

				$this->response(array(
				"status" => 1,
				"message" => "Record updated successfully"
				), REST_Controller::HTTP_OK);
	      	}else{

		        $this->response(array(
		          "status" => 0,
		          "messsage" => "Failed to update Record"
		        ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
	      	}
	  	}else{

	  		$this->response(array(
			"status" => 0,
			"message" => "False Id given"
			), REST_Controller::HTTP_NOT_FOUND);
	  	}
    }else{

		$this->response(array(
		"status" => 0,
		"message" => "Id is must"
		), REST_Controller::HTTP_NOT_FOUND);
    }
  }

}