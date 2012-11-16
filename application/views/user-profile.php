<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?= $app_name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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

  <body>
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
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?= base_url("/welcome") ?>"><?= $app_name ?></a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right loggedinas">
              Logged in as <a href="<?= base_url("/user/index/".$user['id']) ?>" class="navbar-link">
                <img src="<?= $user_pic['picture']['data']['url'] ?>" />
                <?= $user['name'] ?>
              </a>
            </p>
            <ul class="nav">
              <li><a href="<?= base_url("/welcome") ?>">Home</a></li>
              <li><a href="#" id="upload_btn">Upload</a></li>
              <li><a href="#about">About</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid item_list">
      <div class="row-fluid">
        <div class="span9">
          <div class="hero-unit">
            <h1><?= $profile_user['first_name'] ?>'s Profile</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
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
              <h2><?= $profile_user_items[$i_count]['title'] ?></h2>
              <p class="item_img">
                <img align="middle" src="<?= base_url("/files/".$profile_user_items[$i_count]['filename']) ?>" alt="<?= $profile_user_items[$i_count]['title'] ?>" />
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
