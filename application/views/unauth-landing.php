<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?= $app_name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="fb:app_id" content="<?= $fbconfig['appId'] ?>" />
    <meta property="og:type"   content="website" />
    <meta property="og:url"    content="<?= base_url("welcome/index") ?>" />
    <meta property="og:title"  content="<?= $app_name ?>" />
    <meta property="og:image"  content="" />

    <!-- styles -->
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
    </style>
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/welcome.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
    <div class="container-narrow">
      <div class="jumbotron">
        <h1>Super awesome marketing speak!</h1>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <div class="fb-login">
          <a href="<?= $dialog_url ?>">
            <img src="/img/fb-connect.png" alt="Connect with Facebook" /><br/>
            <div class="fb-facepile" data-max-rows="1" data-width="300"></div>
          </a>
        </div>
      </div>

      <hr>

      <?
      $item_counter = 0;
      for($i_count = 0; $i_count < count($recentItems); $i_count++) {
        $item_counter++;
        if($item_counter == 1) {
        ?>
          <div class="row-fluid item_list">
        <?
        }
        ?>
        <div class="span6 item_data">
          <p class="item_img">
            <a href="<?= base_url("item/index/".$recentItems[$i_count]['id']) ?>">
              <img class="item_pic" align="middle" src="<?= base_url("/files/".$recentItems[$i_count]['filename']) ?>" alt="<?= $recentItems[$i_count]['title'] ?>" />
            </a>
          </p>
          <h5>
            <a href="<?= base_url("item/index/".$recentItems[$i_count]['id']) ?>"><?= $recentItems[$i_count]['title'] ?></a>
          </h5>
          <p>
            <img class="user_pic" src="https://graph.facebook.com/<?= $recentItems[$i_count]['fb_user_id'] ?>/picture" alt="<?= $recentItems[$i_count]['first_name'].' '.$recentItems[$i_count]['last_name'] ?>" /> <?= $recentItems[$i_count]['first_name'].' '.$recentItems[$i_count]['last_name'] ?>
          </p>
        </div><!--/span-->
        <?
        if($item_counter == 2 || ($i_count == count($recentItems) -1)) {
          $item_counter = 0;
        ?>
          </div><!-- /row -->
        <?
        }
      }
      ?>

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
    <script src="/js/base.js"></script>
    <script src="/js/welcome.js"></script>
  </body>
</html>
