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
		$this->load->model('User_Model');
	}

	/**
	 * Index Page for this controller
	 */
	public function index() {
		$user_data = array(
			'mail'=>'vladadrian95@gmail.com',
			'type'=>'1'
			);
		$high_score = $this->User_Model->get_high_score($user_data);
		$last_score = $this->User_Model->get_last_score($user_data);
		$data = array(
			'high_score'=>$high_score,
			'last_score'=>$last_score
			);
		$this->load->view('game_view', $data);
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
