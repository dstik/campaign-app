<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller
{
  public function __construct() {
    parent::__construct();
    $this->load->model('Itemmodel');
    $this->load->helper('url');
    $this->load->helper('form');
    $this->load->library('upload');
    $this->fbconfig = $this->config->item('fbconfig');
    $initConfig['appId'] = $this->fbconfig['appId'];
    $initConfig['secret'] = $this->config->item('secret');
    $this->load->library('Facebook', $initConfig);  }

  public function index() {
    redirect('/welcome');
  }

  public function upload_file() {
    $status = "";
    $msg = "";
    $file_element_name = 'userfile';
    if (empty($_POST['title'])) {
      $status = "error";
      $msg = "Please enter a title";
    }
    if ($status != "error") {
      $config['upload_path'] = './files/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size']  = 1024 * 5;
      $config['encrypt_name'] = TRUE;
      $this->upload->initialize($config);

      if (!$this->upload->do_upload($file_element_name)) {
        $status = 'error';
        $msg = $this->upload->display_errors('', '');
      } else {
        $data = $this->upload->data();
        $filedata = array(
          "filename" => $data['file_name'],
          "title" => $_POST['title'],
          "description" => $_POST['description'],
          "fb_user_id" => $_SESSION['user']['id'],
          "first_name" => $_SESSION['user']['first_name'],
          "last_name" => $_SESSION['user']['last_name'],
        );
        $file_id = $this->Itemmodel->insert_file($filedata);
        if($file_id) {
         $status = "success";
         $msg = "$file_id";
        } else {
          unlink($data['full_path']);
          $status = "error";
          $msg = "Something went wrong when saving the file, please try again.";
        }
      }
      @unlink($_FILES[$file_element_name]);
      // Create the OG Action
      //$user_pic = $this->facebook->api('/me/?fields=picture');
    }
    echo json_encode(array('status' => $status, 'msg' => $msg));
  }
}

?>
