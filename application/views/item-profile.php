<!DOCTYPE html>
<html lang="en-US">
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# platformtraining: http://ogp.me/ns/fb/<?= $fbconfig['namespace'] ?>#">
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="en" />
    <title><?= $app_name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="fb:app_id" content="<?= $fbconfig['appId'] ?>" />
    <meta property="og:type"   content="<?= $fbconfig['namespace'] ?>:<?= $fbconfig['item'] ?>" />
    <meta property="og:url"    content="<?= base_url("item/index/".$itemData['id']) ?>" />
    <meta property="og:title"  content="<?= $itemData['title'] ?>" />
    <meta property="og:image"  content="<?= base_url("/files/".$itemData['filename']) ?>" />
    <meta property="og:description" content="<?= $itemData['title'] ?>" />


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
    <link href="/css/item.css" rel="stylesheet">

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

    <div class="container">
      <div class="row">
        <div class="container-fluid">

          <div class="hero-unit">
            <div class="row-fluid">
              <div class="span8">
                <h1><?= $itemData['title'] ?></h1>
                <h6><?= ucfirst($fbconfig['createPastTense']) ?> by <a href="<?= base_url("/user/index/".$item_user['fb_user_id']) ?>"><?= $item_user['first_name']." ".$item_user['last_name'] ?></a></h6>
                <p>
                  <div class="fb-like" data-href="<?= base_url("item/index/".$itemData['id']) ?>" data-send="true" data-width="450" data-show-faces="false"></div>
                </p>
                <p><?= $itemData['description'] ?></p>
                <p>
                  <div class="fb-comments" data-href="<?= base_url("item/index/".$itemData['id']) ?>" data-num-posts="2" data-width="470"></div>
                </p>
              </div>
              <div class="span4 item_pic">
                <img src="<?= base_url("/files/".$itemData['filename']) ?>" alt="<?= $itemData['title'] ?>" />
              </div>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span12">
              <h2>Other <?= ucfirst($fbconfig['itemObjectType']) ?>s</h2>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span4">
              <h3>Heading</h3>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View <?= $fbconfig['itemObjectType'] ?> &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h3>Heading</h3>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h3>Heading</h3>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->
          <div class="row-fluid">
            <div class="span4">
              <h3>Heading</h3>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h3>Heading</h3>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h3>Heading</h3>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->

          <hr>

          <div class="footer">
            <p>&copy; <?= $brand_name ?> 2012</p>
          </div>

        </div> <!-- /container -->
      </div><!--/row-->
    </div><!--/container-->

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
