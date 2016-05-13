<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Controller extends CI_Controller {

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
		$this->load->helper('url');
		$this->load->view('login_view');
	}

    /**
    * Handles the login process
    * If the input email address and password matches then loads the game view
    * Else stay on login view page
    */
	public function login() {
		$this->load->library('session'); 
		$this->load->library('form_validation'); 
		$this->load->helper('url'); 
		$this->form_validation->set_rules('email','Email', 'trim|required'); 
		$this->form_validation->set_rules('password','Password', 'trim|required'); 

		if ($this->form_validation->run() == false){ 
			$this->load->view('login_view');
		} else { 
			$user_data=array( 
				'mail' => $this->input->post('email'), 
				'password' => $this->input->post('password'),
				'type' => '1'
				);
			$login_result = $this->User_Model->login($user_data);
			if ($login_result === "1") {
				$this->session->set_userdata('userlogin',$user_data);
				$this->enterGame();
			}
			else {
				$this->load->view('login_view');
			}
		} 
	}

    /**
    * Handles the register process
    * It will load a view that will display the result (succesful or why not)
    */
	public function register() {
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->form_validation->set_rules('register_user','Username', 'trim|required');
		$this->form_validation->set_rules('register_email','Email', 'trim|required');
		$this->form_validation->set_rules('pass', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirmpwd', 'Password', 'trim|required');

		if ($this->form_validation->run() == false) {
			$this->load->view('login_view');
		} else {
			$user_data = array(
				'mail' => $this->input->post('register_email'),
				'password' => $this->input->post('pass'),
				'username' => $this->input->post('register_user') 
				);
			$status_message = $this->User_Model->insert_regular_user($user_data);
			$data = array(
				'status_message' => $status_message 
				);
			$this->load->view('post_register_view', $data);
		}
	}

    /**
    * Loads the game view and sets up data based on session information
    */
	public function enterGame() {
		$user_data = $this->session->userdata('userlogin');
		$high_score = $this->User_Model->get_high_score($user_data);
    	$last_score = $this->User_Model->get_last_score($user_data);
		$data = array(
 			'high_score'=>$high_score,
 			'last_score'=>$last_score
 			);
 		$this->load->view('game_view', $data);
	}

    /**
    * Handles the logout process
    * Clears all data in session
    */
	public function logout() {
		$this->load->library('session');
		$this->session->unset_userdata('userlogin'); 
		$this->index();
	}
}
