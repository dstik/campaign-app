<!DOCTYPE html>
<html lang="en">
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# profile: http://ogp.me/ns/profile#">
    <meta charset="utf-8">
    <title><?= $app_name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="fb:app_id" content="<?= $fbconfig['appId'] ?>" />
    <meta property="og:type"   content="profile" />
    <meta property="og:url"    content="<?= base_url("user/index/".$profile_user['fb_user_id']) ?>" />
    <meta property="og:title"  content="<?= $profile_user['first_name'].' '.$profile_user['last_name'] ?>" />
    <meta property="og:image"  content="<?= $profile_user_pic ?>" />
    <meta property="profile:first_name"      content="<?= $profile_user['first_name'] ?>">
    <meta property="profile:last_name"       content="<?= $profile_user['last_name'] ?>">
    <meta property="profile:username"        content="<?= $profile_user['username'] ?>">
    <meta property="profile:gender"          content="<?= $profile_user['gender'] ?>">


    <!-- styles -->
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/user.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body class="body">
    <div class="upload_outer">
      <div class="upload_box">
        <?php echo form_open_multipart('/upload/upload_file', array('class' => 'form-upload', 'id' => 'upload_file'));?>
          <h2 class="form-upload-heading">Upload a File</h2>
          <div class="control-group">
            <!-- <label class="control-label" for="userfile"><h5>File</h5></label> -->
            <div class="controls">
              <input type="file" name="userfile" id="userfile" size="20"/>
            </div>
          </div>
          <input type="text" class="input-block-level" name="title" id="title" placeholder="Photo Title">
          <input type="text" class="input-block-level" name="description" id="description" placeholder="Photo Description">
          <button class="btn btn-large btn-primary" name="submit" id="submit" type="submit">Upload</button>
          <button class="btn btn-large upload_cancel" type="button">Cancel</button>
        </form>
      </div>
    </div>


    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <a class="brand" href="<?= base_url("/welcome") ?>"><?= $app_name ?></a>
        <ul class="nav">
          <li><a href="<?= base_url("/welcome") ?>">Home</a></li>
          <?php
          if($user) {
          ?>
          <li><a href="#" id="upload_btn">Upload</a></li>
          <?
          }
          ?>
          <li><a href="#about">About</a></li>
        </ul>
        <?php
        if($user) {
        ?>
        <ul class="nav pull-right rightmenu">
          <li id="fat-menu" class="dropdown">
            <a href="#" id="drop3" role="button" class="navbar-link dropdown-toggle loggedinas" data-toggle="dropdown">
              <!-- <a href="<?= base_url("/user/index/".$user['id']) ?>" class="" data-toggle="dropdown"> -->
              <img src="<?= $user_pic ?>" alt="<?= $user['name'] ?>" />
              <?= $user['name'] ?>
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
              <li><a tabindex="-1" href="<?= base_url("/user/index/".$user['id']) ?>">Profile</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="#">Privacy</a></li>
              <li><a tabindex="-1" href="#">Something else here</a></li>
              <li><a tabindex="-1" href="#">Separated link</a></li>
            </ul>
          </li>
        </ul>
        <?php
        }
        ?>
      </div>
    </div>

    <div class="container-fluid item_list">
      <div class="row-fluid">
        <div class="span9">
          <div class="hero-unit">
            <h1>
              <div class="userphoto">
                <span style="background-image: url(<?= $profile_user_pic ?>)"></span>
              <?= $profile_user['first_name'] ?>'s Profile
              </div>
            </h1>
            <p>This is a template for a user profile page. You can put any sort of user description or copy here to describe a user and their activities using your service</p>
          </div>
          <?
          $item_counter = 0;
          for($i_count = 0; $i_count < count($profile_user_items); $i_count++) {
            $item_counter++;
            if($item_counter == 1) {
            ?>
              <div class="row-fluid">
            <?
            }
            ?>
            <div class="span4 item_data">
              <h2>
                <a href="<?= base_url("item/index/".$profile_user_items[$i_count]['id']) ?>">
                  <?= $profile_user_items[$i_count]['title'] ?>
                </a>
              </h2>
              <p class="item_img">
                <a href="<?= base_url("item/index/".$profile_user_items[$i_count]['id']) ?>">
                  <img align="middle" src="<?= base_url("/files/".$profile_user_items[$i_count]['filename']) ?>" alt="<?= $profile_user_items[$i_count]['title'] ?>" />
                </a>
              </p>
              <p><a class="btn" href="<?= base_url("item/index/".$profile_user_items[$i_count]['id']) ?>">View <?= $fbconfig['itemObjectType'] ?> &raquo;</a></p>
            </div><!--/span-->
            <?
            if($item_counter == 3 || ($i_count == count($profile_user_items) -1)) {
              $item_counter = 0;
            ?>
              </div><!-- /row -->
            <?
            }
          }
          ?>

        </div><!--/span-->
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list friend_list">
              <li class="nav-header"><?= $profile_user['first_name'] ?>'s Friends</li>
              <?
                if($profile_user_friends) {
                  foreach($profile_user_friends as $friend) {
                    ?>
                    <li>
                      <a href="<?= base_url("/user/index/".$friend['id']) ?>">
                        <img src="https://graph.facebook.com/<?= $friend['id'] ?>/picture" />
                        <?= $friend['first_name'].' '.$friend['last_name'] ?>
                      </a>
                    </li>
                    <?
                  }
                } else {
                  ?>
                  <li><a href="#" onclick="user.sendRequestViaMultiFriendSelector('<?= $fbconfig['inviteMessage'] ?>');">Invite Friends!</a></li>
                  <?
                }
              ?>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <div class="footer">
        <p>&copy; <?= $brand_name ?> 2012</p>
      </div>
    </div> <!-- /container -->

    <!-- javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap.min.js"></script>
    <div id="fb-root"></div>
    <script>
      // Additional JS functions here
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?= $fbconfig['appId'] ?>', // App ID
          channelUrl : '<?= base_url("/welcome/channel"); ?>', // Channel File
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true  // parse XFBML
        });

        // Additional init code here

      };

      // Load the SDK Asynchronously
      (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
       }(document));
    </script>
    <script src="/js/ajaxfileupload.js"></script>
    <script src="/js/base.js"></script>
    <script src="/js/user.js"></script>

  </body>
</html>
