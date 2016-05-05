<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	* Controller constructor
	* Calls parent's constructor and loads the database
	*/
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Index Page for this controller
	 */
	public function index() {
		$this->load->view('welcome_message');
		$query = $this->db->query('SELECT * FROM FaceMaze_Users ORDER BY high_score DESC');
		foreach ($query->result_array() as $row) {
		    echo $row['MAIL_ADDRESS'];
		    echo ' ';
		    echo $row['HIGH_SCORE'];
		    echo '<br>';
		}
		//$this->add_user();
		//echo '<br>';
	}

	/**
	* Add a new regular user
	*/
	public function add_user() {
		$this->load->model('User_Model');
		$data = array(
			'mail'=>'donald.trump@madhouse.com',
			'username'=>'Drumpf',
			'password'=>'1234'
			);
		echo $this->User_Model->insert_regular_user($data);
	}
}
