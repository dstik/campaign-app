<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TrackingClass {

/*
  LOG TABLE:
  id int(5) NOT NULL
  fb_action_id bigint(20)
  fb_action_type string(25)
  fb_source string(25)
  landingPath string(100)
*/

  public function LogRequest() {
    // Likely passed from FB in Query_string
    // &fb_action_ids=10100790406086716
    // &fb_action_types=capital_one%3Acustomize
    // &fb_source=other_multiline
    // &action_object_map=%7B%2210100790406086716%22%3A467263969961239%7D
    // &action_type_map=%7B%2210100790406086716%22%3A%22capital_one%3Acustomize%22%7D
    // &action_ref_map=%5B%5D
    // http://daves.fb.com/item/index/3?fb_action_ids=10100790406086716&fb_action_types=capital_one%3Acustomize&fb_source=other_multiline
    if(!isset( $_SESSION['new_user_referrals'])) {
      $get_array = array();
      parse_str($_SERVER['QUERY_STRING'], $get_array);
      // sanitize some data for DB
      if(isset($get_array['fb_action_ids'])) {
        $get_array['fb_action_id'] = $get_array['fb_action_ids'];
      }

      if(isset($get_array['fb_action_types'])) {
        $fb_action_types = explode(":", $get_array['fb_action_types']);
        $get_array['fb_action_type'] = $fb_action_types[1];
      }

      // controller path from PHP Self
      // /index.php/welcome/authed
      $controllerPath = str_replace("/index.php", "", $_SERVER["PHP_SELF"]);
      $get_array['path'] = $controllerPath;
      //print_r($get_array);
      $_SESSION['new_user_referrals'] = $get_array;

    }
  }

}

?>