<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
    $this->fbconfig = $this->config->item('fbconfig');
    $initConfig['appId'] = $this->fbconfig['appId'];
    $initConfig['secret'] = $this->fbconfig['secret'];
    $this->load->library('Facebook', $initConfig);
  }

  public function index() {
    // load user model
    $user = null;

    $user = $this->facebook->getUser();
    if($user == 0) { $user = null; }

    if ($user && $_SESSION['access_token']) {
     redirect('/welcome/authed');
     //$this->authed();
     return;
    }

    // set up redirect_uri
    $protocol = "http";
    if(isset($_SERVER['HTTPS'])){
      $protocol .= "s";
    }
    $my_url = $protocol."://".$_SERVER['HTTP_HOST']."/welcome/authed";
    // we need to determine if the user is logged into fb (and if so are they authed or not)
    // if we're redirected from Facebook or an auth dialog, we'll have a code parameter
    $code = null;
    if(isset($_REQUEST["code"])) {
      $code = $_REQUEST["code"];
    }
    // if not, we'll redirect to the auth dialog, logged in and authed users will be redirected back with
    // the appropriate parameter
    if(empty($code)) {
      // We need to create some unique string to preserve state and protect against Cross-Site Request Forgery
      $_SESSION['state'] = md5(uniqid(rand(), TRUE));
      // We need to specify the (comma separated list of) user permissions we're requesting
      $permissions = $this->config->item('permissions');

      // We'll build the url to the auth dialog
      $dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
        . $this->fbconfig['appId'] . "&redirect_uri=" . urlencode($my_url) . "&state="
        . $_SESSION['state'] . "&scope=" . $permissions;
    }

    $recentItems = $this->Itemmodel->getRecentItems();

    $data = array(
      'brand_name' => $this->config->item('brand_name'),
      'app_name' => $this->config->item('app_name'),
      'fbconfig' => $this->fbconfig,
      'message' => 'My Message',
      'recentItems' => $recentItems
    );

	  $data['dialog_url'] = $dialog_url;
    $this->load->view('unauth-landing', $data);

  }


	public function channel() {
	  $this->load->view('channel');
	}

	public function authed() {
    $user = null;

    $code = null;
    if(isset($_REQUEST["code"])) {
      $code = $_REQUEST["code"];
    }

    // set up redirect_uri
    $protocol = "http";
    if(isset($_SERVER['HTTPS'])){
      $protocol .= "s";
    }
    $my_url = $protocol."://".$_SERVER['HTTP_HOST']."/welcome/authed";

    if($code) {
      // User arrived successfully, let's excheange the code for an access_token
      $token_url = "https://graph.facebook.com/oauth/access_token?"
      . "client_id=" . $this->fbconfig['appId'] . "&redirect_uri=" . urlencode($my_url)
      . "&client_secret=" . $this->fbconfig['secret'] . "&code=" . $code;
      // The response will look like this:
      //  access_token=USER_ACCESS_TOKEN&expires=NUMBER_OF_SECONDS_UNTIL_TOKEN_EXPIRES
      $response = null;
      $response = file_get_contents($token_url);
      if(!$response) {
        // back up plan
        // We need to create some unique string to preserve state and protect against Cross-Site Request Forgery
        $_SESSION['state'] = md5(uniqid(rand(), TRUE));
        // We need to specify the (comma separated list of) user permissions we're requesting
        $permissions = $this->config->item('permissions');

        // We'll build the url to the auth dialog
        $dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
          . $this->fbconfig['appId'] . "&redirect_uri=" . urlencode($my_url) . "&state="
          . $_SESSION['state'] . "&scope=" . $permissions;

        $recentItems = $this->Itemmodel->getRecentItems();

        $data = array(
          'brand_name' => $this->config->item('brand_name'),
          'app_name' => $this->config->item('app_name'),
          'fbconfig' => $this->fbconfig,
          'message' => 'My Message',
          'recentItems' => $recentItems

        );

    	  $data['dialog_url'] = $dialog_url;

        $this->load->view('unauth-landing', $data);
        return;
      }
      $params = null;
      parse_str($response, $params);
      // let's add the access_token and expiration to our session variables
      $_SESSION['access_token'] = $params['access_token'];
      $_SESSION['expires'] = $params['expires'];

      // Let's get the user info and store the user in the DB
      $graph_url = "https://graph.facebook.com/me?access_token="
      . $params['access_token'];
      $graph_contents = file_get_contents($graph_url);
      $userData = json_decode($graph_contents);
      $userDataArray = json_decode($graph_contents, true);
      $_SESSION['user'] = $userDataArray;

      $graph_url = "https://graph.facebook.com/me/friends/?fields=id&access_token="
      . $params['access_token'];
      $friends = json_decode(file_get_contents($graph_url), true);

      $this->Usermodel->addUser($userData, $friends);

    } else {
      // See if there is a user from a cookie
  		$user = $this->facebook->getUser();

      if (!$user || !$_SESSION['access_token']) {
  		  echo "no user";
  		  // redirect('/welcome/index');
  		}

    }

    $recentItems = $this->Itemmodel->getRecentItems();

    $data = array(
      'brand_name' => $this->config->item('brand_name'),
      'app_name' => $this->config->item('app_name'),
      'fbconfig' => $this->fbconfig,
      'message' => 'My Message',
      'recentItems' => $recentItems
    );


	  try {
	    // Proceed knowing you have a logged in user who's authenticated.
	    if(!isset($_REQUEST["code"])) {
	      $user_pic = $this->facebook->api('/me/?fields=picture');
	    } else {
        // Let's get the user info and store the user in the DB
        $graph_url = "https://graph.facebook.com/me/?fields=picture&access_token="
        . $params['access_token'];
        $graph_contents = file_get_contents($graph_url);
        $user_pic = json_decode($graph_contents, true);
	    }
	  } catch (FacebookApiException $e) {
	    show_error(print_r($e, TRUE), 500);
	  }

		$data['facebook'] = $this->facebook;
		$data['user'] = $_SESSION['user'];
		$data['user_pic'] = $user_pic;

    $data['access_token'] = $_SESSION['access_token'];
    $this->load->view('auth-landing', $data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */