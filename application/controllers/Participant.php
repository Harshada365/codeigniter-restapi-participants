<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Participant extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('list');
	}

	public function load_data()
	{
		$this->load->library('datatables_server_side', array(
			'table' => 'tbl_participants',
			'primary_key' => 'id',
			'columns' => array('id', 'name', 'age', 'dob', 'profession', 'locality', 'no_of_guests', 'address'),
			'where' => array()
		));

		$this->datatables_server_side->process();
	}
}