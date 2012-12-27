<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

  public $fbconfig = array();

  public function __construct() {
    parent::__construct();
    // Your own constructor code
    $this->load->model('Usermodel');
    $this->load->model('Itemmodel');
    $this->load->model('Actionmodel');
    $this->load->helper('url');
    $this->load->helper('form');
    // load FB
    $this->fbconfig = $this->config->item('fbconfig');
    $initConfig['appId'] = $this->fbconfig['appId'];
    $initConfig['secret'] = $this->config->item('secret');
    $this->load->library('Facebook', $initConfig);
  }

	public function index($item_id=null)
	{
	  //echo "{ITEM}".$_COOKIE['new_user_referrals']."{/ITEM}";

    $user = null;
    // See if there is a user from user session
    if(isset($_SESSION['user'])) {
      $user = $_SESSION['user'];
    }
    // see if we can grab it from FB session
    if(!$user) {
      try {
        $user = $this->facebook->getUser();
      } catch (Exception $e) {
        $user = null;
      }
    }


    $item = $this->Itemmodel->getItem($item_id);
    if (!$item_id || !$item) {
      // replace this to show a huge array of all objects
      //redirect('/welcome/index');
      echo "aa";
      return;
    } else {
      // Do necessary work here for the object
      // pull FP and count of vote actions
      $itemCount = $this->Actionmodel->getCurrentVote($item_id);
    }

    try {
      // Let's get the user info from FB
      $user_pic = $this->facebook->api('/me/?fields=picture');
	  } catch (FacebookApiException $e) {
	    // show_error(print_r($e, TRUE), 500);
	    $user_pic = false;
	  }

	  try {
      $item_user = $this->Usermodel->getUser($item['fb_user_id']);
      //$item_user_pic = $this->facebook->api('/'.$item['fb_user_id'].'/?fields=picture');
	  } catch (Exception $e) {
	    show_error(print_r($e, TRUE), 500);
	  }

    $recentItems = $this->Itemmodel->getRecentItems($item_id);

    $data = array(
      'brand_name' => $this->config->item('brand_name'),
      'app_name' => $this->config->item('app_name'),
      'fbconfig' => $this->fbconfig,
      'inviteMessage' => $this->config->item('inviteMessage'),
      'user' => $user,
      'user_pic' => $user_pic,
      'itemData' => $item,
      'item_user' => $item_user,
      'itemCount' => $itemCount,
      //'item_user_pic' => $item_user_pic,
      'recentItems' => $recentItems
    );

		$this->load->view('item-profile', $data);
	}

	public function vote()
	{
	  // Check user
	  $user = null;
    // See if there is a user from user session
    if(isset($_SESSION['user'])) {
      $user = $_SESSION['user'];
    }
    // see if we can grab it from FB session
    if(!$user) {
      try {
        $user = $this->facebook->getUser();
      } catch (Exception $e) {
        $user = null;
      }
    }
    if(!$user) {
      echo json_encode(array('status' => "error", 'msg' => "Cannot identify user"));
      return;
    }

	  if(isset($_POST['id']) && isset($_POST['value'])) {
      $actiondata = array(
        "fb_user_id" => $user['id'],
        "item_id" => $_POST['id'],
        "vote" => $_POST['value']
      );
      $action_id = $this->Actionmodel->addAction($actiondata);
      if($action_id) {
        $status = "success";
        $msg = $action_id;
        // TODO: NEED TO PUBLISH ACTIONS HERE!
      } else {
        $status = "error";
        $msg = "Something went wrong when logging the vote, please try again later.";
      }
	  } else {
	    $status = "error";
      $msg = "Something went wrong when logging the vote, please try again later.";
	  }

	  echo json_encode(array('status' => $status, 'msg' => $msg));
    return;
  }

}
