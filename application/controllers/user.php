<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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

	public function index($profile_id)
	{

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

    $profile_user = $this->Usermodel->getUser($profile_id);
    $profile_user_friends = array();
    if (!$profile_user) {
      //redirect('/welcome/index');
      echo "aa";
      exit();
      return;
    } else {
      $profile_user_friends = $this->Usermodel->getFriends($profile_id);
      $profile_user_items = $this->Itemmodel->getItemsFromUser($profile_id);
    }

    try {
      // Let's get the user info from FB
      $user_pic = $this->facebook->api('/me/?fields=picture');
      $profile_user_pic = $this->facebook->api('/'.$profile_id.'/?fields=picture');
      $profile_user_pic = $profile_user_pic['picture']['data']['url'];
	  } catch (FacebookApiException $e) {
	    //show_error(print_r($e, TRUE), 500);
	    $user_pic = false;
      $profile_user_pic = "https://graph.facebook.com/".$profile_id."/picture";
	  }

    $data = array(
      'brand_name' => $this->config->item('brand_name'),
      'app_name' => $this->config->item('app_name'),
      'fbconfig' => $this->fbconfig,
      'inviteMessage' => $this->config->item('inviteMessage'),
      'message' => 'My Message',
      'user' => $user,
      'user_pic' => $user_pic,
      'profile_user' => $profile_user,
      'profile_user_pic' => $profile_user_pic,
      'profile_user_friends' => $profile_user_friends,
      'profile_user_items' => $profile_user_items
    );

		$this->load->view('user-profile', $data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */