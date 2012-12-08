<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model {

    var $fb_user_id   = '';
    var $first_name = '';
    var $last_name    = '';
    var $username   = '';
    var $gender = '';
    var $email    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function checkExists($uid) {
      $query = $this->db->query('SELECT fb_user_id FROM users WHERE fb_user_id = '.$this->db->escape($uid));
      if ($query->num_rows() > 0) {
        return true;
      } else {
        return false;
      }
    }

    function addUser($userData, $friends) {
      // Null check
      if(empty($userData)) {
        return false;
      }
      // if user doesn't exist, we will add them
      if(!$this->checkExists($userData->id)) {
        $data = array(
          'fb_user_id' => $userData->id,
          'first_name' => $userData->first_name,
          'last_name' => $userData->last_name,
          'username' => $userData->username,
          'gender' => $userData->gender,
          'email' => $userData->email
        );
        if(!$this->db->insert('users', $data)) {
          // user exists in DB
          return false;
        }

        // add friends
        if(isset($friends)) {
          // first check if friends are added to avoid a long query
          $query = $this->db->query('SELECT user_id FROM friends WHERE user_id = '.$this->db->escape($userData->id));
          if ($query->num_rows() == 0) {
            foreach($friends['data'] as $friend) {
              $data = array(
                'user_id' => $userData->id,
                'friend_id' => $friend['id']
              );
              if(!$this->db->insert('friends', $data)){
                break;
              }
            }
          }
        }
        return true;
      } else {
        return false;
      }
    }

    function getUser($id) {
        $query = $this->db->query('SELECT fb_user_id, first_name, last_name, username, gender, email FROM users WHERE fb_user_id = '.$this->db->escape($id));
        if ($query->num_rows() > 0) {
          return $query->row_array();
        } else {
          return false;
        }
    }

    function getFriends($id) {
        $friend_array = array();
        $query = $this->db->query("SELECT friends.user_id, friends.friend_id, users.first_name, users.last_name FROM friends, users WHERE friends.user_id = ".$this->db->escape($id)." AND friends.friend_id = users.fb_user_id");
        if ($query->num_rows() > 0) {
          foreach ($query->result_array() as $row) {
            array_push($friend_array, array(
              'id' => $row['friend_id'],
              'first_name' => $row['first_name'],
              'last_name' => $row['last_name']
            ));
          }
          return $friend_array;
        } else {
          return false;
        }
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

}
?>
