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
				'email' => $this->input->post('email'), 
				'password' => $this->input->post('password')
				);
			$this->load->model('Regular_User');
			$login_result = $this->Regular_User->login($user_data);
			if ($login_result === "1") {
				$this->session->set_userdata('userlogin',$user_data);
				$this->load->view('game_view');
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

		$pass1 = $this->input->post('pass');
		$pass2 = $this->input->post('confirmpwd');

		if ($this->form_validation->run() == false) {
			$this->load->view('login_view');
		} else if ($pass1 === $pass2) {
			$user_data = array(
				'email' => $this->input->post('register_email'),
				'password' => $pass1,
				'username' => $this->input->post('register_user') 
				);
			$this->load->model('Regular_User');
			$status_message = $this->Regular_User->insert_regular_user($user_data);
			$data = array(
				'status_message' => $status_message 
				);
			$this->load->view('post_register_view', $data);
		} else {
			$status_message = 'Password and Confirm Password fields do not match';
			$data = array(
				'status_message' => $status_message 
				);
			$this->load->view('post_register_view', $data);
		}
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

    /**
    * Function used for AJAX requests by the
    * game
    */
	public function start_game() {
		$this->load->model('Labyrinth_Generator');
   		$this->Labyrinth_Generator->GenerateMaze();
   		$labyrinth = $this->Labyrinth_Generator->getMaze();
   		echo json_encode($labyrinth);
	}
}
