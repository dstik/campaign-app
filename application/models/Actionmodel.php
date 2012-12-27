<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actionmodel extends CI_Model {

  private $id   = '';
  private $fb_user_id   = '';
  private $fb_action_id   = '';
  private $item_id   = '';
  private $message = '';
  private $image = '';
  private $tags = '';
  private $locations = '';
  private $mentions    = '';
  private $vote = '';
  private $datetime = '';

  function __construct() {
    // Call the Model constructor
    parent::__construct();
  }

  public function addAction($actiondata) {
    $data = array(
      'fb_user_id' => $this->db->escape(intval($actiondata['fb_user_id'])),
      'item_id' => $this->db->escape(intval($actiondata['item_id'])),
      'vote' => $this->db->escape(floatval($actiondata['vote']))
    );
    $this->db->insert('actions', $data);
    return $this->db->insert_id();
  }

  public function getCurrentVote($item_id) {
    $query = $this->db->query('SELECT AVG(vote) as "AVG", COUNT(vote) as "COUNT" FROM actions WHERE item_id = '.$this->db->escape($item_id));
    if ($query->num_rows() > 0) {
      return $query->row_array();
    } else {
      return false;
    }
  }

  public function add_fbid_to_action($actiondata) {
    echo "hi";
  }

}
?>