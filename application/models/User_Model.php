<?php

class User_Model extends CI_Model {

	/**
	* Call parent's constructor
	*/
   	public function __construct() {
   	   	parent::__construct();
   	}

   	/**
   	* Inserts regular user in the database
   	* Param is an array that contains the mail address, username and password
   	* The funcion returns a message that descibes the state of the insert (succseful or why not)
   	*/
   	public function insert_regular_user($data) {
   		$conn = oci_connect("c##facemaze","facemaze","localhost/Test");
   		if (!$conn) {
   			return "Failed to connect to data base";
   		}  
   		$sql = "BEGIN FaceMaze_Pack.insert_regular_user(:bind1, :bind2, :bind3, :bind4); END;";
   		$querry = oci_parse($conn, $sql);
   		oci_bind_by_name($querry, ":bind1", $data['mail']);
        oci_bind_by_name($querry, ":bind2", $data['username']);
        oci_bind_by_name($querry, ":bind3", $data['password']);
        oci_bind_by_name($querry, ":bind4", $message, 128);
   		oci_execute($querry);
   		oci_close($conn);
   		return $message;
   	}

   	/**
   	* Inserts facebook user in the database
   	* Param is an array that contains the mail address, username and real name
   	* The funcion returns a message that descibes the state of the insert (succseful or why not)
   	*/
   	public function insert_facebook_user($data) {
   		$conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
   		if (!$conn) {
   			return "Failed to connect to data base";
   		}  
   		$sql = "BEGIN FaceMaze_Pack.insert_fb_user(:bind1, :bind2, :bind3, :bind4); END;";
   		$querry = oci_parse($conn, $sql);
   		oci_bind_by_name($querry, ":bind1", $data['mail']);
        oci_bind_by_name($querry, ":bind2", $data['username']);
        oci_bind_by_name($querry, ":bind3", $data['real_name']);
        oci_bind_by_name($querry, ":bind4", $message, 128);
   		oci_execute($querry);
   		oci_close($conn);
   		return $message;
   	}

   	/**
   	* Inserts twitter user in the database
   	* Param is an array that contains the mail address, username and real name
   	* The funcion returns a message that descibes the state of the insert (succseful or why not)
   	*/
   	public function insert_twitter_user($data) {
   		$conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
   		if (!$conn) {
   			return "Failed to connect to data base";
   		}  
   		$sql = "BEGIN FaceMaze_Pack.insert_tw_user(:bind1, :bind2, :bind3, :bind4); END;";
   		$querry = oci_parse($conn, $sql);
   		oci_bind_by_name($querry, ":bind1", $data['mail']);
        oci_bind_by_name($querry, ":bind2", $data['username']);
        oci_bind_by_name($querry, ":bind3", $data['real_name']);
        oci_bind_by_name($querry, ":bind4", $message, 128);
   		oci_execute($querry);
   		oci_close($conn);
   		return $message;
   	}
    
    /**
    * Check if a regular user's mail address and password matches
    * Param is an array that contains the mail address and password
    * Returns integer value 1 if yes, 0 if no
    */
   	public function login($data) {
   		$conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
   		if (!$conn) {
   			return "Failed to connect to data base";
   		}  
   		$sql = "BEGIN :result := FaceMaze_Pack.check_login(:bind1, :bind2); END;";
   		$querry = oci_parse($conn, $sql);
   		oci_bind_by_name($querry, ":bind1", $data['mail']);
        oci_bind_by_name($querry, ":bind2", $data['password']);
        oci_bind_by_name($querry, ":result", $message, 32);
   		oci_execute($querry);
   		oci_close($conn);
   		return $message;
   	}

    /**
    * Param is an array that contains the mail address and account type (1 for regular user, 2 for fb user, 3 for tw user)
    * Returns the highest score for a user or -1 if the user does not exists
    */
   	public function get_high_score($data) {
   		$conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
   		if (!$conn) {
   			return "Failed to connect to data base";
   		}  
   		$sql = "BEGIN :result := FaceMaze_Pack.get_high_score(:bind1, :bind2); END;";
   		$querry = oci_parse($conn, $sql);
   		oci_bind_by_name($querry, ":bind1", $data['mail']);
        oci_bind_by_name($querry, ":bind2", $data['type']);
        oci_bind_by_name($querry, ":result", $message, 32);
   		oci_execute($querry);
   		oci_close($conn);
   		return $message;
   	}

    /**
    * Param is an array that contains the mail address and account type (1 for regular user, 2 for fb user, 3 for tw user)
    * Returns the highest score for a user or -1 if the user does not exists
    */
   	public function get_last_score($data) {
   		$conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
   		if (!$conn) {
   			return "Failed to connect to data base";
   		}  
   		$sql = "BEGIN :result := FaceMaze_Pack.get_last_score(:bind1, :bind2); END;";
   		$querry = oci_parse($conn, $sql);
   		oci_bind_by_name($querry, ":bind1", $data['mail']);
        oci_bind_by_name($querry, ":bind2", $data['type']);
        oci_bind_by_name($querry, ":result", $message, 32);
   		oci_execute($querry);
   		oci_close($conn);
   		return $message;
   	}

    /**
    * Delete a user from the database
    * Param is an array that contains the mail addres and account type (1 for regular user, 2 for fb user, 3 for tw user)
    * Returns a status message 
    */
   	public function delete_user($data) {
   		$conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
   		if (!$conn) {
   			return "Failed to connect to data base";
   		}  
   		$sql = "BEGIN FaceMaze_Pack.delete_user(:bind1, :bind2, :bind3); END;";
   		$querry = oci_parse($conn, $sql);
   		oci_bind_by_name($querry, ":bind1", $data['mail']);
        oci_bind_by_name($querry, ":bind2", $data['type']);
        oci_bind_by_name($querry, ":bind3", $message, 128);
   		oci_execute($querry);
   		oci_close($conn);
   		return $message;
   	}

    /**
    * Update user's highest score
    * Param is an array that contains the mail addres, account type (1 for regular user, 2 for fb user, 3 for tw user) and the new score
    * Returns a status message
    */
   	public function update_high_score($data) {
   		$conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
   		if (!$conn) {
   			return "Failed to connect to data base";
   		}  
   		$sql = "BEGIN FaceMaze_Pack.update_high_score(:bind1, :bind2, :bind3, :bind4); END;";
   		$querry = oci_parse($conn, $sql);
   		oci_bind_by_name($querry, ":bind1", $data['mail']);
        oci_bind_by_name($querry, ":bind2", $data['type']);
        oci_bind_by_name($querry, ":bind3", $data['score']);
        oci_bind_by_name($querry, ":bind4", $message, 128);
   		oci_execute($querry);
   		oci_close($conn);
   		return $message;
   	}

    /**
    * Update user's last score
    * Param is an array that contains the mail addres, account type (1 for regular user, 2 for fb user, 3 for tw user) and the new score
    * Returns a status message
    */
   	public function update_last_score($data) {
   		$conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
   		if (!$conn) {
   			return "Failed to connect to data base";
   		}  
   		$sql = "BEGIN FaceMaze_Pack.update_last_score(:bind1, :bind2, :bind3, :bind4); END;";
   		$querry = oci_parse($conn, $sql);
   		oci_bind_by_name($querry, ":bind1", $data['mail']);
        oci_bind_by_name($querry, ":bind2", $data['type']);
        oci_bind_by_name($querry, ":bind3", $data['score']);
        oci_bind_by_name($querry, ":bind4", $message, 128);
   		oci_execute($querry);
   		oci_close($conn);
   		return $message;
   	}
}

?>