<?php

	require_once 'autoload.php';
    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookRequest;
    use Facebook\FacebookResponse;
    use Facebook\FacebookSDKException;
    use Facebook\FacebookRequestException;
    use Facebook\FacebookAuthorizationException;
    use Facebook\GraphObject;
    use Facebook\Entities\AccessToken;
    use Facebook\HttpClients\FacebookCurlHttpClient;
    use Facebook\HttpClients\FacebookHttpable;

    class Fb_Login {

    	private $loginUrl;
    	private $session_in;
    	private $graphObject;
    	private $fbid;
    	private $fbfullname;

    	public function __construct() {
    		// init app with app id and secret
		    FacebookSession::setDefaultApplication( '','' );
		   
		    // login helper with redirect_uri
		    $redirect_uri = new FacebookRedirectLoginHelper('http://localhost/FaceMaze/index.php/Main_Controller/fb_login');

		    $ci = & get_instance();
		    $ci->load->library('session');

		    try {
		        $session_in = $redirect_uri->getSessionFromRedirect();
		    } catch( FacebookRequestException $ex ) {
		      	// When Facebook returns an error
		      	$status_message = 'Facebook error '.$ex;
				$data = array(
					'status_message' => $status_message 
					);
				$ci->load->view('post_register_view', $data);
		    } catch( Exception $ex ) {
		      	// When validation fails or other local issues
		      	$status_message = 'Validation failed '.$ex;
				$data = array(
					'status_message' => $status_message 
					);
				$ci->load->view('post_register_view', $data);
		    }
		   
		    // see if we have a session
		    if (isset($session_in)) {
		    	$request = new FacebookRequest($session_in, 'GET', '/me');
		    	$response = $request->execute();

		    	// get response
      			$graphObject = $response->getGraphObject();
      			$fbid = $graphObject->getProperty('id');           // To Get Facebook ID
      			$fbfullname = $graphObject->getProperty('name');   // To Get Facebook full name

      			$fb_data = array(
      				'id'=>$fbid,
      				'real_name'=>$fbfullname
      				);
      			$ci->session->set_userdata('fb_data', $fb_data);
      			$ci->fb_login();
		    } else {
		    	$loginUrl = $redirect_uri->getLoginUrl();
		    	header("Location: ".$loginUrl);
		    }

    	}

    	public function getFbId() {
    		return $fbid;
    	}

    	public function getFbFullName() {
    		return $fbfullname;
    	}
    }

?>