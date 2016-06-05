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

				//set session for user
				$this->session->set_userdata('userlogin',$user_data);

				$this->load->model('Regular_User');
				$high_score = $this->Regular_User->get_high_score($user_data);
    			$last_score = $this->Regular_User->get_last_score($user_data);
				$user_scores = array(
 					'high_score'=>$high_score,
 					'last_score'=>$last_score
 				);
 				$this->session->set_userdata('userscores', $user_scores);

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
		$this->session->sess_destroy();
		$this->index();
	}

    /**
    * Function used for AJAX requests by the
    * game to get a random labyrinth
    */
	public function start_game() {
		$this->load->model('Labyrinth_Generator');
   		$this->Labyrinth_Generator->GenerateMaze();
   		$labyrinth = $this->Labyrinth_Generator->getMaze();

   		echo json_encode($labyrinth);
	}

    /**
    * Function used for AJAX requests by the 
    * game to get user's score
    */
	public function get_score() {
		$this->load->library('session');
		$scores = $this->session->userdata('userscores');

		$data = array($scores['high_score'], $scores['last_score']);

		echo json_encode($data);
	}

	/**
    * Function used for AJAX requests by the 
    * game to post user's score
    */
	public function post_score() {
		$score = $this->input->post('scoreValue');
		$this->load->library('session');
		$this->session->unset_userdata('userscores');
		if ($this->session->userdata('userlogin')) {
			$user_data = $this->session->userdata('userlogin');
			$data = array(
				'email'=>$user_data['email'],
				'score'=>$score
				);
			$this->load->model('Regular_User');
			$this->Regular_User->update_last_score($data);
			$this->Regular_User->update_high_score($data);

            $high_score = $this->Regular_User->get_high_score($user_data);
    		$last_score = $this->Regular_User->get_last_score($user_data);
			$user_scores = array(
 				'high_score'=>$high_score,
 				'last_score'=>$last_score
 			);
 			$this->session->set_userdata('userscores', $user_scores);

		} else if ($this->session->userdata('fb_data')) {
			$user_data = $this->session->userdata('fb_data');
			$data = array(
				'id'=>$user_data['id'],
				'score'=>$score
				);
			$this->load->model('Fb_User');
			$this->Fb_User->update_last_score($data);
			$this->Fb_User->update_high_score($data);

			$high_score = $this->Fb_User->get_high_score($user_data);
    		$last_score = $this->Fb_User->get_last_score($user_data);
			$user_scores = array(
 				'high_score'=>$high_score,
 				'last_score'=>$last_score
 			);
 			$this->session->set_userdata('userscores', $user_scores);

		} else if ($this->session->userdata('twid')) {
			$user_data = $this->session->userdata('twid');
			$data = array(
				'id'=>$user_data,
				'score'=>$score
				);
			$this->load->model('Tw_User');
			$this->Tw_User->update_last_score($data);
			$this->Tw_User->update_high_score($data);

			$high_score = $this->Tw_User->get_high_score($data);
			$last_score = $this->Tw_User->get_last_score($data);
			$user_scores = array(
 				'high_score'=>$high_score,
 				'last_score'=>$last_score
 			);
 			$this->session->set_userdata('userscores', $user_scores);

		}
		echo json_encode($score);
	}

    /**
    * Handles login process using Facebook account
    */
	public function fb_login() {
		$this->load->library('session');
		if ($this->session->userdata('fb_data')) {
			$user_data = $this->session->userdata('fb_data');
			$this->load->model('Fb_User');
			$this->Fb_User->insert_facebook_user($user_data);
			$high_score = $this->Fb_User->get_high_score($user_data);
    		$last_score = $this->Fb_User->get_last_score($user_data);
			$user_scores = array(
 				'high_score'=>$high_score,
 				'last_score'=>$last_score
 			);
 			$this->session->set_userdata('userscores', $user_scores);

 			$this->load->view('game_view');
		} else {
			$this->load->library('Fb_Login');
		}
	}

	/**
    * Twitter login by redirecting the user to Twitter for authentication
    * and then calls the callback function to redirect the user back to
    * our website
    */
	public function twitter_login() {
		$this->load->library('twconnect');
		$redirect_code = $this->twconnect->twredirect('Main_Controller/callback');

		if (!$redirect_code) {
			$return_message = 'There was a problem with Twitter authentication';
			$data = array(
				'status_message' => $return_message 
				);
			$this->load->view('post_register_view', $data);
		}
	}

    /**
    * Return point from Twitter
    */
	public function callback() {
		$this->load->library('twconnect');
		$callback_code = $this->twconnect->twprocess_callback();

        //Login process worked! Yeeeeeey
		if ($callback_code) {
			// saves Twitter user information to $this->twconnect->tw_user_info
			// twaccount_verify_credentials returns the same information
			$this->twconnect->twaccount_verify_credentials(); //GET account/verify_credentials

            $user_data = array(
				'id'=>$this->twconnect->tw_user_info->id,
				'real_name'=>$this->twconnect->tw_user_info->name
				);
			$this->load->model("Tw_User");
	        $this->Tw_User->insert_twitter_user($user_data);
	        $high_score = $this->Tw_User->get_high_score($user_data);
			$last_score = $this->Tw_User->get_last_score($user_data);
			$user_scores = array(
 				'high_score'=>$high_score,
 				'last_score'=>$last_score
 			);
 			$this->session->set_userdata('twid', $user_data['id']);
 			$this->session->set_userdata('userscores', $user_scores);
			$this->load->view('game_view');
		} else {
			$return_message = 'Twitter connection failed';
			$data = array(
				'status_message' => $return_message 
				);
			$this->load->view('post_register_view', $data);
		}
	}
}