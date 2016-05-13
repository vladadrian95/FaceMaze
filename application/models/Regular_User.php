<?php

class Regular_User extends CI_Model {

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
     		$sql = "BEGIN regular_users_pack.insert_regular_user(:bind1, :bind2, :bind3, :bind4); END;";
     		$query = oci_parse($conn, $sql);
     		oci_bind_by_name($query, ":bind1", $data['email']);
        oci_bind_by_name($query, ":bind2", $data['username']);
        oci_bind_by_name($query, ":bind3", $data['password']);
        oci_bind_by_name($query, ":bind4", $message, 128);
     		oci_execute($query);
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
     		$sql = "BEGIN :result := regular_users_pack.check_login(:bind1, :bind2); END;";
     		$query = oci_parse($conn, $sql);
     		oci_bind_by_name($query, ":bind1", $data['email']);
        oci_bind_by_name($query, ":bind2", $data['password']);
        oci_bind_by_name($query, ":result", $message, 32);
     		oci_execute($query);
     		oci_close($conn);
     		return $message;
   	}

    /**
    * Delete a user from the database
    * Param is an array that contains the mail addres
    * Returns a status message 
    */
    public function delete_user($data) {
        $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
        if (!$conn) {
            return "Failed to connect to data base";
        }  
        $sql = "BEGIN regular_users_pack.delete_user(:bind1, :bind2); END;";
        $query = oci_parse($conn, $sql);
        oci_bind_by_name($query, ":bind1", $data['email']);
        oci_bind_by_name($query, ":bind2", $message, 128);
        oci_execute($query);
        oci_close($conn);
        return $message;
    }

    /**
    * Param is an array that contains the mail address
    * Returns the highest score for a user or -1 if the user does not exists
    */
    public function get_high_score($data) {
        $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
        if (!$conn) {
            return "Failed to connect to data base";
        }  
        $sql = "BEGIN :result := regular_users_pack.get_high_score(:bind1); END;";
        $query = oci_parse($conn, $sql);
        oci_bind_by_name($query, ":bind1", $data['email']);
        oci_bind_by_name($query, ":result", $message, 32);
        oci_execute($query);
        oci_close($conn);
        return $message;
    }

    /**
    * Param is an array that contains the mail address
    * Returns the highest score for a user or -1 if the user does not exists
    */
    public function get_last_score($data) {
      $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
      if (!$conn) {
        return "Failed to connect to data base";
      }  
      $sql = "BEGIN :result := regular_users_pack.get_last_score(:bind1); END;";
      $query = oci_parse($conn, $sql);
      oci_bind_by_name($query, ":bind1", $data['email']);
      oci_bind_by_name($query, ":result", $message, 32);
      oci_execute($query);
      oci_close($conn);
      return $message;
    }


    /**
    * Update user's highest score
    * Param is an array that contains the mail addres and the new score
    * Returns a status message
    */
    public function update_high_score($data) {
      $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
      if (!$conn) {
        return "Failed to connect to data base";
      }  
      $sql = "BEGIN regular_users_pack.update_high_score(:bind1, :bind2, :bind3); END;";
      $query = oci_parse($conn, $sql);
      oci_bind_by_name($query, ":bind1", $data['email']);
      oci_bind_by_name($query, ":bind2", $data['score']);
      oci_bind_by_name($query, ":bind3", $message, 128);
      oci_execute($query);
      oci_close($conn);
      return $message;
    }

    /**
    * Update user's last score
    * Param is an array that contains the mail addres and the new score
    * Returns a status message
    */
    public function update_last_score($data) {
      $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
      if (!$conn) {
          return "Failed to connect to data base";
      }  
      $sql = "BEGIN regular_users_pack.update_high_score(:bind1, :bind2, :bind3); END;";
      $query = oci_parse($conn, $sql);
      oci_bind_by_name($query, ":bind1", $data['email']);
      oci_bind_by_name($query, ":bind2", $data['score']);
      oci_bind_by_name($query, ":bind3", $message, 128);
      oci_execute($query);
      oci_close($conn);
      return $message;
    }
}

?>