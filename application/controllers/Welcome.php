<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$this->load->view('welcome_message');
		$this->load->model('Model');
		$this->Model->test();
		$this->load->database();
		echo "<br>";
		$query = $this->db->query('SELECT * FROM FaceMaze_Users');
		foreach ($query->result_array() as $row) {
		    echo $row['MAIL_ADDRESS'];
		}
	}
}
