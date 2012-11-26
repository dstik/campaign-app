<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newuserreferralsmodel extends CI_Model {

  private $id = '';
  private $fb_action_id = '';
  private $item_id = '';
  private $referred_user_id = '';
  private $fb_source = '';
  private $fb_action_type = '';
  private $path = '';

  function __construct() {
    // Call the Model constructor
    parent::__construct();
  }

  public function addReferral($referral_data) {
    $data = array(
     'filename'     => $this->db->escape($referral_data['filename']),
     'title'        => $this->db->escape($referral_data['title']),
     'description'  => $this->db->escape($referral_data['description']),
     'fb_user_id'   => $this->db->escape($referral_data['fb_user_id']),
     'first_name'   => $this->db->escape($referral_data['first_name']),
     'last_name'    => $this->db->escape($referral_data['last_name'])
    );
    $this->db->insert('items', $data);
    return $this->db->insert_id();
  }

  function getItem($id) {
    $query = $this->db->query('SELECT id, fb_user_id, title, description, filename FROM items WHERE id = '.$this->db->escape($id));
    if ($query->num_rows() > 0) {
      return $query->row_array();
    } else {
      return false;
    }
  }

  function getItemsFromUser($id, $limit=null) {
    if($limit) {
      $limit = "LIMIT ".$limit;
    }
    $query = $this->db->query('SELECT id, title, description, filename FROM items WHERE fb_user_id = '.$this->db->escape($id).' '.$limit);
    if ($query->num_rows() > 0) {
      return $query->result_array();
    } else {
      return false;
    }
  }

  function getRecentItems($exclude_item=null, $limit=6) {
    if($exclude_item) {
      $exclude_item = " AND NOT items.id = ".$exclude_item." ";
    }
    $limit = "LIMIT ".$limit;
    $query = $this->db->query('SELECT items.id, items.title, items.filename, users.first_name, users.last_name, users.fb_user_id FROM items, users WHERE items.fb_user_id = users.fb_user_id '.$exclude_item.' ORDER BY items.datetime DESC'.' '.$limit);
    if ($query->num_rows() > 0) {
      return $query->result_array();
    } else {
      return array();
    }
  }

}

?>