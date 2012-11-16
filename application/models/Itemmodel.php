<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itemmodel extends CI_Model {

  var $id   = '';
  var $fb_user_id   = '';
  var $title = '';
  var $description    = '';
  var $filename   = '';

  function __construct() {
    // Call the Model constructor
    parent::__construct();
  }

  public function insert_file($filedata) {
    $data = array(
     'filename'     => $this->db->escape($filedata['filename']),
     'title'        => $this->db->escape($filedata['title']),
     'description'  => $this->db->escape($filedata['description']),
     'fb_user_id'  => $this->db->escape($filedata['fb_user_id'])
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