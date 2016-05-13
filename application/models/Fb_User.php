<?php

class Fb_User extends CI_Model {

	  /**
	  * Call parent's constructor
	  */
   	public function __construct() {
   	   	parent::__construct();
   	}

    /**
    * Inserts facebook user in the database
    * Param is an array that contains the facebook id and name
    * The funcion returns a message that descibes the state of the insert (succseful or why not)
    */
    public function insert_facebook_user($data) {
        $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
        if (!$conn) {
            return "Failed to connect to data base";
        }  
        $sql = "BEGIN fb_users_pack.insert_fb_user(:bind1, :bind2, :bind3); END;";
        $query = oci_parse($conn, $sql);
        oci_bind_by_name($query, ":bind1", $data['id']);
        oci_bind_by_name($query, ":bind2", $data['real_name']);
        oci_bind_by_name($query, ":bind3", $message, 128);
        oci_execute($query);
        oci_close($conn);
        return $message;
    }

    /**
    * Delete a user from the database
    * Param is an array that contains the facebook id
    * Returns a status message 
    */
    public function delete_user($data) {
        $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
        if (!$conn) {
            return "Failed to connect to data base";
        }  
        $sql = "BEGIN fb_users_pack.delete_user(:bind1, :bind2); END;";
        $query = oci_parse($conn, $sql);
        oci_bind_by_name($query, ":bind1", $data['id']);
        oci_bind_by_name($query, ":bind2", $message, 128);
        oci_execute($query);
        oci_close($conn);
        return $message;
    }

    /**
    * Param is an array that contains the facebook id
    * Returns the highest score for a user or -1 if the user does not exists
    */
    public function get_high_score($data) {
        $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
        if (!$conn) {
            return "Failed to connect to data base";
        }  
        $sql = "BEGIN :result := fb_users_pack.get_high_score(:bind1); END;";
        $query = oci_parse($conn, $sql);
        oci_bind_by_name($query, ":bind1", $data['id']);
        oci_bind_by_name($query, ":result", $message, 32);
        oci_execute($query);
        oci_close($conn);
        return $message;
    }

    /**
    * Param is an array that contains the facebook id
    * Returns the highest score for a user or -1 if the user does not exists
    */
    public function get_last_score($data) {
      $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
      if (!$conn) {
        return "Failed to connect to data base";
      }  
      $sql = "BEGIN :result := fb_users_pack.get_last_score(:bind1); END;";
      $query = oci_parse($conn, $sql);
      oci_bind_by_name($query, ":bind1", $data['id']);
      oci_bind_by_name($query, ":result", $message, 32);
      oci_execute($query);
      oci_close($conn);
      return $message;
    }


    /**
    * Update user's highest score
    * Param is an array that contains the facebook id and the new score
    * Returns a status message
    */
    public function update_high_score($data) {
      $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
      if (!$conn) {
        return "Failed to connect to data base";
      }  
      $sql = "BEGIN fb_users_pack.update_high_score(:bind1, :bind2, :bind3); END;";
      $query = oci_parse($conn, $sql);
      oci_bind_by_name($query, ":bind1", $data['id']);
      oci_bind_by_name($query, ":bind2", $data['score']);
      oci_bind_by_name($query, ":bind3", $message, 128);
      oci_execute($query);
      oci_close($conn);
      return $message;
    }

    /**
    * Update user's last score
    * Param is an array that contains the facebook id and the new score
    * Returns a status message
    */
    public function update_last_score($data) {
      $conn = oci_connect("c##facemaze","facemaze","localhost/Test", null);
      if (!$conn) {
          return "Failed to connect to data base";
      }  
      $sql = "BEGIN fb_users_pack.update_high_score(:bind1, :bind2, :bind3); END;";
      $query = oci_parse($conn, $sql);
      oci_bind_by_name($query, ":bind1", $data['id']);
      oci_bind_by_name($query, ":bind2", $data['score']);
      oci_bind_by_name($query, ":bind3", $message, 128);
      oci_execute($query);
      oci_close($conn);
      return $message;
    }

}

?>