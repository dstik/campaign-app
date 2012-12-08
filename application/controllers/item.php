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

    $user = null;
    // See if there is a user from a cookie
    //NEED To Add If-Statement
		$user = $this->facebook->getUser();

    if (!$user) {
      redirect('/welcome/index');
      return;
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
    }

    try {
      // Let's get the user info and store the user in the DB
      $user_pic = $this->facebook->api('/me/?fields=picture');
      $item_user = $this->Usermodel->getUser($item['fb_user_id']);
      $item_user_pic = $this->facebook->api('/'.$item['fb_user_id'].'/?fields=picture');
	  } catch (FacebookApiException $e) {
	    show_error(print_r($e, TRUE), 500);
	  }

    $recentItems = $this->Itemmodel->getRecentItems($item_id);

    $data = array(
      'brand_name' => $this->config->item('brand_name'),
      'app_name' => $this->config->item('app_name'),
      'fbconfig' => $this->fbconfig,
      'inviteMessage' => $this->config->item('inviteMessage'),
      'message' => 'My Message',
      'user' => $_SESSION['user'],
      'user_pic' => $user_pic,
      'itemData' => $item,
      'item_user' => $item_user,
      'item_user_pic' => $item_user_pic,
      'recentItems' => $recentItems
    );

		$this->load->view('item-profile', $data);
	}

}
